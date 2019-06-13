<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>主页</title>
</head>
<body>

<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
$username=@$_SESSION['username'];
echo $username;
echo "你好，用户：".$username."<br>";
if ($username) {
    loadinfo();
}
else{
    echo "<br>你尚未登录,无权访问本网页<br>";
    echo '<a href="Login.php">登录</a>/<a href="register.php">注册</a>';
}


?>

<script src="js/jquery-1.8.3.js"></script>
<script>
    function image(book_id) {
        alert(book_id);
        window.location.href="image_detail.php?id="+book_id;
    }

</script>
</body>
</html>

<?php


function loadinfo(){
    /*连接数据库*/
    $link=mysqli_connect('localhost','root','')
    or die('数据库连接失败：'.mysqli_error($link));
    if(mysqli_select_db($link,"bookmanagement"))
        echo '<br>选择数据库成功<br>';
    else
        echo '<br>连接数据库失败<br>';
    //设置字符集
    mysqli_set_charset($link,"UTF8");
    //查找全部sql语句
    $sql="select * from book";
    $result=mysqli_query($link,$sql);
    //显示图书信息
    echo "<table border='1'><tr>
    <td>书籍序号</td>
    <td>书籍名称</td>
    <td>书籍作者</td>
    <td>书籍图片</td>
    <td>操    作</td>
    </tr>";
    //显示数据
    if($result->num_rows>0){
        //输出数据
        while($row=$result->fetch_assoc()){
            /*echo $row["book_name"];
            echo $row["book_image"];*/
            echo "<tr><td>" .$row["book_id"]."</td>
                       <td>".$row["book_name"]."</td>
                       <td>".$row["book_author"]."</td>
                       <td><img  onclick='image({$row["book_id"]})' src='{$row["book_image"]}' style='height: 100px ;width: 70px'></td>
                       <td><a href='delete.php?d_id={$row["book_id"]}'  >删除</a>/<a href='update.php?u_id={$row["book_id"]}'>修改</a></td></tr>";
        }
        echo "</table>";
    }
    else {
        echo "0 结果";
    }

    $link->close();
    echo "<a href='add_book.php'>增加图书</a><br>";
    echo "<a href='sort/sort.php'>分类操作</a>";
}

?>
