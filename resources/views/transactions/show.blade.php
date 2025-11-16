<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">Detail Transaksi</h1>
                <p class="text-sm text-gray-300">Informasi lengkap transaksi</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-sm md:text-base text-gray-300 hover:text-white transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Transaction Details -->
        <div class="glass-card rounded-xl md:rounded-2xl shadow-xl overflow-hidden">
            <div class="p-4 md:p-6 lg:p-8">
                <!-- Transaction Type Badge -->
                <div class="mb-6">
                    @if($transaction->type == 'income')
                        <span class="inline-flex items-center px-3 py-1.5 md:px-4 md:py-2 rounded-full text-sm md:text-base font-semibold bg-green-500/20 text-green-300 border border-green-400/30">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                            Pemasukan
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1.5 md:px-4 md:py-2 rounded-full text-sm md:text-base font-semibold bg-red-500/20 text-red-300 border border-red-400/30">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                            Pengeluaran
                        </span>
                    @endif
                </div>

                <!-- Amount -->
                <div class="mb-8">
                    <p class="text-xs md:text-sm text-gray-400 mb-2">Jumlah</p>
                    <p class="text-3xl md:text-4xl lg:text-5xl font-bold {{ $transaction->type == 'income' ? 'text-green-400' : 'text-red-400' }}">
                        {{ $transaction->type == 'income' ? '+' : '-' }} {{ $transaction->formatted_amount }}
                    </p>
                </div>

                <!-- Details Grid -->
                <div class="space-y-5 md:space-y-6">
                    <!-- Category -->
                    <div class="border-b border-white/10 pb-4">
                        <p class="text-xs md:text-sm font-medium text-gray-400 mb-2">Kategori</p>
                        <p class="text-base md:text-lg text-white font-medium">{{ $transaction->category }}</p>
                    </div>

                    <!-- Transaction Date -->
                    <div class="border-b border-white/10 pb-4">
                        <p class="text-xs md:text-sm font-medium text-gray-400 mb-2">Tanggal Transaksi</p>
                        <p class="text-base md:text-lg text-white">{{ $transaction->formatted_date }}</p>
                    </div>

                    <!-- Description -->
                    <div class="border-b border-white/10 pb-4">
                        <p class="text-xs md:text-sm font-medium text-gray-400 mb-2">Deskripsi</p>
                        <p class="text-base md:text-lg text-white">{{ $transaction->description ?? '-' }}</p>
                    </div>

                    <!-- Created At -->
                    <div class="border-b border-white/10 pb-4">
                        <p class="text-xs md:text-sm font-medium text-gray-400 mb-2">Dibuat Pada</p>
                        <p class="text-base md:text-lg text-white">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <!-- Updated At -->
                    <div class="pb-4">
                        <p class="text-xs md:text-sm font-medium text-gray-400 mb-2">Terakhir Diperbarui</p>
                        <p class="text-base md:text-lg text-white">{{ $transaction->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('transactions.edit', $transaction) }}" class="w-full sm:w-auto px-5 py-2.5 md:px-6 md:py-3 text-sm md:text-base bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg md:rounded-xl transition duration-150 text-center">
                        Edit Transaksi
                    </a>
                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-5 py-2.5 md:px-6 md:py-3 text-sm md:text-base bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg md:rounded-xl transition duration-150">
                            Hapus Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
