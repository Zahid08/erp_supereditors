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
    <title>SuperEditors || Sms Template Page</title>
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
                    <h3 class="text-primary">Sms Template</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Sms Template</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!---->

            <!-- Start Page Content -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Sms Template</h4>
                                <form method="post" action="<?php echo base_url()."Setting/add_sms_templates" ?>">
                                    
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Template Message</label>
                                        <textarea name="template_string" id="template_string" placeholder="Template String" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Template Name</label>
                                        <input type="text" class="form-control" name="template_name" id="template_name" placeholder="Template Name" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Parameter Count</label>
                                        <input type="number" class="form-control" name="parameter_count" id="parameter_count" placeholder="Parameter Count">
                                    </div>
                                    <div class="col-sm-4">
                                        <br>
                                        <button type="submit" class="btn btn-primary   text-white" >Add</button>
                                    </div>
                                </div>
                                </form>
                                <center>
                                    <br>
                           <p style="color:green"><?php echo $this->session->flashdata('sms_message') ?></p>
                        </center>
                                
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr.No.</th>
                                                <th>Template Code</th>
                                                <th>Template String</th>
                                                <th>Parameters Count</th>
                                                <th>Status</th>
                                                <th>Actionn</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach($data as $key => $value){ ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $value['template_code']; ?></td>
                                                    <td><?php echo substr( $value['template_string'], 0, 50) ;?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#templatestring<?php echo  $value['template_id'];  ?>">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                    </td>
                                                    <td><?php echo $value['parameter_count']; ?></td>
                                                    <td><?php  if($value['is_active'] == 0){ echo 'Inactive'; }elseif($value['is_active'] == 1){ echo 'Active'; }?></td>
                                                    <td><a href="<?php echo base_url() ?>Setting/sms_status_change?template_id=<?php echo $value['template_id'] ?>&is_active=<?php echo $value['is_active'] ?>"><button type="button" onclick="return confirm('Are you sure you want to change the Status?');"  class="btn btn-primary btn-rounded m-b-10 m-l-5" onsubmit="return confirm('your Status is updated sucessfully?');">Change Status</button></a></td>
                                                </tr>
                                                   <!-- Modal for getting template string-->
                                                <div class="modal fade" id="templatestring<?php echo  $value['template_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Template String</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <p><?php echo  $value['template_string']; ?></p>
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
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
        
       <!--for bootstrap model-->
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 
   
</body>

</html>