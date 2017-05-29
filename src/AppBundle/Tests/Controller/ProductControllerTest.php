<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test case for the ProductController
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductControllerTest extends WebTestCase
{
    public function testMainUrl()
    {
        $client = static::createClient();

        $client->request('GET', '/product');
        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPagination()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/product');
        $selector = $this->getContentElementSelector('.navigation ul.pagination li');

        $last = $crawler->filter($selector)->last();
        $link = $last->filter('a')->link();
        $crawler = $client->click($link);

        $tableSelector = $this->getTableSelector();
        $tableHeadersSelector = $this->getTableHeadersSelector();

        self::assertEquals(1, $crawler->filter($tableSelector)->count());
        self::assertEquals(4, $crawler->filter($tableHeadersSelector)->count());
    }

    /**
     * @param string $url Url to verify
     * @dataProvider getProductsListUrls
     */
    public function testPaginationUrl($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);
        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url Url used to load table
     * @dataProvider getProductsListUrls
     */
    public function testTableCount($url)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        $selector = $this->getTableRowsSelector();

        self::assertEquals(10, $crawler->filter($selector)->count());
    }

    /**
     * @param string $url Url used to load table
     * @dataProvider getProductsListUrls
     */
    public function testTableColumns($url)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        $selector = $this->getTableHeadersSelector();
        $columns = $crawler->filter($selector);

        self::assertEquals(4, $columns->count());
        self::assertEquals('#', $columns->eq(0)->text());
        self::assertEquals('Name', $columns->eq(1)->text());
        self::assertEquals('Price', $columns->eq(2)->text());
        self::assertEquals('Created', $columns->eq(3)->text());
    }

    /**
     * Provides urls used to load list of products
     *
     * @return \Generator
     */
    public function getProductsListUrls()
    {
        yield[
            '/product',
        ];

        yield[
            '/product/1',
        ];

        yield[
            '/product/2',
        ];
    }

    /**
     * Returns selector of row with content
     *
     * @return string
     */
    private function getContentSelector()
    {
        return 'section.content .row.content';
    }

    /**
     * @param string $elementSelector Selector of element located in row with content
     * @return string
     */
    private function getContentElementSelector($elementSelector)
    {
        return sprintf('%s %s', $this->getContentSelector(), $elementSelector);
    }

    /**
     * Returns selector of table with products
     *
     * @return string
     */
    private function getTableSelector()
    {
        return $this->getContentElementSelector('table.table.products');
    }

    /**
     * Returns selector for rows of table with products
     *
     * @return string
     */
    private function getTableRowsSelector()
    {
        return $this->getContentElementSelector('tbody tr');
    }

    /**
     * Returns selector for headers of table with products
     *
     * @return string
     */
    private function getTableHeadersSelector()
    {
        return $this->getContentElementSelector('thead tr th');
    }
}
