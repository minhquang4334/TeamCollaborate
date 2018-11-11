
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unauthorized: Access is denied</title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="/template/401/vendor.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/template/401/main.css">

    <script src="/template/401/modernizr.js"></script>
    <style>
        .link-color {
            color: #0d6aad;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>
<body>
<!--[if lt IE 10]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="page_overlay unauthorized">
    <div class="loader-inner ball-pulse">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div class="cloudWrapper">
    <div class="cloud cloud-1"><img src="/template/401/cloud-1.png" alt=""></div>
    <div class="cloud cloud-2"><img src="/template/401/cloud-2.png" alt=""></div>
    <div class="cloud cloud-3"><img src="/template/401/cloud-3.png" alt=""></div>
    <div class="cloud cloud-4"><img src="/template/401/cloud-4.png" alt=""></div>
</div>

<div class="unauthorized-wrap">
    <div class="scene-unauth"></div>
    <div class="row-flex">
        <div class="messge-unathorized">
            <h1><span>Stop</span> <br>
                Unauthorized</h1>
            <p>Bạn chưa đăng nhập, hoặc không có quyền truy cập. Nhấn vào <a class="link-color cursor-pointer" href="{{route('home')}}">đây</a> để trở về trang đăng nhập</p>
        </div>
    </div>
    <div class="charecter-6">
        <img src="/template/401/charecter-6.png" alt="">
        <span class="eye-6"><img src="/template/401/eye-6.gif" alt=""></span>
        <span class="hand-6">
             <img src="/template/401/hand-6.png" alt="">
           </span>
    </div>
</div>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
    function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
    e=o.createElement(i);r=o.getElementsByTagName(i)[0];
    e.src='//www.google-analytics.com/analytics.js';
    r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','UA-XXXXX-X');ga('send','pageview');
</script>

<script src="/template/401/vendor.js"></script>

<script src="/template/401/plugins.js"></script>

<script src="/template/401/main.js"></script>
</body>
</html>
