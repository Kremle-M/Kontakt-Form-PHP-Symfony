<?php

namespace App\Service;

use GuzzleHttp\Client;

class ProductApiService
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://dummyjson.com',
        ]);
    }
    public function Products(int $limit = 100, int $page = 1): array
    {
        $response = $this->httpClient->get('/products', [
            'query' => ['limit' => $limit, 'skip' => ($page - 1) * $limit]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['products'] ?? [];
    }
    public function ExchangeRate(): array
    {
        $response = $this->httpClient->get('https://www.cnb.cz/cs/financni-trhy/devizovy-trh/kurzy-devizoveho-trhu/kurzy-devizoveho-trhu/denni_kurz.txt');
        $lines = explode("\n", $response->getBody()->getContents());

        foreach ($lines as $line) {
            if (str_contains($line, 'EUR')) {
                $columns = explode('|', $line);
                return [
                    'rate' => floatval(str_replace(',', '.', $columns[4]))
                ];
            }
        }

        throw new \RuntimeException('Kurz EUR nebyl nalezen v odpovědi API.');
    }

    public function notifyDiscord(int $totalProducts, int $updatedProducts): void
    {
        $webhookUrl = $_ENV['DISCORD_WEBHOOK_URL'];

        try {
            $client = new \GuzzleHttp\Client();
            $client->post($webhookUrl, [
                'json' => [
                    'content' => sprintf(
                        "✅ **Synchronizace produktů dokončena**\nCelkový počet produktů: **%d**\nAktualizovaných produktů: **%d**",
                        $totalProducts,
                        $updatedProducts
                    ),
                ],
            ]);
        } catch (\Exception $e) {

            if (isset($this->logger)) {
                $this->logger->error('Chyba při odesílání notifikace na Discord: ' . $e->getMessage());
            }
        }
    }
}