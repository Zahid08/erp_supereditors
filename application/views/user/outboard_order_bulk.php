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
		border: 1px solid white!important;
		background: white!important;
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
		line-height: 10px!important;
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
	.disable{
		pointer-events: none;
		background: #80808030
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
			<form method="post" action = "<?php echo base_url() ?>BillGeneration/save_data" id="billgeneratedForm">
				<section id="po_section" name="po_section">
					<div id="customerform" class="collapse in">
						<div class="card">
							<div class="card-body">
								<center>
									<p style="color:green"><?php echo $this->session->flashdata('message') ?></p>
								</center>
								<h5 class="card-title">Outboard Order Bulk <span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
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

											<!--<div class="col-sm-4">
												<small>Allocation No.</small>-->
												<input type="hidden" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="<?=$chalanNumber?>">
											<!--</div>-->
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
												<select class="form-control" name="karigar_name" id="karigar_name">
													<?php foreach ($karigarMaster as $key=>$value): ?>
													<option value="<?=$value->id?>"><?=$value->name?></option>
													<?php endforeach; ?>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Karigar Type</small>
												<select class="form-control disable" id="karigar_type" name="karigar_type" required="" >
													<option value="">Select Karigar Type</option>
													<option value="cutter_master">Cutter Master</option>
													<option value="worker_master">Worker Master</option>
													<option value="embroidery_master">Embroidery Master</option>
													<option value="pressing_master">Pressing Master</option>
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
												<select class="form-control" name="item_name" id="item_name" required="">
													<option value="">Select Item Name</option>
												</select>
											</div>

											<div class="col-sm-12" style="margin-top: 20px;">
												<h6>Approximate Fabric Details Required</h6>
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 20%">Mts Reqd for Gents</label>
												<input type="text" class="form-control" style="width: 20%" id="gensResultTotal" name="gens_qty_total" readonly>
												<label style="margin-right: 5px;margin-left:5px;width: 1%">X</label>
												<input type="text" class="form-control" style="width: 20%;margin-right: 5px;margin-left:5px;" id="gens_price" name="gens_price">
												<label style="margin-right: 5px;margin-left:5px;width: 1%;font-weight: 600;font-size: medium;">=</label>
												<input type="text" class="form-control" style="width: 20%" id="gensGrandTotal" name="gensGrandTotal"> 
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 20%">Mts Reqd for Ladies</label>
												<input type="text" class="form-control" style="width: 20%" id="ladiesResultTotal" name="ladies_qty_total" readonly>
												<label style="margin-right: 5px;margin-left:5px;width: 1%">X</label>
												<input type="text" class="form-control" style="width: 20%;margin-right: 5px;margin-left:5px;" id="ladies_price" name="ladies_price">
												<label style="margin-right: 5px;margin-left:5px;width: 1%;font-weight: 600;font-size: medium;">=</label>
												<input type="text" class="form-control" style="width: 20%" id="ladiesGrandTotal" name="ladiesGrandTotal">
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 25%">Total Barcodes Allocated</label>
												<label style="margin-right: 10px;width: 20%;color: red"><span id="checkedCount">0</span></label>
											</div>

											<div class="col-md-12" style="display: flex;margin-top: 10px;">
												<label style="margin-right: 10px;width: 20%">Total Mts to be given</label>
												<input type="text" class="form-control" style="width: 20%" id="grandTotal" name="grandTotal">
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
													<th style="border: 1px solid gray">Sr.No</th>
													<th style="border: 1px solid gray"><input type="checkbox" style="=" id="checkall"  class=""></th>
													<th style="border: 1px solid gray">Order No</th>
													<th style="border: 1px solid gray">Item Name</th>
													<th style="border: 1px solid gray">Quantity</th>
													<th style="border: 1px solid gray">Gender</th>
													<th style="border: 1px solid gray">Mesurement</th>
													<th style="border: 1px solid gray">Remark</th>
												</tr>
												</thead>
												<tbody id="getCodeGenerationLeftBlock" >
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


		/*-----Get Karigar Name---------------*/
		$(document).on('change', 'select#karigar_name', function() {
			var karigarId=$(this).val();

			var post_data = {
				'karigarId': karigarId,
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
			};

			var url = "<?php echo base_url();?>OutboardOrderBulk/getKarigarName";

			$.ajax({
				url : url,
				type : 'POST',
				data: post_data,
				success : function(result)
				{
					$('select#karigar_type').val(result).trigger('change');
					$('select#cuttingProcess').val(result).trigger('change');
				}
			});
		});

		/*----CUstomer WIse Code-------*/
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

		/*--------Code Number Wise Get Item Name--------*/
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
							dataName:obj[i]['item_name'],
						}));
					}
				}
			});
		});

		/*---------Load Item Wise Authorize Data-----------*/
		var countCalling=0;
		$(document).on('change', 'select#item_name', function() {
			var startUp         	     =$('select#coderNumber').find(':selected').attr('datastartUp');
			var dataEndOFCode            =$('select#coderNumber').find(':selected').attr('dataEndOFCode');
			var prefix					=$('select#coderNumber').val();
			var karigar_type            =$('select#karigar_type').val();
			var karigar_name            =$('select#karigar_name').val();
			var codeGenerationsId     =$('select#coderNumber').find(':selected').attr('dataCodegenrationsId');
			$('tbody#getCodeGenerationLeftBlock').html('');

			var url = "<?php echo base_url('CodeGeneration/getMesurementInfo'); ?>";

			var post_data = {
				'prefix': prefix,
				'startUp': startUp,
				'dataEndOFCode': dataEndOFCode,
				'codeGenerationsId': codeGenerationsId,
				'karigar_type': karigar_type,
				'karigar_name':karigar_name,
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
						var itemName     =$('select#item_name').find(':selected').attr('dataname');
						$.each(obj, function (index,value) {
							var className='odd';
							if (index%2==0){
								className='even';
							}
							let isWithComment="No";
							if (value.remark!=''){
								isWithComment='Yes';
							}
							let mrp=value.ladies_rate;
							let quantity=value.ladies_qty;
							if (value.gender=='Male'){
								mrp=value.gens_rate;
								quantity=value.gens_qty
							}
							++index;

							html +=`<tr role="row" class="`+className+`" data-authorizationsid="`+value.id+`">
									   <input type="hidden" class="form-control" name="AuthorizationsItem[`+index+`][authorizationId]" id="auth" placeholder="" value="`+value.authorizationId+`">
									   <input type="hidden" class="form-control" name="AuthorizationsItem[`+index+`][id]" id="authorizationId" placeholder="" value="`+value.id+`">
										<td style="border: 1px solid gray" class="sorting_1">`+index+`</td>
										<td style="border: 1px solid gray">
											<input type="checkbox"  name="AuthorizationsItem[`+index+`][authorization_status]" data-index="`+index+`" data-quantity="`+quantity+`" data-gender="`+value.gender+`"  id="authorizations" class="cb-element" value="`+mrp+`">
										</td>
										<td style="border: 1px solid gray" id="uniqueCodeTd">
											<input type="text" class="form-control disabled-options" name="AuthorizationsItem[`+index+`][unique_code]" id="unique_code" placeholder="" value="`+value.unique_code+`" >
										</td>
										<td style="border: 1px solid gray" id="itemName">
											<input type="text" class="form-control disabled-options item_name_`+index+`" name="AuthorizationsItem[`+index+`][item_name]" id="uniqueNameText" placeholder="" value="`+itemName+`" >
										</td>
										<td style="border: 1px solid gray" id="mesurementQtyOptions">
										<input type="text" class="input_mesurement_qty_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mesurement_qty]" id="mesurementQty" placeholder="" value="`+quantity+`" >
										</td>
										<td style="border: 1px solid gray" id="genderName">
											<input type="text" class="form-control disabled-options gender_`+index+`" name="AuthorizationsItem[`+index+`][gender]" id="genderText" placeholder="" value="`+value.gender+`">
										</td>
										<td style="border: 1px solid gray" id="mesurements"><input type="text" class="input_mesurement_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mesurement]" id="mesurementData" placeholder="" value="`+value.mesurement+`" ></td>
										<!--<td style="border: 1px solid gray" id="itemName">-->
											<input type="hidden" class="form-control disabled-options mrp_`+index+`" name="AuthorizationsItem[`+index+`][mrp]" id="uniqueNameText" placeholder="" value="`+mrp+`">
										<!--</td>-->
										<td style="border: 1px solid gray" id="mesurementsRemark"><input type="text" class="input_mesurement_remark_`+index+` form-control disabled-options" name="AuthorizationsItem[`+index+`][mesurement_remark]" id="mesurementRemark" placeholder="" value="`+value.remark+`" ></td>

									 </tr>`;
						});

						$('tbody#getCodeGenerationLeftBlock').html(html);
						countCalling++;
						clickEvent();

					}
				},error: function (){
					alert("Something went wrong")
				}
			});
		});

		$(document).on('change', '#checkall', function() {
			$('.cb-element').trigger('click');
		});

		$(document).on('change', '.cb-element', function() {
			if ($('.cb-element:checked').length == $('.cb-element').length) {
				$('#checkall').prop('checked', true);
			} else {
				$('#checkall').prop('checked', false);
			}
		});

		var checkedCount = 0;
		$(document).on('click', 'input.cb-element', function () {
			let mrp			    =$(this).val();
			let gender		    =$(this).data('gender');
			let quantity		=$(this).data('quantity')||0;
			
			var index=$(this).data('index');
			if($(this).prop("checked") == true){
				if (gender=='Male'){
					let genQty = parseInt($('input#gensResultTotal').val()) || 0;
					var finalQty = genQty + parseInt(quantity);
					$('input#gensResultTotal').val(finalQty);

					$(document).on('input', '#gens_price', function() {
						var gensPriceValue = parseFloat($(this).val());
						var finalResultGens = finalQty * gensPriceValue;
						$('input#gensGrandTotal').val(finalResultGens);
					});
				}else{
					let ladiesQty = parseInt($('input#ladiesResultTotal').val()) || 0;
					var finalladiesQty = ladiesQty + parseInt(quantity);
					$('input#ladiesResultTotal').val(finalladiesQty);

					$(document).on('input', '#ladies_price', function() {
						var gensPriceValue = parseFloat($(this).val());
						var finalResultladies=finalladiesQty*gensPriceValue;
						$('input#ladiesGrandTotal').val(finalResultladies);
					});

				}
				checkedCount++;
			}else if($(this).prop("checked") == false){

				if (gender=='Male'){
					let genQty = parseInt($('input#gensResultTotal').val()) || 0;
					var finalQty = genQty - parseInt(quantity);
					$('input#gensResultTotal').val(finalQty);

					$(document).on('input', '#gens_price', function() {
						var gensPriceValue = parseFloat($(this).val());
						var finalResultGens = finalQty * gensPriceValue;
						$('input#gensGrandTotal').val(finalResultGens);
					});

				}else{
					let ladiesQty = parseInt($('input#ladiesResultTotal').val()) || 0;
					var finalladiesQty = ladiesQty - parseInt(quantity);
					$('input#ladiesResultTotal').val(finalladiesQty);

					$(document).on('input', '#ladies_price', function() {
						var gensPriceValue = parseFloat($(this).val());
						var finalResultladies=finalladiesQty*gensPriceValue;
						$('input#ladiesGrandTotal').val(finalResultladies);
					});
				}
				checkedCount--;
			}
			
			$('#checkedCount').text(checkedCount); 
		});

		$(document).on('input', function() {
			var gensValue = parseFloat($('input#gensGrandTotal').val());
			var ladiesValue = parseFloat($('input#ladiesGrandTotal').val());
			var gens = isNaN(gensValue) ? 0 : gensValue;
			var ladies = isNaN(ladiesValue) ? 0 : ladiesValue;
			var finalResult=gens + ladies;
			$('input#grandTotal').val(finalResult);
		});
	</script>
</body>
</html>
