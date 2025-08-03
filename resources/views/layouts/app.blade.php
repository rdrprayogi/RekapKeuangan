<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Rekap Keuangan')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Enhanced Profile Animations */
        .profile-avatar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }
        
        .role-badge-pulse {
            animation: gentle-pulse 3s ease-in-out infinite;
        }
        
        @keyframes gentle-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .status-indicator {
            animation: status-blink 2s ease-in-out infinite;
        }
        
        @keyframes status-blink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(0.95); }
        }
        
        /* Glassmorphism effect */
        .glass-effect {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Hover animations for profile sections */
        .profile-info-hover {
            transition: all 0.2s ease-in-out;
        }
        
        .profile-info-hover:hover {
            transform: translateY(-1px);
        }
        
        /* Mobile profile card effect */
        .mobile-profile-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        /* Enhanced logout button */
        .logout-btn-enhanced {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .logout-btn-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        
        .logout-btn-enhanced:hover::before {
            left: 100%;
        }
        
        /* Text shimmer effect for names */
        .name-shimmer {
            background: linear-gradient(45deg, #ffffff, #f0f9ff, #ffffff);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shimmer 3s ease-in-out infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @auth
    <nav class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo & Brand -->
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white">Rekap Keuangan</h1>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <div class="hidden md:ml-8 md:flex md:space-x-1">
                        <!-- Dashboard Menu -->
                        <a href="{{ route('dashboard') }}" 
                           class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5zM3 7h18M8 11h8"></path>
                                </svg>
                                <span>Dashboard</span>
                            </div>
                            @if(request()->routeIs('dashboard'))
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-white rounded-full"></div>
                            @endif
                        </a>

                        @if(auth()->user()->isPengaju())
                        <!-- Analytics Menu -->
                        <div class="relative group">
                            <button class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-white/80 hover:text-white hover:bg-white/10 flex items-center space-x-2" onclick="toggleAnalyticsMenu()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span>Analisis Pengeluaran</span>
                                <svg class="w-3 h-3 text-white/70 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="analytics-dropdown-arrow">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Analytics Dropdown -->
                            <div id="analytics-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 z-50 glass-effect">
                                <div class="p-2">
                                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-b border-gray-100 mb-2">📊 Analisis Pengeluaran</div>
                                    <a href="{{ route('analisis.weekly') }}" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4"></path>
                                        </svg>
                                        Tren Mingguan
                                    </a>
                                    <a href="{{ route('analisis.index') }}" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8a4 4 0 01-8 0V8a4 4 0 018 0zM8 20l4-7 4 7H8z"></path>
                                        </svg>
                                        Analisis Bulanan
                                    </a>
                                    <a href="{{ route('analisis.yearly') }}" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Laporan Tahunan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Budget Monitor -->
                        <div class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-white/80 hover:text-white hover:bg-white/10">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span>Budget: 75%</span>
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->isApprover())
                        <!-- Quick Approval Counter -->
                        <div class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-white/80 hover:text-white hover:bg-white/10">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pending: 5</span>
                            </div>
                        </div>

                        <!-- Fast Actions Menu -->
                        <div class="relative group">
                            <button class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-white/80 hover:text-white hover:bg-white/10 flex items-center space-x-2" onclick="toggleFastActionsMenu()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span>Aksi Cepat</span>
                                <svg class="w-3 h-3 text-white/70 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="fast-actions-dropdown-arrow">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Fast Actions Dropdown -->
                            <div id="fast-actions-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 z-50 glass-effect">
                                <div class="p-2">
                                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-b border-gray-100 mb-2">Aksi Cepat Approval</div>
                                    <button onclick="bulkApproveAll()" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Setujui Semua < 500rb
                                    </button>
                                    <button onclick="sortByAmount()" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                        </svg>
                                        Urutkan by Nominal
                                    </button>
                                    <button onclick="filterByUnit()" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Filter by Unit
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->isAdmin())
                        <!-- System Monitor -->
                        <div class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-white/80 hover:text-white hover:bg-white/10">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span>System OK</span>
                            </div>
                        </div>

                        <!-- Export Menu -->
                        <div class="relative group">
                            <button class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-white/80 hover:text-white hover:bg-white/10 flex items-center space-x-2" onclick="toggleExportMenu()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Export</span>
                                <svg class="w-3 h-3 text-white/70 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="export-dropdown-arrow">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Export Dropdown -->
                            <div id="export-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50 glass-effect">
                                <div class="p-2">
                                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-b border-gray-100 mb-2">Export Data</div>
                                    <button onclick="exportExcel()" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export ke Excel
                                    </button>
                                    <button onclick="exportPDF()" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Export ke PDF
                                    </button>
                                    <button onclick="generateReport()" class="w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200 text-left">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Laporan Bulanan
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Help Menu (Universal) -->
                        <div class="relative group">
                            <button class="group relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-white/80 hover:text-white hover:bg-white/10 flex items-center space-x-2" onclick="toggleHelpMenu()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Bantuan</span>
                                <svg class="w-3 h-3 text-white/70 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="help-dropdown-arrow">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Help Dropdown -->
                            <div id="help-dropdown" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-lg shadow-xl border border-gray-200 z-50 glass-effect">
                                <div class="p-2">
                                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-b border-gray-100 mb-2">Panduan Penggunaan</div>
                                    <a href="#" onclick="showGuide('create')" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Cara Membuat Pengajuan
                                    </a>
                                    @if(auth()->user()->isApprover() || auth()->user()->isAdmin())
                                    <a href="#" onclick="showGuide('approve')" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Cara Menyetujui
                                    </a>
                                    @endif
                                    <a href="#" onclick="showGuide('shortcuts')" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Shortcut Keyboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User Info & Logout -->
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <div class="md:hidden mr-2">
                        <button onclick="toggleMobileMenu()" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white/80 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-colors duration-200">
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Enhanced User Profile Display with Dropdown -->
                        <div class="relative">
                            <!-- Profile Button -->
                            <button onclick="toggleProfileDropdown()" class="flex items-center space-x-4 focus:outline-none">
                                <!-- User Avatar with Status Indicator -->
                                <div class="relative">
                                    <div class="profile-avatar w-10 h-10 bg-gradient-to-br from-white/30 to-white/10 rounded-full flex items-center justify-center ring-2 ring-white/20 backdrop-blur-sm glass-effect">
                                        <!-- Dynamic Avatar based on role -->
                                        @if(auth()->user()->isAdmin())
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        @elseif(auth()->user()->isApprover())
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <!-- Online Status Indicator -->
                                    <div class="status-indicator absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                                </div>
                                
                                <!-- User Information -->
                                <div class="hidden lg:block profile-info-hover text-left">
                                    <div class="flex items-center space-x-2">
                                        <div class="text-sm font-semibold text-white name-shimmer">{{ auth()->user()->name }}</div>
                                        @if(auth()->user()->nip)
                                            <div class="text-xs px-2 py-0.5 bg-white/10 rounded text-white/80 glass-effect">{{ auth()->user()->nip }}</div>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2 mt-0.5">
                                        @if(auth()->user()->jabatan)
                                            <div class="text-xs text-white/80">{{ auth()->user()->jabatan }}</div>
                                            @if(auth()->user()->unit_kerja)
                                                <div class="text-white/60">•</div>
                                            @endif
                                        @endif
                                        @if(auth()->user()->unit_kerja)
                                            <div class="text-xs text-white/70">{{ auth()->user()->unit_kerja }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Compact view for smaller screens -->
                                <div class="hidden sm:block lg:hidden profile-info-hover text-left">
                                    <div class="text-sm font-medium text-white name-shimmer">{{ Str::limit(auth()->user()->name, 15) }}</div>
                                    <div class="text-xs text-white/70 flex items-center">
                                        @if(auth()->user()->jabatan)
                                            {{ Str::limit(auth()->user()->jabatan, 20) }}
                                        @else
                                            {{ ucfirst(auth()->user()->userRole?->name ?? 'User') }}
                                        @endif
                                    </div>
                                </div>

                                <!-- Dropdown Arrow -->
                                <svg class="hidden sm:block w-4 h-4 text-white/70 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="profile-dropdown-arrow">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Profile Dropdown Menu -->
                            <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-200 z-50 glass-effect">
                                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-t-xl">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                            @if(auth()->user()->isAdmin())
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            @elseif(auth()->user()->isApprover())
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-2">
                                    <div class="grid grid-cols-2 gap-2 p-2 bg-gray-50 rounded-lg">
                                        @if(auth()->user()->nip)
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">NIP</div>
                                            <div class="text-sm font-medium text-gray-900">{{ auth()->user()->nip }}</div>
                                        </div>
                                        @endif
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Role</div>
                                            <div class="text-sm font-medium text-gray-900">{{ ucfirst(auth()->user()->userRole?->name ?? 'User') }}</div>
                                        </div>
                                        @if(auth()->user()->jabatan)
                                        <div class="text-center col-span-{{ auth()->user()->nip ? '2' : '1' }}">
                                            <div class="text-xs text-gray-500">Jabatan</div>
                                            <div class="text-sm font-medium text-gray-900">{{ auth()->user()->jabatan }}</div>
                                        </div>
                                        @endif
                                        @if(auth()->user()->unit_kerja)
                                        <div class="text-center col-span-2">
                                            <div class="text-xs text-gray-500">Unit Kerja</div>
                                            <div class="text-sm font-medium text-gray-900">{{ auth()->user()->unit_kerja }}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-red-700 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Role Badge -->
                        <div class="hidden md:flex items-center">
                            <div class="px-3 py-1.5 bg-white/15 backdrop-blur-sm rounded-full border border-white/20 shadow-sm glass-effect">
                                <div class="flex items-center space-x-2">
                                    @if(auth()->user()->isAdmin())
                                        <div class="w-2 h-2 bg-yellow-400 rounded-full role-badge-pulse"></div>
                                        <span class="text-xs font-medium text-white">Administrator</span>
                                    @elseif(auth()->user()->isApprover())
                                        <div class="w-2 h-2 bg-green-400 rounded-full role-badge-pulse"></div>
                                        <span class="text-xs font-medium text-white">Approver</span>
                                    @else
                                        <div class="w-2 h-2 bg-blue-400 rounded-full role-badge-pulse"></div>
                                        <span class="text-xs font-medium text-white">Pengaju</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="md:hidden border-t border-white/20 hidden">
            <!-- Mobile User Profile Section -->
            <div class="px-4 py-4 border-b border-white/20">
                <div class="mobile-profile-card rounded-xl p-4 flex items-center space-x-3">
                    <div class="relative">
                        <div class="profile-avatar w-12 h-12 bg-gradient-to-br from-white/30 to-white/10 rounded-full flex items-center justify-center ring-2 ring-white/20 glass-effect">
                            @if(auth()->user()->isAdmin())
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            @elseif(auth()->user()->isApprover())
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="status-indicator absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-indigo-600 rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-base font-semibold text-white truncate name-shimmer">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-white/70">
                            @if(auth()->user()->jabatan)
                                {{ auth()->user()->jabatan }}
                                @if(auth()->user()->nip)
                                    <span class="text-xs ml-2 px-2 py-0.5 bg-white/10 rounded glass-effect">{{ auth()->user()->nip }}</span>
                                @endif
                            @else
                                {{ ucfirst(auth()->user()->userRole?->name ?? 'User') }}
                            @endif
                        </div>
                        @if(auth()->user()->unit_kerja)
                            <div class="text-xs text-white/60 mt-0.5">{{ auth()->user()->unit_kerja }}</div>
                        @endif
                    </div>
                    <!-- Role Badge for Mobile -->
                    <div class="px-2.5 py-1 bg-white/15 rounded-full glass-effect">
                        <div class="flex items-center space-x-1">
                            @if(auth()->user()->isAdmin())
                                <div class="w-2 h-2 bg-yellow-400 rounded-full role-badge-pulse"></div>
                                <span class="text-xs font-medium text-white">Admin</span>
                            @elseif(auth()->user()->isApprover())
                                <div class="w-2 h-2 bg-green-400 rounded-full role-badge-pulse"></div>
                                <span class="text-xs font-medium text-white">Approver</span>
                            @else
                                <div class="w-2 h-2 bg-blue-400 rounded-full role-badge-pulse"></div>
                                <span class="text-xs font-medium text-white">Pengaju</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Navigation Menu -->
            <div class="px-4 pt-4 pb-6 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-3 py-2 rounded-md text-base font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5zM3 7h18M8 11h8"></path>
                    </svg>
                    Dashboard
                </a>
                @if(auth()->user()->isPengaju())
                <a href="{{ route('pengajuan.index') }}" 
                   class="flex items-center px-3 py-2 rounded-md text-base font-medium transition-colors {{ request()->routeIs('pengajuan.index') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Pengajuan Saya
                </a>
                <a href="{{ route('pengajuan.pending') }}" 
                   class="flex items-center px-3 py-2 rounded-md text-base font-medium transition-colors {{ request()->routeIs('pengajuan.pending') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Menunggu Approval
                </a>
                @endif
                @if(auth()->user()->isApprover())
                <a href="{{ route('approval.index') }}" 
                   class="flex items-center px-3 py-2 rounded-md text-base font-medium transition-colors {{ request()->routeIs('approval.index') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Approval
                </a>
                <a href="{{ route('approval.revision_history') }}" 
                   class="flex items-center px-3 py-2 rounded-md text-base font-medium transition-colors {{ request()->routeIs('approval.revision_history') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    History Revisi
                </a>
                @endif
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <main>
        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        // Auto hide flash messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 3000);

        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Profile dropdown toggle
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            const arrow = document.getElementById('profile-dropdown-arrow');
            
            dropdown.classList.toggle('hidden');
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }

        // Admin dropdown toggle
        function toggleAdminMenu() {
            const dropdown = document.getElementById('admin-dropdown');
            const arrow = document.getElementById('admin-dropdown-arrow');
            
            dropdown.classList.toggle('hidden');
            if (arrow) {
                arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        // Help dropdown toggle
        function toggleHelpMenu() {
            const dropdown = document.getElementById('help-dropdown');
            const arrow = document.getElementById('help-dropdown-arrow');
            
            dropdown.classList.toggle('hidden');
            if (arrow) {
                arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        // Analytics Menu toggle
        function toggleAnalyticsMenu() {
            console.log('toggleAnalyticsMenu called');
            const dropdown = document.getElementById('analytics-dropdown');
            const arrow = document.getElementById('analytics-dropdown-arrow');
            
            console.log('Dropdown element:', dropdown);
            console.log('Arrow element:', arrow);
            
            if (dropdown) {
                dropdown.classList.toggle('hidden');
                console.log('Dropdown hidden class toggled, current classes:', dropdown.className);
            }
            
            if (arrow) {
                arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                console.log('Arrow rotation set');
            }
        }

        // Notification panel toggle (kept for other roles)
        function toggleNotificationPanel() {
            alert('📧 Notifikasi Terbaru:\n\n• Pengajuan #PG-001 telah disetujui\n• Revisi diperlukan untuk #PG-003\n• Pengajuan baru dari Tim Marketing');
        }

        // Fast Actions Menu toggle
        function toggleFastActionsMenu() {
            const dropdown = document.getElementById('fast-actions-dropdown');
            const arrow = document.getElementById('fast-actions-dropdown-arrow');
            
            dropdown.classList.toggle('hidden');
            if (arrow) {
                arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        // Export Menu toggle
        function toggleExportMenu() {
            const dropdown = document.getElementById('export-dropdown');
            const arrow = document.getElementById('export-dropdown-arrow');
            
            dropdown.classList.toggle('hidden');
            if (arrow) {
                arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        // Fast Action Functions
        function bulkApproveAll() {
            if (confirm('Setujui semua pengajuan dengan nominal < 500.000?\n\nIni akan menyetujui beberapa pengajuan sekaligus.')) {
                alert('✅ Berhasil menyetujui 3 pengajuan dengan total Rp 1.200.000');
                toggleFastActionsMenu();
            }
        }

        function sortByAmount() {
            window.location.href = "{{ route('approval.index') }}?sort=amount&order=desc";
        }

        function filterByUnit() {
            const unit = prompt('Masukkan nama unit kerja untuk filter:');
            if (unit) {
                window.location.href = `{{ route('approval.index') }}?unit=${encodeURIComponent(unit)}`;
            }
        }

        // Export Functions
        function exportExcel() {
            alert('📊 Menggenerate file Excel...\n\nFile akan diunduh dalam beberapa detik.');
            toggleExportMenu();
        }

        function exportPDF() {
            alert('📄 Menggenerate file PDF...\n\nFile akan diunduh dalam beberapa detik.');
            toggleExportMenu();
        }

        function generateReport() {
            alert('📈 Menggenerate laporan bulanan...\n\nLaporan akan dikirim ke email Anda.');
            toggleExportMenu();
        }

        // Quick search toggle
        function toggleQuickSearch() {
            // Open search modal or redirect to search page
            window.location.href = "{{ route('pengajuan.index') }}?search=1";
        }

        // Show help guide
        function showGuide(type) {
            let message = '';
            switch(type) {
                case 'create':
                    message = 'Untuk membuat pengajuan:\n1. Klik menu Dashboard\n2. Pilih "Buat Pengajuan Baru"\n3. Isi semua field yang diperlukan\n4. Upload dokumen pendukung\n5. Klik "Ajukan" untuk submit';
                    break;
                case 'approve':
                    message = 'Untuk menyetujui pengajuan:\n1. Klik menu Dashboard\n2. Pilih pengajuan yang akan disetujui\n3. Review dokumen dan detail\n4. Klik "Setujui" atau "Tolak"\n5. Berikan komentar jika diperlukan';
                    break;
                case 'shortcuts':
                    message = 'Shortcut Keyboard:\n• Ctrl+N: Buat pengajuan baru\n• Ctrl+S: Simpan draft\n• Ctrl+Enter: Submit pengajuan\n• F1: Buka bantuan\n• Esc: Tutup modal';
                    break;
                case 'status':
                    message = 'Arti Status Pengajuan:\n• Draft: Belum disubmit\n• Pending: Menunggu approval\n• Approved: Sudah disetujui\n• Rejected: Ditolak\n• Revision: Perlu revisi';
                    break;
            }
            alert(message);
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            console.log('Document click detected, target:', event.target.tagName, event.target.className);
            
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileButton = event.target.closest('[onclick="toggleMobileMenu()"]');
            
            const profileDropdown = document.getElementById('profile-dropdown');
            const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');
            
            const helpDropdown = document.getElementById('help-dropdown');
            const helpButton = event.target.closest('[onclick="toggleHelpMenu()"]');
            
            const analyticsDropdown = document.getElementById('analytics-dropdown');
            const analyticsButton = event.target.closest('[onclick="toggleAnalyticsMenu()"]');
            console.log('Analytics button from click outside:', analyticsButton);
            console.log('Analytics dropdown from click outside:', analyticsDropdown);
            
            const fastActionsDropdown = document.getElementById('fast-actions-dropdown');
            const fastActionsButton = event.target.closest('[onclick="toggleFastActionsMenu()"]');
            
            const exportDropdown = document.getElementById('export-dropdown');
            const exportButton = event.target.closest('[onclick="toggleExportMenu()"]');
            
            // Close mobile menu
            if (!mobileButton && !mobileMenu.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
            }
            
            // Close profile dropdown
            if (!profileButton && profileDropdown && !profileDropdown.contains(event.target) && !profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
                const arrow = document.getElementById('profile-dropdown-arrow');
                if (arrow) {
                    arrow.classList.remove('rotate-180');
                }
            }
            
            // Close help dropdown
            if (!helpButton && helpDropdown && !helpDropdown.contains(event.target) && !helpDropdown.classList.contains('hidden')) {
                helpDropdown.classList.add('hidden');
                const arrow = document.getElementById('help-dropdown-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
            
            // Close analytics dropdown
            if (!analyticsButton && analyticsDropdown && !analyticsDropdown.contains(event.target) && !analyticsDropdown.classList.contains('hidden')) {
                analyticsDropdown.classList.add('hidden');
                const arrow = document.getElementById('analytics-dropdown-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
            
            // Close fast actions dropdown
            if (!fastActionsButton && fastActionsDropdown && !fastActionsDropdown.contains(event.target) && !fastActionsDropdown.classList.contains('hidden')) {
                fastActionsDropdown.classList.add('hidden');
                const arrow = document.getElementById('fast-actions-dropdown-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
            
            // Close export dropdown
            if (!exportButton && exportDropdown && !exportDropdown.contains(event.target) && !exportDropdown.classList.contains('hidden')) {
                exportDropdown.classList.add('hidden');
                const arrow = document.getElementById('export-dropdown-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        });

        // Profile hover effects and interactions
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - initializing page');
            console.log('Analytics button exists:', !!document.getElementById('analyticsBtn'));
            console.log('Analytics dropdown exists:', !!document.getElementById('analyticsDropdown'));
            console.log('Analytics arrow exists:', !!document.getElementById('analyticsArrow'));
            console.log('Analytics container exists:', !!document.getElementById('analyticsContainer'));
            
            // Debug all analytics elements
            const analyticsBtn = document.getElementById('analyticsBtn');
            const analyticsDropdown = document.getElementById('analyticsDropdown');
            const analyticsArrow = document.getElementById('analyticsArrow');
            const analyticsContainer = document.getElementById('analyticsContainer');
            
            if (analyticsBtn) {
                console.log('Analytics button found, adding click listener');
                analyticsBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Analytics button clicked via event listener');
                    toggleAnalyticsMenu();
                });
            } else {
                console.log('Analytics button NOT found');
            }
            
            // Add subtle interactions to profile elements
            const profileAvatar = document.querySelector('.profile-avatar');
            const profileInfo = document.querySelector('.profile-info-hover');
            
            if (profileAvatar) {
                profileAvatar.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05) rotate(5deg)';
                });
                
                profileAvatar.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) rotate(0deg)';
                });
            }

            // Add click effects to role badges
            const roleBadges = document.querySelectorAll('.role-badge-pulse');
            roleBadges.forEach(badge => {
                badge.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                });
            });

            // Enhanced logout button confirmation
            const logoutBtns = document.querySelectorAll('form[action*="logout"] button[type="submit"]');
            logoutBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin logout?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
