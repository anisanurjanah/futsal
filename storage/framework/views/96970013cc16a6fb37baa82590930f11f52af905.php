<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitPlaza | <?php echo $__env->yieldContent('title'); ?></title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?php echo e(asset('adminlte')); ?>/plugins/fontawesome-free/css/all.min.css">

    <!-- DataTables -->
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte')); ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="<?php echo e(asset('adminlte')); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo e(asset('adminlte')); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo e(asset('adminlte')); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo e(asset('adminlte')); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('adminlte')); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet"
        href="<?php echo e(asset('adminlte')); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('adminlte')); ?>/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('adminlte')); ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('adminlte')); ?>/plugins/fullcalendar/main.css">
    <link rel="icon" href="<?php echo e(asset('adminlte')); ?>/dist/img/logo.png" type="image/png" sizes="16x16">
    <style>
        .main-sidebar {
            background-color: #2a375c !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown show">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="true" class="nav-link dropdown-toggle">
                        <i class="fas fa-bell"></i>
                    </a>

                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
                        style="left: 0px; right: inherit;" id="notifikasiInner">
                    </ul>
                </li>
                <li class="nav-item dropdown show">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="true" class="nav-link dropdown-toggle">
                        <i class="fas fa-user-circle mr-2 text-lg"></i>
                        <span
                            class="hidden-xs"><?php echo e(auth()->user()->name); ?></span>
                    </a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
                        style="left: 0px; right: inherit;">
                        <li>
                            <a href="<?php echo e(url('profil')); ?>" class="dropdown-item">
                                <i class="nav-icon fas fa-user-secret"></i> Profil
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="<?php echo e(url('logout')); ?>" class="dropdown-item">
                                <i class="nav-icon fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>

        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="#" class="brand-link text-center">
                <span class="brand-text text-white">FIT PLAZA</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo e(url('img/profil/men.png')); ?>" class="img-circle elevation-2">
                    </div>
                    <div class="info">
                        <a href="#"
                            class="d-block"><?php echo e(auth()->user()->name); ?>

                            <br>
                            <span
                                class="small"><?php echo e(auth()->user()->email); ?></span>
                        </a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-header">Home</li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('/dashboard')); ?>"
                                class="nav-link <?php echo e(request()->is('/dashboard') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">Reservasi</li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('/dashboard/reservasi')); ?>"
                                class="nav-link <?php echo e(request()->is('/dashboard/reservasi') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Booking
                                </p>
                            </a>
                        </li>
                        <?php if(auth()->user()->isKasir()): ?>
                        <li class="nav-header">Kasir</li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/dashboard/lapangan')); ?>"
                                    class="nav-link <?php echo e(request()->is('/dashboard/lapangan') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Lapangan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/dashboard/pengguna')); ?>"
                                    class="nav-link <?php echo e(request()->is('/dashboard/pengguna') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-user-plus"></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/dashboard/pelanggan')); ?>"
                                    class="nav-link <?php echo e(request()->is('/dashboard/pelanggan') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-user-plus"></i>
                                    <p>
                                        Pelanggan
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-header">Laporan</li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('/dashboard/keuangan')); ?>"
                                class="nav-link <?php echo e(request()->is('/dashboard/keuangan') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Keuangan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(url('logout')); ?>" class="nav-link text-danger">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('breadcrums'); ?>
                </div>
            </section>

            <section class="content">
                <?php echo $__env->yieldContent('content'); ?>
            </section>
        </div>


        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
            </div>

            <strong>Copyright &copy; 2024 <a href="#">FUTSAL</a>.</strong> All rights
            reserved.
        </footer>
    </div>



    

    <!-- jQuery -->
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery UI -->
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script src="<?php echo e(asset('adminlte')); ?>/dist/js/adminlte.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/toastr/toastr.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/select2/js/select2.full.min.js"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/moment/moment.min.js"></script>
    <script src="<?php echo e(asset('adminlte')); ?>/plugins/fullcalendar/main.js"></script>




    <script>
        $(function() {
            $('#table1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
    <script>
        const notifikasiInner = document.getElementById('notifikasiInner');
        let datas = [];

        setInterval(() => {
            $.ajax({
                url: '<?php echo e(route('notifikasi')); ?>',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);

                    if (Array.isArray(data)) {
                        data.forEach(item => {
                            if (!item.is_read && !datas.find(d => d.id === item.id)) {
                                datas.push(item);
                            }
                        });
                    } else {
                        if (!data.is_read && !datas.find(d => d.id === data.id)) {
                            datas.push(data);
                        }
                    }

                    notifikasiInner.innerHTML = datas.map(item => `
                        <li>
                            <a href="/booking/index" class="dropdown-item">
                                ${item.pesan}
                            </a>
                        </li>
                    `).join('');
                },
                error: function(xhr, status, error) {
                    console.error('Gagal fetch:', error);
                }
            });
        }, 1000);
    </script>



    <?php echo $__env->yieldContent('script'); ?>

</body>

</html>
<?php /**PATH C:\laragon\www\futsal\resources\views/layout/main.blade.php ENDPATH**/ ?>