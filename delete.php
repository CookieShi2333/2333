<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>书籍详情</title>
</head>
<body>
<?php
session_start();
$username=@$_SESSION['username'];
echo "你好，用户：".$username."<br>";
if ($username) {
    delete();
}
else{
    echo "你尚未登录,无权访问本网页";
    echo '<a href="Login.php">登录</a>/<a href="register.php">注册</a>';
}
?>
</body>
</html>

<?php
function delete()
{
//获取从main.php取得的参数
    $book_id = $_GET['d_id'];
    //echo $book_id . "删除页面";

    /*连接数据库*/
    $link = mysqli_connect('localhost', 'root', '')
    or die('数据库连接失败：' . mysqli_error($link));
    if (mysqli_select_db($link, "bookmanagement"))
        echo '<br>选择数据库成功<br>';
    else
        echo '<br>连接数据库失败<br>';
    //设置字符集
    mysqli_set_charset($link, "UTF8");
    //删除sql语句
    $sql = "delete from book WHERE book_id = '{$book_id}'";
    //$sql="select * from book where book_id='{$book_id}'";
    $result = mysqli_query($link, $sql);
    if ($result){
        echo "删除成功";
        echo "<a href='main.php'>返回主页</a>";
    }
    else{
        echo "删除失败";
        echo "<a href='main.php'>返回主页</a>";
    }
}
?>