<x-app-layout>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('notes.index') }}" class="inline-flex items-center space-x-2 text-purple-200 hover:text-white transition mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Checklist</span>
            </a>
            <h1 class="text-3xl font-bold text-white mb-2">✏️ Edit Item</h1>
            <p class="text-purple-200">Perbarui informasi item checklist</p>
        </div>

        <!-- Form -->
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            <form action="{{ route('notes.update', $note) }}" method="POST" class="space-y-6" id="editNoteForm">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-white mb-2">
                        Judul Item <span class="text-red-400">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title', $note->title) }}"
                        placeholder="Contoh: Bayar Listrik PLN"
                        required
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
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
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition resize-none">{{ old('description', $note->description) }}</textarea>
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
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-purple-300 font-medium">Rp</span>
                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            value="{{ old('amount', $note->amount) }}"
                            placeholder="0"
                            min="0"
                            step="0.01"
                            class="w-full pl-12 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    @error('amount')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-purple-300">Masukkan nominal tagihan jika ada</p>
                </div>

                <!-- Item Berulang -->
                <div class="glass-effect rounded-xl p-4">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_recurring"
                            id="is_recurring"
                            value="1"
                            {{ old('is_recurring', $note->is_recurring) ? 'checked' : '' }}
                            class="mt-1 w-5 h-5 rounded border-2 border-purple-400 text-purple-600 focus:ring-2 focus:ring-purple-500">
                        <div>
                            <span class="block text-white font-medium">Item Berulang Tiap Bulan</span>
                            <span class="block text-sm text-purple-200 mt-1">Checklist akan direset otomatis setiap bulan</span>
                        </div>
                    </label>
                </div>

                <!-- Status -->
                @if($note->completed_at)
                <div class="glass-effect rounded-xl p-4 bg-green-500/10 border border-green-400/30">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-green-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <span class="block text-green-300 font-medium">Item Sudah Selesai</span>
                            <span class="block text-sm text-green-200 mt-1">Diselesaikan pada {{ \Carbon\Carbon::parse($note->completed_at)->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button
                        type="submit"
                        class="flex-1 glass-card px-6 py-3 rounded-xl text-white font-medium hover:scale-105 transition-all flex items-center justify-center space-x-2 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Update Item</span>
                    </button>
                    <a
                        href="{{ route('notes.index') }}"
                        class="flex-1 glass-effect px-6 py-3 rounded-xl text-purple-200 font-medium hover:bg-white/10 transition-all flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Delete Section -->
        <div class="mt-6 glass-card rounded-xl p-6 bg-red-500/10 border border-red-400/30">
            <h3 class="text-red-300 font-semibold mb-2 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Zona Berbahaya</span>
            </h3>
            <p class="text-sm text-red-200 mb-4">Hapus item ini secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
            <form action="{{ route('notes.destroy', $note) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <button
                    type="button"
                    onclick="confirmDelete()"
                    class="glass-effect px-6 py-3 rounded-xl text-red-300 font-medium hover:bg-red-500/20 transition-all flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Hapus Item</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('⚠️ Yakin ingin menghapus item "{{ $note->title }}"?\n\nTindakan ini tidak dapat dibatalkan!')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</x-app-layout>
