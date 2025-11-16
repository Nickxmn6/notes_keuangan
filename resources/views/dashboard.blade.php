<x-app-layout>
    <!-- Header -->
    <div class="mb-4 md:mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Dashboard</h1>
        <p class="text-sm md:text-base text-white">Selamat datang kembali, <span class="font-semibold text-purple-600">{{ Auth::user()->name }}</span>! 👋</p>
    </div>

    <!-- Stats Cards - 2 Columns Grid -->
    <div class="grid grid-cols-2 gap-3 md:gap-4 mb-4 md:mb-6">
        <!-- Total Notes -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl p-3 md:p-5 text-white shadow-lg hover:shadow-2xl transition-shadow duration-300">
            <div class="flex flex-col space-y-2">
                <div class="flex items-center justify-between">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <span class="text-2xl md:text-3xl font-bold">{{ \App\Models\Note::where('user_id', Auth::id())->count() }}</span>
                </div>
                <div>
                    <h3 class="text-sm md:text-base font-semibold">Total Notes</h3>
                    <p class="text-blue-100 text-xs">Catatan tersimpan</p>
                </div>
            </div>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl md:rounded-2xl p-3 md:p-5 text-white shadow-lg hover:shadow-2xl transition-shadow duration-300">
            <div class="flex flex-col space-y-2">
                <div class="flex items-center justify-between">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                    </div>
                    <span class="text-xl md:text-2xl font-bold">
                        @php
                            $income = \App\Models\Transaction::where('user_id', Auth::id())->where('type', 'income')->sum('amount');
                            if ($income >= 1000000) {
                                echo number_format($income / 1000000, 1) . 'jt';
                            } else if ($income >= 1000) {
                                echo number_format($income / 1000, 0) . 'k';
                            } else {
                                echo number_format($income, 0);
                            }
                        @endphp
                    </span>
                </div>
                <div>
                    <h3 class="text-sm md:text-base font-semibold">Pemasukan</h3>
                    <p class="text-green-100 text-xs">Total pendapatan</p>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl md:rounded-2xl p-3 md:p-5 text-white shadow-lg hover:shadow-2xl transition-shadow duration-300">
            <div class="flex flex-col space-y-2">
                <div class="flex items-center justify-between">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                        </svg>
                    </div>
                    <span class="text-xl md:text-2xl font-bold">
                        @php
                            $expense = \App\Models\Transaction::where('user_id', Auth::id())->where('type', 'expense')->sum('amount');
                            if ($expense >= 1000000) {
                                echo number_format($expense / 1000000, 1) . 'jt';
                            } else if ($expense >= 1000) {
                                echo number_format($expense / 1000, 0) . 'k';
                            } else {
                                echo number_format($expense, 0);
                            }
                        @endphp
                    </span>
                </div>
                <div>
                    <h3 class="text-sm md:text-base font-semibold">Pengeluaran</h3>
                    <p class="text-red-100 text-xs">Total pengeluaran</p>
                </div>
            </div>
        </div>

        <!-- Net Balance -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl md:rounded-2xl p-3 md:p-5 text-white shadow-lg hover:shadow-2xl transition-shadow duration-300">
            <div class="flex flex-col space-y-2">
                <div class="flex items-center justify-between">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xl md:text-2xl font-bold">
                        @php
                            $balance = $income - $expense;
                            if (abs($balance) >= 1000000) {
                                echo number_format($balance / 1000000, 1) . 'jt';
                            } else if (abs($balance) >= 1000) {
                                echo number_format($balance / 1000, 0) . 'k';
                            } else {
                                echo number_format($balance, 0);
                            }
                        @endphp
                    </span>
                </div>
                <div>
                    <h3 class="text-sm md:text-base font-semibold">Saldo</h3>
                    <p class="text-purple-100 text-xs">Saldo bersih</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - 2 Columns Grid -->
    <div class="mb-4 md:mb-6">
        <h2 class="text-base md:text-lg font-bold text-white mb-3">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('notes.create') }}" class="bg-white hover:bg-gray-50 rounded-lg md:rounded-xl p-3 md:p-4 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Buat Note</h4>
            </a>

            <a href="{{ route('transactions.create') }}" class="bg-white hover:bg-gray-50 rounded-lg md:rounded-xl p-3 md:p-4 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-lg flex items-center justify-center mb-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Tambah Transaksi</h4>
            </a>

            <a href="{{ route('notes.index') }}" class="bg-white hover:bg-gray-50 rounded-lg md:rounded-xl p-3 md:p-4 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Lihat Notes</h4>
            </a>

            <a href="{{ route('transactions.index') }}" class="bg-white hover:bg-gray-50 rounded-lg md:rounded-xl p-3 md:p-4 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-orange-100 rounded-lg flex items-center justify-center mb-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Riwayat Transaksi</h4>
            </a>
        </div>
    </div>

    <!-- Recent Activity - 2 Columns Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
        <!-- Recent Notes -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3">
                <h3 class="text-white font-semibold flex items-center text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Notes Terbaru
                </h3>
            </div>
            <div class="p-3 space-y-2 max-h-64 md:max-h-80 overflow-y-auto">
                @php
                    $recentNotes = \App\Models\Note::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @forelse($recentNotes as $note)
                    <a href="{{ route('notes.show', $note) }}" class="block p-2 md:p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <h4 class="font-semibold text-gray-800 truncate text-xs md:text-sm">{{ $note->title }}</h4>
                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($note->content, 40) }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $note->created_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <p class="text-gray-400 text-center py-6 text-xs md:text-sm">Belum ada notes</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-3">
                <h3 class="text-white font-semibold flex items-center text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Transaksi Terbaru
                </h3>
            </div>
            <div class="p-3 space-y-2 max-h-64 md:max-h-80 overflow-y-auto">
                @php
                    $recentTransactions = \App\Models\Transaction::where('user_id', Auth::id())
                        ->orderBy('transaction_date', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @forelse($recentTransactions as $transaction)
                    <div class="p-2 md:p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 truncate text-xs md:text-sm">{{ $transaction->category }}</h4>
                                <p class="text-xs text-gray-500 truncate">{{ Str::limit($transaction->description ?? 'Tidak ada deskripsi', 30) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $transaction->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-bold text-xs md:text-sm {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }}
                                    @php
                                        $amount = $transaction->amount;
                                        if ($amount >= 1000000) {
                                            echo number_format($amount / 1000000, 1) . 'jt';
                                        } else if ($amount >= 1000) {
                                            echo number_format($amount / 1000, 0) . 'k';
                                        } else {
                                            echo number_format($amount, 0);
                                        }
                                    @endphp
                                </p>
                                <span class="text-xs {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type == 'income' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-6 text-xs md:text-sm">Belum ada transaksi</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
