<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./bootstrap.rtl.min.css">
</head>
<body>

</body>
</html>
<?php
session_start();
extract($_REQUEST , EXTR_PREFIX_SAME , "dup");

include 'db_info.php';

try {
    include 'connection_db.php';

    $sql = $conn->prepare("delete from order_product where order_id=?");
//    $order_id=$_SESSION['order_id'];
    $order_id=$_REQUEST['order_id'];
    $sql->bindParam(1, $order_id);
    $sql->execute();
    $sql = $conn->prepare("delete from orders where id=?");
    $sql->bindParam(1, $order_id);
    $sql->execute();
    session_unset();
    session_destroy();
    echo "<h3 class='text-primary text-center m-5'> سفارش با موفقیت حذف شد</h3>";
    echo"<div class='text-center'> 
                <button class='btn btn-info '><a href='show_orders.php' class='text-white'>بازگشت</a></button>
          </div>";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}