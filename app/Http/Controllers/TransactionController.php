<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
                             ->paginate(15);

        // Get categories for filter
        $categories = Transaction::where('user_id', Auth::id())
                                ->select('category')
                                ->distinct()
                                ->pluck('category');

        // Calculate totals
        $totalIncome = Transaction::where('user_id', Auth::id())
                                 ->where('type', 'income')
                                 ->sum('amount');

        $totalExpense = Transaction::where('user_id', Auth::id())
                                  ->where('type', 'expense')
                                  ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions', 'categories', 'totalIncome', 'totalExpense', 'balance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get existing categories for suggestions
        $categories = Transaction::where('user_id', Auth::id())
                                ->select('category')
                                ->distinct()
                                ->pluck('category');

        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'transaction_date' => 'required|date|before_or_equal:today',
        ], [
            'type.required' => 'Tipe transaksi harus dipilih',
            'type.in' => 'Tipe transaksi tidak valid',
            'amount.required' => 'Jumlah harus diisi',
            'amount.numeric' => 'Jumlah harus berupa angka',
            'amount.min' => 'Jumlah minimal Rp 0.01',
            'category.required' => 'Kategori harus diisi',
            'transaction_date.required' => 'Tanggal transaksi harus diisi',
            'transaction_date.date' => 'Format tanggal tidak valid',
            'transaction_date.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'transaction_date' => $validated['transaction_date'],
        ]);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Authorization check
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Authorization check
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get existing categories for suggestions
        $categories = Transaction::where('user_id', Auth::id())
                                ->select('category')
                                ->distinct()
                                ->pluck('category');

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Authorization check
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'transaction_date' => 'required|date|before_or_equal:today',
        ], [
            'type.required' => 'Tipe transaksi harus dipilih',
            'type.in' => 'Tipe transaksi tidak valid',
            'amount.required' => 'Jumlah harus diisi',
            'amount.numeric' => 'Jumlah harus berupa angka',
            'amount.min' => 'Jumlah minimal Rp 0.01',
            'category.required' => 'Kategori harus diisi',
            'transaction_date.required' => 'Tanggal transaksi harus diisi',
            'transaction_date.date' => 'Format tanggal tidak valid',
            'transaction_date.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Authorization check
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaksi berhasil dihapus!');
    }
}
