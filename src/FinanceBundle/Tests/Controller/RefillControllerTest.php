<?php

namespace FinanceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RefillControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/refill/');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /refill/"
        );
        $crawler = $client->click($crawler->selectLink('Create a new refill')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'financebundle_refill[amount]' => 100,
            'financebundle_refill[description]' => 'Test',
            'financebundle_refill[walletFrom]' => '1',
            'financebundle_refill[walletTo]' => '2',
            'financebundle_refill[date][year]' => '2017',
            'financebundle_refill[date][month]' => '4',
            'financebundle_refill[date][day]' => '13',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(
            0,
            $crawler->filter('td:contains("100")')->count(),
            'Missing element td:contains("100")'
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('td:contains("Test")')->count(),
            'Missing element td:contains("Test")'
        );

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'financebundle_refill[amount]' => 200,
            'financebundle_refill[description]' => 'Update',
            'financebundle_refill[walletFrom]' => '1',
            'financebundle_refill[walletTo]' => '2',
            'financebundle_refill[date][year]' => '2017',
            'financebundle_refill[date][month]' => '4',
            'financebundle_refill[date][day]' => '13',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="200"]')->count(), 'Missing element [value="200"]');
        $this->assertEquals($crawler->filter('textarea')->text(), 'Update', 'Missing textarea with Update value');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
}
