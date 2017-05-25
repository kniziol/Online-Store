<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test case for the MainController
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class MainControllerTest extends WebTestCase
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
        $productsButton = $buttonsCrawler->eq(0);
        $addProductButton = $buttonsCrawler->eq(1);

        self::assertEquals('Products', $productsButton->text());
        self::assertEquals('/product', $productsButton->attr('href'));

        self::assertEquals('Add product', $addProductButton->text());
        self::assertEquals('/admin/new-product', $addProductButton->attr('href'));
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

    public function testMenuItems()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $navbar = $crawler->filter('header .navbar #navbar .navbar-nav')->first();

        $navbarLinks = $navbar->filter('li a');
        $homepageLink = $navbarLinks->eq(0);
        $productsLink = $navbarLinks->eq(1);

        self::assertEquals(2, $navbar->children()->count());

        self::assertEquals('Home', $homepageLink->text());
        self::assertEquals('/', $homepageLink->attr('href'));

        self::assertEquals('Products', $productsLink->text());
        self::assertEquals('/product', $productsLink->attr('href'));
    }
}
