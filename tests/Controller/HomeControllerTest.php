<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1 > span', 'Hello world,');
    }

    public function testAbout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Ori');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1 > strong', 'Florian "Ori" Neveu');
    }
}
