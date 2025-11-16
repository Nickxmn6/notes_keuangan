<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Notes & Keuangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center">
                <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Notes & Keuangan</h1>
                <p class="text-blue-100">Kelola catatan dan keuangan Anda</p>
            </div>

            <!-- Login Form -->
            <div class="p-8">
                <!-- Tab Switcher -->
                <div class="flex mb-8 bg-gray-100 rounded-lg p-1">
                    <button id="tab-password" class="flex-1 py-2 px-4 rounded-md font-medium transition-all duration-200 bg-white text-indigo-600 shadow-sm">
                        Password
                    </button>
                    <button id="tab-face" class="flex-1 py-2 px-4 rounded-md font-medium transition-all duration-200 text-gray-600 hover:text-gray-800">
                        Face ID
                    </button>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm text-red-600">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Password Login Form -->
                <form id="password-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        Masuk
                    </button>
                </form>

                <!-- Face Recognition Form -->
                <div id="face-form" class="hidden">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="email-face">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" id="email-face" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <!-- Status Loading Models -->
                    <div id="models-loading" class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                        <p class="text-sm text-blue-700">
                            <span class="inline-block animate-spin mr-2">⏳</span>
                            Memuat model Face ID...
                        </p>
                    </div>

                    <!-- Camera Preview -->
                    <div class="mb-6">
                        <div class="relative bg-gray-900 rounded-lg overflow-hidden" style="height: 300px;">
                            <video id="video" autoplay muted playsinline class="w-full h-full object-cover"></video>
                            <canvas id="canvas" class="hidden"></canvas>

                            <!-- Loading Overlay -->
                            <div id="loading-overlay" class="hidden absolute inset-0 bg-black bg-opacity-75 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-white mx-auto mb-4"></div>
                                    <p class="text-white font-medium">Mendeteksi wajah...</p>
                                </div>
                            </div>

                            <!-- Face Detected Overlay -->
                            <div id="face-detected" class="hidden absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-64 h-64 border-4 border-green-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 text-center">Posisikan wajah Anda di tengah kamera</p>
                    </div>

                    <button id="btn-face-login" type="button" class="w-full bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold py-3 rounded-lg hover:from-green-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Login dengan Face ID
                        </span>
                    </button>
                </div>

                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-gray-500 text-sm mt-8">
            &copy; 2024 Notes & Keuangan. All rights reserved.
        </p>
    </div>

    <!-- Load face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

    <script>
        // Variables
        const tabPassword = document.getElementById('tab-password');
        const tabFace = document.getElementById('tab-face');
        const passwordForm = document.getElementById('password-form');
        const faceForm = document.getElementById('face-form');
        const video = document.getElementById('video');
        const modelsLoading = document.getElementById('models-loading');
        let stream = null;
        let modelsLoaded = false;

        // Load face-api.js models
        async function loadModels() {
            try {
                const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';

                console.log('Loading face detection models...');
                await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
                await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
                await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);

                modelsLoaded = true;
                console.log('✅ Face detection models loaded successfully');

                if (modelsLoading) {
                    modelsLoading.innerHTML = '<p class="text-sm text-green-700">✅ Model Face ID siap digunakan</p>';
                    modelsLoading.classList.remove('border-blue-500', 'bg-blue-50');
                    modelsLoading.classList.add('border-green-500', 'bg-green-50');
                }
            } catch (error) {
                console.error('❌ Failed to load models:', error);
                if (modelsLoading) {
                    modelsLoading.innerHTML = '<p class="text-sm text-red-700">❌ Gagal memuat model. Refresh halaman.</p>';
                    modelsLoading.classList.remove('border-blue-500', 'bg-blue-50');
                    modelsLoading.classList.add('border-red-500', 'bg-red-50');
                }
            }
        }

        // Tab Switching
        tabPassword.addEventListener('click', () => {
            tabPassword.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
            tabPassword.classList.remove('text-gray-600');
            tabFace.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
            tabFace.classList.add('text-gray-600');
            passwordForm.classList.remove('hidden');
            faceForm.classList.add('hidden');

            // Stop camera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        });

        tabFace.addEventListener('click', async () => {
            tabFace.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
            tabFace.classList.remove('text-gray-600');
            tabPassword.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
            tabPassword.classList.add('text-gray-600');
            passwordForm.classList.add('hidden');
            faceForm.classList.remove('hidden');

            // Load models if not loaded yet
            if (!modelsLoaded) {
                loadModels();
            }

            // Start camera
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    }
                });
                video.srcObject = stream;
            } catch (err) {
                console.error('Camera error:', err);
                alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin kamera.');
            }
        });

        // Face Login
        document.getElementById('btn-face-login').addEventListener('click', async () => {
            const email = document.getElementById('email-face').value;

            if (!email) {
                alert('Silakan masukkan email terlebih dahulu');
                return;
            }

            if (!modelsLoaded) {
                alert('Model Face ID masih loading. Silakan tunggu sebentar...');
                return;
            }

            const loadingOverlay = document.getElementById('loading-overlay');
            const faceDetected = document.getElementById('face-detected');

            // Show loading
            loadingOverlay.classList.remove('hidden');

            try {
                // Detect face with face-api.js
                const detections = await faceapi
                    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                if (!detections) {
                    alert('⚠️ Wajah tidak terdeteksi!\n\nPastikan:\n- Wajah terlihat jelas\n- Pencahayaan cukup terang\n- Posisi wajah menghadap kamera');
                    loadingOverlay.classList.add('hidden');
                    return;
                }

                // Show face detected effect
                faceDetected.classList.remove('hidden');
                setTimeout(() => {
                    faceDetected.classList.add('hidden');
                }, 1000);

                // Get face descriptor
                const descriptor = Array.from(detections.descriptor);
                console.log('Face detected! Descriptor length:', descriptor.length);

                // Send to server
                const response = await fetch('/face-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: email,
                        face_descriptor: JSON.stringify(descriptor)
                    })
                });

                const data = await response.json();

                if (data.success) {
                    console.log('✅ Login successful!');
                    window.location.href = data.redirect || '/dashboard';
                } else {
                    alert(data.message || 'Login gagal. Wajah tidak dikenali atau tidak cocok dengan email yang dimasukkan.');
                }
            } catch (error) {
                console.error('Face login error:', error);
                alert('Terjadi kesalahan saat login dengan Face ID. Silakan coba lagi.');
            } finally {
                loadingOverlay.classList.add('hidden');
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>
