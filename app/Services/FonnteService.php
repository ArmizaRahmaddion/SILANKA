<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

/**
 * Fonnte WhatsApp Gateway Service
 * 
 * Service untuk mengelola integrasi dengan Fonnte API
 * Menyediakan metode untuk manajemen device, pengiriman pesan, dan aktivasi QR
 * 
 * @author Software Engineer
 * @version 1.0
 */
class FonnteService
{
          /**
           * Account token untuk authentication
           */
          protected string $accountToken;

          /**
           * Base URL API Fonnte
           */
          protected string $baseUrl;

          /**
           * Timeout untuk request HTTP
           */
          protected int $timeout;

          /**
           * Endpoint API Fonnte
           */
          const ENDPOINTS = [
                    'send_message'      => '/send',
                    'add_device'        => '/add-device',
                    'qr_activation'     => '/qr',
                    'get_devices'       => '/get-devices',
                    'device_profile'    => '/device',
                    'delete_device'     => '/delete-device',
                    'disconnect'        => '/disconnect',
                    'check_status'      => '/status',
          ];

          /**
           * Status codes yang valid dari Fonnte
           */
          const VALID_STATUS_CODES = [200, 201];

          /**
           * Constructor
           */
          public function __construct()
          {
                    $this->accountToken = config('services.fonnte.account_token');
                    $this->baseUrl = config('services.fonnte.base_url', 'https://api.fonnte.com');
                    $this->timeout = 30;

                    if (empty($this->accountToken)) {
                              throw new \InvalidArgumentException('Fonnte account token is required. Please set FONNTE_ACCOUNT_TOKEN in your environment.');
                    }
          }

          /**
           * Membuat HTTP request ke Fonnte API
           * 
           * @param string $endpoint
           * @param array $params
           * @param bool $useAccountToken
           * @param string|null $deviceToken
           * @return array
           */
          protected function makeRequest(string $endpoint, array $params = [], bool $useAccountToken = true, ?string $deviceToken = null): array
          {
                    try {
                              // Tentukan token yang akan digunakan
                              $token = $useAccountToken ? $this->accountToken : $deviceToken;

                              if (empty($token)) {
                                        return $this->formatErrorResponse('API token or device token is required');
                              }

                              // Build full URL
                              $url = $this->baseUrl . $endpoint;

                              // Setup HTTP client
                              $httpClient = Http::timeout($this->timeout)
                                        ->withHeaders([
                                                  'Authorization' => $token
                                        ])
                                        ->acceptJson();

                              // Log request untuk debugging
                              Log::info('Fonnte API Request', [
                                        'url' => $url,
                                        'params' => $this->sanitizeLogParams($params),
                                        'use_account_token' => $useAccountToken
                              ]);

                              // Kirim request
                              $response = $httpClient->post($url, $params);

                              // Log response untuk debugging
                              Log::info('Fonnte API Response', [
                                        'url' => $url,
                                        'status' => $response->status(),
                                        'response' => $response->json()
                              ]);

                              // Check response status
                              if (!in_array($response->status(), self::VALID_STATUS_CODES)) {
                                        $errorMessage = $this->extractErrorMessage($response);
                                        return $this->formatErrorResponse($errorMessage);
                              }

                              $responseData = $response->json();

                              // Check if Fonnte returned an error in response body
                              if (isset($responseData['status']) && $responseData['status'] === false) {
                                        $errorMessage = $responseData['reason'] ?? 'API returned error status';
                                        return $this->formatErrorResponse($errorMessage);
                              }

                              return $this->formatSuccessResponse($responseData);
                    } catch (RequestException $e) {
                              Log::error('Fonnte API Request Exception', [
                                        'endpoint' => $endpoint,
                                        'message' => $e->getMessage(),
                                        'trace' => $e->getTraceAsString()
                              ]);
                              return $this->formatErrorResponse('Network error: ' . $e->getMessage());
                    } catch (\Exception $e) {
                              Log::error('Fonnte API General Exception', [
                                        'endpoint' => $endpoint,
                                        'message' => $e->getMessage(),
                                        'trace' => $e->getTraceAsString()
                              ]);
                              return $this->formatErrorResponse('Unexpected error: ' . $e->getMessage());
                    }
          }

          /**
           * Format successful response
           */
          private function formatSuccessResponse(array $data): array
          {
                    return [
                              'status' => true,
                              'data' => $data,
                              'error' => null
                    ];
          }

          /**
           * Format error response
           */
          private function formatErrorResponse(string $error): array
          {
                    return [
                              'status' => false,
                              'data' => null,
                              'error' => $error
                    ];
          }

          /**
           * Extract error message from response
           */
          private function extractErrorMessage($response): string
          {
                    $responseData = $response->json();

                    if (isset($responseData['reason'])) {
                              return $responseData['reason'];
                    }

                    if (isset($responseData['message'])) {
                              return $responseData['message'];
                    }

                    return 'HTTP ' . $response->status() . ': ' . $response->body();
          }

          /**
           * Sanitize parameters for logging (hide sensitive data)
           */
          private function sanitizeLogParams(array $params): array
          {
                    $sanitized = $params;

                    // Hide sensitive fields
                    $sensitiveFields = ['otp', 'password', 'token'];
                    foreach ($sensitiveFields as $field) {
                              if (isset($sanitized[$field])) {
                                        $sanitized[$field] = '***';
                              }
                    }

                    return $sanitized;
          }

          /**
           * Validate phone number format
           */
          private function isValidPhoneNumber(string $phoneNumber): bool
          {
                    // Remove all non-numeric characters
                    $cleaned = preg_replace('/\D/', '', $phoneNumber);

                    // Check length (should be between 8-15 digits)
                    $length = strlen($cleaned);

                    return $length >= 8 && $length <= 15;
          }

          /**
           * Format phone number for API
           */
          private function formatPhoneNumber(string $phoneNumber): string
          {
                    // Remove all non-numeric characters
                    $cleaned = preg_replace('/\D/', '', $phoneNumber);

                    // Remove leading zero if exists
                    if (str_starts_with($cleaned, '0')) {
                              $cleaned = '62' . substr($cleaned, 1);
                    }

                    // Add country code if not exists
                    if (!str_starts_with($cleaned, '62')) {
                              $cleaned = '62' . $cleaned;
                    }

                    return $cleaned;
          }

          /**
           * Kirim pesan WhatsApp
           * 
           * @param string $phoneNumber
           * @param string $message
           * @param string $deviceToken
           * @return array
           */
          public function sendWhatsAppMessage(string $phoneNumber, string $message, string $deviceToken): array
          {
                    // Validate phone number
                    if (!$this->isValidPhoneNumber($phoneNumber)) {
                              return $this->formatErrorResponse('Invalid phone number format');
                    }

                    // Validate message
                    if (empty(trim($message))) {
                              return $this->formatErrorResponse('Message cannot be empty');
                    }

                    $params = [
                              'target' => $this->formatPhoneNumber($phoneNumber),
                              'message' => trim($message),
                    ];

                    return $this->makeRequest(self::ENDPOINTS['send_message'], $params, false, $deviceToken);
          }

          /**
           * Ambil semua devices yang terdaftar
           * 
           * @return array
           */
          public function getAllDevices(): array
          {
                    return $this->makeRequest(self::ENDPOINTS['get_devices'], [], true);
          }

          /**
           * Tambah device baru ke Fonnte
           * 
           * @param string $name
           * @param string $phoneNumber
           * @return array
           */
          public function addDevice(string $name, string $phoneNumber): array
          {
                    // Validate inputs
                    if (empty(trim($name))) {
                              return $this->formatErrorResponse('Device name is required');
                    }

                    if (!$this->isValidPhoneNumber($phoneNumber)) {
                              return $this->formatErrorResponse('Invalid phone number format');
                    }

                    $params = [
                              'name' => trim($name),
                              'device' => $this->formatPhoneNumber($phoneNumber),
                              'autoread' => false,
                              'personal' => true,
                              'group' => false,
                    ];

                    return $this->makeRequest(self::ENDPOINTS['add_device'], $params, true);
          }

          /**
           * Request QR code untuk aktivasi device
           * 
           * @param string $phoneNumber
           * @param string $deviceToken
           * @return array
           */
          public function requestQRActivation(string $phoneNumber, string $deviceToken): array
          {
                    if (!$this->isValidPhoneNumber($phoneNumber)) {
                              return $this->formatErrorResponse('Invalid phone number format');
                    }

                    $params = [
                              'type' => 'qr',
                              'whatsapp' => $this->formatPhoneNumber($phoneNumber),
                    ];

                    return $this->makeRequest(self::ENDPOINTS['qr_activation'], $params, false, $deviceToken);
          }

          /**
           * Ambil profil device
           * 
           * @param string $deviceToken
           * @return array
           */
          public function getDeviceProfile(string $deviceToken): array
          {
                    return $this->makeRequest(self::ENDPOINTS['device_profile'], [], false, $deviceToken);
          }

          /**
           * Disconnect device dari WhatsApp
           * 
           * @param string $deviceToken
           * @return array
           */
          public function disconnectDevice(string $deviceToken): array
          {
                    return $this->makeRequest(self::ENDPOINTS['disconnect'], [], false, $deviceToken);
          }

          /**
           * Request OTP untuk delete device
           * 
           * @param string $deviceToken
           * @return array
           */
          public function requestOTPForDeleteDevice(string $deviceToken): array
          {
                    $params = ['otp' => ''];
                    return $this->makeRequest(self::ENDPOINTS['delete_device'], $params, false, $deviceToken);
          }

          /**
           * Submit OTP untuk delete device
           * 
           * @param string $otp
           * @param string $deviceToken
           * @return array
           */
          public function submitOTPForDeleteDevice(string $otp, string $deviceToken): array
          {
                    // Validate OTP
                    if (empty(trim($otp)) || !is_numeric($otp)) {
                              return $this->formatErrorResponse('Invalid OTP format');
                    }

                    $params = ['otp' => (int) $otp];

                    Log::info('Attempting to delete device with OTP', [
                              'otp_length' => strlen($otp),
                              'device_token' => substr($deviceToken, 0, 10) . '...'
                    ]);

                    return $this->makeRequest(self::ENDPOINTS['delete_device'], $params, false, $deviceToken);
          }

          /**
           * Check device status
           * 
           * @param string $deviceToken
           * @return array
           */
          public function checkDeviceStatus(string $deviceToken): array
          {
                    return $this->makeRequest(self::ENDPOINTS['check_status'], [], false, $deviceToken);
          }

          /**
           * Validate device token format
           * 
           * @param string $token
           * @return bool
           */
          public function isValidDeviceToken(string $token): bool
          {
                    return !empty($token) && strlen($token) >= 20;
          }

          /**
           * Get API base URL
           * 
           * @return string
           */
          public function getBaseUrl(): string
          {
                    return $this->baseUrl;
          }

          /**
           * Test API connection
           * 
           * @return array
           */
          public function testConnection(): array
          {
                    try {
                              $response = $this->getAllDevices();

                              if ($response['status']) {
                                        return $this->formatSuccessResponse(['message' => 'Connection successful']);
                              }

                              return $response;
                    } catch (\Exception $e) {
                              return $this->formatErrorResponse('Connection failed: ' . $e->getMessage());
                    }
          }
}
