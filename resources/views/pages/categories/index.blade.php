@extends('layouts.app')

@section('title', 'Kategori - DompetKu')
@section('header_title', 'Atur Kategori')

@push('styles')
    <style>
        .tab-active {
            background-color: #eff6ff;
            color: #2563eb;
            border-color: #2563eb;
        }

        .tab-inactive {
            background-color: #ffffff;
            color: #6b7280;
            border-color: transparent;
        }
    </style>
@endpush

@section('content.layout')

    <div class="flex justify-center mb-8">
        <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-200 flex gap-2">
            <button id="btn-expense" onclick="switchTab('expense')"
                class="px-6 py-2 rounded-lg text-sm font-medium transition-all tab-active border border-transparent shadow-sm">
                <i class="fa-solid fa-arrow-trend-down mr-2 text-red-500"></i> Pengeluaran
            </button>
            <button id="btn-income" onclick="switchTab('income')"
                class="px-6 py-2 rounded-lg text-sm font-medium transition-all tab-inactive border">
                <i class="fa-solid fa-arrow-trend-up mr-2 text-green-600"></i> Pemasukan
            </button>
            <button onclick="toggleModal('addCategoryModal')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-500/30 transition transform active:scale-95">
                <i class="fa-solid fa-plus"></i>
                <span class="hidden sm:inline">Tambah Kategori</span>
            </button>
        </div>
    </div>

    @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif
    @if (session('error'))
        <x-toast type="error" message="{{ session('error') }}" />
    @endif

    <div id="view-expense" class="block animate-fade-in space-y-8">
        <div>
            <h3 class="text-lg font-bold text-gray-700 mb-4">Daftar Kategori</h3>

            @if ($categories->where('type', 'expense')->isEmpty())
                <p class="text-sm text-gray-400 italic ml-1">Belum ada kategori kustom. Tambahkan kategori baru!</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($categories->where('type', 'expense') as $cat)
                        <div
                            class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between group transition-colors hover:shadow-md">
                            <div class="flex items-center gap-3">
                                <span class="font-medium text-gray-700">{{ ucwords($cat->name) }}</span>
                            </div>
                            <div class="flex gap-3 transition-opacity">
                                <button onclick="openEditModal('{{ $cat->id }}', '{{ ucwords($cat->name) }}')"
                                    class="text-blue-600 hover:text-blue-800 transition"><i
                                        class="fa-solid fa-pen"></i></button>

                                <button onclick="openDeleteModal('{{ $cat->id }}', '{{ $cat->name }}')"
                                    class="text-red-500 hover:text-red-700 transition" title="Hapus Kategori">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div id="view-income" class="hidden animate-fade-in space-y-8">

        <div>
            <h3 class="text-lg font-bold text-gray-700 mb-4">Daftar Kategori</h3>

            @if ($categories->where('type', 'income')->isEmpty())
                <p class="text-sm text-gray-400 italic ml-1">Belum ada kategori pemasukan tambahan.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($categories->where('type', 'income') as $cat)
                        <div
                            class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between group transition-colors hover:shadow-md">
                            <div class="flex items-center gap-3">
                                <span class="font-medium text-gray-700">{{ ucwords($cat->name) }}</span>
                            </div>
                            <div class="flex gap-3 transition-opacity">
                                <button onclick="openEditModal('{{ $cat->id }}', '{{ ucwords($cat->name) }}')"
                                    class="text-blue-600 hover:text-blue-800 transition"><i
                                        class="fa-solid fa-pen"></i></button>

                                <button onclick="openDeleteModal('{{ $cat->id }}', '{{ $cat->name }}')"
                                    class="text-red-500 hover:text-red-700 transition" title="Hapus Kategori">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div id="addCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 backdrop-blur-sm transition-opacity" onclick="toggleModal('addCategoryModal')"></div>

        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 animate-fade-in-down">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Kategori Baru</h3>
                    <button type="button" onclick="toggleModal('addCategoryModal')"
                        class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Jenis Transaksi</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value="expense" class="w-4 h-4 text-blue-600" checked>
                                <span class="text-sm text-gray-700">Pengeluaran</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value="income" class="w-4 h-4 text-green-600">
                                <span class="text-sm text-gray-700">Pemasukan</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Kategori</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="Contoh: Investasi">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 transform active:scale-95">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div id="editCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 backdrop-blur-sm transition-opacity" onclick="toggleModal('editCategoryModal')"></div>
        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Kategori</h3>
                    <button type="button" onclick="toggleModal('editCategoryModal')"
                        class="text-gray-400 hover:text-gray-600 self-start">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Kategori</label>
                        <input type="text" name="name" id="editName"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg"><i
                            class="fa-solid fa-floppy-disk mr-2"></i>Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <x-modal id="deleteModal" title="Hapus Kategori" method="DELETE" button="Hapus">
        Menghapus kategori ini akan menghapus semua transaksi terkait.
    </x-modal>
@endpush

@push('scripts')
    <script>
        function switchTab(type) {
            const viewExpense = document.getElementById('view-expense');
            const viewIncome = document.getElementById('view-income');
            const btnExpense = document.getElementById('btn-expense');
            const btnIncome = document.getElementById('btn-income');

            if (type === 'expense') {
                viewExpense.classList.remove('hidden');
                viewIncome.classList.add('hidden');
                btnExpense.classList.add('tab-active', 'shadow-sm');
                btnExpense.classList.remove('tab-inactive', 'hover:bg-gray-100');
                btnIncome.classList.add('tab-inactive', 'hover:bg-gray-100');
                btnIncome.classList.remove('tab-active', 'shadow-sm');
            } else {
                viewExpense.classList.add('hidden');
                viewIncome.classList.remove('hidden');
                btnIncome.classList.add('tab-active', 'shadow-sm');
                btnIncome.classList.remove('tab-inactive', 'hover:bg-gray-100');
                btnExpense.classList.add('tab-inactive', 'hover:bg-gray-100');
                btnExpense.classList.remove('tab-active', 'shadow-sm');
            }
        }

        function openEditModal(id, name) {
            const form = document.getElementById('editForm');
            const inputName = document.getElementById('editName');

            form.action = `/categories/${id}`;
            inputName.value = name;

            toggleModal('editCategoryModal')
        }

        function openDeleteModal(id) {
            document.getElementById('form-deleteModal').action = `/categories/${id}`;
            toggleModal('deleteModal');
        }
    </script>
@endpush
