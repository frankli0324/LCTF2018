<?php
include "head.php";

sqlifilter($_POST['username']);

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['verify_code'])) {
    chk_verify_code();

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "select * from users where username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('login failed.');
    }
    $r = mysqli_fetch_array($result);
    if ($password === $r['password']) {
        $_SESSION['username'] = $username;
        header("location: /index.php");
        die();
    } else {
        die('login failed');
    }
}
?>
<html>
<h1 align="center">登入</h1>
<hr />
<br />
<br />
<br />
<form action="" method="POST">
<div align="center">用户名: <input name="username" type="text"></input> 密码: <input name="password" type="password"></input></div>
<br />
<div align="center"> substr(sha1(<input name="verify_code" type="text" align="center"></input>), 0, 5) === <?=gen_verify_code()?>

</div>
<br />
<div align="center">
<input type="button" onclick="location.href='/register.php'" value="注册一个"></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="submit" type="submit" value="登入"></input>
</div>
</form>
</html>