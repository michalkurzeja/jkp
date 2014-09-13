<?php

namespace JKP\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StaticPageController extends Controller
{
    /**
     * @Template
     */
    public function meAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function individualAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function contactAction()
    {
        return array();
    }
} 