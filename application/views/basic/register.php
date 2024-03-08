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
    <title>SuperEditors || Register</title>
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
                                <p></p>
                                <h4>Register</h4>
                                <form method="post" action="<?php echo base_url() ?>Login/save_register_data" autocomplete="off">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Name" name="name" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="number" class="form-control" placeholder="Mobile" name="mobile" id="mobile" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date Of Birth</label>
                                        <input type="date" class="form-control" placeholder="Date of Birth" max="<?php echo date('Y-m-d') ?>" name="dob" id="dob" required>
                                    </div>
                                    <div class="checkbox">
                                        <label>
										<input type="checkbox" required> Agree the <a href="#">terms and policy</a>
									</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                                    <div class="register-link m-t-15 text-center">
                                        <p>Already have account ? <a href="<?php echo base_url(); ?>Login"> Sign in</a></p>
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