<?php

namespace PointWeb\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PointWebGalleryBundle:Default:index.html.twig');
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Gallery $entity */
        $entity = $em->getRepository('PointWebGalleryBundle:Gallery')->find($id);

        return $this->render('PointWebGalleryBundle:Default:index.html.twig', array(
            'entity' => $entity
        ));
    }
}
