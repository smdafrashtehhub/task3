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
extract($_REQUEST , EXTR_PREFIX_SAME , "dup");

include 'db_info.php';


    if($_REQUEST['user'] == NULL)
        echo "<h3 class='text-primary text-center m-5'> کاربر را انتخاب کنید</h3>";
    if($_REQUEST['product'] == NULL)
        echo "<h3 class='text-primary text-center m-5'> سفارش را انتخاب کنید</h3>";
    if($_REQUEST['user'] != NULL && $_REQUEST['product'] != NULL) {
        try {

            include 'connection_db.php';

            $order = $conn->prepare("insert into orders(user_id)values (?)");
            $order->bindParam(1, $user);
            $order->execute();
//    $inner =$conn->prepare("select orders.id from users inner join orders on orders.user_id = users.id where user_id=? ORDER BY  orders.id desc");
//    $inner->bindParam(1, $user);
//    $inner->execute();
//    $result = $inner->fetch(\PDO::FETCH_ASSOC);
            $inner = $conn->prepare("select id from orders ORDER BY  id desc");
            $inner->execute();
            $result = $inner->fetch(\PDO::FETCH_ASSOC);

            foreach ($_REQUEST['product'] as $product) {
                $products = $conn->prepare("insert into order_product(order_id,product_id)values (?,?)");
                $order_id = $result['id'];
                $product_id = $product;
                $products->bindParam(1, $order_id);
                $products->bindParam(2, $product_id);
                $products->execute();
            }
            echo "<h3 class='text-primary text-center m-5'> سفارش با موفقیت ثبت شد</h3>";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

    }
echo"<div class='text-center'> 
                <button class='btn btn-info '><a href='order.php' class='text-white'>بازگشت</a></button>
          </div>";