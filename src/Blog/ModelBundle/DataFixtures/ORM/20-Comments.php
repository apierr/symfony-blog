<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for the Comment Entity
 */
class Comments extends AbstractFixture implements OrderedFixtureInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 20;
	}

	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$posts = $manager->getRepository('ModelBundle:Post')->findAll();

		$comments = array(
			0 => 'Phasellus rutrum ipsum sit amet sagittis aliquet.',
			1 => 'Aliquam non porttitor ante. ',
			2 => 'Fusce faucibus nunc risus.'
		);

		$i = 0;

		foreach($posts as $post) {
			$comment = new Comment();
			$comment->setAuthorName('someone');
			$comment->setBody($comments[$i++]);
			$comment->setPost($post);

			$manager->persist($comment);
		}

		$manager->flush();
	}
}