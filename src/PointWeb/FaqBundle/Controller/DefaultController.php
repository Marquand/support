<?php

namespace PointWeb\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $list = $this->getDoctrine()->getRepository('PointWebFaqBundle:faq')->findAll();
        return $this->render('PointWebFaqBundle:Default:index.html.twig', array('list' => $list));
    }
}
