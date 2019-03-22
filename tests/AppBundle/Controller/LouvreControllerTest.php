<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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

		echo $client->getResponse()->getContent();
	}
}