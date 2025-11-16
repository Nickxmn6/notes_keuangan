<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">Tambah Transaksi Baru</h1>
                <p class="text-sm text-gray-300">Catat pemasukan atau pengeluaran Anda</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-sm md:text-base text-gray-300 hover:text-white transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="glass-card rounded-xl md:rounded-2xl shadow-xl overflow-hidden">
            <div class="p-4 md:p-6 lg:p-8">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf

                    <!-- Type -->
                    <div class="mb-5 md:mb-6">
                        <label class="block text-sm font-medium text-white mb-3">Tipe Transaksi <span class="text-red-400">*</span></label>
                        <div class="grid grid-cols-2 gap-3 md:gap-4">
                            <label class="relative flex cursor-pointer rounded-lg md:rounded-xl border p-3 md:p-4 focus:outline-none transition {{ old('type') == 'income' ? 'border-green-500 ring-2 ring-green-500 bg-green-500/10' : 'border-white/20 hover:border-white/40' }}">
                                <input type="radio" name="type" value="income" class="sr-only" {{ old('type') == 'income' ? 'checked' : '' }} required>
                                <div class="flex flex-1 items-center">
                                    <div class="flex-1">
                                        <span class="block text-sm md:text-base font-medium text-white">Pemasukan</span>
                                        <span class="mt-1 text-xs md:text-sm text-gray-300">Uang masuk</span>
                                    </div>
                                    <svg class="h-5 w-5 text-green-400 {{ old('type') == 'income' ? '' : 'invisible' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>

                            <label class="relative flex cursor-pointer rounded-lg md:rounded-xl border p-3 md:p-4 focus:outline-none transition {{ old('type') == 'expense' ? 'border-red-500 ring-2 ring-red-500 bg-red-500/10' : 'border-white/20 hover:border-white/40' }}">
                                <input type="radio" name="type" value="expense" class="sr-only" {{ old('type') == 'expense' ? 'checked' : '' }} required>
                                <div class="flex flex-1 items-center">
                                    <div class="flex-1">
                                        <span class="block text-sm md:text-base font-medium text-white">Pengeluaran</span>
                                        <span class="mt-1 text-xs md:text-sm text-gray-300">Uang keluar</span>
                                    </div>
                                    <svg class="h-5 w-5 text-red-400 {{ old('type') == 'expense' ? '' : 'invisible' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="mb-5 md:mb-6">
                        <label for="amount" class="block text-sm font-medium text-white mb-2">
                            Jumlah (Rp) <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 md:left-4 top-2.5 md:top-3 text-sm md:text-base text-gray-400">Rp</span>
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount') }}"
                                class="pl-10 md:pl-12 block w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition @error('amount') border-red-500 ring-2 ring-red-500/50 @enderror"
                                placeholder="0" required>
                        </div>
                        @error('amount')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-5 md:mb-6">
                        <label for="category" class="block text-sm font-medium text-white mb-2">
                            Kategori <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}"
                            list="categories"
                            class="block w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition @error('category') border-red-500 ring-2 ring-red-500/50 @enderror"
                            placeholder="Contoh: Gaji, Makan, Transport, Belanja" required>

                        @if($categories->count() > 0)
                            <datalist id="categories">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                        @endif

                        @error('category')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs md:text-sm text-gray-400">Ketik atau pilih dari kategori yang ada</p>
                    </div>

                    <!-- Transaction Date -->
                    <div class="mb-5 md:mb-6">
                        <label for="transaction_date" class="block text-sm font-medium text-white mb-2">
                            Tanggal Transaksi <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date"
                            value="{{ old('transaction_date', date('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="block w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition @error('transaction_date') border-red-500 ring-2 ring-red-500/50 @enderror"
                            required>
                        @error('transaction_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6 md:mb-8">
                        <label for="description" class="block text-sm font-medium text-white mb-2">
                            Deskripsi (Opsional)
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="block w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition @error('description') border-red-500 ring-2 ring-red-500/50 @enderror"
                            placeholder="Tambahkan catatan atau deskripsi transaksi...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                        <a href="{{ route('transactions.index') }}" class="w-full sm:w-auto px-5 py-2.5 md:px-6 md:py-3 text-sm md:text-base border border-white/20 rounded-lg md:rounded-xl text-gray-300 hover:bg-white/5 transition duration-150 text-center">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 md:px-6 md:py-3 text-sm md:text-base bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg md:rounded-xl transition duration-150">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Dynamic radio button styling
        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('input[name="type"]').forEach(r => {
                    const label = r.closest('label');
                    const svg = label.querySelector('svg');
                    if (r.checked) {
                        label.classList.add('ring-2');
                        if (r.value === 'income') {
                            label.classList.add('border-green-500', 'ring-green-500', 'bg-green-500/10');
                            label.classList.remove('border-white/20', 'hover:border-white/40');
                        } else {
                            label.classList.add('border-red-500', 'ring-red-500', 'bg-red-500/10');
                            label.classList.remove('border-white/20', 'hover:border-white/40');
                        }
                        svg.classList.remove('invisible');
                    } else {
                        label.classList.remove('ring-2', 'border-green-500', 'border-red-500', 'ring-green-500', 'ring-red-500', 'bg-green-500/10', 'bg-red-500/10');
                        label.classList.add('border-white/20', 'hover:border-white/40');
                        svg.classList.add('invisible');
                    }
                });
            });
        });
    </script>
</x-app-layout>
