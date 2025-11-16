<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">📋 Monthly Checklist</h1>
                <p class="text-gray-300">Kelola tagihan dan tugas rutin bulanan Anda</p>
            </div>
            <a href="{{ route('notes.create') }}" class="glass-card px-6 py-3 rounded-xl text-white font-medium hover:scale-105 transition-all flex items-center space-x-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Item</span>
            </a>
        </div>

        <!-- Month Progress -->
        <div class="glass-card rounded-2xl p-6 shadow-xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">{{ now()->format('F Y') }}</h2>
                    <p class="text-gray-300 text-sm">Bulan ke-{{ now()->format('n') }} dari 12</p>
                </div>

                <!-- Progress Bar -->
                <div class="w-full md:w-80">
                    <div class="flex justify-between text-sm text-white mb-2">
                        <span>Progress Bulan Ini</span>
                        <span id="progressText">
                            @php
                                $completedCount = $notes->filter(function($note) {
                                    return $note->completed_at && \Carbon\Carbon::parse($note->completed_at)->isSameMonth(now());
                                })->count();
                                $totalCount = $notes->count();
                                $percentage = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
                            @endphp
                            {{ $completedCount }}/{{ $totalCount }} ({{ $percentage }}%)
                        </span>
                    </div>
                    <div class="h-4 bg-white/10 rounded-full overflow-hidden border border-white/20">
                        <div id="progressBar" class="h-full bg-gradient-to-r from-gray-500 via-gray-400 to-gray-500 transition-all duration-500 shadow-lg" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checklist Items -->
        <div class="grid gap-4">
            @forelse($notes as $note)
            @php
                $isCompleted = $note->completed_at && \Carbon\Carbon::parse($note->completed_at)->isSameMonth(now());
            @endphp
            <div class="glass-card rounded-xl p-5 hover:shadow-2xl transition-all duration-300 {{ $isCompleted ? 'opacity-75' : '' }}" id="note-{{ $note->id }}">
                <div class="flex items-start space-x-4">
                    <!-- Checkbox -->
                    <label class="flex items-center cursor-pointer group">
                        <input
                            type="checkbox"
                            class="hidden peer"
                            data-note-id="{{ $note->id }}"
                            {{ $isCompleted ? 'checked' : '' }}
                            onchange="toggleNote({{ $note->id }}, this)">
                        <div class="w-7 h-7 rounded-lg border-2 border-gray-400 flex items-center justify-center transition-all peer-checked:bg-gradient-to-br peer-checked:from-gray-500 peer-checked:to-gray-700 peer-checked:border-transparent group-hover:scale-110 group-hover:border-gray-300">
                            <svg class="w-5 h-5 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </label>

                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-white mb-1 {{ $isCompleted ? 'line-through' : '' }}">{{ $note->title }}</h3>
                        @if($note->description)
                        <p class="text-gray-300 text-sm mb-2 {{ $isCompleted ? 'line-through' : '' }}">{{ $note->description }}</p>
                        @endif

                        <div class="flex flex-wrap gap-2 items-center">
                            @if($note->amount)
                            <span class="px-3 py-1 bg-green-500/20 text-green-300 rounded-lg font-medium text-sm border border-green-400/30">
                                💰 Rp {{ number_format($note->amount, 0, ',', '.') }}
                            </span>
                            @endif

                            @if($note->is_recurring)
                            <span class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-lg font-medium text-sm border border-blue-400/30">
                                🔄 Berulang
                            </span>
                            @endif
                        </div>

                        <div id="completion-status-{{ $note->id }}">
                            @if($isCompleted)
                            <p class="text-xs text-green-400 mt-2 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Selesai pada {{ \Carbon\Carbon::parse($note->completed_at)->format('d M Y, H:i') }}</span>
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ route('notes.edit', $note) }}"
                           class="glass-effect p-2 rounded-lg text-blue-300 hover:bg-blue-500/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <button onclick="deleteNote({{ $note->id }})"
                                class="glass-effect p-2 rounded-lg text-red-300 hover:bg-red-500/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="glass-card rounded-xl p-12 text-center">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">Belum ada checklist</h3>
                <p class="text-gray-300 mb-6">Mulai tambahkan tagihan dan tugas rutin bulanan Anda</p>
                <a href="{{ route('notes.create') }}" class="inline-flex items-center space-x-2 glass-card px-6 py-3 rounded-xl text-white font-medium hover:scale-105 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Item Pertama</span>
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <script>
        function toggleNote(noteId, checkbox) {
            // Disable checkbox sementara untuk mencegah double-click
            checkbox.disabled = true;

            fetch(`/notes/${noteId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    toggle_complete: true
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const noteCard = document.getElementById(`note-${noteId}`);
                    const statusDiv = document.getElementById(`completion-status-${noteId}`);
                    const titleElement = noteCard.querySelector('h3');
                    const descElement = noteCard.querySelector('p.text-gray-300');

                    if (data.completed) {
                        // Item completed
                        statusDiv.innerHTML = `
                            <p class="text-xs text-green-400 mt-2 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Selesai pada ${data.completed_at}</span>
                            </p>
                        `;
                        noteCard.classList.add('opacity-75');
                        titleElement.classList.add('line-through');
                        if (descElement) descElement.classList.add('line-through');

                        // Show toast
                        if (typeof showToast === 'function') {
                            showToast(data.message || '✅ Item ditandai selesai!', 'success');
                        }
                    } else {
                        // Item uncompleted
                        statusDiv.innerHTML = '';
                        noteCard.classList.remove('opacity-75');
                        titleElement.classList.remove('line-through');
                        if (descElement) descElement.classList.remove('line-through');

                        // Show toast
                        if (typeof showToast === 'function') {
                            showToast(data.message || '↩️ Item dibatalkan dari selesai', 'info');
                        }
                    }

                    // Update progress bar
                    updateProgress();
                } else {
                    // Revert checkbox jika gagal
                    checkbox.checked = !checkbox.checked;
                    if (typeof showToast === 'function') {
                        showToast('❌ Gagal memperbarui status', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert checkbox jika error
                checkbox.checked = !checkbox.checked;
                if (typeof showToast === 'function') {
                    showToast('❌ Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            })
            .finally(() => {
                // Enable checkbox kembali
                checkbox.disabled = false;
            });
        }

        function deleteNote(noteId) {
            if (confirm('⚠️ Yakin ingin menghapus item ini?\n\nTindakan ini tidak dapat dibatalkan!')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/notes/${noteId}`;

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = document.querySelector('meta[name="csrf-token"]').content;

                form.appendChild(methodField);
                form.appendChild(csrfField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function updateProgress() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][data-note-id]');
            const total = checkboxes.length;
            const completed = Array.from(checkboxes).filter(cb => cb.checked).length;
            const percentage = total > 0 ? Math.round((completed / total) * 100) : 0;

            const progressText = document.getElementById('progressText');
            const progressBar = document.getElementById('progressBar');

            if (progressText && progressBar) {
                progressText.textContent = `${completed}/${total} (${percentage}%)`;
                progressBar.style.width = `${percentage}%`;
            }
        }
    </script>
</x-app-layout>
