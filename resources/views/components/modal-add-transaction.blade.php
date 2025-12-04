@props([
    'categories' => [],
    'wallets' => [],
])

<div id="addTransactionModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-opacity-50 backdrop-blur-sm transition-opacity flex items-center justify-center"
        onclick="toggleModal('addTransactionModal')"></div>

    <div class="relative flex min-h-full items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl transform transition-all scale-100 overflow-hidden animate-fade-in-down">

            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Tambah Transaksi Baru</h3>
                <button type="button" onclick="toggleModal('addTransactionModal')"
                    class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Tipe -->
                <div class="grid grid-cols-2 gap-2 p-1 bg-gray-100 rounded-lg mb-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="expense" class="peer sr-only" checked
                            onchange="filterCategories('expense')">
                        <div
                            class="text-center py-2 text-sm font-medium rounded-md text-gray-500 peer-checked:bg-white peer-checked:text-red-500 peer-checked:shadow-sm transition-all">
                            Pengeluaran
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="income" class="peer sr-only"
                            onchange="filterCategories('income')">
                        <div
                            class="text-center py-2 text-sm font-medium rounded-md text-gray-500 peer-checked:bg-white peer-checked:text-green-600 peer-checked:shadow-sm transition-all">
                            Pemasukan
                        </div>
                    </label>
                </div>

                <!-- Jumlah -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400 font-bold">Rp</span>
                        <input type="number" name="amount"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800 placeholder-gray-300"
                            placeholder="0" required>
                    </div>
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Kategori -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
                        <select name="category_id" id="modal_category_select"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white"
                            required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" data-type="{{ $cat->type }}">
                                    {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Dompet -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Dompet</label>
                        <select name="wallet_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white"
                            required>
                            @foreach ($wallets as $wall)
                                <option value="{{ $wall->id }}">{{ $wall->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Catatan (Opsional)</label>
                    <textarea name="description" rows="2"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm resize-none"
                        placeholder="Contoh: Nasi Padang"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-blue-500/30 transition transform active:scale-95">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function filterCategories(type) {
        const select = document.getElementById('modal_category_select');
        const options = select.querySelectorAll('option');

        select.value = "";

        options.forEach(option => {
            if (option.value === "") return;

            const catType = option.getAttribute('data-type');
            if (catType === type) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterCategories('expense');
    });
</script>
