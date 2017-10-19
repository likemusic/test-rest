<?php

namespace AppBundle\Tests\Controller;

use AppBundle\DataFixtures\ORM\UserFixtures;

class CategoryControllerTest extends BaseRestControllerTest
{
    private $accessMap = [
        UserFixtures::ADMIN => [
            'list' => true,
            'create' => true,
            'read' => true,
            'update' => true,
            'delete' => true,
        ],
        UserFixtures::EDITOR => [
            'list' => true,
            'create' => false,
            'read' => true,
            'update' => false,
            'delete' => false,
        ],
        UserFixtures::USER => [
            'list' => false,
            'create' => false,
            'read' => false,
            'update' => false,
            'delete' => false,
        ],
        UserFixtures::ANONYMOUS => [
            'list' => false,
            'create' => false,
            'read' => false,
            'update' => false,
            'delete' => false,
        ]
    ];

    public function testAdminAccesses()
    {
        $this->checkAccesses(UserFixtures::ADMIN);
    }

    public function testEditorAccesses()
    {
        $this->checkAccesses(UserFixtures::EDITOR);
    }

    public function testUserAccesses()
    {
        $this->checkAccesses(UserFixtures::USER);
    }

    public function testAnonAccesses()
    {
        $this->checkAccesses(UserFixtures::ANONYMOUS);
    }

    private function checkAccesses($userType)
    {
        $accesses = $this->accessMap[$userType];
        $apiKey = $this->getClientApiKey($userType);

        $this->checkAccessesBy($userType, $apiKey, $accesses);
    }

    private function getClientApiKey($userType)
    {
        $response = $this->request('POST', '/user/login', [
            'username' => $userType,
            'password' => $userType,
        ]);

        $key = 'api_key';
        $responseData = $this->getResponseData($response);

        return $responseData[$key];
    }

    private function checkAccessesBy($userType, $apiKey, $accesses)
    {
        foreach ($accesses as $methodKey => $accessValue) {
            $this->checkAccessByMethodKey($apiKey, $methodKey, $accessValue);
        }
    }

    private function checkAccessByMethodKey($apiKey, $methodKey, $accessValue)
    {

    }
}
