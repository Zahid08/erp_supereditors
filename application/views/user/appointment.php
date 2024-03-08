<?php
error_reporting(0);
$createdby = $this->session->userdata['user_id'];
if($this->session->userdata['role'] == 2)
$appointmentDetails = $this->db->query("SELECT e.name,e.type,a.date,a.time,a.enquiry_id,a.isaccepted,a.name as appointment_name,a.remark,a.created_by FROM enquiry e 
                                        INNER JOIN appointment a ON a.enquiry_id = e.enquiry_id  
                                        INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
                                        WHERE a.isactive = 1 AND e.isactive = 1 AND e.created_by = $createdby AND a.created_by = $createdby AND  ae.end_date IS NULL AND ae.user_id = $createdby ORDER BY a.date DESC")->result();
else
$appointmentDetails = $this->db->query("SELECT e.name,e.type,a.date,a.time,a.enquiry_id,a.isaccepted,a.name as appointment_name,a.remark,a.created_by FROM enquiry e 
                                        INNER JOIN appointment a ON a.enquiry_id = e.enquiry_id  
                                        INNER JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
                                        WHERE a.isactive = 1 AND e.isactive = 1 AND  ae.end_date IS NULL  ORDER BY a.date DESC")->result();
$communication = $this->db->query("SELECT DISTINCT email,mobile_no FROM(SELECT email,mobile_no FROM owner_details WHERE isactive = 1 
                                   UNION ALL
                                   SELECT email,mobile_no FROM contact_person WHERE isactive = 1 ) T
                                   ")->result();
if($enquiry_id=='' || $enquiry_id== null)
    $enquiry_id = 0;

$enquiryDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1")->result();


?>
<style>
	.modal-backdrop {
		opacity: 0 !important; /* set opacity to 0 */
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/js/select2.min.js"></script>
    <!--============For Dropdown Search and Multi Select===========-->
    
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
                    <h3 class="text-primary">Appointments</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <!-- Start Page Content -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Appointmnets</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>

							<section id="appointment_section" name="appointment_section">
							   <!--  <br>
								<button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#appointment_details" >Appointment</button> -->
								<div id="appointment_details" class="collapse in">
									<div class="card">
										<div class="card-body">
											<center>
												<p style="color:green"><?php echo $this->session->flashdata('appointment_message') ?></p>
												<p style="color:red"><?php echo $this->session->flashdata('quotation_del_appointment_message') ?></p>
											</center>
											<h5 class="card-title">Appointment</h5>
											<form method="post" action="<?php echo base_url() ?>Enquiry/save_appointment_data_inlist" autocomplete="off">
												<div class="row">
													<div class="col-sm-12">
													</div>
													<div class="col-sm-12">
														<input class="form-control" type="hidden" required name="agent_name" id="agent_name" value="<?php echo $this->session->userdata['name'] ?>">
													</div>

													<div class="col-sm-4"><br>
														<h5 class="card-title">Select Enquiry</h5>
														<select class="form-control" name="enquiry_id" required  id="enquiry_id">
															<option value="">Select</option>
															<?php foreach($enquiryDetails as $value){ ?>
																<option value="<?php echo $value->enquiry_id ?>"  ><?php echo $value->name ?></option>
															<?php } ?>
														</select>
													</div>

													<div class="col-sm-4"><br>
														<h5 class="card-title">Select Name</h5>
														<select class="form-control" name="enquery_name" required  id="enquery_name">
															<option value="">Select Name</option>
														</select>
													</div>

													<div class="col-sm-4"><br>
														<h5 class="card-title">Select Email</h5>
														<select class="form-control" name="mail_to" required  id="mail_to">
															<option value="">Select</option>

														</select>
													</div>

													<div class="col-sm-4"><br>
														<h5 class="card-title">Select Number</h5>
														<select class="form-control" name="sms_to" required  id="sms_to" placeholder="Select Mobile" >
															<option value="">Select</option>
														</select>
													</div>

													<div class="col-sm-4"><br>
														<h5 class="card-title">Appointment Date</h5>
														<input type="text" class="form-control" required name="date" id="date" onfocus="this.type='date'" placeholder="Appointment Date" min="<?php echo date('Y-m-d') ?>">
													</div>

													<div class="col-sm-4"><br>
														<h5 class="card-title">Appointment Time</h5>
														<input type="text" class="form-control" required name="time" id="time" onfocus="this.type='time'" placeholder="Appointment Time">
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
                                    <table id="example2333" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Party Name</th>
                                                <th>Party Type</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Created By</th>
                                                <th>Remark</th>
                                                <th>Is Accepted</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($appointmentDetails as $key=>$getappointmentDetails){
												$created_by=$getappointmentDetails->created_by;
												$createdByName 				= $this->db->query("SELECT name FROM user u where isactive = 1 and name IS NOT NULL and user_id=$created_by")->row();
												$nameCreatedBy='';
												if ($createdByName){
													$nameCreatedBy			=$createdByName->name;
												}
                                            	?>
                                                <tr>
                                                    <td><?php echo $getappointmentDetails->name ?></td>
                                                    <td><?php echo $getappointmentDetails->type ?></td>
                                                    <td><?php echo $getappointmentDetails->date; ?></td>
                                                    <td><?php echo date_format(date_create($getappointmentDetails->time),"h:i a"); ?></td>
                                                    <td><?php echo $nameCreatedBy; ?></td>
                                                    <td><?php echo $getappointmentDetails->remark; ?></td>
                                                    <td><?php if($getappointmentDetails->isaccepted == 2){ echo 'No'; }else{ echo 'Yes'; }  ?></td>
                                                    <td>
														<button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editContact<?php echo $key?>"><i class="fa fa-edit"></i> Edit</button>
														<!--Contact Modal-->

														<!-- Modal -->

														<div class="modal" id="editContact<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
															<div class="modal-dialog modal-dialog-centered" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Contact</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<form method="post" action="http://localhost/supereditor/Enquiry/edit_appointment_data_index" autocomplete="off">
																			<div class="row">
																				<div class="col-sm-12">
																					<input class="form-control" type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $appointmentDetails->appointment_id ?>">
																				</div>
																				<div class="col-sm-12">
																					<input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
																				</div>
																				<div class="col-sm-6">
																					<input type="text" class="form-control" name="date" id="date" onfocus="this.type='date'" placeholder="Appointment Date" value="<?php echo date_format(date_create($getappointmentDetails->date),"d-m-Y") ?>" min="<?php echo date('Y-m-d') ?>">
																				</div>
																				<div class="col-sm-6">
																					<input type="text" class="form-control" name="time" id="time" onfocus="this.type='time'" value="<?php echo date_format(date_create($getappointmentDetails->time),"h:i a") ?>" placeholder="Appointment Time">
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
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


                    }
                });
            });

     $(document).on('change', 'select#mail_to', function() {
                var mailto=$(this).val();

                var post_data = {
                    'mailto': mailto,
                    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                var url = "<?php echo base_url();?>Enquiry/getEnquiryWisePhone";

                $.ajax({
                    url : url,
                    type : 'POST',
                    data: post_data,
                    success : function(result)
                    {
                        var obj = JSON.parse(result);
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
                });
            });
            
            
            $(document).ready(function() {
    $('table#example2333').DataTable({
        order: [[2, 'desc']]
    });
});
    $(document).ready(function() {
        $('#enquiry_id').select2({
            placeholder: 'Select Enquiry',
            allowClear: true,
        });
        $('#enquery_name').select2({
            placeholder: 'Select Name',
            allowClear: true,
        });
        $('#mail_to').select2({
            placeholder: 'Select Email',
            allowClear: true,
        });
        $('#sms_to').select2({
            placeholder: 'Select Number',
            allowClear: true,
        });
    });
 </script>
   
</body>

</html>
