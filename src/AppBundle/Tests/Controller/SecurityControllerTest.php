<?php

namespace AppBundle\Tests\Controller;

use Generator;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Test case for the SecurityController
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * @param string $username Username used to login
     * @param string $password Password used to login
     * @param string $error    Error if credentials are invalid
     *
     * @dataProvider getCredentials
     */
    public function testLogin($username, $password, $error)
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $this->getLoginFormCrawler($client, $username, $password);

        self::assertEquals(200, $client->getResponse()->getStatusCode());

        if (!empty($error)) {
            $flashMessage = $crawler
                ->filter('#flash-messages.container .row .col-xs-12 .alert.alert-danger.danger')
                ->text();

            self::assertEquals($error, trim($flashMessage));
        }
    }

    /**
     * @param string $username Username used to login
     * @param string $password Password used to login
     *
     * @dataProvider getValidCredentials
     */
    public function testLogout($username, $password)
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $this->getLoginFormCrawler($client, $username, $password);

        self::assertEquals(200, $client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Logout')->link();
        $client->click($link);

        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Provides credentials used to login (with validation errors)
     *
     * @return Generator
     */
    public function getCredentials()
    {
        $invalid = self::getGeneratorElements($this->getInvalidCredentials());
        $valid = self::getGeneratorElements($this->getValidCredentials());

        $merged = array_merge($invalid, $valid);

        foreach ($merged as $item) {
            yield $item;
        }
    }

    /**
     * Provides invalid credentials used to login (with validation errors)
     *
     * @return Generator
     */
    public function getInvalidCredentials()
    {
        yield[
            'username'         => 'test',
            'password'         => 'test',
            'validation_error' => 'Invalid credentials',
        ];
    }

    /**
     * Provides valid credentials used to login
     *
     * @return Generator
     */
    public function getValidCredentials()
    {
        yield[
            'username'         => 'admin',
            'password'         => 'adminpassword',
            'validation_error' => '',
        ];

        yield[
            'username'         => 'john',
            'password'         => 'johnpassword',
            'validation_error' => '',
        ];
    }

    /**
     * Returns crawler after submit the login form
     *
     * @param Client $client   The client
     * @param string $username Username used to login
     * @param string $password Password used to login
     * @return Crawler
     */
    private function getLoginFormCrawler(Client $client, $username, $password)
    {
        $crawler = $client->request('GET', '/login');

        $submitButton = $crawler->selectButton('Login');
        $form = $submitButton->form();

        return $client->submit($form, [
            'login[username]' => $username,
            'login[password]' => $password,
        ]);
    }

    /**
     * Returns elements of generator
     *
     * @param Generator $generator The generator who elements should be returned
     * @return array
     */
    private static function getGeneratorElements(Generator $generator)
    {
        $elements = [];

        for (; $generator->valid(); $generator->next()) {
            $elements[] = $generator->current();
        }

        return $elements;
    }
}
