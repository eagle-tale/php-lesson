<?php

namespace App\Phpunit;

require_once('..\services\ApplicationService.php');
require_once('..\factories\ApplicationServiceFactory.php');

use ApplicationService;
use ApplicationServiceException;
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

    //****
    // インスタンスが生成できているか
    //****
    public function test_newInstanceOfApplicationService()
    {
        $this->assertInstanceOf(ApplicationService::class, self::$service);
    }
    //****
    // ユーザーが作成できているか
    //****
    public function test_userCreate()
    {
        // 作成
        $this->assertTrue(self::$service->register($this->mail, $this->password, $this->birthday));

        // 作成できているか確認
        $this->test_userInfo();
    }

    //****
    // ユーザーがログインできるか
    //****
    public function test_userLogin()
    {
        $this->assertTrue(self::$service->login($this->mail, $this->password));
    }

    //****
    // ユーザー情報が取得できるか
    //****
    public function test_userInfo()
    {
        $this->assertSame('phpunit@test.com', self::$service->userInfo($this->mail)->mail);
        $this->assertSame('1999-09-09', self::$service->userInfo($this->mail)->birthday);
        $this->assertSame(0, self::$service->userInfo($this->mail)->permission);
    }


    //****
    // ユーザー情報が更新できているか
    //****
    public function test_update()
    {
        // メールアドレスの更新
        $this->assertTrue(self::$service->update($this->mail, 'updated@test.com', '2023-09-19'));

        // 更新できているかチェック
        $this->assertSame('updated@test.com', self::$service->userInfo('updated@test.com')->mail);
        $this->assertSame('2023-09-19', self::$service->userInfo('updated@test.com')->birthday);

        // 元のメールアドレスに戻す
        $this->assertTrue(self::$service->update('updated@test.com', $this->mail, ""));

        // 戻せているかチェック
        $this->assertSame('phpunit@test.com', self::$service->userInfo($this->mail)->mail);
        $this->assertSame('2023-09-19', self::$service->userInfo($this->mail)->birthday);
    }

    //****
    // ユーザーのパスワードが更新できているか
    //****
    public function test_updatePassword()
    {
        $id = self::$service->userInfo($this->mail)->id;
        $password2 = 'updated';

        // パスワードの更新
        $this->assertTrue(self::$service->updatePassword($id, $password2));
        // ログイン試行
        $this->assertTrue(self::$service->login($this->mail, $password2));

        // パスワードをもとに戻す
        $this->assertTrue(self::$service->updatePassword($id, $this->password));
        // ログイン試行
        $this->assertTrue(self::$service->login($this->mail, $this->password));
    }

    //****
    // ユーザーが削除できているか
    //****
    public function test_userDelete()
    {
        // 削除実施
        $this->assertTrue(self::$service->delete($this->mail));

        // 削除されているか
        $this->assertNull(self::$service->userInfo($this->mail)->mail);

        // ログイン試行してエラーが出るか
        $this->expectException(ApplicationServiceException::class);

        self::$service->login($this->mail, $this->password);
    }
}
