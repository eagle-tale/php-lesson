<?php
session_start();

if ($_SESSION['permission'] == 0) {
    $_SESSION['msg'] = '現在の権限では行えない操作です';
    header('Location: ./user_list.php');
    exit();
}

include_once('.\Menu.php');
include_once('..\controllers\UserController.php');
$controller = new UserController();
$userList_array = $controller->userList();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧(管理者)</title>
    <link rel="stylesheet" href="./user_list.css">
</head>

<body>
    <h2>ユーザー一覧(管理者)</h2>
    <div class="tableWrapper">

        <table id="userTable">
            <thead>
                <tr>
                    <td class="idHead">No.</td>
                    <td class="nameHead">Name</td>
                    <td class="birthdayHead">誕生日</td>
                    <td class="createdDateHead">登録日</td>
                    <td class="permissionHead">権限レベル</td>
                    <td class="editHead"></td>
                    <td class="deleteHead"></td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($userList_array)) {
                    foreach ($userList_array as $user) {
                ?>
                        <tr>
                            <td class="id"><?php echo $user->id; ?></td>
                            <td class="mail"><?php echo $user->mail; ?></td>
                            <td class="birthday"><?php echo $user->birthday; ?></td>
                            <td class="createdDate"><?php echo $user->createdDate; ?></td>
                            <td class="permission"><?php echo $user->permission; ?></td>
                            <td>
                                <form action="update_user.php" method="post"><button type="submit" name="updateId" value="<?php echo $user->mail ?>">編集</button></form>
                            </td>
                            <td>
                                <form action="delete_user_action.php" method="post"><button type="submit" name="deleteId" value="<?php echo $user->mail ?>">削除</button></form>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>

        </table>

    </div>


    <!-- メニュー表示 -->
    <ul>
        <li>管理者用メニュー
            <ul>
                <li><a href="./user_list_edit.php">ユーザー情報変更・削除</a></li>
            </ul>
        </li>
        <!-- 通常メニュー -->
        <?php $menu = new Menu;
        $menu->show();
        ?>
    </ul>
</body>

</html>