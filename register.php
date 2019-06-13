<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>图书管理系统注册</title>
    <style type="text/css">
        table{
            margin:0 auto;
        }

        td{
            text-align:center;
        }
    </style>
</head>
<body>
<form action="" method="get">
    <table border="0">
        <tr>
            <td>用户名<input name="username" type="text"></td>
        </tr>
        <tr>
            <td>密码<input name="password" type="password"></td>
        </tr>
        <tr>
            <td colspan="2">
                <input name="Submit" type="submit" value="登录">
                <input name="Submit2" type="reset" value="重置">
            </td>
        </tr>
    </table>
</form>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: shiyi
 * Date: 2019/5/21
 * Time: 16:57
 */

session_start();
/*从Login.php中取得值，
因为method为get，所以取值为@$_GET['username']
如果method为post，取值为$_POST['username']
*/
if(isset($_GET['Submit'])){
$username=@$_GET['username'];
$password=@$_GET['password'];

   if ($username){
  /*连接数据库*/
        $link=mysqli_connect('localhost','root','')
         or die('数据库连接失败：'.mysqli_error($link));
         if(mysqli_select_db($link,"bookmanagement"))
             echo '<br>选择数据库成功<br>';
         else
             echo '<br>连接数据库失败<br>';
         //设置字符集
        mysqli_set_charset($link,"UTF8");
        //增加sql语句
        $sql="insert into user values ('{$username}','{$password}')";
         $result=mysqli_query($link,$sql);
         if($result) {
             echo "<br>注册成功<br>";
             $_SESSION['username']=$username;
             header("location:main.php");
         }
         else {
             echo "<br>注册失败<br>";
             header("location:register.php");
         }
        $link->close();
    }}

    ?>