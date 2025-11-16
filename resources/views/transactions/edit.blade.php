<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Transaksi') }}
            </h2>
            <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                        @csrf
                        @method('PUT')

                        <!-- Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer rounded-lg border p-4 focus:outline-none {{ old('type', $transaction->type) == 'income' ? 'border-green-600 ring-2 ring-green-600' : 'border-gray-300' }}">
                                    <input type="radio" name="type" value="income" class="sr-only" {{ old('type', $transaction->type) == 'income' ? 'checked' : '' }} required>
                                    <div class="flex flex-1">
                                        <div class="flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Pemasukan</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">Uang masuk</span>
                                        </div>
                                    </div>
                                    <svg class="h-5 w-5 text-green-600 {{ old('type', $transaction->type) == 'income' ? '' : 'invisible' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </label>

                                <label class="relative flex cursor-pointer rounded-lg border p-4 focus:outline-none {{ old('type', $transaction->type) == 'expense' ? 'border-red-600 ring-2 ring-red-600' : 'border-gray-300' }}">
                                    <input type="radio" name="type" value="expense" class="sr-only" {{ old('type', $transaction->type) == 'expense' ? 'checked' : '' }} required>
                                    <div class="flex flex-1">
                                        <div class="flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Pengeluaran</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">Uang keluar</span>
                                        </div>
                                    </div>
                                    <svg class="h-5 w-5 text-red-600 {{ old('type', $transaction->type) == 'expense' ? '' : 'invisible' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount', $transaction->amount) }}"
                                    class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('amount') border-red-500 @enderror"
                                    placeholder="0" required>
                            </div>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-6">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="category" id="category" value="{{ old('category', $transaction->category) }}"
                                list="categories"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category') border-red-500 @enderror"
                                placeholder="Contoh: Gaji, Makan, Transport, Belanja" required>

                            @if($categories->count() > 0)
                                <datalist id="categories">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">
                                    @endforeach
                                </datalist>
                            @endif

                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Ketik atau pilih dari kategori yang ada</p>
                        </div>

                        <!-- Transaction Date -->
                        <div class="mb-6">
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Transaksi <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="transaction_date" id="transaction_date"
                                value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('transaction_date') border-red-500 @enderror"
                                required>
                            @error('transaction_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi (Opsional)
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                placeholder="Tambahkan catatan atau deskripsi transaksi...">{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('transactions.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-150">
                                Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
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
                        label.classList.add(r.value === 'income' ? 'border-green-600' : 'border-red-600');
                        label.classList.add(r.value === 'income' ? 'ring-green-600' : 'ring-red-600');
                        svg.classList.remove('invisible');
                    } else {
                        label.classList.remove('ring-2', 'border-green-600', 'border-red-600', 'ring-green-600', 'ring-red-600');
                        label.classList.add('border-gray-300');
                        svg.classList.add('invisible');
                    }
                });
            });
        });
    </script>
</x-app-layout>
