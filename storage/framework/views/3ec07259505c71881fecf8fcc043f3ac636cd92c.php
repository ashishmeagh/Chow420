<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(url('/')); ?>/assets/admin/plugins/images/favicon.png">
    <title><?php echo e(config('app.project.name')); ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo e(url('/')); ?>/assets/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo e(url('/')); ?>/assets/admin/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?php echo e(url('/')); ?>/assets/admin/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo e(url('/')); ?>/assets/admin/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?php echo e(url('/')); ?>/assets/admin/css/colors/default.css" id="theme" rel="stylesheet">
    <script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-19175540-9', 'auto');
    ga('send', 'pageview');
    </script>
</head>

<body>
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>404</h1>
                <h3 class="text-uppercase">Page Not Found !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <a href="<?php echo e(url('/')); ?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
            <footer class="footer text-center"><?php echo e(date('Y')); ?> © <?php echo e(config('app.project.name')); ?></footer>
        </div>
    </section>
    <!-- jQuery -->
    <script src="<?php echo e(url('/')); ?>/assets/admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo e(url('/')); ?>/assets/admin/bootstrap/dist/js/tether.min.js"></script>
    <script src="<?php echo e(url('/')); ?>/assets/admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo e(url('/')); ?>/assets/admin/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>

</body>

</html>
