<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查看所有留言</title>
    <style type="text/css">
        body{
            /*background-image: url(img1.jpg);*/
            background-size: cover;
        }
        textarea{
            background:transparent;
            border-style:solid;
        }
        input::-webkit-input-placeholder {
            color: orange;
            font-size: 12px;
        }
    </style>
</head>
<body>
<table align="center" border="1px" cellspacing="0px" width="800px">
    <tr>
        <th>用户名</th>
        <th>留言</th>
        <th>操作</th>
    </tr>
    <?php
    session_start();

    $dsn = 'mysql:host=103.79.78.236;port=3306;dbname=Album;charset=utf8';
    $username = 'root';
    $password = 'qHx@114514';
    try {
        $dbh = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo '报错信息：' . $e->getMessage();
    }


    if (isset($_GET['id'])) {
        $did = $_GET['id'];
    }
    if (!empty($did)) {
        $sql = "delete from liuyan where id ='$did'";
        $ps = $dbh->prepare($sql);
        $ps->execute();
        header("location:show_liuyan.php");
    }


    $sql = "select id,username,message from liuyan order by id";
    $ps = $dbh->query($sql);
    $result = array();
    $result = $ps->fetchAll();

    for ($i = 0; $i < sizeof($result); $i++) {
        $id = $result[$i]['id'];
        $username = $result[$i]['username'];
        $messages = $result[$i]['message'];
        if ($_SESSION['username'] == $username || $_SESSION['username'] == "admin")  //常规情况下只允许删除自己的留言
        {
            echo '<tr align="center">';
            echo "<td style='color:#FF0000'>$username</td><td align='left'>$messages</td>
                  <td><a href='show_liuyan.php?id=$id'><input type='button' align='right' value='删除'></a></td>";
            echo '</tr>';
        } else {
            echo '<tr align="center">';
            echo "<td>$username</td><td align='left'>$messages</td>";
            echo '</tr>';
        }
    }
    ?>
</table>
</body>
</html>
