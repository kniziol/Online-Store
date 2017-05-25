<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test case for the AdminController
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class AdminControllerTest extends WebTestCase
{
    public function testNewProduct()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/new-product');
        self::assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
