<?php
namespace App\tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class FavoriteTest extends TestCase
{
    public function testAddFavorite()
    {
        $client = HttpClient::create();
        $response = $client->request('PATCH', 'http://localhost:8000/api/users/2/addfavorite',
            ['json' => ['hotel_id_temp' => 2]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRemoveFavorite()
    {
        $client = HttpClient::create();
        $response = $client->request('PATCH', 'http://localhost:8000/api/users/2/removefavorite',
            ['json' => ['hotel_id_temp' => 2]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }


}