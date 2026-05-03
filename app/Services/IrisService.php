<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class IrisService
{
    private string $creatorKey;
    private string $approverKey;
    private string $baseUrl;

    public function __construct()
    {
        $isProduction = config('services.midtrans.is_production', false);
        $this->creatorKey = config('services.iris.creator_key', '');
        $this->approverKey = config('services.iris.approver_key', '');
        $this->baseUrl = $isProduction
            ? 'https://app.midtrans.com/iris/api/v1'
            : 'https://app.sandbox.midtrans.com/iris/api/v1';
    }

    /**
     * Create a payout request using Creator Key.
     * Returns the reference_no from Iris, or throws on failure.
     */
    public function createPayout(array $params): string
    {
        $payload = [
            'payouts' => [
                [
                    'beneficiary_name'    => $params['beneficiary_name'],
                    'beneficiary_account' => $params['beneficiary_account'],
                    'bank'                => $params['bank_code'],
                    'amount'              => (string) intval($params['amount']),
                    'notes'               => $params['notes'] ?? 'Withdrawal',
                ],
            ],
        ];

        $response = $this->request('POST', '/payouts', $payload, $this->creatorKey);

        if (empty($response['payouts'][0]['reference_no'])) {
            Log::error('Iris createPayout failed', ['response' => $response]);
            throw new \RuntimeException('Gagal membuat payout di Iris: ' . json_encode($response));
        }

        return $response['payouts'][0]['reference_no'];
    }

    /**
     * Approve a payout using Approver Key.
     */
    public function approvePayout(string $referenceNo): void
    {
        $payload = ['reference_nos' => [$referenceNo]];
        $response = $this->request('POST', '/payouts/approve', $payload, $this->approverKey);

        if (!isset($response['status']) || $response['status'] !== 'ok') {
            Log::error('Iris approvePayout failed', ['response' => $response, 'ref' => $referenceNo]);
            throw new \RuntimeException('Gagal approve payout di Iris: ' . json_encode($response));
        }
    }

    /**
     * Internal cURL request helper.
     */
    private function request(string $method, string $path, array $payload, string $apiKey): array
    {
        $url = $this->baseUrl . $path;
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($apiKey . ':'),
            ],
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $body     = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new \RuntimeException('cURL Error: ' . $curlError);
        }

        $decoded = json_decode($body, true) ?? [];
        $decoded['_http_code'] = $httpCode;

        return $decoded;
    }
}
