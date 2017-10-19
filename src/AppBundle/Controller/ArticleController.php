<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\ToArrayInterface;
use AppBundle\Form\Type\ArticleType;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ArticleController.
 *
 * @Route("/article")
 */
class ArticleController extends CrudRestController
{
    protected function getEntityClass()
    {
        return Article::class;
    }

    protected function getFormTypeClass()
    {
        return ArticleType::class;
    }

    /**
     * @Route("/list")
     * @Method({"GET"})
     */
    public function getListAction()
    {
        $list = $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();

        $serializer = $this->get('jms_serializer');
        $serializationContext = SerializationContext::create();
        $serializationContext->setGroups(['list']);

        $ret = $serializer->toArray($list, $serializationContext);

        return new JsonResponse($ret);
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
     * @ParamConverter("entity", class="AppBundle:Article")
     * @Security("has_role('ROLE_USER')")
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
     * @ParamConverter("entity", class="AppBundle:Article")
     * @Security("has_role('ROLE_EDIT')")
     *
     * @param Article $entity
     * @param Request $request
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
     * @ParamConverter("entity", class="AppBundle:Article")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Article $entity
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request, $entity)
    {
        return parent::deleteAction($request, $entity);
    }
}
