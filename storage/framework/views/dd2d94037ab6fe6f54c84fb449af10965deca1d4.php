<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired</title>
    <link rel="stylesheet" href="<?php echo e(asset('/public/adminlte')); ?>/dist/css/adminlte.min.css">
    <link rel="icon" href="<?php echo e(asset('/public/adminlte')); ?>/dist/img/header.png" type="image/png" sizes="16x16">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font: 110%/1.5 system-ui, sans-serif;
            background: #131417;
            color: white;
            height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 2rem;
        }

        main {
            max-width: 350px;
        }

        a {
            color: #56BBF9;
        }
    </style>
</head>

<body>
    <main align="center">
        <h1 data-test-id="text-404"><?php echo $__env->yieldContent('code'); ?></h1>
        <p><?php echo $__env->yieldContent('message'); ?>.</p>
        <a href="<?php echo e(url('/')); ?>" class="btn btn-primary">Back to web</a>
    </main>


</body>

</html>
<?php /**PATH C:\laragon\www\futsal\resources\views/errors/minimal.blade.php ENDPATH**/ ?>