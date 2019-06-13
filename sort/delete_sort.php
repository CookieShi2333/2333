<?php
/**
 * Created by PhpStorm.
 * User: shiyi
 * Date: 2019/6/11
 * Time: 19:53
 */
$sort_id = $_GET['sort_id'];
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
$sql = "delete from sort WHERE sort_id = '{$sort_id}'";
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