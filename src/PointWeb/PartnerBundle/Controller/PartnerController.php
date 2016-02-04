<?php

namespace PointWeb\PartnerBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PointWeb\PartnerBundle\Entity\Partner;
use PointWeb\PartnerBundle\Form\PartnerType;

/**
 * Partner controller.
 *
 */
class PartnerController extends Controller
{

    /**
     * Lists all Partner entities.
     *
     */

    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $maxPerPage = 10;
        /** @var PartnersRepository $partnerRepo */
        $partnerRepo = $em->getRepository('PointWebPartnerBundle:Partner');
        $countTotal = $partnerRepo->count();
        if ($maxPerPage >= $countTotal){ $affiche = false; }else{ $affiche=true; }
        $pagination = array(
            'page' => $page,
            'route' => 'admin_partner',
            'pages_count' => ceil($countTotal / $maxPerPage),
            'route_params' => array(),
            'affiche' => $affiche,
        );
        $entities = $partnerRepo->pager('position', $page, $maxPerPage );
        return $this->render('PointWebPartnerBundle:Partner:index.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
        ));

    }

    /**
     * Creates a new Partner entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Partner();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_partner_show', array('id' => $entity->getId())));
        }

        return $this->render('PointWebPartnerBundle:Partner:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Partner entity.
     *
     * @param Partner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Partner $entity)
    {
        $form = $this->createForm(new PartnerType(), $entity, array(
            'action' => $this->generateUrl('admin_partner_create'),
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
     * Displays a form to create a new Partner entity.
     *
     */
    public function newAction()
    {
        $entity = new Partner();
        $form = $this->createCreateForm($entity);

        return $this->render('PointWebPartnerBundle:Partner:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Partner entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebPartnerBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PointWebPartnerBundle:Partner:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Partner entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PointWebPartnerBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PointWebPartnerBundle:Partner:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Partner entity.
     *
     * @param Partner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Partner $entity)
    {
        $form = $this->createForm(new PartnerType(), $entity, array(
            'action' => $this->generateUrl('admin_partner_update', array('id' => $entity->getId())),
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
     * Edits an existing Partner entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Partner $entity */
        $entity = $em->getRepository('PointWebPartnerBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $originalPictures = new ArrayCollection();
        foreach ($entity->getPictures() as $picture) {
            $originalPictures->add($picture);
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            foreach ($originalPictures as $picture) {
                if ($entity->getPictures()->contains($picture) == false) {
                    $entity->getPictures()->removeElement($picture);
                    $em->remove($picture);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('admin_partner_show', array('id' => $id)));
        }

        return $this->render('PointWebPartnerBundle:Partner:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Partner entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PointWebPartnerBundle:Partner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_partner'));
    }

    /**
     * Creates a form to delete a Partner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_partner_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit',
                array(
                    'label' => 'Supprimer',
                    'attr' => array('class' => 'btn btn-danger')
                ))
            ->getForm();
    }

    public function sortAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $value = $request->get('value');
        /** @var Partner $entity */
        $entity = $em->getRepository('PointWebPartnerBundle:Partner')->find($id);
        $entity->setPosition($value);
        $em->persist($entity);
        $em->flush();
        return new JsonResponse(array('result' => 'OK'));
    }
}
