<?php
include 'head.php';

if (!isset($_SESSION['username'])) {
    header("location: /login.php");
}
$sql = "select * from users order by id desc limit 500";

$result = mysqli_query($conn, $sql);
$num = $result->num_rows;
?>
<html>
<body>
<h1>这里已经有<?=$num?>位小伙伴了</h1>
<hr />
<?php while ($r = mysqli_fetch_array($result)): ?>
    <a href="/user.php?userid=<?=$r['id']?>"><?=htmlentities($r['username'])?></a>
    <?=$r['datetime']?>joined.
    <br/>

<?php endwhile?>
</body>
</html>
