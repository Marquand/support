<?php

namespace PointWeb\PartnerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{


    public function indexAction()
    {
        $list = $this->getDoctrine()->getRepository('PointWebPartnerBundle:Partner')->findAll();
        return $this->render('PointWebPartnerBundle:Default:index.html.twig', array('list' => $list));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $detail = $em->getRepository('PointWebPartnerBundle:Partner')->find($id);
        return $this->render('PointWebPartnerBundle:Default:show.html.twig', array('detail' => $detail));
    }

}
