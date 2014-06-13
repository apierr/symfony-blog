<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AuthorController
 */
class AuthorController extends Controller
{
    /**
     * Show posts by author
     *
     * @param string $slug
     *
     * @throws NotFoundException
     * @return array
     *
     * @Route("/author/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
    	$author = $this->getDoctrine()->getRepository('ModelBundle:Author')->findOneBy(
    		array(
    			'slug' => $slug
    		)
    	);

    	if (null === $author) {
    		throw $this->createNotFoundException('Author was not found');
    	}

    	$author = $this->getDoctrine()->getRepository('ModelBundle:Post')->findBy(
    		array(
    			'author' => $author
    		)
    	);

    	return array(
    		'author' => $author,
    		'posts' => $posts
    	);
    }

}
