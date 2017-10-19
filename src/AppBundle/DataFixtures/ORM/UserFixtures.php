<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;

class UserFixtures extends Fixture
{
    const ADMIN = 'admin';
    const EDITOR = 'editor';
    const USER = 'user';
    const ANONYMOUS = 'anon';

    /**
     * @param ObjectManager $userManager
     */
    public function load(ObjectManager $userManager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $this->addUser($userManager, self::ADMIN, User::ROLE_ADMIN);
        $this->addUser($userManager, self::EDITOR, User::ROLE_EDITOR);
        $this->addUser($userManager, self::USER, User::ROLE_USER);
    }

    /**
     * @param UserManagerInterface $userManager
     * @param $userName
     * @param $role
     */
    private function addUser(UserManagerInterface $userManager, $userName, $role)
    {
        $userUser = $userManager->createUser();
        $userUser
            ->setUsername($userName)
            ->setEmail($userName . '@test.dev')
            ->setPlainPassword($userName)
            ->addRole($role)
        ;

        $userManager->updateUser($userUser);
    }
}
