<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Halaman Admin</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= htmlspecialchars(
                    site_url('admin'),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>">
                    <i class="fa fa-dashboard"></i> Home
                </a>
            </li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informasi Login</h3>
            </div>

            <div class="box-body">
                <p>
                    Login sebagai:
                    <strong>
                        <?= htmlspecialchars(
                            $username,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </strong>
                </p>

                <form method="post"
                    action="<?= htmlspecialchars(
                        site_url('auth/logout'),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>">

                    <button type="submit" class="btn btn-danger">
                        Logout
                    </button>

                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php

require APPPATH . '/views/templates/footer.php';
?>