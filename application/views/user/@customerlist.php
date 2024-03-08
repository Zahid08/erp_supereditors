<?php
error_reporting(0);
$createdby = $this->session->userdata['user_id'];
if($this->session->userdata['role'] == 2)
$enquiryDetails = $this->db->query("SELECT * FROM enquiry WHERE isactive = 1 AND  created_by = $createdby and is_customer = 1 ORDER BY enquiry_id DESC")->result();
else
$enquiryDetails = $this->db->query("SELECT *,(SELECT name FROM user u where u.user_id = e.created_by ) as AgentName FROM enquiry e WHERE isactive = 1 and is_customer = 1 ORDER BY enquiry_id DESC")->result();
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
    <title>SuperEditors || Customer</title>
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
                    <h3 class="text-primary">Customer List</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Customer List</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <a href="<?php echo base_url() ?>Po/customer_details" target="_blank"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">Add Customer</button></a>
                    
            <!-- Start Page Content -->
                <div class="card">
                                                   
                            <div class="card-body">
                                <h4 class="card-title">Customer List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Party Name</th>
                                                <th>Party Type</th>
                                                <th>Credit Days</th>
                                                <th>Credit Limit</th>
                                                <?php if($_SESSION['role'] == 1){ ?>
                                                <th>Created By</th>
                                                <?php } ?>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($enquiryDetails as $getenquiryDetails){ 
                                            
                                            $enquiry_id = $getenquiryDetails->enquiry_id;
                                               $HeadingDetails= $this->db->query("SELECT * FROM quotation_heading WHERE isactive = 1 AND enquiry_id = $enquiry_id ORDER BY 1 DESC LIMIT 1 ")->result();
                                                   foreach($HeadingDetails as $getHeadingDetails){
                                                       $latestheadingid = $getHeadingDetails->heading_id;
                                                   }
                                            
                                            ?>
                                                <tr>
                                                    <td><?php echo $getenquiryDetails->name ?></td>
                                                    <td><?php echo $getenquiryDetails->type ?></td>
                                                    <td><?php echo $getenquiryDetails->credit_days ?></td>
                                                    <td><?php echo $getenquiryDetails->credit_limit ?></td>
                                                    <?php if($_SESSION['role'] == 1){ ?>
                                                    <td><?php echo $getenquiryDetails->AgentName ?></td>
                                                    <?php } ?>
                                                    <td>
                                                        <a href="<?php echo base_url() ?>Po/customer_details?enquiry_id=<?php echo $getenquiryDetails->enquiry_id ?>" target="_blank"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">View Details</button></a>
                                                        <a href="<?php echo base_url() ?>Enquiry/quotation?enquiry_id=<?php echo $getenquiryDetails->enquiry_id ?>&header_id=<?php echo $latestheadingid ?>" target="_blank"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">Quotation</button></a>
                                                        <a href="<?php echo base_url() ?>Enquiry?enquiry_id=<?php echo $getenquiryDetails->enquiry_id ?>&#appointment_section" target="_blank"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">Appointment</button></a>
                                                        <a href="<?php echo base_url() ?>Po?enquiry_id=<?php echo $getenquiryDetails->enquiry_id ?>" target="_blank"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">PO</button></a>
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