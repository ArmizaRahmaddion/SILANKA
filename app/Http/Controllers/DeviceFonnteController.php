<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

/**
 * DeviceFonnteController
 * 
 * Controller untuk mengelola WhatsApp Gateway devices menggunakan Fonnte API
 * Menyediakan CRUD operations dan device management functionality
 * 
 * @author Software Engineer
 * @version 2.0
 */
class DeviceFonnteController extends Controller
{
    /**
     * Fonnte service instance
     */
    protected FonnteService $fonnteService;

    /**
     * Constructor
     */
    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    /**
     * Display a listing of devices from Fonnte API
     * 
     * @return View
     */
    public function index(): View
    {
        try {
            // Ambil data devices langsung dari Fonnte API
            $apiResponse = $this->fonnteService->getAllDevices();

            $devices = [];
            if ($apiResponse['status'] && isset($apiResponse['data']['data'])) {
                $devices = collect($apiResponse['data']['data'])->map(function ($device) {
                    return (object) [
                        'id' => $device['token'] ?? '',
                        'name' => $device['name'] ?? 'Unknown Device',
                        'token' => $device['token'] ?? '',
                        'device' => $device['device'] ?? '',
                        'is_active' => $this->mapAPIStatusToLocal($device['status'] ?? 'unknown'),
                        'status' => $device['status'] ?? 'unknown',
                        'device_info' => $device['device_info'] ?? null,
                        'created_at' => now(), // API tidak menyediakan created_at
                    ];
                });
            }

            return view('layouts.admin.fonnte.index', compact('devices'));
        } catch (Exception $e) {
            Log::error('Error fetching devices from API: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return view('layouts.admin.fonnte.index', [
                'devices' => collect([]),
                'error' => 'Unable to fetch devices from Fonnte API: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new device
     * 
     * @return View
     */
    public function create(): View
    {
        return view('layouts.admin.fonnte.create');
    }

    /**
     * Store a newly created device via Fonnte API only
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate request
        $validator = $this->validateDeviceRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $validated = $validator->validated();

        try {
            // Mengirim request ke Fonnte API untuk menambahkan perangkat
            $response = $this->fonnteService->addDevice(
                $validated['name'],
                $validated['device']
            );

            if (!$response['status']) {
                throw new Exception($response['message'] ?? 'Failed to add device to Fonnte');
            }

            $token = $response['data']['token'] ?? null;

            return redirect()->route('devices.index')
                ->with('success', 'Device berhasil didaftarkan! Silakan hubungkan dengan scan QR Code.')
                ->with('device_token', $token);
        } catch (Exception $e) {
            Log::error('Error storing device: ' . $e->getMessage(), [
                'request_data' => $validated,
                'exception' => $e
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Activate device dengan QR code menggunakan token
     * 
     * @param Request $request
     * @param string $token
     * @return JsonResponse
     */
    public function activateDevice(Request $request, string $token): JsonResponse
    {
        try {
            $phoneNumber = $request->input('device');

            if (!$phoneNumber) {
                return response()->json([
                    'status' => false,
                    'error' => 'Phone number is required'
                ], 400);
            }

            // Request QR activation
            $response = $this->fonnteService->requestQRActivation($phoneNumber, $token);

            if ($response['status']) {
                return response()->json([
                    'status' => true,
                    'qr_code' => $response['data']['url'] ?? $response['data']['qr_code'] ?? null
                ]);
            }

            return response()->json([
                'status' => false,
                'error' => $response['message'] ?? 'Failed to generate QR Code'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error activating device: ' . $e->getMessage(), [
                'device_token' => $token,
                'exception' => $e
            ]);

            return response()->json([
                'status' => false,
                'error' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display device details by token
     * 
     * @param string $token
     * @return View|JsonResponse
     */
    public function show(string $token)
    {
        try {
            // Get device info from API
            $response = $this->fonnteService->getDeviceProfile($token);

            if (!$response['status']) {
                if (request()->ajax()) {
                    return response()->json(['error' => 'Device not found'], 404);
                }
                abort(404, 'Device not found');
            }

            $deviceData = $response['data'];

            // Jika request adalah AJAX, return JSON
            if (request()->ajax()) {
                return response()->json([
                    'status' => true,
                    'name' => $deviceData['name'] ?? 'Unknown Device',
                    'token' => $token,
                    'device' => $deviceData['device'] ?? '',
                    'status' => $deviceData['status'] ?? 'unknown',
                    'device_info' => $deviceData
                ]);
            }

            // Jika bukan AJAX, tampilkan view
            $device = (object) [
                'name' => $deviceData['name'] ?? 'Unknown Device',
                'token' => $token,
                'device' => $deviceData['device'] ?? '',
                'status' => $deviceData['status'] ?? 'unknown',
                'device_info' => $deviceData
            ];

            return view('layouts.admin.fonnte.show', compact('device'));
        } catch (Exception $e) {
            Log::error('Error showing device: ' . $e->getMessage(), [
                'device_token' => $token,
                'exception' => $e
            ]);

            if (request()->ajax()) {
                return response()->json(['error' => 'Internal server error'], 500);
            }

            return redirect()->route('devices.index')
                ->with('error', 'Error loading device details');
        }
    }

    /**
     * Disconnect device from WhatsApp using token
     * 
     * @param Request $request
     * @param string $token
     * @return JsonResponse
     */
    public function disconnect(Request $request, string $token): JsonResponse
    {
        try {
            $response = $this->fonnteService->disconnectDevice($token);

            if ($response['status']) {
                return response()->json([
                    'status' => true,
                    'message' => 'Device berhasil di-disconnect'
                ]);
            }

            return response()->json([
                'status' => false,
                'error' => $response['message'] ?? 'Failed to disconnect device'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error disconnecting device: ' . $e->getMessage(), [
                'device_token' => $token,
                'exception' => $e
            ]);

            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Delete device using token (two-step: request OTP then submit OTP)
     * 
     * @param Request $request
     * @param string $token
     * @return JsonResponse
     */
    public function destroy(Request $request, string $token): JsonResponse
    {
        try {
            $otp = $request->input('otp');

            if (empty($otp)) {
                // Step 1: Request OTP
                $response = $this->fonnteService->requestOTPForDeleteDevice($token);

                if ($response['status']) {
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP has been sent to your WhatsApp number. Please check your phone.',
                        'requires_otp' => true
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'error' => $response['message'] ?? 'Failed to request OTP'
                ], 500);
            } else {
                // Step 2: Submit OTP and delete
                $response = $this->fonnteService->submitOTPForDeleteDevice($otp, $token);

                if ($response['status']) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Device berhasil dihapus'
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'error' => $response['message'] ?? 'Invalid OTP or failed to delete device'
                ], 400);
            }
        } catch (Exception $e) {
            Log::error('Error deleting device: ' . $e->getMessage(), [
                'device_token' => $token,
                'exception' => $e
            ]);

            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Check device status using token
     * 
     * @param string $token
     * @return JsonResponse
     */
    public function checkDeviceStatus(string $token): JsonResponse
    {
        try {
            $response = $this->fonnteService->checkDeviceStatus($token);

            if ($response['status']) {
                return response()->json([
                    'status' => $response['data']['status'] ?? 'unknown',
                    'data' => $response['data']
                ]);
            }

            return response()->json([
                'status' => false,
                'error' => $response['message'] ?? 'Failed to check device status'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error checking device status: ' . $e->getMessage(), [
                'device_token' => $token,
                'exception' => $e
            ]);

            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Send WhatsApp message
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'target' => 'required|string|min:8|max:15',
            'message' => 'required|string|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ], 422);
        }

        try {
            $deviceToken = $request->header('Authorization');

            // Remove 'Bearer ' prefix if exists
            if (str_starts_with($deviceToken, 'Bearer ')) {
                $deviceToken = substr($deviceToken, 7);
            }

            if (empty($deviceToken)) {
                return response()->json([
                    'status' => false,
                    'error' => 'Device token is required in Authorization header'
                ], 401);
            }

            $response = $this->fonnteService->sendWhatsAppMessage(
                $request->input('target'),
                $request->input('message'),
                $deviceToken
            );

            if ($response['status']) {
                return response()->json([
                    'status' => true,
                    'message' => 'Pesan berhasil dikirim!',
                    'data' => $response['data']
                ]);
            }

            return response()->json([
                'status' => false,
                'error' => $response['error'] ?? 'Failed to send message'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage(), [
                'request_data' => $request->only(['target', 'message']),
                'exception' => $e
            ]);

            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Test API connection
     * 
     * @return JsonResponse
     */
    public function testConnection(): JsonResponse
    {
        try {
            $response = $this->fonnteService->testConnection();

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error testing connection: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'error' => 'Connection test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // Private helper methods

    /**
     * Validate device request
     */
    private function validateDeviceRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'device' => 'required|string|min:8|max:15|regex:/^[0-9]+$/',
        ], [
            'name.required' => 'Nama device harus diisi',
            'name.min' => 'Nama device minimal 3 karakter',
            'device.required' => 'Nomor WhatsApp harus diisi',
            'device.min' => 'Nomor WhatsApp minimal 8 digit',
            'device.max' => 'Nomor WhatsApp maksimal 15 digit',
            'device.regex' => 'Nomor WhatsApp hanya boleh berisi angka',
        ]);
    }



    /**
     * Send test message
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function sendTestMessage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'phone' => 'required|string',
                'message' => 'required|string|max:1000'
            ]);

            $token = $request->input('token');
            $phone = $request->input('phone');
            $message = $request->input('message');

            // Check device status from API
            $statusResponse = $this->fonnteService->checkDeviceStatus($token);

            if (!$statusResponse['status']) {
                return response()->json([
                    'status' => false,
                    'message' => 'Device tidak ditemukan atau tidak dapat diakses'
                ], 404);
            }

            $deviceStatus = $statusResponse['data']['status'] ?? 'unknown';
            if (!in_array($deviceStatus, ['authenticated', 'connected', 'active'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Device tidak aktif atau belum terkoneksi'
                ], 400);
            }

            // Send message via Fonnte service
            $result = $this->fonnteService->sendWhatsAppMessage($phone, $message, $token);

            if ($result['status']) {
                Log::info('Test message sent successfully', [
                    'device_token' => $token,
                    'phone' => $phone,
                    'message' => $message
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Pesan test berhasil dikirim',
                    'data' => $result['data']
                ]);
            } else {
                Log::warning('Test message failed', [
                    'device_token' => $token,
                    'phone' => $phone,
                    'error' => $result['message']
                ]);

                return response()->json([
                    'status' => false,
                    'message' => $result['message'] ?? 'Gagal mengirim pesan'
                ], 400);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            Log::error('Error sending test message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    /**
     * Map API status to local display status
     */
    private function mapAPIStatusToLocal(string $apiStatus): string
    {
        return match (strtolower($apiStatus)) {
            'connected', 'authenticated', 'active' => 'active',
            'disconnected', 'inactive' => 'inactive',
            'pending' => 'pending',
            default => 'unknown'
        };
    }
}
