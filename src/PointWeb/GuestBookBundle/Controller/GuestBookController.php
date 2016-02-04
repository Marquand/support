<?php

namespace PointWeb\GuestBookBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PointWeb\GuestBookBundle\Entity\GuestBook;
use PointWeb\GuestBookBundle\Form\GuestBookType;

/**
 * GuestBook controller.
 *
 */
class GuestBookController extends Controller
{

    /**
     * Lists all GuestBook entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PointWebGuestBookBundle:GuestBook')->findBy(array(), array('position' => 'ASC'));

        return $this->render('PointWebGuestBookBundle:GuestBook:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new GuestBook entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GuestBook();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_guestbook_show', array('id' => $entity->getId())));
        }

        return $this->render('PointWebGuestBookBundle:GuestBook:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GuestBook entity.
     *
     * @param GuestBook $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GuestBook $entity)
    {
        $form = $this->createForm(new GuestBookType(), $entity, array(
            'action' => $this->generateUrl('admin_guestbook_create'),
            'method' => 'POST',
            'back' => true
        ));

        $form->add('submit', 'submit',
            array(
                'label' => 'Enregistrer',
                'attr' => array('class' => 'btn btn-success')
            ));

        return $form;
    }

    /**
     * Displays a form to create a new GuestBook entity.
     *
     */
    public function newAction()
    {
        $entity = new GuestBook();
        $form = $this->createCreateForm($entity);

        return $this->render('PointWebGuestBookBundle:GuestBook:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GuestBook entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebGuestBookBundle:GuestBook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GuestBook entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PointWebGuestBookBundle:GuestBook:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GuestBook entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebGuestBookBundle:GuestBook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GuestBook entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PointWebGuestBookBundle:GuestBook:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a GuestBook entity.
     *
     * @param GuestBook $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(GuestBook $entity)
    {
        $form = $this->createForm(new GuestBookType(), $entity, array(
            'action' => $this->generateUrl('admin_guestbook_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'back' => true
        ));

        $form->add('submit', 'submit',
            array(
                'label' => 'Enregistrer',
                'attr' => array('class' => 'btn btn-success')
            ));

        return $form;
    }

    /**
     * Edits an existing GuestBook entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebGuestBookBundle:GuestBook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GuestBook entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_guestbook_show', array('id' => $id)));
        }

        return $this->render('PointWebGuestBookBundle:GuestBook:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a GuestBook entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PointWebGuestBookBundle:GuestBook')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GuestBook entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_guestbook'));
    }

    /**
     * Creates a form to delete a GuestBook entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_guestbook_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit',
                array(
                    'label' => 'Supprimer',
                    'attr' => array('class' => 'btn btn-danger')
                ))
            ->getForm();;
    }

    public function sortAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $value = $request->get('value');
        /** @var Guestbook $entity */
        $entity = $em->getRepository('PointWebGuestBookBundle:Guestbook')->find($id);
        $entity->setPosition($value);
        $em->persist($entity);
        $em->flush();
        return new JsonResponse(array('result' => 'OK'));
    }
}
