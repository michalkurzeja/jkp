<?php

namespace JKP\AdminBundle\Controller;

use JKP\AdminBundle\Form\Type\CategoryType;
use JKP\CoreBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'categories' => $this->getDoctrine()->getManager()->getRepository('JKPCoreBundle:Category')->findAll()
        );
    }

    /**
     * @Template()
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category, array(
            'translations' => $this->get('jkp_admin.translations')
        ));

        if ($request->isMethod('post')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($category);
                $em->flush();

                return $this->redirect($this->generateUrl('jkp_admin_category'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function editAction(Category $category)
    {
        $request = $this->get('request');
        $form = $this->createForm(new CategoryType(), $category, array(
            'translations' => $this->get('jkp_admin.translations')
        ));

        if ($request->isMethod('post')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->flush();

                return $this->redirect($this->generateUrl('jkp_admin_category'));
            }
        }

        return array(
            'category' => $category,
            'form' => $form->createView()
        );
    }

    public function switchAction(Category $category)
    {
        $category->setActive(!$category->getActive());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('jkp_admin_category'));
    }

    public function deleteAction(Category $category)
    {
        $this->getDoctrine()->getManager()->remove($category);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('jkp_admin_category'));
    }
} 