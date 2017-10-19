<?php

namespace AppBundle\Tests\Controller;

use AppBundle\DataFixtures\ORM\UserFixtures;

class UserControllerTest extends BaseRestControllerTestCase
{
    public function testLoginAdmin()
    {
        $this->login(UserFixtures::ADMIN);
    }

    public function testLoginEditor()
    {
        $this->login(UserFixtures::EDITOR);
    }

    public function testLoginUser()
    {
        $this->login(UserFixtures::USER);
    }

    protected function login($userNameAndPassword)
    {
        $response = $this->request('POST', '/user/login', [
            'username' => $userNameAndPassword,
            'password' => $userNameAndPassword,
        ]);

        $this->assertSuccessResponse($response);
        $responseData = $this->getResponseData($response);

        $key = 'api_key';
        $this->assertArrayHasKey($key, $responseData);
        $this->assertNotEmpty($responseData[$key]);
    }


}
