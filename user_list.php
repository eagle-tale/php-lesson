<?php
session_start();
require('Menu.php');
require('Db_controller.php');
$db = new Db();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧</title>
    <link rel="stylesheet" href="user_list.css">
</head>

<body>
    <h2>ユーザー一覧</h2>
    <div class="tableWrapper">

        <!-- 一般ユーザーの場合 -->
        <?php if ($_SESSION['permission'] == 0) { ?>

            <table id="userTable">
                <thead>
                    <tr>
                        <td class="idHead">No.</td>
                        <td class="nameHead">Name</td>
                        <td class="birthdayHead">誕生日</td>
                        <td class="permissionHead">権限レベル</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $userList_array = $db->get_UserList($_SESSION['permission']);
                    if (isset($userList_array)) {
                        foreach ($userList_array as $user) {
                    ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['loginId']; ?></td>
                                <td><?php echo $user['birthday']; ?></td>
                                <td><?php echo $user['permission']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>

            </table>

        <?php } ?>

        <!-- 管理者ユーザーの場合 -->
        <?php if ($_SESSION['permission'] == 1) { ?>

            <table id="userTable">
                <thead>
                    <tr>
                        <td class="idHead">No.</td>
                        <td class="nameHead">Name</td>
                        <td class="birthdayHead">誕生日</td>
                        <td class="createdDateHead">登録日</td>
                        <td class="permissionHead">権限レベル</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $userList_array = $db->get_UserList($_SESSION['permission']);
                    if (isset($userList_array)) {
                        foreach ($userList_array as $user) {
                    ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['loginId']; ?></td>
                                <td><?php echo $user['birthday']; ?></td>
                                <td><?php echo $user['createdDate']; ?></td>
                                <td><?php echo $user['permission']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>

            </table>

        <?php } ?>

    </div>


    <!-- メニュー表示 -->
    <?php $menu = new Menu;
    $menu->show();
    ?>
</body>

</html>