<?php
/**
 * Created by PhpStorm.
 * User: shiyi
 * Date: 2019/6/11
 * Time: 19:54
 */
echo "<form action='' method='post'>
                  分类序号：<input name='sort_id' type='text'><br>
                  分类名称：<input name='sort_name' type='text'><br>
                  <input name='submit' type='submit' value='提交'></form>";
if (isset($_POST['submit'])) {
    $sort_id = @$_POST['sort_id'];
    $sort_name = @$_POST['sort_name'];

    /*连接数据库*/
    $link = mysqli_connect('localhost', 'root', '')
    or die('数据库连接失败：' . mysqli_error($link));
    if (mysqli_select_db($link, "bookmanagement"))
        echo '<br>选择数据库成功<br>';
    else
        echo '<br>连接数据库失败<br>';
//设置字符集
    mysqli_set_charset($link, "UTF8");
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