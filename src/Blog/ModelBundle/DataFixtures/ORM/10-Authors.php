<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/** 
 * Fixture for the Author Entity
 */
class Authors extends AbstractFixture implements OrderedFixtureInterface
{
	/**
	 * {@InheritDoc}
	 */
	public function getOrder()
	{
		return 10;
	}

	/**
	 * {@InheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$a1 = new Author();
		$a1->setName('Antonio');

		$a2 = new Author();
		$a2->setName('Leonardo');

		$a3 = new Author();
		$a3->setName('Francesca');

		$manager->persist($a1);
		$manager->persist($a2);
		$manager->persist($a3);

		$manager->flush();
	}
}
