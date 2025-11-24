<div id="addCategoryModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" onclick="toggleModal('addCategoryModal')"></div>

    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 animate-fade-in-down">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Kategori Baru</h3>
                <button type="button" onclick="toggleModal('addCategoryModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Kategori</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Investasi">
                </div>

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
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Warna Ikon</label>
                    <div class="flex gap-3">
                        <input type="hidden" name="color" id="selectedColor">

                        <div onclick="selectColor('red')" class="w-8 h-8 rounded-full bg-red-100 border-2 border-red-500 cursor-pointer hover:scale-110 transition"></div>
                        <div onclick="selectColor('blue')" class="w-8 h-8 rounded-full bg-blue-100 border border-gray-200 cursor-pointer hover:scale-110 transition"></div>
                        <div onclick="selectColor('green')" class="w-8 h-8 rounded-full bg-green-100 border border-gray-200 cursor-pointer hover:scale-110 transition"></div>
                        <div onclick="selectColor('yellow')" class="w-8 h-8 rounded-full bg-yellow-100 border border-gray-200 cursor-pointer hover:scale-110 transition"></div>
                        <div onclick="selectColor('purple')" class="w-8 h-8 rounded-full bg-purple-100 border border-gray-200 cursor-pointer hover:scale-110 transition"></div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Pilih Ikon</label>
                    <div class="grid grid-cols-6 gap-2 border p-3 rounded-lg h-32 overflow-y-auto bg-gray-50 custom-scrollbar">
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-utensils"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-bus"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-house"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-shirt"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-gamepad"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-blue-100 border-blue-500 border rounded cursor-pointer text-blue-600"><i class="fa-solid fa-book"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-heart-pulse"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-plane"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-paw"></i></div>
                        <div class="h-8 w-8 flex items-center justify-center bg-white rounded border hover:bg-blue-100 cursor-pointer text-gray-600"><i class="fa-solid fa-music"></i></div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 transform active:scale-95">
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>
</div>
