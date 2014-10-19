a:9:{i:0;s:564:"<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
        <base href="<?php echo $baseUrl; ?>"></base>
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/base.css" rel="stylesheet">
        <script src="lib/jquery/jquery.min.js"></script>
        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/base.js"></script>
        ";s:4:"head";N;i:1;s:23:"
        <title>CMS | ";s:5:"title";N;i:2;s:1519:"</title>
    </head>
    <body>
        <div class="content-area">
            <div class="root-header row">
                <div class="navbar col">
                    <?php foreach ($menu as $item) { ?>
                    <div class="col nav-item"><a href="<?php echo $item->href; ?>"><?php echo $item->name; ?></a></div>
                    <?php } ?>
                </div>
                <div class="profile col">
                    <?php if (empty($user)) { ?>
                    <a href="index/login">Log in</a>
                    <?php } else { ?>
                    <span><?php echo $user->username; ?>, welcom!</span>
                    <a href="index/logout">Log out</a>
                    <?php } ?>
                </div>
            </div>
            <div class="root-content row">
            <div class="alert alert-success alert-dismissible" role="alert" style="height: 50px; display: none;">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <span class="content"></span>
            </div>
            <div class="alert alert-danger alert-dismissible" role="alert" style="height: 50px; display: none;">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <span class="content"></span>
            </div>
                ";s:7:"content";N;i:3;s:55:"
            </div>
        </div>
    </body>
    ";s:6:"script";N;i:4;s:11:"
</html>
";}