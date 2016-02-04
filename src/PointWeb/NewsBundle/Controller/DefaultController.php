<?php

namespace PointWeb\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $listnews = $this->getDoctrine()->getRepository('PointWebNewsBundle:News')->findAll();
        return $this->render('PointWebNewsBundle:Default:index.html.twig', array('listnews' => $listnews));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $detailnews = $em->getRepository('PointWebNewsBundle:News')->find($id);
        return $this->render('PointWebNewsBundle:Default:show.html.twig', array('detailnews' => $detailnews));
    }
}
