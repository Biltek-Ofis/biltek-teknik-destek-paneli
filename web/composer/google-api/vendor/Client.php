<?php

namespace Kedniko\FCM;

use GuzzleHttp;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

class Client
{
    const FCM_SEND_HOST = 'fcm.googleapis.com';
    const FCM_SEND_PATH = '/fcm/send';
    const FCM_TOPIC_MANAGEMENT_HOST = 'iid.googleapis.com';
    const FCM_TOPIC_MANAGEMENT_ADD_PATH = '/iid/v1:batchAdd';
    const FCM_TOPIC_MANAGEMENT_REMOVE_PATH = '/iid/v1:batchRemove';

    public const CONTENT_TYPE = 'json';

    public const HTTP_ERRORS_OPTION = 'http_errors';

    public function getUrl(string $projectID): string
    {
        return "https://fcm.googleapis.com/v1/projects/{$projectID}/messages:send";
    }

    public function send(string $bearerToken, string $projectID, array $body)
    {
        $url = $this->getUrl($projectID);
        return $this->post($bearerToken, $url, $body);
    }

    /**
     * Birden fazla token'a paralel olarak bildirim gönderir.
     * 
     * @param string $bearerToken
     * @param string $projectID
     * @param array $tokens FCM token listesi
     * @param array $data Bildirim data payload'ı (title, body, tip, id vb.)
     * @param int $concurrency Eş zamanlı istek sayısı
     * @return array ['success' => int, 'failed' => int]
     */
    public function sendParallel(
        string $bearerToken,
        string $projectID,
        array $tokens,
        array $data,
        int $concurrency = 10
    ): array {
        $url     = $this->getUrl($projectID);
        $results = ['success' => 0, 'failed' => 0];

        $client = new GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $bearerToken,
                'Content-Type'  => 'application/json',
            ],
            self::HTTP_ERRORS_OPTION => false,
        ]);

        // Her token için bir Request üret
        $requests = function () use ($tokens, $url, $data) {
            foreach ($tokens as $token) {
                $body = json_encode([
                    'message' => [
                        'token' => $token,
                        'data'  => $data,
                    ],
                ]);
                yield new Request('POST', $url, [], $body);
            }
        };

        $pool = new Pool($client, $requests(), [
            'concurrency' => $concurrency,
            'fulfilled'   => function ($response) use (&$results) {
                if ($response->getStatusCode() === 200) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                }
            },
            'rejected'    => function ($reason) use (&$results) {
                $results['failed']++;
            },
        ]);

        $pool->promise()->wait();

        return $results;
    }

    public function post(string $bearerToken, string $url, array $body)
    {
        $config = [
            'headers' => [
                'Authorization' => 'Bearer ' . $bearerToken,
            ]
        ];

        if ($this->getHost($url) === self::FCM_TOPIC_MANAGEMENT_HOST) {
            $config['headers']['access_token_auth'] = 'true';
        }

        $options = [
            self::CONTENT_TYPE       => $body,
            self::HTTP_ERRORS_OPTION => false,
        ];

        $client   = new GuzzleHttp\Client($config);
        $response = $client->request('POST', $url, $options);

        if ($response->getStatusCode() === 200) {
            return true;
        }
        $result = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return $result['error']['message'];
    }

    private function getHost(string $url)
    {
        $parts = parse_url($url);
        return $parts['host'];
    }
}