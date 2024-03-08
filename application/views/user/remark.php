<?php
error_reporting(0);
$createdby = $this->session->userdata['user_id'];
$enquiryDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1")->result();

$previousDay = date('Y-m-d', strtotime('-1 day')); // Get the previous day
$futureDate = date('Y-m-d', strtotime('+1 day')); // Get the future date

$remarkDetails = $this->db->query("
    SELECT *
    FROM remarks
    LEFT JOIN enquiry ON enquiry.enquiry_id = remarks.enquiry_id
    WHERE remarks.isactive = 1
    AND remarks.call_back_date >= '$previousDay'
    ORDER BY remarks.call_back_date ASC
")->result();

if(isset($_POST['search'])) {
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$remarkDetails = $this->db->query("SELECT * FROM remarks left join enquiry on enquiry.enquiry_id=remarks.enquiry_id WHERE remarks.isactive = 1 AND (remarks.call_back_date BETWEEN '$from_date' AND '$to_date')  AND remarks.call_back_date >= '$previousDay'
     order by remarks.call_back_date ASC")->result();

}
?>
<style>
	.modal-backdrop {
		opacity: 0 !important; /* set opacity to 0 */
	}
	.select2-container .select2-selection--single {
        height: 35px!important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 34px!important;
    height: 34px!important;
}
</style>
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
	<!--============For Editor===========-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/client_asstes/css/lib/html5-editor/bootstrap-wysihtml5.css" />
	<!--============For Editor===========-->
	<!--============For Accordian===========-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<!--============For Accordian===========-->
	<!--============For Dropdown Search and Multi Select===========-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
	<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
	<script>
		$(document).ready(function(){
			var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
				removeItemButton: true,
				maxItemCount:10,
				searchResultLimit:10,
				renderChoiceLimit:10
			});
		});
	</script>
	<!--============For Dropdown Search and Multi Select===========-->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
				<h3 class="text-primary">Opening Month/Call Back</h3> </div>
			<div class="col-md-7 align-self-center">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Opening Month/Call Back</li>
				</ol>
			</div>
		</div>
		<!-- End Bread crumb -->
		<!-- Container fluid  -->
		<div class="container-fluid">
			<!-- Start Page Content -->
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Opening Month/Call Back</h4>
					<h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>

					<section id="appointment_section" name="appointment_section">
						<!--  <br>
						 <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#appointment_details" >Appointment</button> -->
						<div id="appointment_details" class="collapse in">
							<div class="card">
								<div class="card-body">
									<center>
										<p style="color:green"><?php echo $this->session->flashdata('remark_message') ?></p>
										<p style="color:red"><?php echo $this->session->flashdata('remark_delete_message') ?></p>
									</center>
									<h5 class="card-title" style="padding-bottom: 30px;">Remarks</h5>
									<form method="post" action="<?php echo base_url() ?>Enquiry/save_remark_list_data" autocomplete="off">
										<div class="row">
										    
											<div class="col-sm-4">
												<h5 class="card-title">Select Enquiry</h5>
												<select class="form-control" name="enquiry_id" required  id="enquiry_id">
													<option value="">Select</option>
													<?php foreach($enquiryDetails as $value){ ?>
														<option value="<?php echo $value->enquiry_id ?>"  ><?php echo $value->name ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-4">
												<h5 class="card-title">Select Name</h5>
												<select class="form-control" name="contact_name" required  id="enquery_name">
													<option value="">Select Name</option>
												</select>
											</div>

											<div class="col-sm-4">
												<h5 class="card-title">Select Email</h5>
												<select class="form-control" name="contact_email" required  id="mail_to">
													<option value="">Select Name</option>
												</select>
											</div>

										</div>
										<div class="row" style="margin-top: 30px;">
											<div class="col-sm-4">
												<h5 class="card-title">Select Number</h5>
												<select class="form-control" name="contact_phone" required  id="sms_to">
													<option value="">Select Name</option>
												</select>
											</div>
											<div class="col-sm-4">
												<h5 class="card-title">Callback Date</h5>
												<input type="text" onfocus="this.type='date'" class="form-control" name="call_back_date" id="call_back_date" placeholder="Call Back Date">
											</div>
											<div class="col-sm-4">
												<h5 class="card-title">Callback Time</h5>
												<input type="text" onfocus="this.type='time'" class="form-control" name="call_back_time" id="call_back_time" placeholder="Call Back Time">
											</div>
											<div class="col-sm-12"><br>
												<h5 class="card-title">Remark</h5>
												<textarea class="textarea_editor form-control" rows="10" placeholder="Enter Remark ..." name="remark" id="remark" style="height:100px"></textarea>
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

					<div class="table-responsive m-t-40">
						<form method="post" action="<?php echo base_url()."Enquiry/ramarklist" ?>" autocomplete="off">
							<div class="row">
								<div class="col-sm-3">
									<input class="form-control" type="date" name="from_date" id="from_date" required value="<?php echo $from_date ?>" placeholder="From Date" required>
								</div>
								<div class="col-sm-3">
									<input class="form-control" type="date" name="to_date" id="to_date" required value="<?php echo $to_date ?>" placeholder="To Date" required>
								</div>
								<div class="col-sm-2">
									<button type="submit" name="search" id="search" class="btn btn-primary btn-rounded m-b-10 m-l-5">Search</button>
								</div>
							</div>
						</form>

						<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th class="text-center">SL</th>
								<th class="text-center">Party Name</th>
								<th class="text-center">OD/Call Back Date</th>
								<th class="text-center">Remark</th>
								<th class="text-center">Contact Person</th>
								<th class="text-center">Contact No</th>
								<th class="text-center">Email</th>
								<th class="text-center">Created By</th>
								<th >Action</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($remarkDetails as $key=>$getremarkDetails){
								$created_by=$getremarkDetails->created_by;
								$createdByName 				= $this->db->query("SELECT name FROM user u where isactive = 1 and name IS NOT NULL and user_id=$created_by")->row();
								$nameCreatedBy='';
								if ($createdByName){
									$nameCreatedBy			=$createdByName->name;
								}
								?>
								<tr class="text-center">
									<td><?php echo ++$key; ?></td>
									<td><?php echo $getremarkDetails->name ?></td>
									<td>
										<a href="javascript:void(0)" class="" data-toggle="modal" data-target="#editRemarkItem<?php echo $getremarkDetails->remark_id ?>">
										<?php if($getremarkDetails->call_back_date == NULL){ echo 'N/A'; }else{ echo date("d-m-Y", strtotime($getremarkDetails->call_back_date)); } ?></td>
									</button>
									<td><?php echo $getremarkDetails->remark ?></td>
									<td><?php echo $getremarkDetails->contact_name ?></td>
									<td><?php echo $getremarkDetails->contact_phone ?></td>
									<td><?php echo $getremarkDetails->contact_email ?></td>
									<td><?php echo $nameCreatedBy ?></td>
									<td>
										<button type="button" class="btn btn-primary text-white" onclick="myDeletePromptRemarkdetails('<?php echo $enquiry_id ?>','<?php echo $getremarkDetails->remark_id ?>')"><i class="fa fa-trash"></i> Delete</button>
										<button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editRemarkItem<?php echo $getremarkDetails->remark_id ?>"><i class="fa fa-edit"></i> Edit</button>
										<!--Contact Modal-->

										<div class="modal fade" id="editRemarkItem<?php echo $getremarkDetails->remark_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Item</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<form method="post" action="<?php echo base_url(); ?>Enquiry/edit_remark_data?type=list" autocomplete="off">
															<div class="row">
																<div class="col-sm-12">
																	<input class="form-control" type="hidden" name="remark_id" id="remark_id" value="<?php echo $getremarkDetails->remark_id ?>">
																</div>
																<div class="col-sm-12">
																	<input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $getremarkDetails->enquiry_id ?>">
																</div>
																<div class="col-sm-12">
																	<label>Remark</label>
																	<input class="form-control" name="remark" id="remark" placeholder="Remark" value="<?php echo $getremarkDetails->remark ?>">
																</div>
																<div class="col-sm-12">
																	<label>Call Back Time</label>
																	<input class="form-control" onfocus="this.type='date'" max="<?php echo date("d-m-y") ?>" name="call_back_date" id="call_back_date" placeholder="Call Back Date" value="<?php echo $getremarkDetails->call_back_date ?>">
																</div>
																<div class="col-sm-12">
																	<label>Call Back Time</label>
																	<input class="form-control" onfocus="this.type='time'" name="call_back_time" id="call_back_time" placeholder="Call Back Time" value="<?php echo $getremarkDetails->call_back_time ?>">
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
										</div>
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

	<!-- Bootstrap Modal -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
	
	    $('select#enquiry_id').select2();
	    
		function myDeletePromptRemarkdetails(enquiry_id,remark_itemdetails_id) {
			var output = confirm('Are you sure you want to Delete?');
			if (output == true) {
				window.location.href = "<?php echo base_url() ?>Enquiry/delete_remark_itemdetails_data?type=List&enquiry_id=" + enquiry_id + "&remark_itemdetails_id=" + remark_itemdetails_id;
			} else {
				window.location.href = "<?php echo base_url() ?>Enquiry?enquiry_id="+enquiry_id;
			}
		}
	</script>

	<script>
		$(document).on('change', 'select#enquiry_id', function() {
			var enquiryid=$(this).val();

			var post_data = {
				'enquiryid': enquiryid,
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
			};

			var url = "<?php echo base_url();?>Enquiry/getEnquiryWiseEmail";

			$.ajax({
				url : url,
				type : 'POST',
				data: post_data,
				success : function(result)
				{
					var obj = JSON.parse(result);
					$('select#mail_to').find('option').remove();
					$('select#mail_to').append($('<option/>', {
						value: '',
						text : 'Select Email'
					}));

					if(obj.length>0){
    					for(var i=0;i<obj.length;i++)
    					{
    						$('select#mail_to').append($('<option/>', {
    							value: obj[i]['email'],
    							text : obj[i]['email'],
    						}));
    					}
    					
    						$('select#enquery_name').find('option').remove();
					$('select#enquery_name').append($('<option/>', {
						value: '',
						text : 'Select Name'
					}));

					for(var i=0;i<obj.length;i++)
					{
						$('select#enquery_name').append($('<option/>', {
							value : obj[i]['name'],
							text : obj[i]['name']+' ('+obj[i]['designation']+')',
						}));
					}
					
						$('select#sms_to').find('option').remove();
    					$('select#sms_to').append($('<option/>', {
    						value: '',
    						text : 'Select Phone'
    					}));
    
    					for(var i=0;i<obj.length;i++)
    					{
    						$('select#sms_to').append($('<option/>', {
    							value: obj[i]['mobile_no'],
    							text : obj[i]['mobile_no'],
    						}));
    					}
    					

					}

				}
			});
		});

// 		$(document).on('change', 'select#mail_to', function() {
// 			var mailto=$(this).val();

// 			var post_data = {
// 				'mailto': mailto,
// 				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
// 			};

// 			var url = "<?php echo base_url();?>Enquiry/getEnquiryWisePhone";

// 			$.ajax({
// 				url : url,
// 				type : 'POST',
// 				data: post_data,
// 				success : function(result)
// 				{
// 					var obj = JSON.parse(result);
					
// 						if(obj.length>0){
//     					$('select#sms_to').find('option').remove();
//     					$('select#sms_to').append($('<option/>', {
//     						value: '',
//     						text : 'Select Phone'
//     					}));
    
//     					for(var i=0;i<obj.length;i++)
//     					{
//     						$('select#sms_to').append($('<option/>', {
//     							value: obj[i]['mobile_no'],
//     							text : obj[i]['mobile_no'],
//     						}));
//     					}
// 						}
// 				}
// 			});
// 		});
	</script>

</body>

</html>
