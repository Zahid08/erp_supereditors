<?php
$userid = $_GET["userid"];
$roleDetails = $this->db->query("SELECT * FROM roles WHERE is_active = 1")->result();
$userDetails = $this->db->query("SELECT * FROM user u INNER JOIN roles r ON r.id = u.role WHERE user_id = $userid")->result();
?>
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
    <title>SuperEditors || Roles Page</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">a
    
    
</head>

<body class="header-fix fix-sidebar">
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
       <?php include("includes/header.php") ?>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <?php include("includes/sidenav.php") ?>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Roles</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <section id="enquiry_section" name="enquiry_section">
               <center>
                    <p style="color:green"><?php echo $this->session->flashdata('role_message') ?></p>
                </center>
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        
                        <h5 class="card-title">User</h5>
                        <?php foreach($userDetails as $getuserDetails){ ?>
                        <form method="post" action="<?php echo base_url() ?>User/edit_user_data" autocomplete="off">
                            <input class="form-control" type="hidden" name="user_id" id="user_id" value="<?php echo $userid ?>" required>
                           <div class="row">
                              <div class="col-sm-6">
                                 <input class="form-control" name="name" id="name"  placeholder="Name" value="<?php echo $getuserDetails->name ?>" required>
                              </div>
                              <div class="col-sm-6">
                                 <input class="form-control" type="email" name="email" id="email"  placeholder="Email" value="<?php echo $getuserDetails->email ?>" required>
                              </div>
                              <div class="col-sm-6">
                                 <input class="form-control" name="mobile" id="mobile" pattern="[0-9]*" inputmode="numeric" value="<?php echo $getuserDetails->mobile ?>" minlength="10" maxlength="10" title="Please enter a valid Phone number" placeholder="Mobile" required>
                                 <span id="mobileError" style="color: red;"></span>
                              </div>
                              <div class="col-sm-6">
                                 <input  class="form-control" name="password" id="password"  value="<?php echo $getuserDetails->password ?>"  placeholder="Password" readonly>
                              </div>
                              <div class="col-sm-6">
                                  <select class="form-control" name="isactive" id="isactive">
                                      <option value="">Status</option>
                                      <option value="1"  <?php if($getuserDetails->isactive == 1){ ?> selected <?php } ?>>Active</option>
                                      <option value = "2" <?php if($getuserDetails->isactive == 2){ ?> selected <?php } ?>>In Active</option>
                                  </select>
                              </div>
                              <div class="col-sm-6">
                                  <select class="form-control" name="role" id="role"  required>
                                      <option value="">Role</option>
                                      <?php foreach($roleDetails as $getroleDetails){ ?>
                                      <option value="<?php echo $getroleDetails->id ?>" <?php if($getuserDetails->role == $getroleDetails->id){ ?> selected <?php } ?>><?php echo $getroleDetails->role_name  ?></option>
                                      <?php } ?>
                                  </select>
                                 
                              </div>
                              <div class="col-sm-12">
                                <p>&nbsp;</p>  
                              </div>
                              <div class="col-sm-12">
                                 <br>
                                 <button type="submit" class="btn btn-primary  text-white" >Save</button>
                              </div>
                           </div>
                        </form>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </section>
               
            
            <!-- Start Page Content -->   
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/footer.php") ?>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    
    <!-- Scripts -->
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
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/webticker/jquery.webticker.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/peitychart/jquery.peity.min.js"></script>
        <!-- scripit init-->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/custom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/dashboard-1.js"></script>
        
        <!-- Data Tables-->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables-init.js"></script>
        <script>
         document.getElementById('mobile').addEventListener('input', function() {
            var mobileInput = this.value;
            var mobileError = document.getElementById('mobileError');
            
            if (mobileInput.length > 10 || mobileInput.length < 10 && (/[^0-9]/.test(mobileInput))) {
                  mobileError.textContent = 'Mobile number should be exactly 10 digits and should contain only numeric characters.';
            } else {
               mobileError.textContent = '';
            }
         });
         </script> 
   
</body>

</html>