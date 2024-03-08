<?php
error_reporting(0);
$createdby = $this->session->userdata['user_id'];
if($this->session->userdata['role'] == 2)

$quotationDetails = $this->db->query("SELECT qh.heading_id
	,qh.enquiry_id
	,e.name AS company_name
	,e.type AS company_type
	,qh.to_email AS contact_person_name
	,CONCAT (
		a.address_type
		,','
		,a.address_line_1
		,','
		,a.address_line_2
		,','
		,a.country
		,','
		,a.STATE
		,','
		,a.city
		,','
		,a.street
		,','
		,a.pincode
		) AS address
	,qh.created_datetime AS quotation_sent_date
	,(
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) AS AgentName
FROM `quotation_heading` qh
INNER JOIN enquiry e ON e.enquiry_id = qh.enquiry_id
INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
INNER JOIN address a ON a.enquiry_id = e.enquiry_id AND  qh.created_by = $createdby 
WHERE ae.end_date IS NULL AND ae.user_id = $createdby  ORDER BY qh.created_datetime DESC")->result();
else
$quotationDetails = $this->db->query("SELECT qh.heading_id
	,qh.enquiry_id
	,e.name AS company_name
	,e.type AS company_type
	,qh.to_email AS contact_person_name
	,CONCAT (
		a.address_type
		,','
		,a.address_line_1
		,','
		,a.address_line_2
		,','
		,a.country
		,','
		,a.STATE
		,','
		,a.city
		,','
		,a.street
		,','
		,a.pincode
		) AS address
	,qh.created_datetime AS quotation_sent_date
	,(
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) AS AgentName
FROM `quotation_heading` qh
INNER JOIN enquiry e ON e.enquiry_id = qh.enquiry_id
INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
LEFT JOIN address a ON a.enquiry_id = e.enquiry_id
WHERE ae.end_date IS NULL 
ORDER BY qh.created_datetime DESC")->result();



if(isset($_POST['search'])){
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $agent_name = $_POST['agent_name'];
    
    if($this->session->userdata['role'] == 2){
        
    $quotationDetails = $this->db->query("SELECT qh.heading_id
	,qh.enquiry_id
	,e.name AS company_name
	,e.type AS company_type
	,qh.to_email AS contact_person_name
	,CONCAT (
		a.address_type
		,','
		,a.address_line_1
		,','
		,a.address_line_2
		,','
		,a.country
		,','
		,a.STATE
		,','
		,a.city
		,','
		,a.street
		,','
		,a.pincode
		) AS address
	,qh.created_datetime AS quotation_sent_date
	,(
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) AS AgentName
FROM `quotation_heading` qh
INNER JOIN enquiry e ON e.enquiry_id = qh.enquiry_id
INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
LEFT JOIN address a ON a.enquiry_id = e.enquiry_id WHERE qh.created_by = $createdby AND  (qh.created_datetime BETWEEN '$from_date' AND '$to_date') 
WHERE ae.end_date IS NULL AND ae.user_id = $createdby
ORDER BY qh.created_datetime DESC")->result();
   
   
   
    }
    else{
    $quotationDetails = $this->db->query("SELECT qh.heading_id
	,qh.enquiry_id
	,e.name AS company_name
	,e.type AS company_type
	,qh.to_email AS contact_person_name
	,CONCAT (
		a.address_type
		,','
		,a.address_line_1
		,','
		,a.address_line_2
		,','
		,a.country
		,','
		,a.STATE
		,','
		,a.city
		,','
		,a.street
		,','
		,a.pincode
		) AS address
	,qh.created_datetime AS quotation_sent_date
	,(
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) AS AgentName
FROM `quotation_heading` qh
INNER JOIN enquiry e ON e.enquiry_id = qh.enquiry_id
INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
LEFT JOIN address a ON a.enquiry_id = e.enquiry_id WHERE   (qh.created_datetime BETWEEN '$from_date' AND '$to_date') 
WHERE ae.end_date IS NULL 
ORDER BY qh.created_datetime DESC")->result();
    }
    
    
     
    
    
    
    if(!empty($agent_name)){
        if($this->session->userdata['role'] == 2){
        $quotationDetails = $this->db->query("SELECT qh.heading_id
	,qh.enquiry_id
	,e.name AS company_name
	,e.type AS company_type
	,qh.to_email AS contact_person_name
	,CONCAT (
		a.address_type
		,','
		,a.address_line_1
		,','
		,a.address_line_2
		,','
		,a.country
		,','
		,a.STATE
		,','
		,a.city
		,','
		,a.street
		,','
		,a.pincode
		) AS address
	,qh.created_datetime AS quotation_sent_date
	,(
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) AS AgentName
FROM `quotation_heading` qh
INNER JOIN enquiry e ON e.enquiry_id = qh.enquiry_id
INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
LEFT JOIN address a ON a.enquiry_id = e.enquiry_id WHERE qh.created_by = $createdby AND (
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) LIKE '%$agent_name%' AND  (qh.created_datetime BETWEEN '$from_date' AND '$to_date') 
		WHERE ae.end_date IS NULL AND ae.user_id = $createdby
		ORDER BY qh.created_datetime DESC
   ")->result();
        }
        else{
        $quotationDetails = $this->db->query("SELECT qh.heading_id
	,qh.enquiry_id
	,e.name AS company_name
	,e.type AS company_type
	,qh.to_email AS contact_person_name
	,CONCAT (
		a.address_type
		,','
		,a.address_line_1
		,','
		,a.address_line_2
		,','
		,a.country
		,','
		,a.STATE
		,','
		,a.city
		,','
		,a.street
		,','
		,a.pincode
		) AS address
	,qh.created_datetime AS quotation_sent_date
	,(
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) AS AgentName
FROM `quotation_heading` qh
INNER JOIN enquiry e ON e.enquiry_id = qh.enquiry_id
INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
LEFT JOIN address a ON a.enquiry_id = e.enquiry_id WHERE  (
		SELECT name
		FROM user u
		WHERE u.user_id = qh.created_by
		) LIKE '%$agent_name%' AND  (qh.created_datetime BETWEEN '$from_date' AND '$to_date') 
		WHERE ae.end_date IS NULL AND ae.user_id = $createdby
		ORDER BY qh.created_datetime DESC
  ")->result();
        }
    }
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
    <title>SuperEditors || Home Page</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
    
    <!--For JQuery Date Function-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
      $( function() {
        $( "#from_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#to_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
         
      } );
      </script>
    <!--For JQuery Date Function-->  
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
                    <h3 class="text-primary">Quotation List</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Quotation List</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <!-- Start Page Content -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Quotation List</h4>
                                <form method="post" action="<?php echo base_url()."Enquiry/quotationlist" ?>" autocomplete="off">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <input class="form-control" type="text" name="from_date" id="from_date" required value="<?php echo $from_date ?>" placeholder="From Date" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input class="form-control" type="text" name="to_date" id="to_date" required value="<?php echo $to_date ?>" placeholder="To Date" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" name="agent_name" id="agent_name" list="agent_names" value="<?php echo $agent_name ?>" placeholder="Agent Name" >
                                            <datalist id="agent_names">
                                            <?php
                                            $AgentNameSearch = $this->db->query("SELECT name FROM user WHERE isactive = 1")->result();
                                            foreach($AgentNameSearch as $getAgentNameSearch){ ?>
                                             <option value="<?php echo $getAgentNameSearch->name ?>">
                                            <?php  } ?> 
                                            </datalist>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" name="search" id="search" class="btn btn-primary btn-rounded m-b-10 m-l-5">Search</button>
                                        </div>         
                                    </div>
                                </form>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
												<th>Quotation Ref No.</th>
                                                <th>Company Name</th>
                                                <th>Company Type</th>
                                                <th>Latest Quotaion</th>
                                                
                                                
                                                <th>Contact Person Name</th>
                                                <?php if($_SESSION['role'] == 1){ ?>
                                                <th>Agent Name</th>
                                                <?php } ?>
                                                <th>Quotation Sent Date</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $c = 0;
                                            foreach($quotationDetails as $getquotationDetails){ 
                                            $c++;

												$nextyear = date("y",strtotime($getquotationDetails->created_datetime)) + 1;
												$integer =  str_pad($getquotationDetails->heading_id, 4, '0', STR_PAD_LEFT);
												if($getquotationDetails->company == 'SuperEditors' || $getquotationDetails->company == 'Coose Company')
													$reference_no = 'SE'.date("Y",strtotime($getquotationDetails->created_datetime)).'-'.$nextyear .'/'.$integer;
												else
													$reference_no = 'MW'.date("Y",strtotime($getquotationDetails->created_datetime)).'-'.$nextyear .'/'.$integer;

                                            ?>
                                                <tr>
                                                    <td><?php echo $c ?></td>
                                                    <td><?php echo $reference_no ?></td>
                                                    <td>
														<a href="<?php echo base_url() ?>Enquiry?enquiry_id=<?php echo $getquotationDetails->enquiry_id ?>" target="_blank">
                                                       		 <?php echo $getquotationDetails->company_name ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $getquotationDetails->company_type ?></td>
                                                    <td><a target="_blank" href="<?php echo base_url().'GeneratePdfController?enquiry_id='.$getquotationDetails->enquiry_id.'&heading_id='.$getquotationDetails->heading_id ?>">View Quotaion</a></td>
                                                    
                                                    <td><?php echo $getquotationDetails->contact_person_name ?></td>
                                                    <?php if($_SESSION['role'] == 1){ ?>
                                                    <td><?php echo $getquotationDetails->AgentName ?></td>
                                                    <?php } ?>
                                                     <td><?php echo date("d-m-Y H:i",strtotime($getquotationDetails->quotation_sent_date)) ?></td>
                                                     <td><?php echo $getquotationDetails->address ?></td>
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
<!--        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/jquery/jquery.min.js"></script>
-->        <!-- Bootstrap tether Core JavaScript -->
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
