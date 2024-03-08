<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/client_asstes/images/favicon.png">
    <title>SuperEditors || Login</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
</head>

<body class="header-fix fix-sidebar">
    
    <!-- Main wrapper  -->
    <div id="main-wrapper">

        <div class="unix-login">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <div class="login-form">
                                <center><span><img src="<?php echo base_url(); ?>assets/client_asstes/images/logo.png" alt="homepage" class="logo"  /></span></center>
                                <center><p style="color:green"><?php echo $this->session->flashdata('message') ?></p></center>
                                <h4>Login</h4>
                                <form method="post" action="<?php echo base_url() ?>Login/checklogin" autocomplete="off">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Login</button>
                                    <div class="register-link m-t-15 text-center">
                                        <p>Don't have an account ? <a href="<?php echo base_url(); ?>Login/register"> Sign up</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/custom.min.js"></script>

</body>

</html>