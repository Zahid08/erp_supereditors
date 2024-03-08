<?php
$customerDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1")->result();
$itemDetails = $this->db->query("SELECT * FROM items WHERE item_type_id = 2 and is_active = 1")->result();
$itemDetailsFebrics = $this->db->query("SELECT * FROM items WHERE item_type_id = 3 and is_active = 1")->result();
$patternList = $this->db->query("SELECT * FROM patterns WHERE is_active = 1")->result();

$userId=$this->session->userdata['user_id'];
$getUser = $this->db->query("SELECT * FROM user WHERE user_id =$userId")->row();

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
	<!--============For Editor===========-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/client_asstes/css/lib/html5-editor/bootstrap-wysihtml5.css" />
	<!--============For Editor===========-->
	<!--============For Accordian===========-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<!--============For Accordian===========-->
</head>
<body class="header-fix fix-sidebar">
<style>
	.form-control {
		height: 30px;
		font-size:11px;
	}
	select.form-control:not([size]):not([multiple]) {
		height: 30px;
		font-size: 11px;
	}
	.disabled-options {
		pointer-events: none;
		border: none;
		background: no-repeat;
	}

	select.disabled-options-select {
		pointer-events: none;
		background: none;
		border: none;
		-webkit-appearance: none;
	}
	#loading-bar-spinner.spinner {
		left: 50%;
		margin-left: -20px;
		top: 50%;
		margin-top: -20px;
		position: absolute;
		z-index: 19 !important;
		animation: loading-bar-spinner 400ms linear infinite;
	}

	#loading-bar-spinner.spinner .spinner-icon {
		width: 40px;
		height: 40px;
		border:  solid 4px transparent;
		border-top-color:  #ca2573 !important;
		border-left-color: #ca2573 !important;
		border-radius: 50%;
	}

	@keyframes loading-bar-spinner {
		0%   { transform: rotate(0deg);   transform: rotate(0deg); }
		100% { transform: rotate(360deg); transform: rotate(360deg); }
	}
	.toast-content {
		margin-top: 55px!important;
		background: #ca2573;
	}
	.table>thead>tr>th,.table>tbody>tr>td {
		font-size: 80%;
		font-weight: 400;
	}
	div.hide-div {
		display: none;
	}
	input.form-control.hide-input-field {
		border: none;
		background: white;
	}
	input#gensQty,input#gensRate,input#ladiesRate,input#ladiesRate,input#itemName,input#febricsItem{
		pointer-events: none;
	}
	input#generatedStatus {
		height: 14px;
		margin-top: 5px;
	}
	.table>thead>tr>th, .table>tbody>tr>td{
		cursor: pointer;
	}
	.modal-header .close {
		font-size: 35px!important;
		margin-right: -14px!important;
		margin-top: -25px!important;
	}
	input#checkall,input.form-control.cb-element {
		width: 18px;
	}
	div#example2555_wrapper,.col-sm-12.table-responsive {
		margin-top: 26px;
	}

	.dt-buttons {
		display: none;
	}
	div#example2555_filter {
		margin-right: 62px;
	}
	.notEditable {
		background: #80808014;
		pointer-events: none;
		cursor: crosshair;
	}
	#fullScreenDiv.fullscreen{
		z-index: 9999;
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		left: 0;
		background: #666666;
	}
	span#fullScreenbtn {
		cursor: pointer;
	}
	div.screen-full footer.footer {
		display: none;
	}
	div.screen-full .card{
		height: 95vh;
		overflow: auto;
	}
	.card-body {
		padding: inherit;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		color: black;
	}
	select.disable-gender-option {
		display: none;
	}
	tr.default-authorize-color{
	    background:#fbcee3!important
	}

</style>
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

		<center>
			<p style="color:green"><?php echo $this->session->flashdata('pattern_message') ?></p>
		</center>

		<!-- End Bread crumb -->
		<!-- Container fluid  -->
		<div class="container-fluid" id="fullScreenDiv">
			<!-- Start Page Content -->
			<form method="post" action = "<?php echo base_url() ?>CodeGeneration/save_code_data" id="codegeneratedForm" enctype='multipart/form-data'>
				<section id="po_section" name="po_section">
					<div id="customerform" class="collapse in">
						<div class="card">
							<div class="card-body">
								<center>
									<p style="color:green"><?php echo $this->session->flashdata('message') ?></p>
								</center>
								<h5 class="card-title">Code Authorizations <span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
								<div class="row">
									<div class="col-sm-12">
										<div class="row" style="border-style: ridge;">
											<input type="hidden" value="" id="codeGenerationsId" name="codeGenerationsId">
											<div class="col-sm-4">
												<small>Company Name</small>
												<select class="form-control " name="company_name"   id="company_name" required>
													<option value="">Company Name</option>
													<option value = "SuperEditors">SuperEditors</option>
													<option value = "MannaMenswear">MannaMenswear</option>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Updations For</small>
												<select class="form-control " name="updations_for"   id="updationsFor" required>
													<option value="">Select updations for</option>
													<option value="Authorize Code">Authorize Code</option>
													<option value = "Updations For Ready">Updations For Ready</option>
													<option value = "Updations For Sign">Updations For Sign</option>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Customer</small>
												<select class="form-control" name="customer" id="customer" required>
													<option value="">Select Customer</option>
													<?php foreach($customerDetails as $getcustomerDetails){ ?>
														<option value="<?php echo $getcustomerDetails->name ?>"
																data-credit-limit="<?=$getcustomerDetails->credit_limit?>"
																data-state="<?=$getcustomerDetails->state?>"
																data-customer-id="<?=$getcustomerDetails->enquiry_id?>"
																data-delivery-address="<?=$getcustomerDetails->shipping_address?>"
														><?php echo $getcustomerDetails->name ?></option>
													<?php } ?>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Code Number</small>
												<select class="form-control" name="code_number" id="coderNumber" required>
													<option value="">Select Code Number</option>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Entry Date</small>
												<input type="date" class="form-control" name="entry_date" id="entry_date" value="<?php echo date("Y-m-d") ?>" >
											</div>

											<div class="col-sm-4">
												<small>Upload Excel File For Import</small>
												<input type="file" class="form-control" name="import_file" id="import_file" value=""  >
											</div>

											<div class="col-sm-4" >
												<small>Remark</small>
												<input type="text" class="form-control" name="remark" id="remark" placeholder="Remark" >
											</div>

											<div class="col-sm-12 table-responsive">
												<h2 style="float: right;top: 31px;right: 9px;display: none" id="exportCSVDheader" >
													<a href="javascript:void(0)" style="text-decoration: none;box-shadow: none;" id="exportCsv">
														<img src="<?php echo base_url(); ?>assets/client_asstes/images/csv-2.png" style="width: 72px;">
													</a>
												</h2>

												<table id="example2555" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
													<tr>
														<th><input type="checkbox" style="=" id="checkall"  class=""></th>
														<th>SR NO</th>
														<th>Unique Code</th>
														<th>Unique name</th>
														<th>Gender(Gens/Ladies)</th>
														<th>Authorizations</th>
														<th>ID/Roll No</th>
														<th>Cell No</th>
														<th>Mens Tak</th>
														<th>Mens Taken</th>
														<th>Delivery Date</th>
														<th>Delivery By</th>
														<th>Actions</th>
													</tr>
													</thead>
													<tbody id="getCodeGenerationLeftBlock" >

													</tbody>
												</table>
											</div>


											<div class="col-sm-12" style="margin-bottom: 10px">
												<br>
												<button type="submit" class="btn btn-sm btn-primary text-white submit-btn" id="readDataFromExcel">Save Or Read Data From CSV</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</form>

			<!-- End Container fluid  -->
			<!-- footer -->
			<?php include("includes/footer.php") ?>
			<!-- End footer -->
		</div>
		<!-- End Page wrapper  -->
	</div>
	<!-- End Wrapper -->
	<!-- All Jquery -->

	<div class='modal' id='myModal' tabindex='-1' aria-labelledby='myModallabel' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='myModallabel'>OTP Confirmations</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text'>
					<form method="post" action="<?php echo base_url() ?>CodeGeneration/authorizations" autocomplete="off" id="authorizationsValidations">
						<div class="row">
							<div class="col-sm-12">
								<p>Please contact system admin for OTP. After correct OTP verification,<br/> you will be able to Modify data.</p>
							</div>
							<div class="col-sm-12">
								<input class="form-control" name="otp_code" id="heading" placeholder="Paste here otp code" value="" required>
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
	<!-- Bootstrap Modal -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


	<script>
		$( document ).ready(function() {

			$(document).on('change', 'select#company_name', function() {
				var companyname=$(this).val();

				var post_data = {
					'companyname': companyname,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				var url = "<?php echo base_url();?>CodeGeneration/getCompanyWiseCustomer";

				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
						var obj = JSON.parse(result);
						$('select#customer').find('option').remove();
						$('select#customer').append($('<option/>', {
							value: '',
							text : 'Select Customer'
						}));

						for(var i=0;i<obj.length;i++)
						{
							$('select#customer').append($('<option/>', {
								value: obj[i]['name'],
								text : obj[i]['name'],
							}));
						}
					}
				});
			});


			$(document).on('change', '#checkall', function() {
				$('.cb-element').prop('checked', this.checked);
				// if ($('#checkall:checked').length == $('#checkall').length) {
				// 	$('select#genderOptions').show();
				// }else {
				// 	$('select#genderOptions').hide();
				// }
			});

			$(document).on('change', '.cb-element', function() {
				if ($('.cb-element:checked').length == $('.cb-element').length) {
					$('#checkall').prop('checked', true);
				} else {
					$('#checkall').prop('checked', false);
				}
			});

			var successImage    ='<?php echo base_url(); ?>assets/alert_image/success.svg';

			$(document).on('change', 'select#customer', function() {
				var customerId          =$('option:selected',this).data("customer-id");
				var customerName=$(this).val();

				var url = "<?php echo base_url('CodeGeneration/get_code_number'); ?>";

				var post_data = {
					'customerId': customerId,
					'customerName': customerName,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
						var obj = JSON.parse(result);

						$('select#coderNumber').find('option').remove();
						$('select#coderNumber').append($('<option/>', {
							value: '0',
							text : 'Select Code Number'
						}));

						for(var i=0;i<obj.length;i++)
						{
							var endofCode=Number(obj[i]['number_starts_form'])+Number(obj[i]['number_of_code_generations']);

							var textData=obj[i]['prefix']+' '+obj[i]['number_starts_form']+' - '+obj[i]['prefix']+' '+endofCode;
							$('select#coderNumber').append($('<option/>', {
								value: obj[i]['prefix'],
								text : textData,
								datastartUp : obj[i]['number_starts_form'],
								dataEndOFCode: obj[i]['number_of_code_generations'],
							}));
						}
					}
				});
			});

			var countCalling=0;
			$(document).on('change', 'select#coderNumber', function() {

				var startUp         	  =$('select#coderNumber').find(':selected').attr('datastartUp');
				var dataEndOFCode          =$('select#coderNumber').find(':selected').attr('dataEndOFCode');
				var prefix					=$(this).val();

				var startUpSecond=Number(startUp);
				var dataEndOFCodeSecond=Number(dataEndOFCode);

				$('tbody#getCodeGenerationLeftBlock').html('');


				var url = "<?php echo base_url('CodeGeneration/getGenerationsInfo'); ?>";

				var post_data = {
					'prefix': prefix,
					'startUp': startUp,
					'dataEndOFCode': dataEndOFCode,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				var html='';

				$.ajax({
					url : url,
					type : 'POST',
					data:post_data,
					success : function(result)
					{
						if (result){
							var obj = JSON.parse(result);

							$.each(obj.codeAuthorizationsDetails, function (index,value) {

								var className='odd';
								if (index%2==0){
									className='even';
								}
								++index;

								var checkedStatus='cb-element';
								var enableDisableGender=`gender-disable-enable-`+index+``;
								var enableDisbaleGenderClass="disable-gender-option";
								var NoneEditableClass='';
								var authorizedAlreadyStyle='';

								var checkedClassName='';
								if (value.billing_status==1 || value.authorization=='Yes'){
									checkedStatus='checked';
									NoneEditableClass='notEditable';
									enableDisableGender="";
									enableDisbaleGenderClass="";
									authorizedAlreadyStyle='background: #fbcee3;';
								}else{
									checkedStatus='unchecked';
									NoneEditableClass='notEditable';
									enableDisableGender="disable-gender-option";
									enableDisbaleGenderClass="";
									authorizedAlreadyStyle='background: white';
								}

								if (value.gender){
									enableDisbaleGenderClass="";
								}

								var selections1=selections2='';
								if (value.authorization=='Yes'){
									selections1='selected';
								}else if (value.authorization=='No'){
									selections2='selected';
								}

								var maleSelected=femaleselected='';
								if (value.gender=='Male'){
									maleSelected='selected';
								}else if (value.gender=='Female'){
									femaleselected='selected';
								}

								var menstalkSelections1=menstalkSelections2=menstalkSelections3='';
								if (value.mens_tak==='No'){
									menstalkSelections1='selected';
								}else if (value.mens_tak==='Yes'){
									menstalkSelections2='selected';
								}else if (value.mens_tak==='Store Receive'){
									menstalkSelections3='selected';
								}


								if (value.roll_no==null){
									value.roll_no='';
								}
								if (value.cell_no==null){
									value.cell_no='';
								}

								if (value.mens_taken==null){
									value.mens_taken='';
								}

								if (value.stud_name==null){
									value.stud_name='';
								}

								if (value.unique_name==null){
									value.unique_name='';
								}
								
								if(obj.delivery_date=="null"){
								    obj.delivery_date="";
								}


								html +=`<tr role="row" class="`+className+`" data-authorizationsid="`+value.id+`" id="deleteItemRow-`+value.id+`" style="`+authorizedAlreadyStyle+`">
										 <td class="`+NoneEditableClass+` modify-options-`+index+`">
											<input type="hidden" class="form-control" name="AuthorizationsItem[`+index+`][id]" id="authorizationId" placeholder="" value="`+value.id+`">
											<input type="checkbox"  name="AuthorizationsItem[`+index+`][authorization_status]" data-index="`+index+`" class="`+checkedStatus+`" `+checkedStatus+` id="authorizations-`+index+`"></td>
										 <td class="sorting_1">`+index+`</td>
										<td id="uniqueCodeTd" class="`+NoneEditableClass+` modify-options-`+index+`">`+value.unique_code+`</td>
										<td id="uniqueNameTd" class="`+NoneEditableClass+` modify-options-`+index+`"><input type="text" class="input_unique_name_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][unique_name]" id="uniqueNameText" placeholder="" value="`+value.unique_name+`" data-authorizationsid="`+value.id+`"></td>
										<td id="genderTdOptions_`+index+`" class="genderTdOptions `+NoneEditableClass+` modify-options-`+index+`">
										<select class="input_gender_`+index+` form-control disabled-options-select `+enableDisbaleGenderClass+` `+enableDisableGender+`" id="genderOptions" name="AuthorizationsItem[`+index+`][gender]">
											<option value="Male" `+maleSelected+`>Male</option>
											<option value="Female" `+femaleselected+`>Female</option>
										  </select>
										</td>
										<td id="authorizationsOptions" class="`+NoneEditableClass+` modify-options-`+index+`">
											<select class="input_authorizations_`+index+` form-control disabled-options-select select-options-`+index+`" id="authorization" name="AuthorizationsItem[`+index+`][authorization]" data-index="`+index+`">
											<option value="No" `+selections2+`>No</option>
											<option name="Yes" `+selections1+`>Yes</option>
											</select>
										</td>
										<td id="rollNumberOptions" class="`+NoneEditableClass+` modify-options-`+index+`"><input type="text" class="input_roll_no_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][roll_no]" id="rollNumberOptionsText" placeholder="" value="`+value.roll_no+`" ></td>
										<td id="cellNumber" class="`+NoneEditableClass+` modify-options-`+index+`"><input type="text" class="input_cell_no_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][cell_no]" id="cellNumberText" placeholder="" value="`+value.cell_no+`" ></td>
										<td id="mensTakOptions" class="`+NoneEditableClass+` modify-options-`+index+`">
											<select class="input_mens_tak_`+index+` form-control disabled-options-select" id="mensTalkOptions" name="AuthorizationsItem[`+index+`][mens_tak]">
											<option value="No" `+menstalkSelections1+`>No</option>
											<option name="Yes" `+menstalkSelections2+`>Yes</option>
											<option name="Store Receive" `+menstalkSelections3+`>Store Receive</option>
											</select>
										</td>
										<td id="mensTakenoptions" class="`+NoneEditableClass+` modify-options-`+index+`"><input type="text" class="input_mens_taken_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mens_taken]" id="mensTakenoptionsText" placeholder="" value="`+value.mens_taken+`"></td>
										<td id="deliveryDate" class="`+NoneEditableClass+` modify-options-`+index+`">`+obj.delivery_date+`</td>
										<td id="deliveryOptions" class="`+NoneEditableClass+` modify-options-`+index+`"><input type="text" class="input_stud_name_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][stud_name]" id="deliveryOptionsText" placeholder="" value="`+value.stud_name+`"></td>
										<td><button type="button" class="btn btn-sm btn-primary text-white submit-btn" data-index="`+index+`" id="modifybtnActions" data-delete-id="`+value.id+`" style="margin-right: 10px;">Modify</button><button type="button" class="btn btn-sm btn-primary text-white submit-btn" id="deleteBtnAction" data-delete-id="`+value.id+`">Delete</button></td>
										</tr>`;
							});

							$('tbody#getCodeGenerationLeftBlock').html(html);

							if (countCalling==0) {
								$('#example2555').DataTable({
									 "bPaginate": false,
									"searching": true,
									dom: 'Bfrtip',
									buttons: [
										'copy', 'csv', 'excel', 'pdf', 'print'
									]
								});
							}
							$('h2#exportCSVDheader').show();
							countCalling++;


							clickEvent();

						}else{
							alert("Something wrong");
						}
					},error: function (){
						alert("Something went wrong")
					}
				});

			});
		});

		function clickEvent() {
			//Gender Change
			$(function() {
				$("td.genderTdOptions,td#authorizationsOptions,td#mensTakOptions").on('click', function(e) {
					e.stopPropagation();
					var authorizationsStatus='<?=$getUser->authorize_edit_code_status?>';
					if (authorizationsStatus==1) {
						$('tbody#getCodeGenerationLeftBlock select').addClass('disabled-options-select');
						$('tbody#getCodeGenerationLeftBlock input').addClass('disabled-options');
						$(this).find('select').removeClass('disabled-options-select');
						$('tbody#getCodeGenerationLeftBlock .cb-element').removeClass('disabled-options');
					}else {
						$('#myModal').modal('show');
						sendOtpCode();
					}
				});
			});

			$(document).on('click', 'td#uniqueNameTd,td#rollNumberOptions,td#cellNumber,td#mensTakenoptions,td#deliveryOptions', function () {
				var authorizationsStatus='<?=$getUser->authorize_edit_code_status?>';
			    if (authorizationsStatus==1) {
			    	$('input#uniqueNameText,input#rollNumberOptionsText,input#cellNumberText,input#mensTakenoptionsText,input#deliveryOptionsText').addClass('disabled-options');
					$('tbody#getCodeGenerationLeftBlock select').addClass('disabled-options-select');
					$(this).find('input').removeClass('disabled-options');
				}else {
					$('#myModal').modal('show');
					sendOtpCode();
				}
			});


			//studNameOptions
			$(document).on('click', 'td#studNameOptions', function () {
				var authorizationsStatus='<?=$getUser->authorize_edit_code_status?>';
				if (authorizationsStatus==1) {

				var authorizationsId=$(this).closest('tr').data('authorizationsid');
				var currentvalue=$(this).text()||$(this).children().val();
				$(this).html('<input type="text" class="form-control" name="stud_name" id="studNameText" placeholder="Stud name" value="'+currentvalue+'" data-authorizationsid="'+authorizationsId+'">');
				$(this).find('#studNameText').focus();

				}else {
					$('#myModal').modal('show');
					sendOtpCode();
				}
			});

			//mensTakenoptions
			$(document).on('click', 'td#mensTakenoptions', function () {
				var authorizationsStatus='<?=$getUser->authorize_edit_code_status?>';
				if (authorizationsStatus==1) {



				}else {
					$('#myModal').modal('show');
					sendOtpCode();
				}
			});

			$(document).on('click', 'input.cb-element', function () {
				var index=$(this).data('index');
				if($(this).prop("checked") == true){
					//$('td.modify-options-'+index+'').addClass('notEditable');
					$('select.select-options-'+index+'').val('Yes').trigger('change');
					$('select.gender-disable-enable-'+index+'').show();
				}
				else if($(this).prop("checked") == false){
					$('select.select-options-'+index+'').val('No').trigger('change');
				}
			});


			$(document).on('click', 'button#modifybtnActions', function () {
				var index=$(this).data('index');
				$('td.modify-options-'+index+'').removeClass('notEditable');
				$('input#authorizations-'+index+'').addClass('cb-element');
				cuteToast({
					type: "success", // or 'info', 'error', 'warning'
					message: "You can edit now",
					timer: 5000,
					img: successImage,
				});
			});


			$(document).on('change', 'td#authorizationsOptions select', function() {
				var currentValue=$(this).val();
				var index=$(this).data('index');
				if (currentValue==='Yes'){
					$('input#authorizations-'+index+'').prop('checked', true);
					$('tr#deleteItemRow-1').css('background','#fbcee3');
				}else {
					$('input#authorizations-'+index+'').prop('checked', false);
					$('tr#deleteItemRow-1').css('background','unset');
				}
			});
		}

		$(document).on('click', 'button#deleteBtnAction', function () {
			var authorizationsStatus='<?=$getUser->authorize_edit_code_status?>';
			if (authorizationsStatus==1) {
				var getDeleteAuthorizationsId=$(this).data('delete-id');
				if(getDeleteAuthorizationsId){
					cuteAlert({
						type: "success", // or 'info', 'error', 'warning'
						title: 'Code Authorization item',
						message: "Are you sure you want to delete this record?",
						buttonText: "Okay",
						img: successImage,
					}).then((e)=>{
						if ( e === ("ok")){
							var url = "<?php echo base_url('CodeGeneration/deleteAuthorizationsItem'); ?>";
							var post_data = {
								'authorizationsId': getDeleteAuthorizationsId,
								'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
							};
							$.ajax({
								url : url,
								type : 'POST',
								data: post_data,
								success : function(result)
								{
									if (result==1) {
										cuteToast({
											type: "success", // or 'info', 'error', 'warning'
											message: "Successfully Update Data",
											timer: 5000,
											img: successImage,
										});
										$('tr#deleteItemRow-'+getDeleteAuthorizationsId+'').remove();
									}
								}
							});
						}
					});
				}
			}else {
				$('#myModal').modal('show');
				sendOtpCode();
			}
		});


		function sendOtpCode(){
			var url = "<?php echo base_url('CodeGeneration/sendOtpCode'); ?>";
			var post_data = {
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
			};

			$.ajax({
				url : url,
				type : 'POST',
				data: post_data,
				success : function(result)
				{
					console.log("See")
				}
			});
		}


		var successImage    ='<?php echo base_url(); ?>assets/alert_image/success.svg';

		$("form#codegeneratedForm").submit(function(e) {
			e.preventDefault();

			var companyName				=$('select#company_name').val();
			var updateFor				=$('select#updationsFor').val();
			var customerName			=$('select#customer').val();
			var startUp         	  	=$('select#coderNumber').find(':selected').attr('datastartUp');
			var dataEndOFCode          	=$('select#coderNumber').find(':selected').attr('dataEndOFCode');
			var prefix					=$('select#coderNumber').val();


			var xhr = new XMLHttpRequest()

			var url ="<?php echo base_url('CodeGeneration/saveOrImportCode'); ?>";

			//var formData = new FormData();
			var formData = new FormData($('form')[0]);
			formData.append('file',xhr.file);
			formData.append("companyName",companyName);
			formData.append("updateFor",updateFor);
			formData.append("customerName",customerName);
			formData.append("startUp",startUp);
			formData.append("dataEndOFCode",dataEndOFCode);
			formData.append("prefix",prefix);

			$.ajax({
				url : url,
				processData: false,
				contentType: false,
				cache: false,
				type : 'POST',
				data: formData, // serializes the form's elements.
				success : function(result)
				{
					if (result==1){
					    
					    $("input:checkbox[type=checkbox]:checked").each(function(){
				        	var index=$(this).data('index');
			                $('td.modify-options-'+index+'').addClass('notEditable');
			                $(this).closest('tr').addClass("default-authorize-color");
                        });

						cuteToast({
							type: "success", // or 'info', 'error', 'warning'
							message:'Successfully Save Authorizations Data',
							timer: 5000,
							img:successImage,
						});

						setTimeout(function() {
							$('button#readDataFromExcel').html("Save Or Read Data From CSV");
						}, 1000);

					}else {
						var obj = JSON.parse(result);
						$.each(obj, function (index,value) {
							++index;
							$('input.input_unique_name_'+index+'').val(value.unique_name);
                            
                            if(value.gender){
    							$('select.input_gender_'+index+'').val(value.gender).trigger('change');
    							$('select.input_gender_'+index+'').show();
                            }else{
                               $('select.input_gender_'+index+'').hide();
                            }

							if (value.authorization) {
								$('select.input_authorizations_' + index + '').val(value.authorization).trigger('change');
							}

							$('input.input_roll_no_'+index+'').val(value.roll_no);
							$('input.input_cell_no_'+index+'').val(value.cell_no);

							if (value.mens_tak) {
								$('select.input_mens_tak_' + index + '').val(value.mens_tak).trigger('change');
							}

							$('input.input_mens_taken_'+index+'').val(value.mens_taken);
							$('input.input_stud_name'+index+'').val(value.stud_name);

						});

						cuteToast({
							type: "success", // or 'info', 'error', 'warning'
							message:'Successfully Updated Data',
							timer: 5000,
							img:successImage,
						});

						setTimeout(function() {
							$('button#readDataFromExcel').html("Save Or Read Data From CSV");
						}, 1000);

					}
				},error: function (){
					alert("Something went wrong");
					$('button#readDataFromExcel').html("Save Or Read Data From CSV");
				},
				beforeSend: function (xhr){
					$('button#readDataFromExcel').html("<span class='fa fa-spin fa-spinner'></span> Processing...");
				}
			});
		});


		//mensTakenoptions
		$(document).on('click', 'a#exportCsv', function () {
			var startUp         	  	=$('select#coderNumber').find(':selected').attr('datastartUp');
			var dataEndOFCode          	=$('select#coderNumber').find(':selected').attr('dataEndOFCode');
			var prefix					=$('select#coderNumber').val();
			var customer					=$('select#customer').val();

			var url ="<?php echo base_url('CodeGeneration/exportCSV'); ?>?startForm="+startUp+"&dataEndOFCode="+dataEndOFCode+"&prefix="+prefix+"&customer="+customer+"";
			window.location.href =url;
		});

		$('span#fullScreenbtn').click(function(e){
			$('#fullScreenDiv').toggleClass('fullscreen');
			$('div#main-wrapper').toggleClass('screen-full');
		});

	</script>


</body>
</html>
