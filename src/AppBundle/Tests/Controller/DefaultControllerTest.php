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
    public function testHomepageUrl()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testHomepageJumbotron()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $jumbotronContainer = $crawler->filter('.content .jumbotron .container');

        self::assertContains('Hi, how you doing? :)', $jumbotronContainer->filter('h1')->text());
        self::assertEquals(2, $jumbotronContainer->filter('.item .btn')->count());

        $buttonsCrawler = $jumbotronContainer->filter('.item .btn');
        $productsButtonCrawler = $buttonsCrawler->eq(0);
        $loginButtonCrawler = $buttonsCrawler->eq(1);

        self::assertEquals('/product', $productsButtonCrawler->attr('href'));
        self::assertEquals('#', $loginButtonCrawler->attr('href'));
    }

    public function testApplicationName()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        self::assertEquals('Online Store', $crawler->filter('header .navbar .navbar-header .navbar-brand')->text());
    }

    public function testMenuGroupsCount()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $navbar = $crawler->filter('header .navbar #navbar .navbar-nav');

        self::assertEquals(2, $navbar->count());
        self::assertEquals(2, $navbar->first()->filter('li')->count());
    }
}
