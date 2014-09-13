<?php

namespace JKP\CoreBundle\DependencyInjection;


use Doctrine\ORM\EntityManager;

class CategoryMenu
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCategories()
    {
        $results = $this->em->getRepository('JKPCoreBundle:Category')->findBy(array('active' => true));
        return $results;
    }
} 