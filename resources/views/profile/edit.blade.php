<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">⚙️ Profile Settings</h1>
            <p class="text-gray-300">Kelola informasi akun dan keamanan Anda</p>
        </div>

        <!-- Update Profile Information -->
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            <header class="mb-6">
                <h2 class="text-xl font-semibold text-white mb-2">Profile Information</h2>
                <p class="text-sm text-gray-300">
                    Update your account's profile information and email address.
                </p>
            </header>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-2">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                    @error('name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-white mb-2">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                    @error('email')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="glass-card px-6 py-3 rounded-xl text-white font-medium hover:scale-105 transition-all shadow-lg">
                        Save Changes
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-400 font-medium"
                        >✓ Saved</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            <header class="mb-6">
                <h2 class="text-xl font-semibold text-white mb-2">Update Password</h2>
                <p class="text-sm text-gray-300">
                    Ensure your account is using a long, random password to stay secure.
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-white mb-2">Current Password</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                    @error('current_password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-white mb-2">New Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                    @error('password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                    @error('password_confirmation', 'updatePassword')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="glass-card px-6 py-3 rounded-xl text-white font-medium hover:scale-105 transition-all shadow-lg">
                        Update Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-400 font-medium"
                        >✓ Saved</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- Face ID Section -->
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            @include('profile.partials.face-id-form')
        </div>

        <!-- Delete Account -->
        <div class="glass-card rounded-2xl p-8 shadow-2xl bg-red-500/10 border border-red-400/30">
            <header class="mb-6">
                <h2 class="text-xl font-semibold text-red-300 mb-2 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Delete Account
                </h2>
                <p class="text-sm text-red-200">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                </p>
            </header>

            <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="glass-effect px-6 py-3 rounded-xl text-red-300 font-medium hover:bg-red-500/20 transition-all flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Delete Account</span>
            </button>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 glass-effect rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-semibold text-white mb-4">
                Are you sure you want to delete your account?
            </h2>

            <p class="text-sm text-gray-300 mb-6">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="mb-6">
                <label for="password" class="sr-only">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition">
                @error('password', 'userDeletion')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="glass-effect px-6 py-3 rounded-xl text-gray-300 font-medium hover:bg-white/10 transition-all">
                    Cancel
                </button>
                <button type="submit" class="glass-effect px-6 py-3 rounded-xl text-red-300 font-medium hover:bg-red-500/20 transition-all">
                    Delete Account
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Load face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const cameraOff = document.getElementById('camera-off');
        const btnStartCamera = document.getElementById('btn-start-camera');
        const btnCapture = document.getElementById('btn-capture');
        const btnDeleteFace = document.getElementById('btn-delete-face');
        const loadingOverlay = document.getElementById('loading-overlay');
        const successOverlay = document.getElementById('success-overlay');
        let stream = null;
        let modelsLoaded = false;

        async function loadModels() {
            try {
                const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';
                console.log('Loading face detection models...');
                await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
                await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
                await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
                modelsLoaded = true;
                console.log('✅ Face detection models loaded successfully');
            } catch (error) {
                console.error('❌ Failed to load models:', error);
                if (typeof showToast === 'function') {
                    showToast('Gagal memuat model Face ID. Silakan refresh halaman.', 'error');
                }
            }
        }

        loadModels();

        if (btnStartCamera) {
            btnStartCamera.addEventListener('click', async () => {
                if (!modelsLoaded) {
                    if (typeof showToast === 'function') {
                        showToast('Model Face ID masih loading. Silakan tunggu...', 'warning');
                    }
                    return;
                }

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { width: { ideal: 640 }, height: { ideal: 480 } }
                    });
                    video.srcObject = stream;
                    cameraOff.classList.add('hidden');
                    btnStartCamera.classList.add('hidden');
                    btnCapture.classList.remove('hidden');
                } catch (err) {
                    console.error('Camera error:', err);
                    if (typeof showToast === 'function') {
                        showToast('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin kamera.', 'error');
                    }
                }
            });
        }

        if (btnCapture) {
            btnCapture.addEventListener('click', async () => {
                if (!modelsLoaded) {
                    if (typeof showToast === 'function') {
                        showToast('Model Face ID masih loading...', 'warning');
                    }
                    return;
                }

                loadingOverlay.classList.remove('hidden');

                try {
                    const detections = await faceapi
                        .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                        .withFaceLandmarks()
                        .withFaceDescriptor();

                    if (!detections) {
                        if (typeof showToast === 'function') {
                            showToast('Wajah tidak terdeteksi! Pastikan wajah terlihat jelas dan pencahayaan cukup.', 'error');
                        }
                        loadingOverlay.classList.add('hidden');
                        return;
                    }

                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    const imageData = canvas.toDataURL('image/jpeg');
                    const descriptor = Array.from(detections.descriptor);

                    const response = await fetch('/face-register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            image: imageData,
                            face_descriptor: JSON.stringify(descriptor)
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        loadingOverlay.classList.add('hidden');
                        successOverlay.classList.remove('hidden');
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Gagal menyimpan Face ID', 'error');
                        }
                        loadingOverlay.classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Capture error:', error);
                    if (typeof showToast === 'function') {
                        showToast('Terjadi kesalahan saat menyimpan Face ID.', 'error');
                    }
                    loadingOverlay.classList.add('hidden');
                }
            });
        }

        if (btnDeleteFace) {
            btnDeleteFace.addEventListener('click', async () => {
                if (!confirm('Apakah Anda yakin ingin menghapus Face ID?\n\nAnda tidak dapat login menggunakan Face ID setelah dihapus.')) {
                    return;
                }

                try {
                    const response = await fetch('/face-delete', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        if (typeof showToast === 'function') {
                            showToast('✅ Face ID berhasil dihapus', 'success');
                        }
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Gagal menghapus Face ID', 'error');
                        }
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    if (typeof showToast === 'function') {
                        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    }
                }
            });
        }

        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</x-app-layout>
