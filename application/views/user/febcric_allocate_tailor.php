
<?php
$karigarMaster = $this->db->query("SELECT id,name FROM karigar_master")->result();
$brand = $this->db->query("SELECT brand_id,brand_name FROM brand")->result();
$OrderBulk_id = $this->input->get('OrderBulk_id');
$orderDetails = $this->db->query("SELECT * FROM allocate_order WHERE allocated_order_id = $OrderBulk_id")->result();

foreach($orderDetails as $value)
{
	$challan_no = $value->chalan_number;
	$company_name = $value->company_name;
	$karigar_name = $this->db->query("SELECT k.name as karigar_name FROM karigar_master k LEFT JOIN allocate_order a ON a.karigar_name = k.id WHERE a.karigar_name = $value->karigar_name")->row()->karigar_name;
	$party_name =$value->customer;
	$challan_date = $value->billing_date;
	$total_gens = $value->gensGrandTotal;
	$total_ladies = $value->ladiesGrandTotal;
	$total = $value->grandTotal;
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
			<form method="post" action = "<?php echo base_url() ?>BillGeneration/febric_save_data" id="billgeneratedForm">
				<section id="po_section" name="po_section">
					<div id="customerform" class="collapse in">
						<div class="card">
							<div class="card-body">
								<center>
									<p style="color:green"><?php echo $this->session->flashdata('message') ?></p>
								</center>
								<h5 class="card-title">Febric Allocate To Tailor<span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
								<div class="row">
									<div class="col-sm-6">
										<div class="row" style="border-style: ridge;margin-left: 1px;">
											<div class="col-sm-4">
												<small>Company Name</small>
												<input type="text" class="form-control" name="company_name" id="company_name" placeholder="company_name." value="<?php echo $company_name; ?>" readonly>
											</div>
											<div class="col-sm-4">
												<small>Challan No.</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="<?php echo $challan_no; ?>" readonly>
											</div>
											<div class="col-sm-4">
												<small>Challan Date</small>
												<input type="date" class="form-control" name="bill_date" id="bill_date" value="<?php echo $challan_date?>" readonly>
											</div>

											<div class="col-sm-4">
												<small>Party Name</small>
												<input type="text" class="form-control" name="party_name" id="party_name" placeholder="Party Name."  value="<?php echo $party_name; ?>" readonly>
											</div>

											<div class="col-sm-4">
												<small>Karigar Name</small>
												<input type="text" class="form-control" name="karigar_name" id="karigar_name" placeholder="karigar_name." value="<?php echo $karigar_name; ?>" readonly>
											</div>

											<div class="col-sm-4">
												<small>Allocate Order No.</small>
												<input type="text" class="form-control" name="allocate_no" id="allocate_no" placeholder="Allocate order number."  value="<?php echo $OrderBulk_id; ?>" readonly>
											</div>

											<div class="col-sm-12" style="margin-top: 20px;">
												<h6>Total Calculation</h6>
											</div>

											<div class="col-sm-6">
												<small>Total Gents MTS</small>
												<input type="text" class="form-control" name="total_gents_mts" id="total_gents_mts" placeholder="Total gents mts."  value="<?php echo $total_gens; ?>" readonly>
											</div>

											<div class="col-sm-6">
												<small>Ladeis MTS</small>
												<input type="text" class="form-control" name="ladies_mts" id="ladies_mts" placeholder="Ladies mts."  value="<?php echo $total_ladies; ?>"readonly>
											</div>

											<div class="col-sm-6">
												<small>Total Order MTS</small>
												<input type="text" class="form-control" name="total_order_mts" id="total_order_mts" placeholder="Total Order mts."  value="<?php echo $total; ?>"readonly>
											</div>

											<div class="col-sm-6">
											</div>

											<div class="col-sm-6">
												<small>Already allocated</small>
												<input type="text" class="form-control" name="already_allocated" id="already_allocated" placeholder="Already allocated."  value="">
											</div>

											<div class="col-sm-6">
												<small>Bal to allocated</small>
												<input type="text" class="form-control" name="bal_to_allocate" id="bal_to_allocate" placeholder="Bal to allocated."  value="">
											</div>

											<div class="col-sm-6">
												<small>Brand Name</small>
												<select class="form-control" name="brand_name" id="brand_name" required>
													<option value="">Select Brand Name</option>
													<?php foreach ($brand as $key=>$value): ?>
													<option value="<?=$value->brand_id?>"><?=$value->brand_name?></option>
													<?php endforeach; ?>
												</select>
											</div>

											<div class="col-sm-6">
												<small>Febric Name</small>
												<select class="form-control" name="febric_name" id="febric_name" required>
													<option value="">Select Febric Name</option>
												</select>
											</div>

											<div class="col-sm-6">
												<small>Total Tagas</small>
												<input type="text" class="form-control" name="total_tags" id="total_tags" placeholder="Total Tags."  value="">
											</div>
											<div class="col-sm-6"></div>

											<div class="col-sm-6">
												<small>Total MTS</small>
												<input type="text" class="form-control" name="total_mts" id="total_mts" placeholder="Total mts."  value="">
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
										<div class="table-responsive" style="border-style: double;height:520px;position:relative;" id="barcodeBlock">
											<table class="table table-sm">
												<thead>
												<tr>
													<th style="border: 1px solid gray">Sr.No</th>
													<th style="border: 1px solid gray"><input type="checkbox" style="=" id="checkall"  class=""></th>
													<th style="border: 1px solid gray">Barcode</th>
													<th style="border: 1px solid gray">Febric Name</th>
													<th style="border: 1px solid gray">Shade</th>
													<th style="border: 1px solid gray">MTS</th>
												</tr>
												</thead>
												<tbody id="barCodeContent" >
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

				/*--------Brand Wise Get Febric Name--------*/
				$(document).on('change', 'select#brand_name', function() 
				{
					var brandId =$(this).val();

					var url = "<?php echo base_url('OutboardOrderBulk/get_febric_name'); ?>";

					var post_data = {
						'brandId': brandId,
					};
					$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
						var obj = JSON.parse(result);
						$('select#febric_name').find('option').remove();
						$('select#febric_name').append($('<option/>', {
							value: '',
							text : 'Select Febric Name',
						}));

						for(var i=0;i<obj.length;i++)
						{
							$('select#febric_name').append($('<option/>', {
								value: obj[i]['fabric_name'],
								text : obj[i]['fabric_name']
							}));
						}
					}
				});
			});

			/*---------brand Item Wise Febric Data-----------*/
		var countCalling=0;
		
		$(document).on('change', 'select#febric_name', function() {
			var startUp         	     =$('select#brand_name').find(':selected').attr('datastartUp');
			var dataEndOFCode            =$('select#brand_name').find(':selected').attr('dataEndOFCode');
			var prefix					=$('select#brand_name').val();

			var brandId=$('select#brand_name').find(':selected').attr('dataCodegenrationsId');
	
			$('tbody#barCodeContent').html('');

			var url = "<?php echo base_url('CodeGeneration/getfebricInfo'); ?>";
			var post_data = {
				'prefix': prefix,
				'startUp': startUp,
				'dataEndOFCode': dataEndOFCode,
				'brandId': brandId,
				'febric': $(this).val(),
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
			};

			var html='';

			$.ajax({
				url : url,
				type : 'POST',
				data:post_data,
				success : function(result)
				{  console.log(result)
					if (result){
						var obj = JSON.parse(result);
						var febric_name=$('select#febric_name').find(':selected').attr('dataname');
						$.each(obj, function (index,value) {
							var className='odd';
							if (index%2==0){
								className='even';
							}
							let isWithComment="No";
							if (value.remark!=''){
								isWithComment='Yes';
							}
							let mtp=value.ladies_rate;
							if (value.gender=='Male'){
								mtp=value.gens_rate;
							}
							++index;
							html +=`<tr role="row" class="`+className+`" data-authorizationsid="`+value.id+`">
									   <input type="hidden" class="form-control" name="Item[`+index+`][code_generations_id]" id="auth" placeholder="" value="`+value.code_generations_id+`">
										<td style="border: 1px solid gray" class="sorting_1">`+index+`</td>
										<td style="border: 1px solid gray">
											<input type="checkbox"  name="Item[`+index+`][febric_status]" data-index="`+index+`" data-febric="`+value.item_febrics+`" data-shade="`+value.color_code+`"  id="authorizations" class="cb-element" value="`+mtp+`">
										</td>
										<td style="border: 1px solid gray" id="barcode">
											<input type="text"  class="form-control" name="Item[`+index+`]" id="barcode" placeholder="" " >
										</td>
										<td style="border: 1px solid gray" id="febric_name">
											<input type="text" class="form-control" febric_name_`+index+`" name="Item[`+index+`][item_febrics]" id="febricNameText" placeholder="" value="`+value.item_febrics+`" >
										</td>
										<td style="border: 1px solid gray" id="shade">
											<input type="text" class="form-control" shade_`+index+`" name="Item[`+index+`][color_code]" id="shadeText" placeholder="" value="`+value.color_code+`">
										</td>
										<td style="border: 1px solid gray" id="febric_name">
											<input type="hidden" class="form-control" mrp_`+index+`" name="Item[`+index+`][mtp]" id="febricNameText" placeholder="" value="`+mtp+`">
										</td>

									 </tr>`;
						});

						$('tbody#barCodeContent').html(html);
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

	</script>
</body>
</html>
