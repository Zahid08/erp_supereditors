<?php
$chalanNumber    ='CH-'.str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
$karigarMaster = $this->db->query("SELECT id,name FROM karigar_master")->result();

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
		background: #ca25736e;
		border: 1px solid #ca25736e;
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
	input#Barcode,input.subTotalAmount,input#OrderNumber,input#itemName,input#discountAmount{
		pointer-events: none;
	}
	.modal-backdrop.in {
		background: #8080804f!important;
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



		<!-- End Bread crumb -->
		<!-- Container fluid  -->
		<div class="container-fluid" id="fullScreenDiv">
			<!-- Start Page Content -->
			<form method="post" action = "<?php echo base_url() ?>BillGeneration/save_bill_data" id="billgeneratedForm">
				<section id="po_section" name="po_section">
					<div id="customerform" class="collapse in">
						<div class="card">
							<div class="card-body">
								<center>
									<p style="color:green"><?php echo $this->session->flashdata('message') ?></p>
								</center>
								<h5 class="card-title">Allocate Order Bulk <span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
								<div class="row">
									<div class="col-sm-6">
										<div class="row" style="border-style: ridge;margin-left: 1px;">
											<div class="col-sm-4">
												<small>Company Name</small>
												<select class="form-control " name="company_name"   id="company_name" required>
													<option value="">Company Name</option>
													<option value = "SuperEditors">SuperEditors</option>
													<option value = "MannaMenswear">MannaMenswear</option>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Allocation No.</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="<?=$chalanNumber?>">
											</div>
											<div class="col-sm-4">
												<small>Date</small>
												<input type="date" class="form-control" name="bill_date" id="bill_date" value="<?php echo date("Y-m-d") ?>"   required>
											</div>
											<div class="col-sm-4">
												<small>Delivery Date</small>
												<input type="date" class="form-control" name="bill_date" id="bill_date" value="<?php echo date("Y-m-d") ?>"   required>
											</div>

											<div class="col-sm-8">
												<small>Karigar Name</small>
												<select class="form-control" name="kariagar_master" id="kariagar_master">
													<?php foreach ($karigarMaster as $key=>$value): ?>
													<option value="<?=$value->id?>"><?=$value->name?></option>
													<?php endforeach; ?>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Karigar Type</small>
												<select class="form-control" id="karigar_type" name="karigar_type" required="">
													<option value="">Select Karigar Type</option>
													<option value="cutter_master">Cutter Master</option>
													<option value="worker_master">Worker Master</option>
													<option value="embroidery_master">Embroidery Master</option>
													<option value="pressing_master">Pressing Master</option>
												</select>
											</div>

											<div class="col-sm-8" style="margin-top: 20px;">
												<small></small>
												<select class="form-control" name="cutting_process" id="cuttingProcess" required>
													<option value="">Cutting process</option>
												</select>
											</div>

											<div class="col-sm-12" style="margin-top: 20px;margin-bottom: 20px;">
												<input type="checkbox" class=""> Is with cutting ?
											</div>


											<div class="col-sm-12">
												<small>Party Name</small>
												<select class="form-control" name="customer" id="customer" required>
													<option value="">Select Party</option>
												</select>
											</div>

											<div class="col-sm-12">
												<small>Code Number</small>
												<select class="form-control" name="code_number" id="coderNumber" required>
													<option value="">Select Code Number</option>
												</select>
											</div>

											<div class="col-sm-12">
												<small>Item Name</small>
												<select class="form-control" name="item_name" id="item_name" required>
													<option value="">Choose Item Name</option>
												</select>
											</div>

											<div class="col-sm-12" style="margin-top: 20px;">
												<h6>Approximate Fabric Details Required</h6>
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 20%">Mts Reqd for Gents</label>
												<input type="text" class="form-control" style="width: 20%">
												<label style="margin-right: 5px;margin-left:5px;width: 1%">X</label>
												<input type="text" class="form-control" style="width: 20%;margin-right: 5px;margin-left:5px;">
												<label style="margin-right: 5px;margin-left:5px;width: 1%;font-weight: 600;font-size: medium;">=</label>
												<input type="text" class="form-control" style="width: 20%">
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 20%">Mts Reqd for Ladies</label>
												<input type="text" class="form-control" style="width: 20%">
												<label style="margin-right: 5px;margin-left:5px;width: 1%">X</label>
												<input type="text" class="form-control" style="width: 20%;margin-right: 5px;margin-left:5px;">
												<label style="margin-right: 5px;margin-left:5px;width: 1%;font-weight: 600;font-size: medium;">=</label>
												<input type="text" class="form-control" style="width: 20%">
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 25%">Total Barcodes Allocated</label>
												<label style="margin-right: 10px;width: 20%;color: red">100</label>
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 20%">Total Mts to be given</label>
												<input type="text" class="form-control" style="width: 20%">
											</div>

											<div class="col-sm-12" style="margin-bottom: 10px">
												<br>
												<button type="submit" class="btn btn-sm btn-primary text-white" >Save</button>
												<button type="button" class="btn btn-sm btn-primary text-white" >Modify Bill</button>
												<button type="button" class="btn btn-sm btn-primary text-white" >Add New</button>
											</div>

										</div>

									</div>
									<div class="col-sm-6">
										<div class="table-responsive" style="border-style: double;height:650px;position:relative;" id="barcodeBlock">
											<table class="table table-sm">
												<thead>
												<tr>
													<th>Sr.No</th>
													<th>Select</th>
													<th>Order No</th>
													<th>Barcode</th>
													<th>Is with comment</th>
													<th>Gender</th>
												</tr>
												</thead>
												<tbody id="barCodeContent" >
												<tr>
													<td>1</td>
													<td><input type="checkbox"></td>
													<td>#20254</td>
													<td>9024540</td>
													<td>Yes</td>
													<td>Male</td>
												</tr>

												</tbody>
											</table>
										</div>
										<div style="margin-top: 15px;text-align: center;" id="barcodeBlock" class="hide-div">
											<button type="button" class="btn btn-sm btn-primary text-white" id="bulkItemLoad">Bulk Item Load</button>
											<button type="button" class="btn btn-sm btn-primary text-white" id="closeButton">Close</button>
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
						text : 'Select Customer',
					}));

					for(var i=0;i<obj.length;i++)
					{
						$('select#customer').append($('<option/>', {
							value: obj[i]['name'],
							text : obj[i]['name']
						}));
					}
				}
			});
		});

		$(document).on('change', 'select#customer', function() {
			var customerName         =$(this).val();
			getAuthorizationsCode($(this).val(),$('select#company_name').val());
		});

		function getAuthorizationsCode(customerName,companyName) {

			if (customerName && companyName){
				var url = "<?php echo base_url('BillGeneration/getAuthorizationBillingCode'); ?>";

				var post_data = {
					'customerName': customerName,
					'companyName': companyName,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{

						var obj = JSON.parse(result);
						if (obj.length>0) {
							$('select#coderNumber').find('option').remove();
							$('select#coderNumber').append($('<option/>', {
								value: '0',
								text: 'Select Code Number'
							}));

							for (var i = 0; i < obj.length; i++) {
								$('select#coderNumber').append($('<option/>', {
									value: obj[i]['unique_code'],
									text: obj[i]['unique_code']
								}));
							}
						}
					}
				});
			}
		}

		$(document).on('change', 'select#coderNumber', function() {
			var prefix =$(this).val();

			var url = "<?php echo base_url('BillGeneration/getItemName'); ?>";

			var post_data = {
				'prefix': prefix,
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
					$('select#item_name').addClass('add-authorizations-item');
					$('select#item_name').append($('<option/>', {
						value: '0',
						text : 'Select Item Name'
					}));

					for(var i=0;i<obj.length;i++)
					{
						$('select#item_name').append($('<option/>', {
							value: obj[i]['item_id'],
							text :obj[i]['item_name'],
							dataigst :0,
							dataItemName : obj[i]['item_name'],
							codegenerationsid: obj[i]['code_generations_id'],
						}));
					}
				}
			});
		});

	</script>
</body>
</html>
