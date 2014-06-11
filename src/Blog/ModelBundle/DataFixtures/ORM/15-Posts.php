<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/** 
 * Fixture for the Post Entity
 */
class Posts extends AbstractFixture implements OrderedFixtureInterface
{
	/**
	 * {@InheritDoc}
	 */
	public function getOrder()
	{
		return 15;
	}

	/**
	 * {@InheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$p1 = new Post();
		$p1->setTitle('Lorem ipsum dolor sit amet');
		$p1->setBody('Fusce sodales gravida metus, eu consequat odio vestibulum in. Vestibulum nec purus venenatis, aliquet nulla vel, interdum massa. Mauris non rhoncus nisi. Cras blandit pretium lacus ut interdum. Aenean tempus lacus ac convallis suscipit. Maecenas porta placerat mollis. Donec iaculis lacus sit amet turpis faucibus eleifend. Proin congue venenatis risus, non pellentesque lectus tempor quis. Sed scelerisque diam quis augue hendrerit consequat. Pellentesque cursus porttitor diam, id ultricies nisl tempor et. Donec vel felis sit amet sapien feugiat cursus. Aenean tincidunt odio nec nisi porta, ac volutpat mauris sagittis. Integer quis rutrum justo. Ut aliquam vel turpis et pellentesque.');
		$p1->setAuthor($this->getAuthor($manager, 'Antonio'));

		$p2 = new Post();
		$p2->setTitle('In auctor purus vitae urna faucibus aliquet');
		$p2->setBody('Vestibulum nec mauris ligula. Nullam sed sagittis leo. In sodales sodales sapien. Quisque feugiat mollis rhoncus. In a tempor sapien, at molestie justo. Morbi faucibus aliquet dolor. In scelerisque scelerisque nibh vel hendrerit. Sed fermentum at neque sit amet elementum. Morbi mattis justo ut velit volutpat, eu fermentum elit vehicula. Integer dui lorem, accumsan vel faucibus et, vulputate ac justo. Vivamus pharetra pretium risus eget dictum. In dapibus enim non dolor gravida lobortis. Vestibulum semper rhoncus purus ut pharetra.');
		$p2->setAuthor($this->getAuthor($manager, 'Leonardo'));

		$p3 = new Post();
		$p3->setTitle('Cras et tortor porta mi dictum rutrum');
		$p3->setBody('Sed cursus turpis odio, et fermentum nibh semper eget. Nullam placerat enim id venenatis sollicitudin. Nullam dignissim felis venenatis enim pulvinar, sit amet molestie diam vehicula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam eget ligula metus. Phasellus laoreet elit eu imperdiet volutpat. Etiam nec augue massa. Fusce vitae purus eget mi egestas eleifend et ut leo. Pellentesque sodales mi neque, nec lacinia libero faucibus nec. Sed nec luctus quam. Nam euismod pulvinar urna sit amet sodales. Praesent ullamcorper felis quis sem iaculis aliquet. Nunc facilisis ullamcorper sagittis. Vivamus quis diam ut augue ornare mollis. Curabitur commodo accumsan placerat.');
		$p3->setAuthor($this->getAuthor($manager, 'Francesca'));


		$manager->persist($p1);
		$manager->persist($p2);
		$manager->persist($p3);

		$manager->flush();
	}

	/** 
	 * Get an author
	 *
	 * @param ObjectManager $manager
 	 * @param string 		$name
 	 *
 	 * @return Author
	 */
	private function getAuthor(ObjectManager $manager, $name)
	{
		return $manager->getRepository('ModelBundle:Author')->findOneBy(
			array(
				'name' => $name
			)
		);
	}
}