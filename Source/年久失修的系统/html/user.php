<?php
include 'head.php';

if (!isset($_SESSION) || !isset($_GET['userid'])) {
    header("location: /index.php");
}

$userid = $_GET['userid'];
sqlifilter($userid);
$user_sql = "select * from users where id = $userid";
$result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_array($result);

if (!$user) {
    header("location: /index.php");
    die("no such user");
}

if ($_POST['action'] === 'setmotto' && isset($_POST['motto'])) {
    chk_verify_code();
    if (!($user['username'] === $_SESSION['username'])) {
        die('permission denied');
    }
    $new_motto = $_POST['motto'];
    sqlifilter($new_motto);
    if (strlen($new_motto) > 140) {
        die("motto too long");
    }
    $motto_sql = "update users set motto = '$new_motto' where id = $userid";
    mysqli_query($conn, $motto_sql);
    die("set motto success !");

} elseif ($_POST['action'] === 'resetpass') {
    chk_verify_code();
    if (!($user['username'] === $_SESSION['username'])) {
        die('permission denied');
    }
    $newpass = md5($_POST['new_password']);
    $sql = "update users set password = '$newpass' where id = $userid";
    mysqli_query($conn, $sql);
    die("reset password success !");
}

$verify_code = gen_verify_code();

$username = $user['username'];
$query_sql = "select * from user_posts where username = '$username' order by id limit 200";
$posts_result = mysqli_query($conn, $query_sql);
?>
<html>
<body>
<h1>个人中心</h1>
<hr />
<h4>

<h4><?=htmlentities($user['username'])?></h4>
motto: <?=htmlentities($user['motto'])?><br/>
注册于: <?=htmlentities($user['datetime'])?><br/>
<br />
<?php
while ($r = mysqli_fetch_array($posts_result)) {

    echo htmlentities($r['datetime'] . ' said:');
    echo '<br />';
    echo htmlentities($r['message']);
    echo '<br />';
}
?>
<?php if ($user['username'] === $_SESSION['username']): ?>
    <br />
    <h3>更改信息</h3>
    <hr />
    <form action="" method="POST">
    设置motto: <input type='text' name="motto" size="70"></input><br />
    <br />
    substr(sha1( <input name="verify_code" type="text" size="30"></input> ), 0, 5) === <?=$verify_code?>
    &nbsp;
    <input name="action" type="hidden" value="setmotto">
    <input type="submit" value="提交"></input>
    </form>

    <form action="" method="POST">
    设置密码: <input type='password' name="new_password" size="72"></input><br />
    <br />
    substr(sha1( <input name="verify_code" type="text" size="30"></input> ), 0, 5) === <?=$verify_code?>

    &nbsp;
    <input name="action" type="hidden" value="resetpass">
    <input name="setmotto" type="submit" value="提交"></input>
    </form>
<?php endif?>
<?php if ($_SESSION['username'] === 'admin'): ?>
    <a href='s3cr_adm111111111111n.php'>后台管理</a>
<?php endif?>