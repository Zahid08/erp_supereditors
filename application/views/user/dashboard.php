<?php
error_reporting(0);
$createdby = $this->session->userdata['user_id'];

if($this->session->userdata['role'] == 2)
$enquiryCount = $this->db->query("SELECT 1 FROM enquiry e INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id WHERE e.isactive = 1 AND  ae.user_id = $createdby AND ae.end_date IS NULL ORDER BY e.enquiry_id ASC")->result();
else
$enquiryCount = $this->db->query("SELECT 1 FROM enquiry e INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id WHERE e.isactive = 1 AND ae.end_date IS NULL  ORDER BY e.enquiry_id ASC")->result();

if($this->session->userdata['role'] == 2)
$enquiryDetails = $this->db->query("SELECT * FROM enquiry e INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id  WHERE e.isactive = 1 AND  ae.user_id = $createdby AND ae.end_date IS NULL ORDER BY e.enquiry_id DESC LIMIT 5")->result();
else
$enquiryDetails = $this->db->query("SELECT * FROM enquiry e INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id  WHERE e.isactive = 1 AND ae.end_date IS NULL ORDER BY e.enquiry_id DESC LIMIT 5")->result();



$appointmentCount = $this->db->query("SELECT 1 FROM appointment a INNER JOIN agent_enquiry ae ON ae.enquiry_id = a.enquiry_id WHERE a.isactive = 1 AND date = CURRENT_DATE() AND ae.end_date IS NULL")->result();

$createdby = $this->session->userdata['user_id'];
if($this->session->userdata['role'] == 2)
$appointmentDetails = $this->db->query("SELECT e.name,e.type,a.date,a.time,a.enquiry_id,a.isaccepted FROM enquiry e 
                                        INNER JOIN appointment a ON a.enquiry_id = e.enquiry_id
                                        INNER JOIN agent_enquiry ae ON ae.enquiry_id = a.enquiry_id
                                        WHERE a.isactive = 1 AND e.isactive = 1 AND e.created_by = $createdby AND a.created_by = $createdby AND ae.user_id = $createdby  AND a.date = CURRENT_DATE()  
                                        AND ae.end_date IS NULL
                                        ")->result();
                                            

else
$appointmentDetails = $this->db->query("SELECT e.name,e.type,a.date,a.time,a.enquiry_id,a.isaccepted FROM enquiry e 
                                        INNER JOIN appointment a ON a.enquiry_id = e.enquiry_id  
                                        INNER JOIN agent_enquiry ae ON ae.enquiry_id = a.enquiry_id
                                        WHERE a.isactive = 1 AND e.isactive = 1 AND a.date = CURRENT_DATE() 
                                        AND ae.end_date IS NULL
                                        ")->result();


if($this->session->userdata['role'] == 2)
$remarkDetails = $this->db->query("SELECT e.name,e.type,a.call_back_date as date,a.call_back_time as time ,a.enquiry_id,'Yes' as isaccepted,a.remark FROM enquiry e 
                                        INNER JOIN remarks a ON a.enquiry_id = e.enquiry_id
                                        INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
                                        WHERE a.isactive = 1 AND e.isactive = 1 AND e.created_by = $createdby AND a.created_by = $createdby AND ae.user_id = $createdby  AND a.call_back_date = CURRENT_DATE()  
                                       AND ae.end_date IS NULL
                                        ")->result();
                                            

else
$remarkDetails = $this->db->query("SELECT  e.name,e.type,a.call_back_date as date,a.call_back_time as time,a.enquiry_id,'Yes' as isaccepted,a.remark FROM enquiry e 
                                        INNER JOIN remarks a ON a.enquiry_id = e.enquiry_id
                                        INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
                                        WHERE a.isactive = 1 AND e.isactive = 1 AND a.call_back_date = CURRENT_DATE() 
                                        AND ae.end_date IS NULL
                                        ")->result();



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
    <title>SuperEditors || Home Page</title>
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
                    <h3 class="text-primary">Dashboard</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="stat-widget-five">
                                <div class="stat-icon">
                                    <i class="ti-home bg-primary"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-heading color-primary">Enquiries</div>
                                    <div class="stat-text"><?php echo count($enquiryCount); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="stat-widget-five">
                                <div class="stat-icon">
                                    <i class="ti-file bg-success"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-heading color-success">Appointments</div>
                                    <div class="stat-text"><?php echo count($appointmentCount); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="stat-widget-five">
                                <div class="stat-icon">
                                    <i class="ti-info bg-danger"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-heading color-danger">Sales</div>
                                    <div class="stat-text">20098080</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title">
                                <h4>Summary</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Party Name</th>
                                                <th>Party Type</th>
                                                <th>Quotation</th>
                                                <th>PO</th>
                                                <th>Order Process</th>
                                                <th>Billing</th>
                                                <th>Payment Received</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($enquiryDetails as $getenquiryDetails){ 
                                                
                                            $enqid = $getenquiryDetails->enquiry_id;    
                                            $remarkCount = $this->db->query("SELECT count(1) as remarkcount FROM remarks WHERE isactive = 1 and enquiry_id = $enqid")->result();
                                            foreach($remarkCount as $remarkCnt){
                                                 $rmcnt = $remarkCnt->remarkcount;
                                            }
                                            
                                            ?>
                                                <tr>
                                                    <td><a href="<?php echo base_url() ?>Enquiry?enquiry_id=<?php echo $getenquiryDetails->enquiry_id ?>"><?php echo $getenquiryDetails->name ?></a></td>
                                                    <td><?php echo $getenquiryDetails->type ?></td>
                                                    <td>Test
                                                    
                                                         <?php
                                                         $enquiry_id = $getenquiryDetails->enquiry_id;
                                                         $quotationDetails = $this->db->query("SELECT * FROM quotation WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY quotation_id DESC LIMIT 1")->result();
                                                          foreach($quotationDetails as $getquotationDetails){ ?>
                                                       <a href="<?php echo base_url() ?>assets/client_asstes/quotations/<?php echo $getquotationDetails->attachment ?>" target="_blank"><i class="fa fa-eye"> </i></a>
                                                       <?php
                                                          }
                                                          ?>
                                                   
                                                    </td>
                                                    <td>PO</td>
                                                    <td>Order Process</td>
                                                    <td>Billing</td>
                                                    <td>Payment Received</td>
                                                    <td><a href="<?php echo base_url() ?>Enquiry?enquiry_id=<?php echo $getenquiryDetails->enquiry_id ?>&#remarks_section"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">View Details</button></a>
                                                    <span class="badge badge-secondary"><?php echo $rmcnt ?></span></h3>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right"><a href="<?php echo base_url() ?>Enquiry/enquirylist">View All</a></td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h4>Todays Remarks - call backs</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Party Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Remark</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($remarkDetails as $getremarkDetails){ ?>
                                                <tr>
                                                    <td><?php echo $getremarkDetails->name ?></td>
                                                    <td><?php echo date_format(date_create($getremarkDetails->date),"d-m-Y"); ?></td>
                                                    <td><?php
                                                            if($getremarkDetails->time == NULL){
                                                            echo 'N/A';
                                                            }else{
                                                            echo date_format(date_create($getremarkDetails->time),"h:i a");
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $getremarkDetails->remark ?></td>
                                                    <td><a href="<?php echo base_url() ?>Enquiry/ramarklist"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">View Details</button></a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right"><a href="<?php echo base_url() ?>Enquiry/ramarklist">View All</a></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h4>Todays Appointments</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Party Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($appointmentDetails as $getappointmentDetails){ ?>
                                                <tr>
                                                    <td><?php echo $getappointmentDetails->name ?></td>
                                                    <td><?php echo date_format(date_create($getappointmentDetails->date),"d-m-Y"); ?></td>
                                                    <td><?php
                                                            if($getappointmentDetails->time == NULL){
                                                            echo 'N/A';
                                                            }else{
                                                            echo date_format(date_create($getappointmentDetails->time),"h:i a");
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><a href="<?php echo base_url() ?>Enquiry/appointmentlist"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">View Details</button></a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right"><a href="<?php echo base_url() ?>Enquiry/appointmentlist">View All</a></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h4>Latest 5 Enquiries</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Party Name</th>
                                                <th>Party Type</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($enquiryDetails as $getenquiryDetails){ ?>
                                                <tr>
                                                    <td><?php echo $getenquiryDetails->name ?></td>
                                                    <td><?php echo $getenquiryDetails->type ?></td>
                                                    <td><a href="<?php echo base_url() ?>Enquiry?enquiry_id=<?php echo $getenquiryDetails->enquiry_id ?>"><button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">View Details</button></a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right"><a href="<?php echo base_url() ?>Enquiry/enquirylist">View All</a></td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
        <!-- End Page wrapper  -->
         <!-- footer -->
        <?php include("includes/footer.php") ?>
        <!-- End footer -->
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
        
        
        <!--text editor kit -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/wysihtml5-0.3.0.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/bootstrap-wysihtml5.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/wysihtml5-init.js"></script>
       
 
   
</body>

</html>