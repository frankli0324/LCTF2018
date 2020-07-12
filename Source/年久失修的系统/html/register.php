<?php
include "head.php";

sqlifilter($_POST['username']);
sqlifilter($_POST['password']);

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['verify_code'])) {
    chk_verify_code();

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    if (strlen($username) < 6) {
        die("username is too short");
    }
    if (strlen($username) > 18) {
        die("username is too long");
    }

    $query_sql = "select * from users where username = '$username'";
    $result = mysqli_query($conn, $query_sql);

    if ($result->num_rows !== 0) {
        die("username has already been registered.");
    }
    $now_time = date("Y-m-d H:i:s");
    $insert_sql = "insert into users (`username`, `password`, `datetime`) values ('$username','$password','$now_time')";

    mysqli_query($conn, $insert_sql);
    header("location: /login.php");
    die();
}
?>
<html>
<h1 align="center">注册</h1>
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
<input type="button" onclick="location.href='/login.php'" value="去登陆"></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="submit" type="submit" value="注册"></input>
</div>
</form>
</html>
