<?php
error_reporting(1);
$roleid = $_GET['roleid'];
$rolesDetails = $this->db->query("SELECT * FROM roles r INNER JOIN user u ON u.user_id = r.created_by WHERE r.is_active = 1 AND r.id = $roleid ORDER BY id DESC")->result();
foreach($rolesDetails as $getrolesDetails){
    $rolename = $getrolesDetails->role_name;
    $dashboard = $getrolesDetails->dashboard;
    $add_enquiry = $getrolesDetails->add_enquiry;
    $enquiry_list = $getrolesDetails->enquiry_list;
    $quotation = $getrolesDetails->quotation;
    $appointment = $getrolesDetails->appointment;
    $customers = $getrolesDetails->customers;
    $send_email = $getrolesDetails->send_email;
    $check_mail_status = $getrolesDetails->check_mail_status;
    $bulk_email_report = $getrolesDetails->bulk_email_report;
    $send_sms = $getrolesDetails->send_sms;
    $check_sms_status = $getrolesDetails->check_sms_status;
    $bulk_sms_report = $getrolesDetails->bulk_sms_report;
    $send_whatsapp_msg = $getrolesDetails->send_whatsapp_msg;
    $check_whatsapp_status = $getrolesDetails->check_whatsapp_status;
    $transport = $getrolesDetails->transport;
    $measure = $getrolesDetails->measure;
    $supplier = $getrolesDetails->supplier;
    $item = $getrolesDetails->item;
    $brand = $getrolesDetails->brand;
    $add_client_email = $getrolesDetails->add_client_email;
    $purchase = $getrolesDetails->purchase;
    $config = $getrolesDetails->config;
    $users = $getrolesDetails->users;
    $roles = $getrolesDetails->roles;
    $sms_template = $getrolesDetails->sms_template;
}
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
               
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        
                        <h5 class="card-title">Enquiry</h5>
                        <form method="post" action="<?php echo base_url() ?>Roles/edit_role_data" autocomplete="off">
                            <input class="form-control" type="hidden" name="role_id" id="role_id" value="<?php echo $roleid ?>" required>
                           <div class="row">
                              <div class="col-sm-12">
                                 <input class="form-control" name="role_name" id="role_name"  placeholder="Role Name" value="<?php echo $rolename ?>" required>
                              </div>
                              <div class="col-sm-12">
                                <p>&nbsp;</p>  
                              </div>
                              <div class="col-sm-6">
                                  <!--==========================Dashboard==============================-->
                                  <p><b>Dashboard</b></p>
                                  <input type="checkbox" id="dashboard" name="dashboard" value="1" <?php if($dashboard == 1){ ?> checked <?php } ?>>
                                  <label for="dashboard"> Dashboard</label><br>
                                  <hr>
                                  
                                  <!--==========================Enquiry================================-->
                                  <p><b>Enquiry</b></p>
                                  <input type="checkbox" id="add_enquiry" name="add_enquiry" value="1" <?php if($add_enquiry == 1){ ?> checked <?php } ?>>
                                  <label for="add_enquiry"> Add Enquiry</label><br>
                                  <input type="checkbox" id="enquiry_list" name="enquiry_list" value="1" <?php if($enquiry_list == 1){ ?> checked <?php } ?>>
                                  <label for="enquiry_list"> Enquiry List</label><br>
                                  <input type="checkbox" id="quotation" name="quotation" value="1" <?php if($quotation == 1){ ?> checked <?php } ?>>
                                  <label for="quotation"> Quotations</label><br>
                                  <input type="checkbox" id="appointment" name="appointment" value="1" <?php if($appointment == 1){ ?> checked <?php } ?>>
                                  <label for="appointment"> Appointments</label><br>
                                  <hr>
                                  
                                  <!--===============================Customers================================-->
                                  <p><b>Customers</b></p>
                                  <input type="checkbox" id="customers" name="customers" value="1" <?php if($customers == 1){ ?> checked <?php } ?>>
                                  <label for="customers"> Customers</label><br>
                                  <hr>
                                  
                                  <!--===============================Communication================================-->
                                  <p><b>Communication</b></p>
                                  <input type="checkbox" id="send_email" name="send_email" value="1" <?php if($send_email == 1){ ?> checked <?php } ?>>
                                  <label for="send_email"> Send Email</label><br>
                                  <input type="checkbox" id="check_mail_status" name="check_mail_status" value="1" <?php if($check_mail_status == 1){ ?> checked <?php } ?>>
                                  <label for="check_mail_status"> Check Mail Status</label><br>
                                  <input type="checkbox" id="bulk_email_report" name="bulk_email_report" value="1" <?php if($bulk_email_report == 1){ ?> checked <?php } ?>>
                                  <label for="bulk_email_report"> Bulk Email Report</label><br>
                                  <input type="checkbox" id="send_sms" name="send_sms" value="1" <?php if($send_sms == 1){ ?> checked <?php } ?>>
                                  <label for="send_sms"> Send SMS</label><br>
                                  <input type="checkbox" id="check_sms_status" name="check_sms_status" value="1" <?php if($check_sms_status == 1){ ?> checked <?php } ?>>
                                  <label for="check_sms_status"> Check SMS Status</label><br>
                                  <input type="checkbox" id="bulk_sms_report" name="bulk_sms_report" value="1" <?php if($bulk_sms_report == 1){ ?> checked <?php } ?>>
                                  <label for="bulk_sms_report"> Bulk SMS Report</label><br>
                                  <input type="checkbox" id="send_whatsapp_msg" name="send_whatsapp_msg" value="1" <?php if($send_whatsapp_msg == 1){ ?> checked <?php } ?>>
                                  <label for="send_whatsapp_msg"> Send WhatsApp Msg</label><br>
                                  <input type="checkbox" id="check_whatsapp_status" name="check_whatsapp_status" value="1" <?php if($check_whatsapp_status == 1){ ?> checked <?php } ?>>
                                  <label for="send_email"> Check WhatsApp Status</label><br>
                                  <hr>
                                   <!--===============================Master================================-->
                                   <p><b>Master</b></p>
                                  <input type="checkbox" id="transport" name="transport" value="1" value="1" <?php if($transport == 1){ ?> checked <?php } ?>>
                                  <label for="transport"> Transport</label><br>
                                  <input type="checkbox" id="measure" name="measure" value="1" value="1" <?php if($measure == 1){ ?> checked <?php } ?>>
                                  <label for="measure"> Measure</label><br>
                                  <input type="checkbox" id="supplier" name="supplier" value="1" value="1" <?php if($supplier == 1){ ?> checked <?php } ?>>
                                  <label for="supplier"> Supplier</label><br>
                                  <input type="checkbox" id="item" name="item" value="1" value="1" <?php if($item == 1){ ?> checked <?php } ?>>
                                  <label for="item"> Items</label><br>
                                  <input type="checkbox" id="brand" name="brand" value="1" value="1" <?php if($brand == 1){ ?> checked <?php } ?>>
                                  <label for="brand"> Brand</label><br>
                                   <input type="checkbox" id="add_client_email" name="add_client_email" value="1" value="1" <?php if($add_client_email == 1){ ?> checked <?php } ?>>
                                  <label for="add_client_email"> Add Client Email</label><br>
                                  <hr>
                                  
                                  <!--===============================Purchase================================-->
                                  <p><b>Purchase</b></p>
                                  <input type="checkbox" id="purchase" name="purchase" value="1" <?php if($purchase == 1){ ?> checked <?php } ?>>
                                  <label for="purchase"> Purchase</label><br>
                                  <hr>
                                                                    <!--===============================Setting================================-->
                                  <p><b>Setting</b></p>
                                  <input type="checkbox" id="config" name="config" value="1" <?php if($config == 1){ ?> checked <?php } ?>>
                                  <label for="customers"> Config</label><br>
                                  <input type="checkbox" id="users" name="users" value="1" <?php if($users == 1){ ?> checked <?php } ?>>
                                  <label for="customers"> Users</label><br>
                                  <input type="checkbox" id="roles" name="roles" value="1" <?php if($roles == 1){ ?> checked <?php } ?>>
                                  <label for="customers"> Roles</label><br>
                                   <input type="checkbox" id="sms_template" name="sms_template" value="1" <?php if($sms_template == 1){ ?> checked <?php } ?>>
                                  <label for="sms_template"> SMS Template</label><br>
                                  <hr>

                              </div>
                              <div class="col-sm-12">
                                 <br>
                                 <button type="submit" class="btn btn-primary  text-white" >Save</button>
                              </div>
                           </div>
                        </form>
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
       
 
   
</body>

</html>