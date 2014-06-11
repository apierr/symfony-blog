<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixtures;
use Doctrine\Common\DataFixtures\OrderedFixturesInterface;

/** 
 * Fixture for the Author Entity
 */
class Authors extends AbstractFixtures implements OrderedFixturesInterface
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
