<?php

namespace PointWeb\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($path)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('PointWebPageBundle:Page')->findOneBy(array('path' => $path));

        return $this->render('PointWebPageBundle:Default:index.html.twig', array('page' => $entity));
    }
}
