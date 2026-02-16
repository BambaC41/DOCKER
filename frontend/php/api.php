<?php
require_once __DIR__ . '/config.php';

/**
 * Appel générique vers l'API distante.
 * Retourne un tableau contenant:
 *  - ok (bool)
 *  - status (int)
 *  - body (decoded JSON|null)
 *  - raw (raw response string)
 *  - error (string|null)
 */
function api_call(string $method, string $endpoint, $data = null): array {
    $url = rtrim(API_BASE_URL, '/') . $endpoint;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $headers = ['Accept: application/json'];

    if ($data !== null) {
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $headers[] = 'Content-Type: application/json';
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if ($response === false) {
        $err = curl_error($ch);
        curl_close($ch);
        return ['ok' => false, 'status' => 0, 'body' => null, 'raw' => null, 'error' => "cURL error: $err"];
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $decoded = json_decode($response, true);
    return [
        'ok' => $httpCode >= 200 && $httpCode < 300,
        'status' => $httpCode,
        'body' => $decoded,
        'raw' => $response,
        'error' => null
    ];
}