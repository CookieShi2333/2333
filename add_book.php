<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>书籍详情</title>
</head>
<body>
<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
$username=@$_SESSION['username'];
echo "你好，用户：".$username . ",请增加图书:<br/>";
if ($username) {
    add_book();
}
else{
    echo "<br>你尚未登录,无权访问本网页<br>";
    echo '<a href="Login.php">登录</a>/<a href="register.php">注册</a>';
}
?>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: shiyi
 * Date: 2019/5/21
 * Time: 17:38
 */

function add_book()
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
    $sql = "select * from sort";
    $result = mysqli_query($link, $sql);
    ?>

    <form method="post" action="" enctype="multipart/form-data">
    <div>
    书籍名称: <input name="book_name"><br>
    书记作者:<input name="book_author"><br>
    书籍出版社:<input name="book_pub"><br>
    <div>
    图书分类:<br/>
    <?php
    echo "<select name='book_sort'>";
    if ($result->num_rows > 0) {
        //输出数据

        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row["sort_id"]}'> {$row['sort_name']} </option>";
        }
        echo "</select><br><br>";
        }
        else{
        echo "0数据";
        }
        ?>
        <!--<input type="radio" name="book_sort" value="1">青春文学
        <input type="radio" name="book_sort" value="2">现代文学
        <input type="radio" name="book_sort" value="3">外国小说
        <input type="radio" name="book_sort" value="4">经典名著-->
        </div>
        书籍登记日期:<input name="book_record"><br>
        书籍封面:<input type="file" name="file"><br>
        书籍下载路径:<input type="file" name="file2"><br>
        </div>
        <br>
        <input type="submit" value="提交" name="submit">
        </form>
        </body>
        </html>

        <?php
        if (isset($_POST['submit'])) {
            $book_name = @$_POST['book_name'];
            $book_author = @$_POST['book_author'];
            $book_pub = @$_POST['book_pub'];
            $book_sort = @$_POST['book_sort'];
            //修改时间格式
            $date = @$_POST['book_record'];
            $book_record = date("Y-m-d", strtotime($date));
            //验证图片格式
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
                        $book_image = "image/" . $_FILES["file"]["name"];
                    } else {
                        // 如果 upload 目录不存在该文件则将文件上传到 image 目录下
                        move_uploaded_file($_FILES["file"]["tmp_name"], "image/" . $_FILES["file"]["name"]);
                        echo "<br>图片存储在: " . "image/" . $_FILES["file"]["name"] . "<br>";
                        $book_image = "image/" . $_FILES["file"]["name"];
                        // echo $book_image;
                    }
                }
            } else {
                echo "图片，非法的文件格式";
                header("location:add_book.php");
            }

            //验证pdf格式
            if (($_FILES["file2"]["type"] == "application/pdf")) {
                if ($_FILES["file2"]["error"] > 0) {
                    echo "错误：: " . $_FILES["file2"]["error"] . "<br>";
                } else {
                    // 判断当期目录下的 pdf目录是否存在该文件
                    // 如果没有 pdf 目录，你需要创建它，image 目录权限为 777
                    if (file_exists("pdf/" . $_FILES["file2"]["name"])) {
                        echo $_FILES["file2"]["name"] . " 文件已经存在。 ";
                        $book_download_url = "pdf/" . $_FILES["file2"]["name"];
                    } else {
                        // 如果 upload 目录不存在该文件则将文件上传到 image 目录下
                        move_uploaded_file($_FILES["file2"]["tmp_name"], "pdf/" . $_FILES["file2"]["name"]);
                        echo "<br>书籍存储在: " . "pdf/" . $_FILES["file2"]["name"] . "br>";
                        $book_download_url = "pdf/" . $_FILES["file2"]["name"];
                        //echo $book_download_url;
                    }
                }
            } else {
                echo "书籍，非法的文件格式";
                header("location:add_book.php");
            }


            //增加sql语句
            $sql = "insert into book(book_name,book_author,book_pub,book_sort,book_record,book_image,book_download_url)
         values ('{$book_name}','{$book_author}','{$book_pub}','{$book_sort}','{$book_record}','{$book_image}','{$book_download_url}')";
            $result = mysqli_query($link, $sql);
            if ($result) {
                echo "<br>增加图书成功<br>";
                echo "<br><a href='main.php'>返回主页</a><br>";
            } else {
                echo "<br>增加图书失败<br>";
                echo "<br><a href='add_book.php'>重新增加图书</a><br>";
            }
            $link->close();
        }
    }

?>

