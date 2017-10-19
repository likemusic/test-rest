<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserLoginType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Uecode\Bundle\ApiKeyBundle\Util\ApiKeyGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class UserController
 * @package AppBundle\Controller
 * @Route("/user")
 */
class UserController extends RestController
{
    protected function getFormTypeClass()
    {
        return UserLoginType::class;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/login", name = "user_login")
     * @Method({"POST"})
     */
    public function loginAction(Request $request)
    {
        $className = $this->getFormTypeClass();
        $form = $this->createForm(new $className());

        $this->processForm($request, $form);

        if (!$form->isValid()) {
            return new JsonResponse($form->getErrors());
        }

        $userManager = $this->get('fos_user.user_manager');
        /** @var User $user */
        $user = $userManager->findUserByUsernameOrEmail($form->get('username')->getData());

        $this->validatePassword($form->get('password')->getData(), $user);
        $user->setApiKey(ApiKeyGenerator::generate());
        $userManager->updateUser($user, true);

        $response = [
            'api_key' => $user->getApiKey()
        ];

        return new JsonResponse($response);
    }

    private function validatePassword($password, User $user)
    {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $isPasswordValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        if (!$isPasswordValid) {
            throw new AuthenticationException();
        }
    }
}