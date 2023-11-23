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
<div class="container col-3">
    <h3 class="text-center bg-danger mt-4 text-white " style="border-radius: 1rem; padding: .2rem">محصولات </h3>
    <form action="insert_product.php" method="post">
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">نام</label>
            <input type="text" class="form-control" name="name">
        </div>
        <?php echo'<div class="text-center">
            <button type="submit" class="btn btn-info">ذخیره</button>
        </div>';
        ?>
</body>
</html>