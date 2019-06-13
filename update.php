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
echo "你好，用户：".$username."<br>请修改";
if ($username) {
    update();
}
else{
    echo "<br>你尚未登录,无权访问本网页<br>";
    echo '<a href="Login.php">登录</a>/<a href="register.php">注册</a>';
}
?>
</body>
</html>
<?php

function update()
{
//获取从main.php取得的参数
        $book_id = $_GET['u_id'];
        //echo $book_id . "修改页面";
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
        echo "<form method='post' action='' enctype='multipart/form-data'><table border='1'><tr>
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
                $book_id=$row['book_id'];
                $book_image0=$row["book_image"];
                $book_download_url0=$row['book_download_url'];
               /* $_SESSION['book_id']=$book_id;
                $_SESSION['book_image']=$book_image;
                $_SESSION['book_download_url']=$book_download_url;*/

                echo "<tr><td>{$row['book_id']}</td>
                       <td><input type='text' name='book_name' value='{$row["book_name"]}'/></td>
                       <td><input type='text' name='book_author' value='{$row["book_author"]}'/></td>
                       <td><input type='text' name='book_pub' value='{$row["book_pub"]}'/></td>
                       <td><input type='text' name='book_sort' value='{$row["book_sort"]}'/></td>
                       <td><input type='text' name='book_record' value='{$row["book_record"]}'/></td>
                       <td><img src='{$row["book_image"]}' style='height: 100px ;width: 70px'>
                       <br><input type='file' name='file'> </td>
                       <td>{$row['book_download_url']}<br><input type='file' name='file2'>
                       </td></tr>";
            }
            echo "</table><input type='submit' value='提交' name='submit'></form>";
            echo "<a href='main.php'>跳转到主页</a>";
        }



    if(isset($_POST['submit'])){
        $book_name=@$_POST['book_name'];
        $book_author=@$_POST['book_author'];
        $book_pub=@$_POST['book_pub'];
        $book_sort=@$_POST['book_sort'];
        //修改时间格式
        $date=@$_POST['book_record'];
        $book_record=date("Y-m-d", strtotime($date));
        //验证有无新图片和图片格式
        if ($_FILES["file"]["name"]==null){
            $book_image=$book_image0;
        }
        else {
            $allowedExts = array("gif", "jpeg", "jpg", "png", "pjpeg");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);     // 获取文件后缀名
            if ((($_FILES["file"]["type"] == "image/gif")
                    || ($_FILES["file"]["type"] == "image/jpeg")
                    || ($_FILES["file"]["type"] == "image/jpg")
                    || ($_FILES["file"]["type"] == "image/png")
                    || ($_FILES["file"]["type"] == "image/pjpeg"))
                && ($_FILES["file"]["size"] < 307200)   // 小于 300 kb
                && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "错误：: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    // 判断当期目录下的 image 目录是否存在该文件
                    // 如果没有 image 目录，你需要创建它，image 目录权限为 777
                    if (file_exists("image/" . $_FILES["file"]["name"])) {
                        echo $_FILES["file"]["name"] . " 文件已经存在。 ";
                        $book_image = "http://php/homework/image/" . $_FILES["file"]["name"];
                    } else {
                        // 如果 upload 目录不存在该文件则将文件上传到 image 目录下
                        move_uploaded_file($_FILES["file"]["tmp_name"], "image/" . $_FILES["file"]["name"]);
                        echo "<br>图片存储在: " . "image/" . $_FILES["file"]["name"] . "<br>";
                        $book_image = "http://php/homework/image/" . $_FILES["file"]["name"];
                        // echo $book_image;
                    }
                }
            } else {
                echo "图片，非法的文件格式";
                header("location:update_book.php");
            }
        }

       //验证pdf格式
        if ($_FILES["file2"]["name"]==null){
            $book_download_url=$book_download_url0;
        }else {
            if (($_FILES["file2"]["type"] == "application/pdf")) {
                if ($_FILES["file2"]["error"] > 0) {
                    echo "错误：: " . $_FILES["file2"]["error"] . "<br>";
                } else {
                    // 判断当期目录下的 pdf目录是否存在该文件
                    // 如果没有 pdf 目录，你需要创建它，image 目录权限为 777
                    if (file_exists("pdf/" . $_FILES["file2"]["name"])) {
                        echo $_FILES["file2"]["name"] . " 文件已经存在。 ";
                        $book_download_url = "http://php/homework/pdf/" . $_FILES["file2"]["name"];
                    } else {
                        // 如果 upload 目录不存在该文件则将文件上传到 image 目录下
                        move_uploaded_file($_FILES["file2"]["tmp_name"], "pdf/" . $_FILES["file2"]["name"]);
                        echo "<br>书籍存储在: " . "pdf/" . $_FILES["file2"]["name"] . "br>";
                        $book_download_url = "http://php/homework/pdf/" . $_FILES["file2"]["name"];
                        //echo $book_download_url;
                    }
                }
            } else {
                echo "书籍，非法的文件格式";
                header("location:update.php");
            }
        }


        //修改sql语句
        $sql="update book set book_name='{$book_name}',book_author='{$book_author}',book_pub='{$book_pub}',book_sort='{$book_sort}',book_record='{$book_record}',book_image='{$book_image}',book_download_url='{$book_download_url}'
         where book_id='{$book_id}'";
         $result=mysqli_query($link,$sql);
         if($result) {
             echo "<br>修改图书成功<br>";
             echo "<br><a href='main.php'>返回主页</a><br>";
         }
         else {
             echo "<br>修改图书失败<br>";
             echo "<br><a href='update.php'>重新修改图书</a><br>";
         }
        $link->close();
    }
    }

?>