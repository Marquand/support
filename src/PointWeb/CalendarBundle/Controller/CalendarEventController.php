<?php

namespace PointWeb\CalendarBundle\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PointWeb\CalendarBundle\Entity\CalendarEvent;
use PointWeb\CalendarBundle\Form\CalendarEventType;

/**
 * CalendarEvent controller.
 *
 */
class CalendarEventController extends Controller
{
    /**
     * Creates a new CalendarEvent entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new CalendarEvent();
        $entity->setCreator($this->getUser());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $events = $em->getRepository('PointWebCalendarBundle:CalendarEvent')->findBy(array('creator' => $this->getUser()));
        $badStartDate = false;
        $badEndDate = false;
        /** @var CalendarEvent $event */
        foreach ($events as $event) {
            if ($form->get('startDate')->getData()->getTimestamp() > $event->getStartDate()->getTimestamp() && $form->get('startDate')->getData()->getTimestamp() < $event->getEndDate()->getTimestamp()) {
                $badStartDate = true;
            }
            if ($form->get('endDate')->getData()->getTimestamp() > $event->getStartDate()->getTimestamp() && $form->get('endDate')->getData()->getTimestamp() < $event->getEndDate()->getTimestamp()) {
                $badEndDate = true;
            }
            if ($form->get('startDate')->getData()->getTimestamp() < $event->getStartDate()->getTimestamp() && $form->get('endDate')->getData()->getTimestamp() > $event->getEndDate()->getTimestamp()) {
                $badStartDate = true;
                $badEndDate = true;
            }
        }
        if ($badEndDate) {
            $form->get('endDate')->addError(new FormError("La date de fin n'est pas valide"));
        }
        if ($badStartDate) {
            $form->get('startDate')->addError(new FormError("La date de début n'est pas valide"));
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('point_web_calendar_admin_reroute'));
        }

        return $this->render('PointWebCalendarBundle:CalendarEvent:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CalendarEvent entity.
     *
     * @param CalendarEvent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CalendarEvent $entity)
    {
        $form = $this->createForm(new CalendarEventType(), $entity, array(
            'action' => $this->generateUrl('admin_calendarevent_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit',
            array(
                'label' => 'Enregistrer',
                'attr' => array('class' => 'btn btn-success')
            ));

        return $form;
    }

    /**
     * Displays a form to create a new CalendarEvent entity.
     *
     */
    public function newAction()
    {
        $entity = new CalendarEvent();
        $entity->setCreator($this->getUser());
        $form = $this->createCreateForm($entity);

        return $this->render('PointWebCalendarBundle:CalendarEvent:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing CalendarEvent entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebCalendarBundle:CalendarEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CalendarEvent entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PointWebCalendarBundle:CalendarEvent:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a CalendarEvent entity.
     *
     * @param CalendarEvent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CalendarEvent $entity)
    {
        $form = $this->createForm(new CalendarEventType(), $entity, array(
            'action' => $this->generateUrl('admin_calendarevent_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit',
            array(
                'label' => 'Enregistrer',
                'attr' => array('class' => 'btn btn-success')
            ));

        return $form;
    }

    /**
     * Edits an existing CalendarEvent entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebCalendarBundle:CalendarEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CalendarEvent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        $events = $em->getRepository('PointWebCalendarBundle:CalendarEvent')->findBy(array('creator' => $this->getUser()));
        $badStartDate = false;
        $badEndDate = false;
        /** @var CalendarEvent $event */
        foreach ($events as $event) {
            if ($editForm->get('startDate')->getData()->getTimestamp() > $event->getStartDate()->getTimestamp() && $editForm->get('startDate')->getData()->getTimestamp() < $event->getEndDate()->getTimestamp()) {
                $badStartDate = true;
            }
            if ($editForm->get('endDate')->getData()->getTimestamp() > $event->getStartDate()->getTimestamp() && $editForm->get('endDate')->getData()->getTimestamp() < $event->getEndDate()->getTimestamp()) {
                $badEndDate = true;
            }
            if ($editForm->get('startDate')->getData()->getTimestamp() < $event->getStartDate()->getTimestamp() && $editForm->get('endDate')->getData()->getTimestamp() > $event->getEndDate()->getTimestamp()) {
                $badStartDate = true;
                $badEndDate = true;
            }
        }
        if ($badEndDate) {
            $editForm->get('endDate')->addError(new FormError("La date de fin n'est pas valide"));
        }
        if ($badStartDate) {
            $editForm->get('startDate')->addError(new FormError("La date de début n'est pas valide"));
        }
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('point_web_calendar_admin_reroute'));
        }

        return $this->render('PointWebCalendarBundle:CalendarEvent:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CalendarEvent entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PointWebCalendarBundle:CalendarEvent')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CalendarEvent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('point_web_calendar_admin_reroute'));
    }

    /**
     * Creates a form to delete a CalendarEvent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_calendarevent_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit',
                array(
                    'label' => 'Supprimer',
                    'attr' => array('class' => 'btn btn-danger')
                ))
            ->getForm();
    }
}
