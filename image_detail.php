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
echo "你好，用户：".$username;
if ($username) {
    image_detail();
}
else{
    echo "你尚未登录,无权访问本网页";
    echo '<a href="Login.php">登录</a>/<a href="register.php">注册</a>';
}
?>
</body>
</html>

<?php
function image_detail()
{
//获取从main.php取得的参数
    $book_id = $_GET['id'];
   // echo $book_id;
    //根据id从数据库中读取值
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
    $sql="select * from book where book_id='{$book_id}'";
    $result=mysqli_query($link,$sql);
    //显示图书信息
    echo "<table border='1'><tr>
    <td>书籍序号</td>
    <td>书籍名称</td>
    <td>书籍作者</td>
    <td>书籍出版社</td>
    <td>书籍分类</td>
    <td>书籍登记日期</td>
    <td>书籍封面</td>
    <td>书籍下载地址</td>
    </tr>";
    //显示数据
    if($result->num_rows>0){
        //输出数据
        while($row=$result->fetch_assoc()){
            /*echo $row["book_name"];
            echo $row["book_image"];*/
            echo "<tr><td>".$row["book_id"]."</td>
                       <td>".$row["book_name"]."</td>
                       <td>".$row["book_author"]."</td>
                       <td>".$row["book_pub"]."</td>
                       <td>".$row["book_sort"]."</td>
                       <td>".$row["book_record"]."</td>
                       <td><img src='{$row["book_image"]}' style='height: 100px ;width: 70px'></td>
                       <td><a href='{$row["book_download_url"]}'>下载地址</a></td></tr>";
        }
        echo "</table>";
        echo "<a href='main.php'>跳转到主页</a>";
    }
    else {
        echo "0 结果";
    }
    $link->close();
}

?>