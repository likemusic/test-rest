<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uecode\Bundle\ApiKeyBundle\Entity\ApiKeyUser;

/**
 * User
 *
 * @ORM\Entity
 */
class User extends ApiKeyUser
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_EDITOR = 'ROLE_EDITOR';
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
