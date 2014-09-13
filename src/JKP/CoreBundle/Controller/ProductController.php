<?php

namespace JKP\CoreBundle\Controller;

use JKP\CoreBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductController extends Controller
{
    /**
     * @Template
     */
    public function showAction(Product $product)
    {
        return array(
            'product' => $product
        );
    }
} 