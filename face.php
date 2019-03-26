<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>头像选择器</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap/js/jquery-3.3.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<section id="face">
    <div class="container">
        <h4 class="text-center">头像选择</h4>
    </div>
    <dl>
    <?php foreach (range(1,9) as $num){?>
    <dd>
        <img src="face/m0<?php echo $num ?>.gif" alt="" title="头像<?php echo $num ?>">
        <?php  }?>
    </dd>
    </dl>
    <dl>
        <?php foreach (range(10,64) as $num){?>
        <dd>
            <img src="face/m<?php echo $num ?>.gif" alt="" title="头像<?php echo $num ?>">
            <?php  }?>
        </dd>
    </dl>
</section>
<script src="js/face.js"></script>

</body>
</html>
