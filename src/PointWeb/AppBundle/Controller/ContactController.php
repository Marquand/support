<?php

namespace PointWeb\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PointWeb\AppBundle\Entity\Contact;
use PointWeb\AppBundle\Form\ContactType;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{

    /**
     * Lists all Contact entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PointWebAppBundle:Contact')->findBy(
            array(),
            array('id' => 'DESC')
        );

        return $this->render('PointWebAppBundle:Contact:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Contact entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebAppBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        return $this->render('PointWebAppBundle:Contact:show.html.twig', array(
            'entity'      => $entity
        ));
    }
   /**
     * Deletes a ContactMail entity.
     *
     */
    public function deleteAction($id)
    {

        if ($id != 0 ) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PointWebAppBundle:Contact')->find($id);
     
          
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
              
            }
        
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_contact'));
    }
}
