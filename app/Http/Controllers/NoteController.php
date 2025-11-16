<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentMonth = $request->get('month', now()->format('Y-m'));

        $notes = Note::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notes.index', compact('notes', 'currentMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'amount' => 'nullable|numeric|min:0',
                'is_recurring' => 'boolean'
            ]);

            $note = Note::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'amount' => $validated['amount'] ?? null,
                'is_recurring' => $request->boolean('is_recurring', true),
                'completed_at' => null
            ]);

            return redirect()->route('notes.index')
                ->with('success', '✨ Item "' . $note->title . '" berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Gagal menambahkan item. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        // Handle toggle completion (AJAX request)
        if ($request->has('toggle_complete')) {
            $currentMonth = Carbon::now()->format('Y-m');
            $completedMonth = $note->completed_at ? Carbon::parse($note->completed_at)->format('Y-m') : null;

            // Toggle logic: jika sudah completed bulan ini, uncheck. Jika belum, check.
            if ($completedMonth === $currentMonth) {
                // Uncheck - set completed_at ke null
                $note->completed_at = null;
                $message = '↩️ Item dibatalkan dari selesai';
                $isCompleted = false;
            } else {
                // Check - set completed_at ke sekarang
                $note->completed_at = now();
                $message = '✅ Item ditandai selesai!';
                $isCompleted = true;
            }

            $note->save();

            return response()->json([
                'success' => true,
                'completed' => $isCompleted,
                'completed_at' => $note->completed_at ? $note->completed_at->format('d M Y, H:i') : null,
                'message' => $message
            ]);
        }

        // Regular update (dari form edit)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'nullable|numeric|min:0',
            'is_recurring' => 'boolean'
        ]);

        $oldTitle = $note->title;
        $note->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'amount' => $validated['amount'] ?? null,
            'is_recurring' => $request->boolean('is_recurring', true)
        ]);

        return redirect()->route('notes.index')
            ->with('success', '🎉 Item "' . $oldTitle . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $title = $note->title;
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', '🗑️ Item "' . $title . '" berhasil dihapus!');
    }
}
