<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ToArrayInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RestController.
 */
abstract class CrudRestController extends RestController
{
    abstract protected function getFormTypeClass();

    abstract protected function getEntityClass();

    public function createAction(Request $request)
    {
        $className = $this->getFormTypeClass();
        $formTypeClass = new $className();
        $entityClass = $this->getEntityClass();
        $entity = new $entityClass();

        $form = $this->createForm($formTypeClass, $entity);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            return new JsonResponse($form->getErrors());
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush($entity);

        $ret = [
            'id' => $entity->getId(),
        ];

        return new JsonResponse($ret);
    }

    /**
     * @param ToArrayInterface $entity
     *
     * @return JsonResponse
     */
    public function readAction(ToArrayInterface $entity)
    {
        return new JsonResponse($entity->toArray());
    }

    /**
     * @Route("/{id}")
     * @Method({"PATCH"})
     *
     * @param $entity
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request, $entity)
    {
        $className = $this->getFormTypeClass();
        $formType = new $className();
        $form = $this->createForm($formType, $entity);

        $this->processForm($request, $form);

        if (!$form->isValid()) {
            return new JsonResponse($form->getErrors());
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->flush($entity);

        return new JsonResponse();
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     *
     * @param $entity
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request, $entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($entity);
        $em->flush($entity);

        return new JsonResponse();
    }
}
