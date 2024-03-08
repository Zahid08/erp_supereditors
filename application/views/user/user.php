<?php
error_reporting(1);
$userDetails = $this->db->query("SELECT * FROM user u INNER JOIN roles r where r.id = u.role  ORDER BY user_id DESC")->result();
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
    <title>SuperEditors || Users Page</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
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
                    <h3 class="text-primary">Users</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <a href="<?php echo base_url()?>User/add_user" target="_blank"><button type="button" class="btn btn-primary  text-white" >Add User</button></a>
                
                <center>
                    <p style="color:green"><?php echo $this->session->flashdata('user_message') ?></p>
                </center>
            <!-- Start Page Content -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Roles</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Created Datetime</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $c=1;
                                            foreach($userDetails as $getuserDetails){ ?>
                                                <tr>
                                                    <td><?php echo $c++ ?></td>
                                                    <td><?php echo $getuserDetails->name ?></td>
                                                    <td><?php echo $getuserDetails->email ?></td>
                                                    <td><?php echo $getuserDetails->mobile ?></td>
                                                    <td><?php echo $getuserDetails->role_name ?></td>
                                                    <td style="color: <?php echo ($getuserDetails->isactive == 1) ? 'green' : 'red'; ?>">
                                                    <?php if($getuserDetails->isactive == 1){ echo "Active"; }else{ echo "In Active"; }?></td>
                                                    <td><?php if($getuserDetails->created_by == NULL){ echo 'Self'; }else{ echo 'Admin'; } ?></td>
                                                    <td><?php echo date_format(date_create($getuserDetails->created_datetime),"d-m-Y H:i:s"); ?></td>
                                                    <td>
                                                        <a href="<?php base_url() ?>User/edit_user?userid=<?php echo $getuserDetails->user_id ?>">
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                          Edit
                                                        </button>
                                                        </a>
                                                        <a href="<?php base_url() ?>User/bulktransfer_user?userid=<?php echo $getuserDetails->user_id ?>">
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                          Bulk Transfer
                                                        </button>
                                                        </a>
                                                        <a href="<?php base_url() ?>User/active_user?userid=<?php echo $getuserDetails->user_id ?>">
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                          Active
                                                        </button>
                                                        </a>
                                                        <a href="<?php base_url() ?>User/inactive_user?userid=<?php echo $getuserDetails->user_id ?>">
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                          Inactive
                                                        </button>
                                                        </a>
                                                        <a href="<?php base_url() ?>User/delete_user?userid=<?php echo $getuserDetails->user_id ?>">
                                                            <button type="button" onclick="return confirm('Are you sure you want to delete this records?');"  class="btn btn-primary btn-sm " >
                                                                Delete
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>    
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
       
 
   
</body>

</html>