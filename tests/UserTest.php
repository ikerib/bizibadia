<?php

namespace App\Tests;


use Facebook\WebDriver\WebDriverDimension;
use Symfony\Component\Panther\PantherTestCase;

class UserTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', 'http://bizibadia.test/login');
        $size = new WebDriverDimension(1920,1080);
        $client->manage()->window()->setSize($size);


        self::assertSelectorTextContains('h1','Saioa hasi');

        // Login incorrect
        $form = $crawler->selectButton('Hasi saioa')->form();
        $form['username'] = 'email@domain.com';
        $form['password'] = 'password';
        $crawler = $client->submit($form);
        self::assertSelectorIsVisible('.alert-danger');

        $form = $crawler->selectButton('Hasi saioa')->form();
        $form['username'] = 'superadmin';
        $form['password'] = '!Superadmin';
        $crawler = $client->submit($form);
        self::assertSelectorIsVisible('.user-profile');


        //$size = new WebDriverDimension([1920,12080]); // error to pause
    }
}
