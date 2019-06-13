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
    echo '<a href="Login.php">登录</a>/<a href="register.php">注册</a>';
}
?>




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
                   <td><button>删除<?php delete_sort({$row['sort_id']})?></button>/<button onclick='update_sort({$row['sort_id']})'>修改</button></td></tr>";
        }
        echo "</table>";
        echo "<br><button onclick='add_sort()'>增加分类</button>";
    }
}
?>
<div id="sort_content"></div>

<script src="js/jquery-1.8.3.js"></script>
<script>
    function delete_sort() {
        alert(1111);
        <?php
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
        ?>

    }

    function update_sort(sort_id){
        alert(sort_id);
        /*  $("#sort_content").html();
          $("#sort_content").append("<form method='post' action=''>
              "<table border='1'>
              <tr><td>分类序号</td><td>分类名称</td></tr>");*/

        <?php
        $sql ="select * from sort where sort_id='{$sort_id}'";
        $result = mysqli_query($link, $sql);

        echo "<form method='post' action=''><table border='1'>
             <tr><td>分类序号</td><td>分类名称</td></tr>";
        if ($result->num_rows > 0) {
            //输出数据
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td><input type='text' name='sort_id' value='{$row["sort_id"]}'></td>
                   <td><input type='text' name='sort_name' value='{$row["sort_id"]}'></td></tr>";
            }
            echo "</table><input name='submit' type='submit' value='提交'></form>";
        }

        if (isset($_POST['submit'])) {
            $sort_id = @$_POST['sort_id'];
            $sort_name = @$_POST['sort_name'];

            $sql ="update sort set sort_id='{$sort_id}',sort_name='{$sort_name}' where sort_id='{$sort_id}'";
            $result = mysqli_query($link, $sql);
            if ($result){
                echo "更新成功";
                header("location:sort.php");
            }
            else{
                echo "更新失败";
                header("location:sort.php");
            }}
        ?>
    }

    function add_sort(){
        alert(1111);
        <?php
        echo "<form action='' method='post'>
                  分类序号：<input name='sort_id' type='text'><br>
                  分类名称：<input name='sort_name' type='text'><br>
                  <input name='submit' type='submit' value='提交'></form>";
        if (isset($_POST['submit'])) {
            $sort_id = @$_POST['sort_id'];
            $sort_name = @$_POST['sort_name'];

            $sql = "insert into sort(sort_id,sort_name) values ('{$sort_id}','{$sort_name}')";
            $result = mysqli_query($link, $sql);
            if ($result) {
                echo "增加成功";
                header("location:sort.php");
            } else {
                echo "增加失败";
                header("location:sort.php");
            }
        }
        ?>
    }

</script>
</body>
</html>


