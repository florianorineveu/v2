<?php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class DashboardControllerTest extends WebTestCase
{
    public function testIndexWithoutAuthentication(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/io/');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects(
            $client->getContainer()->get(RouterInterface::class)->generate('admin_security_login', [], RouterInterface::ABSOLUTE_URL),
            Response::HTTP_FOUND
        );
    }
}
