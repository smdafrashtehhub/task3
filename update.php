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


if($user == NULL)
    echo "<h3 class='text-primary text-center m-5'> کاربر را انتخاب کنید</h3>";
if($products == NULL)
    echo "<h3 class='text-primary text-center m-5'> سفارش را انتخاب کنید</h3>";
if($user != NULL && $products != NULL) {
    try {

        include 'connection_db.php';
        $order = $conn->prepare("update orders set user_id=? where id=? ");
        $order->bindParam(1, $user);
        $order->bindParam(2, $order_id);
        $order->execute();

        $delete = $conn->prepare("delete from order_product where order_id=? ");
        $delete->bindParam(1, $order_id);
        $delete->execute();


        foreach ($products as $product) {
            $products = $conn->prepare("insert into order_product(order_id,product_id)values (?,?)");
            $products->bindParam(1, $order_id);
            $products->bindParam(2, $product);
            $products->execute();
        }
        echo "<h3 class='text-primary text-center m-5'> سفارش با موفقیت ثبت شد</h3>";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

}
echo"<div class='text-center'> 
                <button class='btn btn-info '><a href='show_orders.php' class='text-white'>بازگشت</a></button>
          </div>";