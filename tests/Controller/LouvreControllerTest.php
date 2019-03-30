<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Booking;

/**
 * Created by PhpStorm.
 * User: Bloody
 * Date: 21/03/2019
 * Time: 09:55
 */

class LouvreControllerTest extends WebTestCase
{
	/**
	 * permet de tester si la page Home est bien fonctionnelle
	 */
	public function testHomepageIsUp()
	{
		$client = static::createClient(); //création du client HTTP
		$client->request('GET', '/');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	/**
	 * Test si le titre est bien présent sur la page d'accueil
	 */
	public function testHomePageTitle()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/');

		$this->assertEquals(1, $crawler->filter('html:contains("Bienvenue sur le site de réservation en ligne du Louvre")')->count());
	}

	/**
	 * @group test
	 */
	/*public function testFormBooking()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', 'booking');

		$addTicketButton = $crawler->selectLink("add-ticket")->link();
		$client->click($addTicketButton);
		$form = $crawler->selectButton('Commander')->form();
		$form['booking[reservationDate]'] = '02/04/2019';
		$form['booking[email]'] = 'mathieu_franon@outlook.fr';
		$form['booking[dayType]'] = false;
		$form['booking[tickets][0][name]'] = 'franon';
		$form['booking[tickets][0][firstname]'] = 'mathieu';
		$form['booking[tickets][0][country]'] = 'France';
		$form['booking[tickets[0][birthdayDate]'] = '28/02/1986';
		$form['booking[tickets][0][reducePrice]'] = true;

		$client->submit($form);

		$crawler = $client->followRedirect();

		$this->assertEquals(1, $crawler->filter('div.alert.alert-success')->count());
	}*/
}