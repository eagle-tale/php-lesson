<?php
session_start();
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
    <title>ユーザー一覧</title>
    <link rel="stylesheet" href="./user_list.css">
</head>

<body>
    <h2>ユーザー一覧</h2>
    <div class="tableWrapper">

        <!-- 一般ユーザーの場合 -->
        <table id="userTable">
            <thead>
                <tr>
                    <td class="idHead">No.</td>
                    <td class="nameHead">Name</td>
                    <td class="birthdayHead">誕生日</td>
                    <?php if ($_SESSION['permission'] == 1) { ?>
                        <td class="createdDateHead">登録日</td>
                    <?php } ?>
                    <td class="permissionHead">権限レベル</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($userList_array)) {
                    foreach ($userList_array as $user) {
                ?>
                        <tr>
                            <td><?php echo $user->id; ?></td>
                            <td><?php echo $user->mail; ?></td>
                            <td><?php echo $user->birthday; ?></td>
                            <?php if ($_SESSION['permission'] == 1) { ?>
                                <td><?php echo $user->createdDate; ?></td>
                            <?php } ?>
                            <td><?php echo $user->permission; ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>

        </table>

    </div>


    <!-- メニュー表示 -->
    <?php if ($_SESSION['permission'] == 1) { ?>
        <ul>
            <li>管理者用メニュー
                <ul>
                    <li><a href="./user_list_edit.php">ユーザー情報変更・削除</a></li>
                </ul>
            </li>
        <?php } ?>
        <!-- 通常メニュー -->
        <?php $menu = new Menu;
        $menu->show();
        ?>
        </ul>
</body>

</html>