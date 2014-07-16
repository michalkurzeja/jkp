<?php

namespace JKP\AdminBundle\Controller;

use JKP\AdminBundle\Form\Type\ProductType;
use JKP\CoreBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Template()
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product, array(
            'translations' => $this->get('jkp_admin.translations')
        ));

        if ($request->isMethod('post')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($product);
                $em->flush();

                return $this->redirect($this->generateUrl('jkp_admin_product'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function editAction(Product $product)
    {
        $request = $this->get('request');
        $form = $this->createForm(new ProductType(), $product, array(
            'translations' => $this->get('jkp_admin.translations')
        ));

        if ($request->isMethod('post')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->flush();

                return $this->redirect($this->generateUrl('jkp_admin_product'));
            }
        }

        return array(
            'product' => $product,
            'form' => $form->createView()
        );
    }

    public function switchAction(Product $product)
    {
        $product->setActive(!$product->getActive());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('jkp_admin_product'));
    }

    public function deleteAction(Product $product)
    {
        $this->getDoctrine()->getManager()->remove($product);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('jkp_admin_product'));
    }
} 