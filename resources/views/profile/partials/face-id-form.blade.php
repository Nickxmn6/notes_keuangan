<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            {{ __('Face ID Login') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Daftarkan wajah Anda untuk login lebih cepat dan aman tanpa password.') }}
        </p>
    </header>

    <!-- Status Face ID -->
    <div class="mt-6">
        @if(auth()->user()->face_descriptor)
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-green-800">Face ID Aktif</p>
                        <p class="text-sm text-green-700">Anda dapat login menggunakan Face ID</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-yellow-800">Face ID Belum Aktif</p>
                        <p class="text-sm text-yellow-700">Daftarkan Face ID untuk login lebih cepat</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Camera Preview -->
    <div class="mt-6">
        <div class="relative bg-gray-900 rounded-lg overflow-hidden" style="height: 320px;">
            <video id="video" autoplay muted playsinline class="w-full h-full object-cover"></video>
            <canvas id="canvas" class="hidden"></canvas>

            <!-- Face Detection Guide -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-48 h-64 border-4 border-white border-dashed rounded-full opacity-30"></div>
            </div>

            <!-- Camera Off State -->
            <div id="camera-off" class="absolute inset-0 flex items-center justify-center bg-gray-800">
                <div class="text-center text-white">
                    <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm opacity-75">Klik tombol untuk mengaktifkan kamera</p>
                </div>
            </div>

            <!-- Loading Overlay -->
            <div id="loading-overlay" class="hidden absolute inset-0 bg-black bg-opacity-75 flex items-center justify-center">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-white mx-auto mb-4"></div>
                    <p class="text-white font-medium">Memproses Face ID...</p>
                </div>
            </div>

            <!-- Success Overlay -->
            <div id="success-overlay" class="hidden absolute inset-0 bg-green-600 bg-opacity-90 flex items-center justify-center">
                <div class="text-center text-white">
                    <svg class="w-20 h-20 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-2xl font-bold">Berhasil!</p>
                    <p class="mt-2">Face ID telah disimpan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 space-y-3">
        <button id="btn-start-camera" type="button" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            {{ __('Aktifkan Kamera') }}
        </button>

        <button id="btn-capture" type="button" class="hidden w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            @if(auth()->user()->face_descriptor)
                {{ __('Update Face ID') }}
            @else
                {{ __('Daftarkan Face ID') }}
            @endif
        </button>

        @if(auth()->user()->face_descriptor)
            <button id="btn-delete-face" type="button" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                {{ __('Hapus Face ID') }}
            </button>
        @endif
    </div>

    <!-- Info -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <p class="text-sm text-blue-700">
            <strong>Tips:</strong> Pastikan wajah Anda terlihat jelas dan pencahayaan cukup terang untuk hasil terbaik.
        </p>
    </div>
</section>
