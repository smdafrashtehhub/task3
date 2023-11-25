<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./bootstrap.rtl.min.css">
    <link rel="stylesheet" href="css/body.css">
</head>
<body>

</body>
</html>
<?php
extract($_REQUEST , EXTR_PREFIX_SAME , "dup");

include 'db_info.php';

try {
    include 'connection_db.php';

    $users = $conn->prepare("select * from users ");
    $products = $conn->prepare("select * from products");
    $userid = $conn->prepare("select user_id from orders where id=?");
    $productname = $conn->prepare("select products.name from products inner join order_product on products.id=order_product.product_id where order_product.order_id=?");

    $userid->bindParam(1,$_REQUEST['order_id']);
    $productname->bindParam(1,$_REQUEST['order_id']);

    $userid->execute();
    $users->execute();
    $products->execute();
    $productname->execute();

    $product_name=$productname->fetchall();
    $user_id=$userid->fetch();
    $result_users=$users->fetchAll(\PDO::FETCH_ASSOC);
    $result_products=$products->fetchall(\PDO::FETCH_ASSOC);
    echo'<div class="container m-5 ">
    <div class="text-center col-3">
        <h3 class=" bg-danger mt-4 text-white  " style="border-radius: 1rem; padding: .2rem">ثبت سفارش : </h3>
    </div>
        <form action="update.php" method="post" class="d-flex" >
        <input type="number" name="order_id" value="'.$_REQUEST['order_id'].'" hidden>
        <div class="users col-3 bg-secondary-subtle m-2 p-2">
            <h4 class="bg-dark-subtle p-3">کاربر را انتخاب کنید : </h4>
            <div >';
    foreach ($result_users as $user)
    {
        echo'<input type="radio" id="'.$user['name'].'" name="user" value="'.$user['id'].'"';
        if($user['id']==$user_id['user_id']){
                    echo "checked";
                }
                    echo'>
                      <label for="'.$user['name'].'">'.$user['name'].'</label><br>';
    }
    echo'</div>
        </div>
        <div class="products col-9 bg-secondary-subtle m-2 p-2">
            <h4 class="bg-dark-subtle p-3">محصولات را انتخاب کنید : </h4>
            <div>';
    foreach ($result_products as $product)
    {
        echo'<input type="checkbox" id="'.$product['name'].'" name="products[]"  value="'.$product['id'].'"';
        foreach ($product_name as $prdct)
        if($product['name']==$prdct['name'])
            echo "checked";
        echo'>
                    <label for="'.$product['name'].'">'.$product['name'].'</label><br>';
    }
    echo '</div>
        </div>
          <button type="submit" class="m-2 bg-primary-subtle">ثبت</button>
</form></div>';
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}