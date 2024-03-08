
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
	div#example2555_wrapper,.col-sm-12.table-responsive {
		margin-top: 26px;
	}

	.dt-buttons {
		display: none;
	}
	div#example2555_filter {
		margin-right: 62px;
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

		<!-- Container fluid  -->
		<div class="container-fluid" id="fullScreenDiv">
			<!-- Start Page Content -->
			<form method="post" action = "<?php echo base_url() ?>CodeGeneration/save_code_data" id="codegeneratedForm" enctype='multipart/form-data' style="display: flex;width: 100%;">
				<section id="po_section" name="po_section">
					<div id="customerform" class="collapse in">
						<div class="card">
							<div class="card-body">
								<center>
									<p style="color:green"><?php echo $this->session->flashdata('message') ?></p>
								</center>
								<center>
									<p style="color:green"><?php echo $this->session->flashdata('pattern_message') ?></p>
								</center>

								<h5 class="card-title">Code Measurements <span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
								<div class="row">
									<div class="col-sm-12">
										<div class="row" style="border-style: ridge;">
											<input type="hidden" value="" id="codeGenerationsId" name="codeGenerationsId">

											<div class="col-sm-3">
												<small>Company Name</small>
												<select class="form-control " name="company_name"   id="company_name" required>
													<option value="">Company Name</option>
													<option value ="SuperEditors">SuperEditors</option>
													<option value ="MannaMenswear">MannaMenswear</option>
												</select>
											</div>

											<div class="col-sm-3">
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

											<div class="col-sm-3">
												<small>Code Number</small>
												<select class="form-control" name="code_number" id="coderNumber" required>
													<option value="">Select Code Number</option>
												</select>
												<span id="codeNumberError" style="color: red"></span>
											</div>

											<div class="col-sm-3">
												<small>Item Name</small>
												<select class="form-control" name="item_name" id="item_name" required>
													<option value="">Select Item Name</option>
												</select>
											</div>

											<div class="col-sm-4" style="margin-top: 23px;">
												<small>Upload Excel File For Import</small>
												<input type="file" class="form-control" name="import_file" id="import_file" value=""  >
											</div>

											<div class="col-sm-12 table-responsive">
												<h2 style="float: right;position: absolute; top: 31px;right: 9px;display: none" id="exportCSVDheader" >
													<a href="javascript:void(0)" style="text-decoration: none;box-shadow: none;" id="exportCsv">
														<img src="<?php echo base_url(); ?>assets/client_asstes/images/csv-2.png" style="width: 72px;">
													</a>
												</h2>
												<table id="example2555" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
													<tr>
														<th>SR NO</th>
														<th>Unique Code</th>
														<th>Name</th>
														<th>Gender</th>
														<th>New Qty</th>
														<th>Measurements</th>
														<th>Pattern</th>
														<th>Remark</th>
													</tr>
													</thead>
													<tbody id="getCodeGenerationLeftBlock" >
													</tbody>
												</table>
											</div>
											<div class="col-sm-12" style="margin-bottom: 10px">
												<br>
												<button type="submit" class="btn btn-sm btn-primary text-white submit-btn" id="readDataFromExcel">Save Or Read Data From CSV</button>
												<button type="button" class="btn btn-sm btn-primary text-white submit-btn" id="markQuantitybtn">Mark All Qty To Zero</button>
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
					<form method="post" action="<?php echo base_url() ?>CodeGeneration/authorizations?page=Measurements" autocomplete="off" id="authorizationsValidations">
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

			$('#checkall').change(function() {
				$('.cb-element').prop('checked', this.checked);
			});

			$('.cb-element').change(function() {
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
							text : 'Select Code Number',
						}));

						for(var i=0;i<obj.length;i++)
						{
							var endofCode=Number(obj[i]['number_starts_form'])+Number(obj[i]['number_of_code_generations']);

							var textData=obj[i]['prefix']+' '+obj[i]['number_starts_form']+' - '+obj[i]['prefix']+' '+endofCode;
							$('select#coderNumber').append($('<option/>', {
								value: obj[i]['prefix'],
								text : textData,
								dataCodegenrationsId:obj[i]['code_generations_id'],
								datastartUp : obj[i]['number_starts_form'],
								dataEndOFCode: obj[i]['number_of_code_generations'],
								codegenerationsid: obj[i]['code_generations_id'],
							}));
						}
					}
				});
			});

			$(document).on('change', 'select#coderNumber', function() {
				var codeGenerationsId =$('select#coderNumber').find(':selected').attr('codegenerationsid');

				var url = "<?php echo base_url('CodeGeneration/get_code_genrated_item_name'); ?>";

				var post_data = {
					'codeGenerationsId': codeGenerationsId,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
						var obj = JSON.parse(result);

						$('select#item_name').find('option').remove();
						$('select#item_name').append($('<option/>', {
							value: '0',
							text : 'Select Item Name'
						}));

						for(var i=0;i<obj.length;i++)
						{
							$('select#item_name').append($('<option/>', {
								value: obj[i]['id'],
								text :obj[i]['item_name'],
							}));
						}
					}
				});
			});

		});


		var countCalling=0;
		$(document).on('change', 'select#item_name', function() {

			var startUp         	  =$('select#coderNumber').find(':selected').attr('datastartUp');
			var dataEndOFCode          =$('select#coderNumber').find(':selected').attr('dataEndOFCode');
			var prefix					=$('select#coderNumber').val();

			var codeGenerationsId     =$('select#coderNumber').find(':selected').attr('dataCodegenrationsId');

			$('tbody#getCodeGenerationLeftBlock').html('');

			var url = "<?php echo base_url('CodeGeneration/getCodeMesurementInfo'); ?>";

			var post_data = {
				'prefix': prefix,
				'startUp': startUp,
				'dataEndOFCode': dataEndOFCode,
				'codeGenerationsId': codeGenerationsId,
				'codeGenerationItemId': $(this).val(),
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

						$.each(obj, function (index,value) {
							var className='odd';
							if (index%2==0){
								className='even';
							}
							++index;

							var checkedStatus='';
							if (value.billing_status==1){
								checkedStatus='checked';
							}


							var patterns_type	=value.patterns_type;
							var inititalQty		=0;

							if (value.mesurement==null){
								value.mesurement='';
							}

							var maleSelected=femaleselected='';
							if (value.gender=='Male'){
								maleSelected='selected';
								inititalQty = value.gens_qty;
							}else if (value.gender=='Female'){
								inititalQty=value.ladies_qty;
								femaleselected='selected';
							}

							inititalQty = value.gens_qty;

							if (value.patterns_type==null || value.patterns_type==''){
								value.patterns_type=patterns_type;
							}

							if (value.remark==null){
								value.remark='';
							}

							html +=`<tr role="row" class="`+className+`" data-authorizationsid="`+value.id+`">
									   <input type="hidden" class="form-control" name="AuthorizationsItem[`+index+`][authorizationId]" id="auth" placeholder="" value="`+value.authorizationId+`">
									   <input type="hidden" class="form-control" name="AuthorizationsItem[`+index+`][id]" id="authorizationId" placeholder="" value="`+value.id+`">
										<td class="sorting_1">`+index+`</td>
										<td id="uniqueCodeTd"><input type="text" class="form-control disabled-options" name="AuthorizationsItem[`+index+`][unique_code]" id="unique_code" placeholder="" value="`+value.unique_code+`" ></td>
										<td id="uniqueNameTd"><input type="text" class="form-control disabled-options unique_name_`+index+`" name="AuthorizationsItem[`+index+`][unique_name]" id="uniqueNameText" placeholder="" value="`+value.unique_name+`" data-authorizationsid="`+value.id+`"></td>
										<td id="genderTdOptions">
										<select class="form-control disabled-options-select select_gender_`+index+`" id="genderOptions" name="AuthorizationsItem[`+index+`][gender]" data-keyindex="`+index+`">
											<option value="Male" `+maleSelected+`>Male</option>
											<option value="Female" `+femaleselected+`>Female</option>
										  </select>
										</td>
										<td id="mesurementQtyOptions"><input type="text" class="input_mesurement_qty_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mesurement_qty]" id="mesurementQty" placeholder="" value="`+inititalQty+`" ></td>
										<td id="mesurements"><input type="text" class="input_mesurement_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mesurement]" id="mesurementData" placeholder="" value="`+value.mesurement+`" ></td>
										<td id="mesurementPattern"><input type="text" class="input_mesurement_pattern_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mesurement_pattern]" id="mesurement_pattern" placeholder="" value="`+value.patterns_type+`" ></td>
										<td id="mesurementsRemark"><input type="text" class="input_mesurement_remark_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mesurement_remark]" id="mesurementRemark" placeholder="" value="`+value.remark+`" ></td>
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

					}
				},error: function (){
					alert("Something went wrong")
				}
			});
		});

		function clickEvent() {

			//Gender Change
			$(function() {
				$("td#genderTdOptions,td#authorizationsOptions,td#mensTakOptions").on('click', function(e) {
					e.stopPropagation();
					var authorizationsStatus='<?=$getUser->authorize_edit_code_status?>';
					if (authorizationsStatus==1) {
						$('tbody#getCodeGenerationLeftBlock select').addClass('disabled-options-select');
						$('tbody#getCodeGenerationLeftBlock input').addClass('disabled-options');
						$(this).find('select').removeClass('disabled-options-select');
					}else {
						$('#myModal').modal('show');
						sendOtpCode();
					}
				});
			});

			$(document).on('click', 'td#uniqueNameTd,td#mesurementQtyOptions,td#mesurements,td#mesurementPattern,td#mesurementsRemark', function () {
				var authorizationsStatus='<?=$getUser->authorize_edit_code_status?>';
				if (authorizationsStatus==1) {
					$('tbody#getCodeGenerationLeftBlock input').addClass('disabled-options');
					$('tbody#getCodeGenerationLeftBlock select').addClass('disabled-options-select');
					$(this).find('input').removeClass('disabled-options');
				}else {
					$('#myModal').modal('show');
					sendOtpCode();
				}
			});
		}


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
			var itemid					=$('select#item_name').val();

			var xhr = new XMLHttpRequest()

			var url = "<?php echo base_url('CodeGeneration/importCodeMesurement'); ?>";

			//var formData = new FormData();
			var formData = new FormData($('form')[0]);
			formData.append('file',xhr.file);

			formData.append("companyName",companyName);
			formData.append("updateFor",updateFor);
			formData.append("customerName",customerName);
			formData.append("startUp",startUp);
			formData.append("dataEndOFCode",dataEndOFCode);
			formData.append("prefix",prefix);
			formData.append("itemid",itemid);

			$.ajax({
				url : url,
				processData: false,
				contentType: false,
				cache: false,
				type : 'POST',
				data: formData, // serializes the form's elements.
				success : function(result)
				{
					if (Number(result)===1){
						cuteToast({
							type: "success", // or 'info', 'error', 'warning'
							message: "Successfully Import data",
							timer: 5000,
							img:successImage,
						});

						setTimeout(function() {
							$('button#readDataFromExcel').html("Save Or Read Data From CSV");
							if (Number(result)==2) {
								location.reload();
							}
						}, 1000);

					}else{
						var obj = JSON.parse(result);
						$.each(obj, function (index,value) {
							++index;
							
						    $('input.unique_name_'+index+'').val(value.unique_name);
						    
                            if(value.gender){
    							$('select.select_gender'+index+'').val(value.gender).trigger('change');
                            }
                            
                            if(value.mesurement){
                              $('input.input_mesurement_'+index+'').val(value.mesurement);
                            }
                            
                             if(value.pattern){
                              $('input.input_mesurement_pattern_'+index+'').val(value.pattern);
                            }
                            
                            if(value.remark){
                              $('input.input_mesurement_remark_'+index+'').val(value.remark);
                            }
                            
						});	
						
						
				     	cuteToast({
							type: "success", // or 'info', 'error', 'warning'
							message: "Successfully Import data",
							timer: 5000,
							img:successImage,
						});

						setTimeout(function() {
							$('button#readDataFromExcel').html("Save Or Read Data From CSV");
							if (Number(result)==2) {
								location.reload();
							}
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
			var itemId					=$('select#item_name').val();
			var customer				=$('select#customer').val();

			var url ="<?php echo base_url('CodeGeneration/exportCsvMesurement'); ?>?startForm="+startUp+"&dataEndOFCode="+dataEndOFCode+"&prefix="+prefix+"&itemId="+itemId+"&customer="+customer+"";
			window.location.href =url;
		});


		$(document).on('click', 'button#markQuantitybtn', function() {

			var url = "<?php echo base_url('CodeGeneration/markAllQuantityUpdate'); ?>";
			var itemid					=$('select#item_name').val();

			var post_data = {
				'itemid':itemid,
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
			};

			$.ajax({
				url : url,
				type : 'POST',
				data: post_data,
				success : function(result)
				{
					var obj = JSON.parse(result);
					cuteToast({
						type: "success", // or 'info', 'error', 'warning'
						message: "Make all quantity 0 where mesurement is equal to empty",
						timer: 5000,
						img:successImage,
					});

				    $("tr").each(function(index,value) {
					    ++index;
					    var checkMesuremetn     =$("input.input_mesurement_"+index+"").val();
					    if(!checkMesuremetn){
					        $('input.input_mesurement_qty_'+index+'').val(0);
					    }
					    
	                });
	                
	                	setTimeout(function() {
						$('button#markQuantitybtn').html("Mark All Qty To Zero");
					}, 1000);
					
				},error: function (){
					alert("Something went wrong");
					$('button#markQuantitybtn').html("Mark All Qty To Zero");
				},
				beforeSend: function (xhr){
					$('button#markQuantitybtn').html("<span class='fa fa-spin fa-spinner'></span> Processing...");
				}
			});
		});

		$('span#fullScreenbtn').click(function(e){
			$('#fullScreenDiv').toggleClass('fullscreen');
			$('div#main-wrapper').toggleClass('screen-full');
		});

	</script>

</body>
</html>
