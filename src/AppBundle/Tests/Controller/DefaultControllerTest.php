<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test case for the DefaultController
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertContains('Hi, how you doing? :)', $crawler->filter('.content .jumbotron .container h1')->text());
    }
}
