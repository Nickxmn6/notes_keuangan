<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class FaceAuthController extends Controller
{
    /**
     * Threshold untuk face matching
     * Nilai standar face-api.js: 0.6
     * Nilai lebih longgar: 0.65 - 0.7
     */
    const FACE_MATCH_THRESHOLD = 0.65; // Ubah dari 0.6 ke 0.65 untuk lebih toleran

    /**
     * Check if user has face data registered
     */
    public function checkFaceData(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'has_face_data' => !empty($user->face_descriptor),
            'user_name' => $user->name
        ]);
    }

    /**
     * Face Login - Authenticate with face descriptor
     */
    public function faceLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'face_descriptor' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->face_descriptor) {
            Log::warning('Face login failed: No face data', ['email' => $request->email]);
            return response()->json([
                'success' => false,
                'message' => 'Face ID belum terdaftar untuk email ini. Silakan daftarkan Face ID terlebih dahulu.'
            ], 404);
        }

        try {
            $storedDescriptor = json_decode($user->face_descriptor, true);
            $providedDescriptor = json_decode($request->face_descriptor, true);

            // Validasi format descriptor
            if (!is_array($storedDescriptor) || !is_array($providedDescriptor)) {
                Log::error('Face login failed: Invalid descriptor format', [
                    'email' => $request->email,
                    'stored_type' => gettype($storedDescriptor),
                    'provided_type' => gettype($providedDescriptor)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Format Face ID tidak valid. Silakan daftar ulang Face ID.'
                ], 400);
            }

            // Validasi panjang descriptor (harus 128)
            if (count($storedDescriptor) !== 128 || count($providedDescriptor) !== 128) {
                Log::error('Face login failed: Invalid descriptor length', [
                    'email' => $request->email,
                    'stored_length' => count($storedDescriptor),
                    'provided_length' => count($providedDescriptor)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Face ID tidak lengkap. Silakan daftar ulang Face ID.',
                    'debug' => [
                        'stored_length' => count($storedDescriptor),
                        'provided_length' => count($providedDescriptor)
                    ]
                ], 400);
            }

            // Calculate Euclidean distance
            $distance = $this->calculateEuclideanDistance($storedDescriptor, $providedDescriptor);

            // Log untuk debugging
            Log::info('Face matching attempt', [
                'email' => $request->email,
                'distance' => $distance,
                'threshold' => self::FACE_MATCH_THRESHOLD,
                'match' => $distance < self::FACE_MATCH_THRESHOLD
            ]);

            // Check if faces match
            if ($distance < self::FACE_MATCH_THRESHOLD) {
                Auth::login($user);

                Log::info('Face login successful', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'distance' => $distance
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil dengan Face ID!',
                    'redirect' => route('dashboard'),
                    'debug' => [
                        'distance' => round($distance, 4),
                        'threshold' => self::FACE_MATCH_THRESHOLD
                    ]
                ]);
            }

            // Face tidak cocok
            Log::warning('Face login failed: Face mismatch', [
                'email' => $request->email,
                'distance' => $distance,
                'threshold' => self::FACE_MATCH_THRESHOLD,
                'difference' => $distance - self::FACE_MATCH_THRESHOLD
            ]);

            return response()->json([
                'success' => false,
                'message' => "Wajah tidak cocok dengan Face ID yang terdaftar.\n\nDistance: " . round($distance, 4) . "\nThreshold: " . self::FACE_MATCH_THRESHOLD . "\n\nTips:\n- Pastikan pencahayaan sama dengan saat registrasi\n- Posisi wajah menghadap kamera\n- Jarak dengan kamera sama",
                'debug' => [
                    'distance' => round($distance, 4),
                    'threshold' => self::FACE_MATCH_THRESHOLD,
                    'difference' => round($distance - self::FACE_MATCH_THRESHOLD, 4)
                ]
            ], 401);

        } catch (\Exception $e) {
            Log::error('Face login error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat verifikasi wajah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register Face ID for authenticated user
     */
    public function registerFace(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'face_descriptor' => 'required|string'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi'
            ], 401);
        }

        try {
            // Validasi face descriptor
            $descriptor = json_decode($request->face_descriptor, true);

            if (!is_array($descriptor)) {
                Log::error('Face register failed: Invalid descriptor format', [
                    'user_id' => $user->id,
                    'descriptor_type' => gettype($descriptor)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Format Face ID tidak valid'
                ], 400);
            }

            if (count($descriptor) !== 128) {
                Log::error('Face register failed: Invalid descriptor length', [
                    'user_id' => $user->id,
                    'length' => count($descriptor)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Face ID tidak lengkap (harus 128 dimensi, dapat ' . count($descriptor) . ')'
                ], 400);
            }

            // Simpan face descriptor
            $user->face_descriptor = $request->face_descriptor;
            $user->save();

            Log::info('Face registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'descriptor_length' => count($descriptor)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Face ID berhasil didaftarkan!'
            ]);

        } catch (\Exception $e) {
            Log::error('Face register error', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftarkan Face ID: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Face ID
     */
    public function deleteFace(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi'
            ], 401);
        }

        $user->face_descriptor = null;
        $user->save();

        Log::info('Face ID deleted', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Face ID berhasil dihapus'
        ]);
    }

    /**
     * Calculate Euclidean distance between two face descriptors
     *
     * @param array $descriptor1
     * @param array $descriptor2
     * @return float
     */
    private function calculateEuclideanDistance(array $descriptor1, array $descriptor2): float
    {
        if (count($descriptor1) !== count($descriptor2)) {
            throw new \Exception('Descriptor dimensions do not match: ' . count($descriptor1) . ' vs ' . count($descriptor2));
        }

        $sum = 0;
        for ($i = 0; $i < count($descriptor1); $i++) {
            $diff = $descriptor1[$i] - $descriptor2[$i];
            $sum += $diff * $diff;
        }

        return sqrt($sum);
    }
}
