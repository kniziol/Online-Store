<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Test case for the AdminController
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class AdminControllerTest extends WebTestCase
{
    /**
     * The client
     *
     * @var Client
     */
    private $client;

    public function testNewProductUrl()
    {
        $this->client->request('GET', '/admin/new-product');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @param string $name        Name of product
     * @param string $description Description of product
     * @param float  $price       Price of product
     * @param array  $errors      Errors if product's data is invalid
     *
     * @dataProvider getProductData
     */
    public function testNewProductForm($name, $description, $price, array $errors)
    {
        $this->login();
        $this->client->followRedirects();
        $crawler = $this->getProductFormCrawler($name, $description, $price);

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());

        if (empty($errors)) {
            $flashMessage = $crawler
                ->filter('#flash-messages.container .row .col-xs-12 .alert.alert-success.success')
                ->text();

            self::assertEquals('Saved', trim($flashMessage));

            return;
        }

        $formSelector = $this->getProductFormSelector();
        $selector = sprintf('%s %s', $formSelector, '.form-group.has-error');
        $errorsCrawler = $crawler->filter($selector);

        $errorsCrawler->each(function (Crawler $formGroupCrawler, $index) use ($errors) {
            $errorCrawler = $formGroupCrawler->filter('.help-block ul.list-unstyled li');
            self::assertContains($errors[$index], $errorCrawler->text());
        });
    }

    public function getProductData()
    {
        yield[
            'name'        => '',
            'description' => '',
            'price'       => '',
            'errors'      => [
                'This value should not be blank',
                'This value should not be blank',
                'This value should not be blank',
            ],
        ];

        yield[
            'name'        => '',
            'description' => '',
            'price'       => 0,
            'errors'      => [
                'This value should not be blank',
                'This value should not be blank',
                'This value should be greater than 0',
            ],
        ];

        yield[
            'name'        => 'abc',
            'description' => 'abc',
            'price'       => -1,
            'errors'      => [
                'This value is too short. It should have 5 characters or more.',
                'This value is too short. It should have 100 characters or more.',
                'This value should be greater than 0',
            ],
        ];

        yield[
            'name'        => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore',
            'price'       => 10.45,
            'errors'      => [
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Logs in user.
     * Required to be authenticated to add product.
     */
    private function login()
    {
        $firewallName = 'main';

        $session = $this
            ->client
            ->getContainer()
            ->get('session');

        $token = new UsernamePasswordToken('admin', 'adminpassword', $firewallName, ['ROLE_ADMIN']);
        $session->set(sprintf('_security_%s', $firewallName), serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this
            ->client
            ->getCookieJar()
            ->set($cookie);
    }

    /**
     * Returns crawler after submit the "create product" form
     *
     * @param string $name        Name of product
     * @param string $description Description of product
     * @param float  $price       Price of product
     * @return Crawler
     */
    private function getProductFormCrawler($name, $description, $price)
    {
        $crawler = $this->client->request('GET', '/admin/new-product');

        $submitButton = $crawler->selectButton('Create');
        $form = $submitButton->form();

        return $this->client->submit($form, [
            'product[name]'        => $name,
            'product[description]' => $description,
            'product[price]'       => $price,
        ]);
    }

    /**
     * Returns selector of the "create product" form
     *
     * @return string
     */
    private function getProductFormSelector()
    {
        return 'section.content .row.content form';
    }
}
