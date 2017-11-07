<?php

namespace FinanceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/payment/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /payment/");
        $crawler = $client->click($crawler->selectLink('Create a new payment')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'financebundle_payment[amount]'  => '100',
            'financebundle_payment[description]'  => 'Test',
            'financebundle_payment[walletFrom]'  => '1',
            'financebundle_payment[walletTo]'  => '2',
            'financebundle_payment[date][year]'  => '2017',
            'financebundle_payment[date][month]'  => '4',
            'financebundle_payment[date][day]'  => '13',
            'financebundle_payment[category]'  => 1,
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'financebundle_payment[amount]'  => '200',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="200"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
}
