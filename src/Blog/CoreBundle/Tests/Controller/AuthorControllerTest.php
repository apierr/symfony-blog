<?php

namespace Blog\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AuthorControllerTest
 */
class AuthorControllerTest extends WebTestCase
{
	/**
	 * Test show author
	 */
    public function testShow()
    {
        $client = static::createClient();

        /** @var Author $author */
        $author = $client->getContainer()
        	->get('doctrine')
        	->getManager()
        	->getRepository('ModelBundle:Author')
        	->findFirst();
        $authorPostCount = $author->getPosts()->count();

        $crawler = $client->request('GET', '/author/'.$author->getSlug());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        $this->assertCount($authorPostCount, $crawler->filter('h2'), 'There should be '.$authorPostCount.' posts');
    }

}
