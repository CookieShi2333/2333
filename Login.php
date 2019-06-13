<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>图书管理系统登录</title>
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
if(isset($_GET['Submit'])) {
    $username = @$_GET['username'];
    $password = @$_GET['password'];


    function loadinfo()
    {
        /*连接数据库*/
        $link = mysqli_connect('localhost', 'root', '')
        or die('数据库连接失败：' . mysqli_error($link));
        if (mysqli_select_db($link, "bookmanagement"))
            echo '<br>选择数据库成功<br>';
        else
            echo '<br>连接数据库失败<br>';
        //设置字符集
        mysqli_set_charset($link, "UTF8");
        //查找全部sql语句
        $sql = "select * from user";
        // $sql="select * from departments";
        $result = mysqli_query($link, $sql);

        //将mysql查询结果放入数组中
        $user_array = array();
        $i = 0;
        if ($result->num_rows > 0) {
            //输出数据
            while ($row = $result->fetch_assoc()) {
                $user_array[$i] = array($row["user_account"], $row["password"]);
                $i++;
            }
        } else {
            echo "0 结果";
        }
        $link->close();
        return $user_array;
    }


    $user_array = loadinfo();
    if ($username) {
        if (!in_array(array($username, $password), $user_array))
            echo "<script>alert('用户名或密码错误！');location='Login.php';</script>";
        else {
            foreach ($user_array AS $value) {
                list($user, $pwd) = $value;
                if ($user == $username && $pwd == $password) {
                    /*把username放入session中，取出时用$username=@_SESSION['username'];*/
                    $_SESSION['username'] = $username;
                    //$_SESSION['password']=$password;
                    echo "<div>您的用户名为:" . $user . "</div>";
                    header("location:main.php");
                }
            }
        }
    }
}


?>