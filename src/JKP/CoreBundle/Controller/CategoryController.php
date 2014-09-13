<?php

namespace JKP\CoreBundle\Controller;

use JKP\CoreBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller
{
    /**
     * @Template()
     */
    public function showAction($slug)
    {
        $category = $this->getDoctrine()->getManager()->getRepository('JKPCoreBundle:Category')->findOneBySlug($slug);

        return array(
            'category' => $category
        );
    }
} 