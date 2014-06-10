<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * PostController class
 */
class PostController extends Controller
{
    /**
     * Show the Post list
     *
	 * @return Array
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    	retun array();
    }
}
