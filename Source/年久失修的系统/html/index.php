<?php
include "head.php";

if (!isset($_SESSION['username'])) {
    header("location: /login.php");
}

if (isset($_POST['msg']) or isset($_POST['verify_code'])) {
    chk_verify_code();
    $username = $_SESSION['username'];
    $message = $_POST['msg'];
    sqlifilter($username);
    sqlifilter($message);
    $now_time = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $insert_sql = "insert into user_posts (`username`,`message`,`datetime`,`ip`) values ('$username','$message','$now_time','$ip')";
    $result = mysqli_query($conn, $insert_sql);
    var_dump($result);
    header("location: /index.php");
    die();
}

?>
<html>
<body>
<h1>在这里随便输入一些可有可无的东西</h1>
<hr />
<pre>
<?php
$select_sql = "select * from user_posts order by id desc limit 0,200";
$result = mysqli_query($conn, $select_sql);
while ($row = mysqli_fetch_array($result)) {

    echo htmlentities($row['username'] . ' at ' . $row['datetime'] . ' said:');
    echo '<br />';
    echo '&nbsp;&nbsp;&nbsp;';
    echo htmlentities($row['message']);
    echo '<br />';
    echo '<br />';

}
?>
</pre>
<a href='users.php'>所有用户</a>
<br />
<br />
<br />
<br />
<form action="" method="POST">
<input name="msg" type="text" size="100"></input>
<input type="submit" value="UP!"></input>
<br />
<br />
substr(sha1( <input name="verify_code" type="text" size="30"></input> ), 0, 5) ===<?=gen_verify_code()?>
</form>
</body>
</html>
