<?php

namespace PointWeb\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $product = $this->getDoctrine()->getRepository('PointWebProductBundle:Product')->findAll();
        return $this->render('PointWebProductBundle:Default:index.html.twig', array('product' => $product));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $detail = $em->getRepository('PointWebProductBundle:Product')->find($id);
        return $this->render('PointWebProductBundle:Default:show.html.twig', array('detail' => $detail));
    }

}

