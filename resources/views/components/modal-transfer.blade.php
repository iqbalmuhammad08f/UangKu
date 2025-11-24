<div id="transferModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" onclick="toggleModal('transferModal')"></div>
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 animate-fade-in-up">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Transfer Antar Dompet</h3>
                <button onclick="toggleModal('transferModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Dari</label>
                        <select name="from_wallet_id" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                            <option value="1">BCA Utama</option>
                            <option value="2">GoPay</option>
                        </select>
                    </div>
                    <div class="pt-4 text-gray-400"><i class="fa-solid fa-arrow-right"></i></div>
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Ke</label>
                        <select name="to_wallet_id" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                            <option value="3">Tunai</option>
                            <option value="1">BCA Utama</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jumlah Transfer</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-400">Rp</span>
                        <input type="number" name="amount" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="0">
                    </div>
                </div>
                <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-lg font-bold hover:bg-gray-900 transition transform active:scale-95">
                    Proses Transfer
                </button>
            </form>
        </div>
    </div>
</div>
