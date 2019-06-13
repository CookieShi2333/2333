<!DOCTYPE html>
<!--成功-->
<html>
<head>
    <meta charset="UTF-8">
    <title>分类操作</title>

</head>
<body>
<?php
session_start();
$username=@$_SESSION['username'];
echo "你好，用户：".$username."可以开始分类操作<br>";
if ($username) {
    loadinfo();
}
else{
    echo "你尚未登录,无权访问本网页";
    echo '<a href="../Login.php">登录</a>/<a href="../register.php">注册</a>';
}
?>
</body>
</html>



    <!--function delete_sort(sort_id) {
        $sort_id=sort_id;
        //删除sql语句
        $sql = "delete from sort WHERE book_id = '{$sort_id}'";
        $result = mysqli_query($link, $sql);
        if ($result){
            echo "删除成功";
            echo "<a href='sort.php'>分类操作</a>";
        }
        else{
            echo "删除失败";
            echo "<a href='sort.php'>分类操作</a>";
        }

    }-->


<?php
function loadinfo()
{
    /**
     * Created by PhpStorm.
     * User: shiyi
     * Date: 2019/6/8
     * Time: 21:26
     */
    /*连接数据库*/
    $link = mysqli_connect('localhost', 'root', '')
    or die('数据库连接失败：' . mysqli_error($link));
    if (mysqli_select_db($link, "bookmanagement"))
        echo '<br>选择数据库成功<br>';
    else
        echo '<br>连接数据库失败<br>';
//设置字符集
    mysqli_set_charset($link, "UTF8");
    $sql = "select * from sort";
    $result = mysqli_query($link, $sql);
    echo "<table border='1'>
       <tr><td>分类序号</td><td>分类名称</td><td>操作</td></tr>";
    if ($result->num_rows > 0) {
        //输出数据
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['sort_id']}</td>
                   <td>{$row['sort_name']}</td>
                   <td><a href='delete_sort.php?sort_id={$row["sort_id"]}'  >删除</a>/<a href='update_sort.php?sort_id={$row["sort_id"]}'>修改</a></td></tr>";
        }//delete_sort(
        echo "</table>";
        echo "<br><a href='add_sort.php?sort_id={$row["sort_id"]}'>增加</a>";
        echo "<br><a href='../main.php'>返回主页面</a>";
    }
}
?>



