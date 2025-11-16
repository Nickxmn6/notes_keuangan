<x-app-layout>
    <div class="space-y-4 md:space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 md:gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-1 md:mb-2">💰 Transaksi Keuangan</h1>
                <p class="text-sm md:text-base text-gray-300">Kelola pemasukan dan pengeluaran Anda</p>
            </div>
            <a href="{{ route('transactions.create') }}" class="w-full md:w-auto glass-card px-4 py-2.5 md:px-6 md:py-3 rounded-xl text-white font-medium hover:scale-105 transition-all flex items-center justify-center space-x-2 shadow-lg text-sm md:text-base">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Transaksi</span>
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
            <div class="glass-card rounded-xl md:rounded-2xl p-4 md:p-6 shadow-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500/20 rounded-lg md:rounded-xl p-2 md:p-3 border border-green-400/30">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4 min-w-0 flex-1">
                        <p class="text-xs md:text-sm font-medium text-gray-300 truncate">Total Pemasukan</p>
                        <p class="text-lg md:text-2xl font-semibold text-green-400 truncate">
                            @php
                                $income = $totalIncome;
                                if ($income >= 1000000) {
                                    echo 'Rp ' . number_format($income / 1000000, 1) . 'jt';
                                } else if ($income >= 1000) {
                                    echo 'Rp ' . number_format($income / 1000, 0) . 'k';
                                } else {
                                    echo 'Rp ' . number_format($income, 0);
                                }
                            @endphp
                        </p>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-xl md:rounded-2xl p-4 md:p-6 shadow-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500/20 rounded-lg md:rounded-xl p-2 md:p-3 border border-red-400/30">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4 min-w-0 flex-1">
                        <p class="text-xs md:text-sm font-medium text-gray-300 truncate">Total Pengeluaran</p>
                        <p class="text-lg md:text-2xl font-semibold text-red-400 truncate">
                            @php
                                $expense = $totalExpense;
                                if ($expense >= 1000000) {
                                    echo 'Rp ' . number_format($expense / 1000000, 1) . 'jt';
                                } else if ($expense >= 1000) {
                                    echo 'Rp ' . number_format($expense / 1000, 0) . 'k';
                                } else {
                                    echo 'Rp ' . number_format($expense, 0);
                                }
                            @endphp
                        </p>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-xl md:rounded-2xl p-4 md:p-6 shadow-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0 {{ $balance >= 0 ? 'bg-blue-500/20 border-blue-400/30' : 'bg-red-500/20 border-red-400/30' }} rounded-lg md:rounded-xl p-2 md:p-3 border">
                        <svg class="h-5 w-5 md:h-6 md:w-6 {{ $balance >= 0 ? 'text-blue-400' : 'text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4 min-w-0 flex-1">
                        <p class="text-xs md:text-sm font-medium text-gray-300 truncate">Saldo</p>
                        <p class="text-lg md:text-2xl font-semibold {{ $balance >= 0 ? 'text-blue-400' : 'text-red-400' }} truncate">
                            @php
                                $bal = abs($balance);
                                if ($bal >= 1000000) {
                                    echo 'Rp ' . number_format($balance / 1000000, 1) . 'jt';
                                } else if ($bal >= 1000) {
                                    echo 'Rp ' . number_format($balance / 1000, 0) . 'k';
                                } else {
                                    echo 'Rp ' . number_format($balance, 0);
                                }
                            @endphp
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="glass-card rounded-xl md:rounded-2xl p-4 md:p-6 shadow-xl">
            <form method="GET" action="{{ route('transactions.index') }}" class="space-y-3 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-5 md:gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-white mb-1.5 md:mb-2">Tipe</label>
                    <select name="type" class="w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                        <option value="">Semua</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-white mb-1.5 md:mb-2">Kategori</label>
                    <select name="category" class="w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-white mb-1.5 md:mb-2">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-white mb-1.5 md:mb-2">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-white mb-1.5 md:mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi..." class="w-full px-3 py-2 md:px-4 md:py-3 text-sm md:text-base bg-white/10 border border-white/20 rounded-lg md:rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                </div>

                <div class="md:col-span-2 lg:col-span-5 flex gap-2">
                    <button type="submit" class="flex-1 md:flex-none glass-card px-4 py-2 md:px-6 md:py-3 rounded-lg md:rounded-xl text-white text-sm md:text-base font-medium hover:scale-105 transition-all shadow-lg">
                        Filter
                    </button>
                    <a href="{{ route('transactions.index') }}" class="flex-1 md:flex-none glass-effect px-4 py-2 md:px-6 md:py-3 rounded-lg md:rounded-xl text-gray-300 text-sm md:text-base font-medium hover:bg-white/10 transition-all text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Transactions List -->
        <div class="glass-card rounded-xl md:rounded-2xl shadow-xl overflow-hidden">
            @if($transactions->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-white/5 border-b border-white/10">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Jumlah</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($transactions as $transaction)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white">
                                        {{ $transaction->formatted_date }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($transaction->type == 'income')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-300 border border-green-400/30">
                                                Pemasukan
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-300 border border-red-400/30">
                                                Pengeluaran
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white">
                                        {{ $transaction->category }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-300 max-w-xs truncate">
                                        {{ $transaction->description ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right font-semibold {{ $transaction->type == 'income' ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }} {{ $transaction->formatted_amount }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('transactions.show', $transaction) }}" class="text-blue-400 hover:text-blue-300">Lihat</a>
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-gray-300 hover:text-white">Edit</a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden divide-y divide-white/10">
                    @foreach($transactions as $transaction)
                        <div class="p-4 hover:bg-white/5 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($transaction->type == 'income')
                                            <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-green-500/20 text-green-300 border border-green-400/30">
                                                Pemasukan
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-red-500/20 text-red-300 border border-red-400/30">
                                                Pengeluaran
                                            </span>
                                        @endif
                                        <span class="text-xs text-gray-400">{{ $transaction->formatted_date }}</span>
                                    </div>
                                    <h3 class="text-sm font-semibold text-white mb-1">{{ $transaction->category }}</h3>
                                    <p class="text-xs text-gray-400 truncate">{{ $transaction->description ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                                <div class="text-right ml-3 flex-shrink-0">
                                    <p class="text-lg font-bold {{ $transaction->type == 'income' ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }}
                                        @php
                                            $amount = $transaction->amount;
                                            if ($amount >= 1000000) {
                                                echo number_format($amount / 1000000, 1) . 'jt';
                                            } else if ($amount >= 1000) {
                                                echo number_format($amount / 1000, 0) . 'k';
                                            } else {
                                                echo 'Rp' . number_format($amount, 0);
                                            }
                                        @endphp
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <a href="{{ route('transactions.show', $transaction) }}" class="flex-1 text-center py-2 bg-blue-500/20 text-blue-300 rounded-lg hover:bg-blue-500/30 transition">
                                    Lihat
                                </a>
                                <a href="{{ route('transactions.edit', $transaction) }}" class="flex-1 text-center py-2 bg-gray-500/20 text-gray-300 rounded-lg hover:bg-gray-500/30 transition">
                                    Edit
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-2 bg-red-500/20 text-red-300 rounded-lg hover:bg-red-500/30 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 md:p-6 border-t border-white/10">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="text-center py-12 px-4 md:px-6">
                    <svg class="mx-auto h-12 w-12 md:h-16 md:w-16 text-gray-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg md:text-xl font-semibold text-white">Tidak ada transaksi</h3>
                    <p class="mt-2 text-sm text-gray-300">Mulai dengan menambahkan transaksi baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center glass-card px-4 py-2 md:px-6 md:py-3 rounded-lg md:rounded-xl text-white text-sm md:text-base font-medium hover:scale-105 transition-all shadow-lg">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Transaksi
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
