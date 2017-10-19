<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\ToArrayInterface;
use AppBundle\Form\Type\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class CategoryController.
 *
 * @Route("/category")
 */
class CategoryController extends CrudRestController
{
    protected function getFormTypeClass()
    {
        return CategoryType::class;
    }

    protected function getEntityClass()
    {
        return Category::class;
    }

    /**
     * @Route("/")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    /**
     * @Route("/{id}")
     * @Method({"GET"})
     * @ParamConverter("entity", class="AppBundle:Category")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param $entity
     *
     * @return JsonResponse
     */
    public function readAction(ToArrayInterface $entity)
    {
        return parent::readAction($entity);
    }

    /**
     * @Route("/{id}")
     * @Method({"PATCH"})
     * @ParamConverter("entity", class="AppBundle:Category")
     * @Security("has_role('ROLE_EDITOR')")
     *
     * @param Category $entity
     * @param Request  $request
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request, $entity)
    {
        return parent::updateAction($request, $entity);
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     * @ParamConverter("entity", class="AppBundle:Category")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Category $entity
     * @param Request  $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request, $entity)
    {
        return parent::deleteAction($request, $entity);
    }
}
