<?php

namespace App\Phpunit;

require_once('..\services\ApplicationService.php');
require_once('..\factories\ApplicationServiceFactory.php');

use ApplicationService;
use ApplicationServiceFactory;
use PHPUnit\Framework\TestCase;

class ApplicationServiceTest extends TestCase
{

    private static $service;

    private $mail = 'phpunit@test.com';
    private $password = 'phpunit';
    private $birthday = '1999-09-09';

    public function setUp(): void
    {
        // 各テストメソッド実行前に行いたい処理
        self::$service = ApplicationServiceFactory::createApplicationService('production');
    }

    public function test_newInstanceOfApplicationService()
    {
        $this->assertInstanceOf(ApplicationService::class, self::$service);
    }

    public function test_userCreate()
    {
        $this->assertTrue(self::$service->register($this->mail, $this->password, $this->birthday));
    }

    public function test_userLogin()
    {
        $this->assertTrue(self::$service->login($this->mail, $this->password));
    }

    public function test_userInfo()
    {
        $this->assertSame('phpunit@test.com', self::$service->userInfo($this->mail)->mail);
        $this->assertSame('1999-09-09', self::$service->userInfo($this->mail)->birthday);
        $this->assertSame(0, self::$service->userInfo($this->mail)->permission);
    }

    public function test_update()
    {
        $this->assertTrue(self::$service->update($this->mail, 'updated@test.com', '2023-09-19'));

        $this->assertSame('updated@test.com', self::$service->userInfo('updated@test.com')->mail);
        $this->assertSame('2023-09-19', self::$service->userInfo('updated@test.com')->birthday);

        $this->assertTrue(self::$service->update('updated@test.com', $this->mail, ""));

        $this->assertSame('phpunit@test.com', self::$service->userInfo($this->mail)->mail);
        $this->assertSame('2023-09-19', self::$service->userInfo($this->mail)->birthday);
    }

    public function test_updatePassword()
    {
        $id = self::$service->userInfo($this->mail)->id;
        $password2 = 'updated';

        $this->assertTrue(self::$service->updatePassword($id, $password2));
        $this->assertTrue(self::$service->login($this->mail, $password2));

        $this->assertTrue(self::$service->updatePassword($id, $this->password));
        $this->assertTrue(self::$service->login($this->mail, $this->password));
    }

    public function test_userDelete()
    {
        $this->assertTrue(self::$service->delete($this->mail));
    }
}
