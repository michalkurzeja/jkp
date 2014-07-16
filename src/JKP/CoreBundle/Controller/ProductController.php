<?php

namespace JKP\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'products' => $this->getDoctrine()->getRepository('JKPCoreBundle:Product')->findAll()
        );
    }
} 