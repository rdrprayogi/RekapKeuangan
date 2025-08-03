@extends('layouts.app')

@section('title', 'Edit Pengajuan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-lg shadow-xl p-8 text-white">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold mb-2">Edit Pengajuan Keuangan</h1>
            <p class="text-orange-100 text-lg">
                Perbarui informasi pengajuan Anda sesuai kebutuhan
            </p>
            <div class="mt-4 flex items-center justify-center space-x-4 text-sm">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    ID: #{{ str_pad($pengajuan->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Dibuat: {{ $pengajuan->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Terdapat beberapa kesalahan pada form:
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($pengajuan->status === 'revision' && $pengajuan->catatan_approval)
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Catatan Revisi dari Approver:
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>{{ $pengajuan->catatan_approval }}</p>
                    </div>
                    <div class="mt-3 text-xs text-blue-600">
                        <p><strong>Petunjuk:</strong> Silakan perbaiki pengajuan sesuai catatan di atas, kemudian simpan perubahan. Status akan berubah menjadi "Menunggu Persetujuan" setelah disimpan.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('pengajuan.update', $pengajuan) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="px-6 py-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Pengajuan
                </h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                            Judul Pengajuan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul', $pengajuan->judul) }}" required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                               placeholder="Contoh: Pengadaan Alat Laboratorium Komputer">
                        @error('judul')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Pengajuan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" required
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                                  placeholder="Jelaskan secara detail mengenai pengajuan ini, latar belakang, dan tujuan pengajuan...">{{ old('deskripsi', $pengajuan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="keperluan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Keperluan/Tujuan Penggunaan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keperluan" id="keperluan" rows="4" required
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                                  placeholder="Jelaskan untuk apa barang-barang ini akan digunakan, manfaat, dan urgensi pengadaan...">{{ old('keperluan', $pengajuan->keperluan) }}</textarea>
                        @error('keperluan')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Detail -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="px-6 py-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Detail Item yang Diajukan
                    </h3>
                    <button type="button" id="add-item" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Item
                    </button>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Petunjuk:</strong> Klik tombol "Tambah Item" untuk menambahkan barang yang ingin diajukan. Data item yang sudah ada akan ditampilkan otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="items-container" class="space-y-4">
                    <!-- Items will be loaded here -->
                </div>

                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Total Estimasi Biaya:</h4>
                            <p class="text-sm text-gray-600 mt-1">Akan dihitung otomatis berdasarkan item yang ditambahkan</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-indigo-600">
                                Rp <span id="total-amount">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200 p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Simpan perubahan?</h4>
                    <p class="text-sm text-gray-600 mt-1">Pastikan semua data sudah benar sebelum menyimpan perubahan</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('pengajuan.show', $pengajuan) }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-lg hover:shadow-xl transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
let itemIndex = 0;

// Existing items from database
const existingItems = @json($pengajuan->items);

document.getElementById('add-item').addEventListener('click', function() {
    addItem();
});

function addItem(item = null) {
    const container = document.getElementById('items-container');
    const itemDiv = document.createElement('div');
    itemDiv.className = 'border-2 border-dashed border-gray-200 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition duration-200';
    itemDiv.setAttribute('data-item-index', itemIndex);
    
    itemDiv.innerHTML = `
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-medium text-gray-800 flex items-center">
                <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full mr-2">Item #${itemIndex + 1}</span>
                Item Pengajuan
            </h4>
            <button type="button" onclick="removeItem(${itemIndex})" 
                    class="inline-flex items-center p-2 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Item <span class="text-red-500">*</span>
                </label>
                <input type="text" name="items[${itemIndex}][nama_barang]" value="${item?.nama_barang || ''}" required
                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                       placeholder="Contoh: Komputer Desktop All-in-One">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jumlah <span class="text-red-500">*</span>
                </label>
                <input type="number" name="items[${itemIndex}][jumlah]" value="${item?.jumlah || ''}" min="1" required
                       onchange="calculateItemTotal(${itemIndex})"
                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                       placeholder="1">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Satuan <span class="text-red-500">*</span>
                </label>
                <select name="items[${itemIndex}][satuan]" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200">
                    <option value="">Pilih Satuan</option>
                    <option value="unit" ${item?.satuan === 'unit' ? 'selected' : ''}>Unit</option>
                    <option value="pcs" ${item?.satuan === 'pcs' ? 'selected' : ''}>Pcs</option>
                    <option value="set" ${item?.satuan === 'set' ? 'selected' : ''}>Set</option>
                    <option value="box" ${item?.satuan === 'box' ? 'selected' : ''}>Box</option>
                    <option value="kg" ${item?.satuan === 'kg' ? 'selected' : ''}>Kg</option>
                    <option value="liter" ${item?.satuan === 'liter' ? 'selected' : ''}>Liter</option>
                    <option value="meter" ${item?.satuan === 'meter' ? 'selected' : ''}>Meter</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Satuan (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="items[${itemIndex}][harga_satuan]" value="${item?.harga_satuan || ''}" min="0" step="1000" required
                           onchange="calculateItemTotal(${itemIndex})"
                           class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                           placeholder="5000000">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Total Harga
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="text" id="item-total-${itemIndex}" readonly
                           class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 sm:text-sm"
                           placeholder="0">
                </div>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Spesifikasi/Keterangan
                </label>
                <textarea name="items[${itemIndex}][deskripsi_barang]" rows="3"
                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                          placeholder="Contoh: Intel Core i5, RAM 8GB, SSD 256GB, Monitor 21.5 inch">${item?.deskripsi_barang || ''}</textarea>
            </div>
        </div>
        
        ${item?.id ? `<input type="hidden" name="items[${itemIndex}][id]" value="${item.id}">` : ''}
    `;
    
    container.appendChild(itemDiv);
    itemIndex++;
    
    // Calculate total after adding item
    calculateItemTotal(itemIndex - 1);
}

function removeItem(index) {
    const itemDiv = document.querySelector(`[data-item-index="${index}"]`);
    if (itemDiv) {
        // Check if this is the last item
        const container = document.getElementById('items-container');
        if (container.children.length <= 1) {
            alert('Minimal harus ada 1 item dalam pengajuan.');
            return;
        }
        
        itemDiv.remove();
        calculateTotal();
        updateItemNumbers();
    }
}

function updateItemNumbers() {
    const container = document.getElementById('items-container');
    const items = container.children;
    
    for (let i = 0; i < items.length; i++) {
        const itemNumber = items[i].querySelector('.bg-indigo-100');
        if (itemNumber) {
            itemNumber.textContent = `Item #${i + 1}`;
        }
    }
}

function calculateItemTotal(index) {
    const jumlahElement = document.querySelector(`input[name="items[${index}][jumlah]"]`);
    const hargaSatuanElement = document.querySelector(`input[name="items[${index}][harga_satuan]"]`);
    const totalElement = document.getElementById(`item-total-${index}`);
    
    if (jumlahElement && hargaSatuanElement && totalElement) {
        const jumlah = parseFloat(jumlahElement.value) || 0;
        const hargaSatuan = parseFloat(hargaSatuanElement.value) || 0;
        const total = jumlah * hargaSatuan;
        
        totalElement.value = total.toLocaleString('id-ID');
        calculateTotal();
    }
}

function calculateTotal() {
    let total = 0;
    const container = document.getElementById('items-container');
    const items = container.children;
    
    for (let i = 0; i < items.length; i++) {
        const itemIndex = items[i].getAttribute('data-item-index');
        const jumlahElement = document.querySelector(`input[name="items[${itemIndex}][jumlah]"]`);
        const hargaSatuanElement = document.querySelector(`input[name="items[${itemIndex}][harga_satuan]"]`);
        
        if (jumlahElement && hargaSatuanElement) {
            const jumlah = parseFloat(jumlahElement.value) || 0;
            const hargaSatuan = parseFloat(hargaSatuanElement.value) || 0;
            total += jumlah * hargaSatuan;
        }
    }
    
    document.getElementById('total-amount').textContent = total.toLocaleString('id-ID');
}

// Load existing items on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add existing items
    existingItems.forEach(function(item) {
        addItem(item);
    });
    
    // If no existing items, add one empty item
    if (existingItems.length === 0) {
        addItem();
    }
});
</script>
@endpush
@endsection
