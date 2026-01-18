<?php

namespace App\Services;

use GuzzleHttp\Client;

class WhatsappService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.whatsapp.url'),
            'timeout'  => 300,
            'connect_timeout' => 30,
        ]);
    }

    public function sendImage(string $number, $stream, string $filename, string $caption = '', string $media_type = '')
    {
        $end_point = '/send/image';

        if($media_type == 'photo') {
            $end_point = '/send/image';
        } elseif ($media_type == 'video') {
            $end_point = '/send/video';
        }

        $response = $this->client->post($end_point, [
            'multipart' => [
                [
                    'name'     => 'number',
                    'contents' => $number
                ],
                [
                    'name'     => 'caption',
                    'contents' => $caption
                ],
                [
                    'name'     => 'file',
                    'contents' => $stream,
                    'filename' => $filename
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
