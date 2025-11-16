<x-app-layout>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('notes.index') }}" class="inline-flex items-center space-x-2 text-gray-300 hover:text-white transition mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Checklist</span>
            </a>
            <h1 class="text-3xl font-bold text-white mb-2">➕ Tambah Item Baru</h1>
            <p class="text-gray-300">Buat tagihan atau tugas rutin bulanan</p>
        </div>

        <!-- Form -->
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            <form action="{{ route('notes.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-white mb-2">
                        Judul Item <span class="text-red-400">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Bayar Listrik PLN"
                        required
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                    @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-white mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        placeholder="Tambahkan catatan atau detail..."
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nominal -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-white mb-2">
                        Nominal (Opsional)
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            value="{{ old('amount') }}"
                            placeholder="0"
                            min="0"
                            step="0.01"
                            class="w-full pl-12 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                    </div>
                    @error('amount')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-400">Masukkan nominal tagihan jika ada</p>
                </div>

                <!-- Item Berulang -->
                <div class="glass-effect rounded-xl p-4">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_recurring"
                            id="is_recurring"
                            value="1"
                            checked
                            class="mt-1 w-5 h-5 rounded border-2 border-gray-400 text-gray-600 focus:ring-2 focus:ring-gray-500">
                        <div>
                            <span class="block text-white font-medium">Item Berulang Tiap Bulan</span>
                            <span class="block text-sm text-gray-300 mt-1">Checklist akan direset otomatis setiap tanggal 1</span>
                        </div>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button
                        type="submit"
                        class="flex-1 glass-card px-6 py-3 rounded-xl text-white font-medium hover:scale-105 transition-all flex items-center justify-center space-x-2 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Item</span>
                    </button>
                    <a
                        href="{{ route('notes.index') }}"
                        class="flex-1 glass-effect px-6 py-3 rounded-xl text-gray-300 font-medium hover:bg-white/10 transition-all flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="mt-6 glass-effect rounded-xl p-4">
            <h3 class="text-white font-semibold mb-2 flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Tips</span>
            </h3>
            <ul class="text-sm text-gray-300 space-y-1 ml-7">
                <li>• Gunakan nama yang jelas seperti "Bayar Listrik" atau "Iuran Keamanan"</li>
                <li>• Tambahkan nominal untuk tracking pengeluaran bulanan</li>
                <li>• Item berulang akan otomatis reset setiap tanggal 1</li>
                <li>• Status checklist akan tersimpan sampai akhir bulan</li>
            </ul>
        </div>
    </div>
</x-app-layout>
