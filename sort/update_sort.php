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
$sql ="select * from sort where sort_id='{$sort_id}'";
$result = mysqli_query($link, $sql);

echo "<form method='post' action=''><table border='1'>
             <tr><td>分类序号</td><td>分类名称</td></tr>";
if ($result->num_rows > 0) {
    //输出数据
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td><input type='text' name='sort_id' value='{$row["sort_id"]}'></td>
                   <td><input type='text' name='sort_name' value='{$row["sort_name"]}'></td></tr>";
    }
    echo "</table><input name='submit' type='submit' value='提交'></form>";
}

if (isset($_POST['submit'])) {
    $sort_id = @$_POST['sort_id'];
    $sort_name = @$_POST['sort_name'];
echo $sort_id;
    $sql ="update sort set sort_id='{$sort_id}',sort_name='{$sort_name}' where sort_id='{$sort_id}'";
    $result = mysqli_query($link, $sql);
    if ($result){
        echo "更新成功";
        echo "<a href='sort.php'>分类操作</a>";
    }
    else{
        echo "更新失败";
        echo "<a href='sort.php'>分类操作</a>";
    }}
?>