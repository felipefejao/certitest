<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GeminiService
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function makeAQuestion(string $theme)
    {
        try {
            $client = new Client;

            // O modelo selecionado (ex: gemini-2.5-flash ou gemini-2.5-pro)
            $model = 'gemini-3.8-flash';

            // URL padrão da API do Google Gemini
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-goog-api-key' => $this->apiKey,
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $theme],
                            ],
                        ],
                    ],
                    // Opcional: ajustar parâmetros como criatividade
                    'generationConfig' => [
                        'temperature' => 0.7,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Retorna o texto gerado diretamente
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        } catch (ClientException $e) {
            // Exibe o corpo exato da resposta de erro da API
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
