<!doctype html>
<html lang="en" dir="rtl">
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

    $orders = $conn->prepare("SELECT * FROM orders ORDER BY id DESC ");

    $orders->execute();
    $result = $orders->fetchAll(\PDO::FETCH_ASSOC);

    echo "<div class='container text-center'>
<h3 class='m-5 bg-dark-subtle col-3 p-1 '> کلیه سفارش ها</h3>

<table class='table table-hover table-striped table-bordered text-center '>
    <thead>
                <tr>
                <th>کد سفارش</th>
                <th>کاربر سفارش دهنده</th>
                <th>سفارش</th>
                <th>عملیات</th>
               <tr>
          </thead><tbody>";

    foreach ($result as $order) {
        $_SESSION['order_id']=$order['id'];
        $username=$conn->prepare("select users.name from users inner join orders on users.id=orders.user_id where orders.user_id=? ");
        $username->bindParam(1,$order['user_id']);
        $username->execute();
        $user_name=$username->fetch(\PDO::FETCH_ASSOC);
        $products=$conn->prepare("select products.name from products inner join order_product on products.id=order_product.product_id where order_product.order_id=?");
        $products->bindParam(1,$order['id']);
        $products->execute();
        $product=$products->fetchAll(\PDO::FETCH_ASSOC);

        echo"<tr><td class='text-danger'>".$order['id']."</td>
                <td class='text-info'>".$user_name['name']."</td>
                <td class='text-danger'>";
                    foreach ($product as $product_name)
                         echo $product_name['name']."<br>";
               echo"</td>
               <td>
                    <form action=''>
                    <input type='number' name='order_id' hidden value='". $order['id']."'>
                    <button type='submit' class='btn btn-danger ' formaction='delete.php'>حذف</button>
                    <button type='submit' class='btn btn-info ' formaction='edit.php'>ویرایش</button>
                    </form>
               </td>
                </tr>
        ";

    }
    echo "</tbody></table></div>";
    echo "<h3 class='text-primary text-center m-5'> اطلاعات کاربران  با موفقیت نمایش داده شد</h3>";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
