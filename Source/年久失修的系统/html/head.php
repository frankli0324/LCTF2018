<?php
session_start();
function sqlifilter($data)
{
    $data = (string) $data;
    if (preg_match('/(select|insert|update|delete|all|order|limit|by|union|exist|if|case|sleep|benchmark|time|information|and|or|rand|floor|xml|extra|concat|limit|offset|char|hex|version|case|%|\,|\\\\|\'|\"|\#|&|\||\^|`|\(|\))/i', $data)) {
        die('illegal request.');
    }
    return true;
}

function chk_verify_code()
{
    $stored = $_SESSION['verify_code'];
    unset($_SESSION['verify_code']);
    if (substr(sha1($_POST['verify_code']), 0, 5) !== $stored) {
        die("illegal verify code.");
    }

}

function gen_verify_code()
{
    $eles = "0123456789abcdef";
    $verify_code = "";
    for ($i = 0; $i < 5; $i++) {
        $verify_code .= substr($eles, mt_rand(0, strlen($eles) - 1), 1);
    }
    $_SESSION['verify_code'] = $verify_code;
    return $verify_code;
}
$conn = mysqli_connect('localhost', 'lctf2018', 'mysql-upgrade-best-practices', 'ctf');
