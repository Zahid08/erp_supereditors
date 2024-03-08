<?php
$customerDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1")->result();
$itemDetails = $this->db->query("SELECT * FROM items WHERE item_type_id = 2 and is_active = 1")->result();
$itemDetailsFebrics = $this->db->query("SELECT * FROM items WHERE item_type_id = 3 and is_active = 1")->result();
$patternList = $this->db->query("SELECT * FROM patterns WHERE is_active = 1")->result();
$brandDetails = $this->db->query("SELECT * FROM brand WHERE is_active = 1")->result();
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
    input#gensQty,input#gensRate,input#ladiesRate,input#ladiesRate,input#itemName,input#febricsItem,input#patternType{
        pointer-events: none;
    }
    input#generatedStatus {
        height: 14px;
        margin-top: 5px;
    }
	.table>thead>tr>th, .table>tbody>tr>td{
		cursor: pointer;
	}
	div#itemOptions table{
		border: 1px solid gray;
	}
	div#itemOptions tbody {
		display: block;
		height: 100px;
		overflow: auto;
	}

	div#itemOptions thead, div#itemOptions tbody tr {
		display: table;
		width: 100%;
		table-layout: fixed;/* even columns width , fix width of table too*/
	}
	div#itemOptions thead {
		/*width: calc( 100% - 1em )!* scrollbar is average 1em/16px width, remove it from thead width *!*/
	}

	/* scrollbar design */
	/* width */
	::-webkit-scrollbar {
		width: 5px;
		right: 10px;
	}

	/* Track */
	::-webkit-scrollbar-track {
		box-shadow: none;
		border-radius: 10px;
	}
	/* Handle */
	::-webkit-scrollbar-thumb {
		background: #E3E3E3;
		border-radius: 10px;
	}
	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
		background: #dfdfdf;
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
	select.error,input.error {
		border: 1px solid red;
	}

    tr#editRows:hover {
        background: #ca257361;
        color: white;
    }

    /*input#printing_status {*/
    /*    width: 24px;*/
    /*}*/
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
            <form method="post" action = "<?php echo base_url() ?>CodeGeneration/save_code_data" id="codegeneratedForm">
            <section id="po_section" name="po_section">
                <div id="customerform" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('message') ?></p>
                            </center>
                            <h5 class="card-title">Code Generation <span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
                            <div class="row">
                                <div class="col-sm-7">
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
                                                <small>Prefix For Unique Code</small>
                                                <input type="text" class="form-control" name="prefix" id="prefix" placeholder="prefix" required>
                                            </div>

                                            <div class="col-sm-4">
                                                <small>Order Date</small>
                                                <input type="date" class="form-control" name="order_date" id="order_date" value="<?php echo date("Y-m-d") ?>"   required>
                                            </div>

                                            <div class="col-sm-4">
                                                <small>Delivery Date</small>
                                                <input type="date" class="form-control" name="delivery_date" id="delivery_date" value="<?php echo date("Y-m-d") ?>"   required>
                                            </div>

                                            <div class="col-sm-4">
                                                <small>Number Of Codes Generations</small>
                                                <input type="text" class="form-control" name="number_of_code_generations" id="number_of_code_generations" placeholder="Number of codes" required>
                                            </div>

                                            <div class="col-sm-8">
                                                <small>Order No.</small>
                                                <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No" required>
                                            </div>

                                            <div class="col-sm-4">
                                                <small>Number Starts Form</small>
                                                <input type="text" class="form-control" name="number_starts_form" id="number_starts_form" placeholder="Number Starts Form" required>
                                            </div>

                                            <div class="col-sm-4 mt-2">
                                                <small>Item Name</small>
                                                <select class="form-control" name="item_name" id="item_name">
                                                    <option value="">Select Item Name</option>
                                                    <?php foreach($itemDetails as $getitemDetails){ ?>
                                                        <option value="<?php echo $getitemDetails->item_id ?>" dataigst="<?=$getitemDetails->igst?>" dataItemName="<?php echo $getitemDetails->item_name  ?>"><?php echo $getitemDetails->item_name  ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-sm-4 mt-2">
												<small>Patterns</small>
												<select class="form-control" name="patterns_type" id="patterns_type">
													<option value="">Select Patterns</option>
													<?php if ($patternList): foreach ($patternList as $key=>$item):?>
														<option value="<?=$item->pattern_type.' '.$item->pattern_name?>"><?=$item->pattern_type.' '.$item->pattern_name?></option>
													<?php endforeach;endif;?>
												</select>
											</div>
											

                                            <div class="col-sm-3" style=" margin-top: 7px;">
												<small>Logo & Printing</small>
												<input type="text" class="form-control" name="logo_and_printing" id="logo_and_printing" placeholder="Logo & Printing">
											</div>

											<div class="col-sm-1" style="margin-top: 7px;text-align: center;padding:0">
												<small>Yes/No</small>
												<input type="checkbox" class="form-control" name="printing_status" id="printing_status" placeholder="Logo & Printing Status" value="1">
											</div>


                                            <div class="col-sm-3 mt-2">
                                                <small>Gens Qty.</small>
                                                <input type="text" class="form-control" name="gens_qty" id="gens_qty" placeholder="Gens Qty">
                                            </div>
                                            <div class="col-sm-3 mt-2">
                                                <small>Rate.</small>
                                                <input type="text" class="form-control" name="gens_rate" id="gens_rate" placeholder="Rate">
                                            </div>

                                            <div class="col-sm-3 mt-2">
                                                <small>Ladies Qty.</small>
                                                <input type="text" class="form-control" name="ladies_qty" id="ladies_qty" placeholder="Ladies Qty">
                                            </div>

                                            <div class="col-sm-3 mt-2">
                                                <small>Rate.</small>
                                                <input type="text" class="form-control" name="ladies_rate" id="ladies_rate" placeholder="Rate">
                                            </div>


											<div class="col-sm-4 mt-2">
												<small>Brand Name</small>
												<select class="form-control" name="brand_name" id="brand_name">
													<option value="">Select Brand</option>
													<?php foreach($brandDetails as $getbrandDetails){ ?>
														<option value="<?php echo $getbrandDetails->brand_id ?>"><?php echo $getbrandDetails->brand_name  ?></option>
													<?php } ?>
												</select>
											</div>

											<div class="col-sm-4 mt-2">
												<small>Febrics Item</small>
												<select class="form-control" name="item_febrics" id="item_febrics">
													<option value="">Select Item name</option>
													<?php foreach($itemDetailsFebrics as $getitemDetails){ ?>
														<option value="<?php echo $getitemDetails->item_id ?>" dataigst="<?=$getitemDetails->igst?>" dataItemName="<?php echo $getitemDetails->item_name  ?>"><?php echo $getitemDetails->item_name  ?></option>
													<?php } ?>
												</select>
											</div>

											<div class="col-sm-2 mt-2">
												<small>Color Code.</small>
												<input type="text" class="form-control" name="color_code" id="color_code" placeholder="Color Code">
											</div>

                                            <div class="col-sm-2" style="padding: 0;margin-top: 30px;">
                                                <button type="button" class="btn btn-sm btn-primary text-white"  id="addCodesInList">Add In List</button>
                                            </div>

                                            <div class="col-sm-12" id="itemOptions">
                                                <table class="table table-sm" style="margin-top: 20px;">
                                                    <thead>
                                                    <tr>
                                                        <th>SR NO</th>
                                                        <th>Item Name</th>
                                                        <th>Gens Qty</th>
                                                        <th>Gens Rate</th>
                                                        <th>Ladies Qty</th>
                                                        <th>Ladies Rate</th>
                                                        <th>Generated</th>
                                                        <th>Febrics</th>
                                                        <th>Pattern</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="getCodeGenerationLeftBlock" >
                                                    </tbody>
                                                </table>
                                            </div>


                                            <div class="col-sm-12" style="margin-top: 20px;">
                                                <small>Remark</small>
                                                <input type="text" class="form-control" name="remark" id="remark" placeholder="Remark" >
                                            </div>

                                            <div class="col-sm-12" style="margin-bottom: 10px">
                                                <br>
                                                <button type="submit" class="btn btn-sm btn-primary text-white submit-btn" >Save</button>
                                            </div>

                                        </div>
                                </div>


                                <div class="col-sm-5">
                                    <div class="table-responsive" style="border-style: double;height:648px;" id="reportBlock">
                                        <table class="table table-sm">
                                            <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th>Company Name</th>
                                                <th>Order No.</th>
                                                <th>Pref.</th>
                                                <th>Code Range</th>
                                            </tr>
                                            </thead>
                                            <tbody id="codeGenrationsBody">
                                            <?php
                                            if ($generatedCode){

                                                foreach ($generatedCode as $key=>$item){
                                                	$endedData=$item->number_starts_form+$item->number_of_code_generations-1;
                                                	?>
                                                    <tr id="editRows" data-id="<?=$item->code_generations_id?>">
                                                        <td><?=$item->customer_name?></td>
                                                    <td class="company_name_clickable"><?=$item->company_name?></td>
                                                    <td><?=$item->order_no?></td>
                                                    <td><?=$item->prefix?></td>
                                                    <td><?=$item->prefix.'-'.$item->number_starts_form.' to '.$item->prefix.'-'.$endedData?></td>
                                                    </tr>
                                                   <?php }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
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

			$(document).on('change', 'select#brand_name', function() {
				var brandId=$(this).val();

				var post_data = {
					'id': brandId,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				var url = "<?php echo base_url();?>Items/getitem_name";

				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
						var obj = JSON.parse(result);
						$('select#item_febrics').find('option').remove();
						$('select#item_febrics').append($('<option/>', {
							value: '',
							text : 'Select Item Name'
						}));

						console.log(obj);

						for(var i=0;i<obj.length;i++)
						{
							$('select#item_febrics').append($('<option/>', {
								value: obj[i]['fabric_id'],
								text : obj[i]['fabric_name'],
								dataItemName :obj[i]['fabric_name'],
							}));
						}
					}
				});
			});


            var successImage    ='<?php echo base_url(); ?>assets/alert_image/success.svg';
			var warning    ='<?php echo base_url(); ?>assets/alert_image/warning.svg';

            /*-------Add Calcualtions functionality---------------*/
            var indexOfCodeGenerations = $('tbody#getCodeGenerationLeftBlock tbody tr').length;

			function validateItemAddingList(){
				var errorCount="";

				var itemId                  = $('select#item_name').val();
				var gensQty                 = $('input#gens_qty').val();
				var gensRate                = $('input#gens_rate').val();
				var ladiesQty               = $('input#ladies_qty').val();
				var ladiesRate              = $('input#ladies_rate').val();
				var febricsitem             = $('select#item_febrics').find(':selected').attr('dataItemName');
				var pattern                =$('select#patterns_type').find(':selected').attr('dataPatternName')||'';
				var colorCode				=$('input#color_code').val();
				var brandname				=$('select#brand_name').val();


				if (itemId==="" || itemId==='undefined'){
					errorCount=1;
					$('select#item_name').addClass("error");
				}else{
					$('select#item_name').removeClass("error");
				}

				if (gensQty==="" || gensQty==='undefined'){
					errorCount=1;
					$('input#gens_qty').addClass("error");
				}else{
					$('input#gens_qty').removeClass("error");
				}

				if (gensRate==="" || gensRate==='undefined'){
					errorCount=1;
					$('input#gens_rate').addClass("error");
				}else{
					$('input#gens_rate').removeClass("error");
				}

				if (ladiesQty==="" || ladiesQty==='undefined'){
					errorCount=1;
					$('input#ladies_qty').addClass("error");
				}else{
					$('input#ladies_qty').removeClass("error");
				}

				if (ladiesRate==="" || ladiesRate==='undefined'){
					errorCount=1;
					$('input#ladies_rate').addClass("error");
				}else{
					$('input#ladies_rate').removeClass("error");
				}

				if (pattern==="" || pattern==='undefined'){
					errorCount=1;
					$('select#patterns_type').addClass("error");
				}else{
					$('select#patterns_type').removeClass("error");
				}

				if (brandname==="" || brandname==='undefined'){
					errorCount=1;
					$('select#brand_name').addClass("error");
				}else{
					$('select#brand_name').removeClass("error");
				}

				return errorCount;
			}

            $(document).on('click', 'button#addCodesInList', function() {
				if (validateItemAddingList()=="") {
					addCodesInlist();
				}
            });

            function addCodesInlist() {
                var companyName             = $('select#company_name').val();
                var itemId                  = $('select#item_name').val();
                var ItemName                =$('select#item_name').find(':selected').attr('dataItemName');
                var orderDate               = $('input#order_date').val();
                var OrderNumber             = $('input#order_no').val();
                var customerId              =$('option:selected','select#customer').data("customer-id");
                var customerName            = $('input#customer').val();
                var gensQty                 = $('input#gens_qty').val();
                var gensRate                = $('input#gens_rate').val();
                var ladiesQty               = $('input#ladies_qty').val();
                var ladiesRate              = $('input#ladies_rate').val();
                var febricsitem              = $('select#item_febrics').find(':selected').attr('dataItemName');
				var pattern                =$('select#patterns_type').find(':selected').attr('dataPatternName')||'';

                var colorCode				=$('input#color_code').val();
                var brandname				=$('select#brand_name').val();

				var logo_and_printing        = $('input#logo_and_printing').val();
			
				var printing_status="";
				if ($("input:checkbox[name=printing_status]:checked").is(":checked"))
				{
					printing_status="1";
				}

                var newSr                    =indexOfCodeGenerations+1;

                var html = `<tr>
                                <th ><input type="hidden" value="`+itemId+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][itemId]">
								<input type="hidden" value="`+printing_status+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][printing_status]"><input type="hidden" value="`+logo_and_printing+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][logo_and_printing]"><input type="hidden" value="`+colorCode+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][colorCode]"><input type="hidden" value="`+brandname+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][brandName]"><input type="hidden" value="" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][codeGenerationsItemId]" id="codeGenerationsItemId"><input type="text" value="`+newSr+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][IndexRow]" class="form-control hide-input-field ordernumber-event IndexRow-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="IndexRow"></th>
                                <th ><input type="text" value="`+ItemName+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][itemName]" class="form-control hide-input-field ordernumber-event itemName-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="itemName"></th>
                                <td><input type="text" value="`+gensQty+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][gensQty]" class="form-control hide-input-field itemname-event gensQty-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="gensQty"></td>
                                <td><input type="text" value="`+gensRate+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][gensRate]" class="form-control hide-input-field barcode-event gensRate-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="gensRate"></td>
                                <td><input type="text" value="`+ladiesQty+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][ladiesQty]" class="form-control hide-input-field stock-event ladiesQty-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="ladiesQty"></td>
                                <td><input type="text" value="`+ladiesRate+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][ladiesRate]" class="form-control hide-input-field rate-price ladiesRate-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="ladiesRate"></td>
                                <td><input type="checkbox" checked value="1" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][generatedStatus]" class="form-control hide-input-field discount-event generatedStatus-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="generatedStatus"></td>
                                <td><input type="text" value="`+febricsitem+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][febricsItem]" class="form-control hide-input-field discount-event febricsItem-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="febricsItem"></td>
                                <td><input type="text" value="`+pattern+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][patternType]" class="form-control hide-input-field discount-event patternTypeItem-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="patternType"></td>
                            </tr>`;

                $('tbody#getCodeGenerationLeftBlock').append(html);

                resetAllfield();
                indexOfCodeGenerations++;

            }

            function resetAllfield(){
                $('select#patterns_type').val('').trigger('change');
                $('select#brand_name').val('').trigger('change');
                $('select#item_name').val('').trigger('change');
                $('input#gens_qty').val('');
                $('input#gens_rate').val('');
                $('input#ladies_qty').val('');
                $('input#ladies_rate').val('');
                $('input#color_code').val('');
            }


            // this is the id of the form
            $("form#codegeneratedForm").submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var actionUrl = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(result)
                    {
                    	var responseData = JSON.parse(result);
						if (responseData.status==='error'){
							cuteAlert({
								type: "question",
								title: "CODE GENERATION ALERT",
								message: "Number starts should be greater than"+responseData.support,
								confirmText: "Okay",
								cancelText: "Cancel",
								img:warning,
							});
						}else {
							if (responseData) {
								cuteAlert({
									type: "success", // or 'info', 'error', 'warning'
									title: 'Code Generations',
									message: "Successfully generated Code",
									buttonText: "Okay",
									img: successImage,
								}).then((e) => {
									if (e === ("ok")) {
										location.reload();
									}
								});

							} else {
								alert("Somethings wrong");
							}
						}
                    }
                });

            });


            $(document).on('dblclick', 'tr#editRows', function() {
                var url = '<?php echo base_url();?>CodeGeneration/getCodeGenerationsData';
                var post_data = {
                    'id': $(this).data('id'),
                };
                $.ajax({
                    url : url,
                    type : 'post',
                    data :post_data,
                    success : function(responce){

                    	$('button.btn.btn-sm.btn-primary.text-white.submit-btn').text('Update');

                        var responseData = JSON.parse(responce);
                        var CodeGenerationsDataItem = JSON.parse(responseData.CodeGenerationsData);
                        var codeGenerationsItemData  = JSON.parse(responseData.codeGenerationsItem);

                        console.log(codeGenerationsItemData);

                       if (CodeGenerationsDataItem){
                           $('select#company_name').val(CodeGenerationsDataItem.company_name).trigger('change');
                          
                           $('input#order_no').val(CodeGenerationsDataItem.order_no);
                           $('input#delivery_date').val(CodeGenerationsDataItem.delivery_date);
                           $('input#order_date').val(CodeGenerationsDataItem.order_date);
                           $('input#prefix').val(CodeGenerationsDataItem.prefix);
                           $('input#number_of_code_generations').val(CodeGenerationsDataItem.number_of_code_generations);
                           $('input#number_starts_form').val(CodeGenerationsDataItem.number_starts_form);
                           $('input#codeGenerationsId').val(CodeGenerationsDataItem.code_generations_id);
                             setTimeout(function(){
                                $('select#customer').val(CodeGenerationsDataItem.customer_name).trigger('change');
                            }, 1000);
                       }

                        $('tbody#getCodeGenerationLeftBlock').html('');
                        var html='';
                        $(codeGenerationsItemData).each(function(index,item){
                            var indexSr=index+1;
                             html += `<tr>
                                 <th >
								 <input type="hidden" value="`+item.logo_and_printing+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][logo_and_printing]">
								<input type="hidden" value="`+item.colorCode+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][colorCode]">
                                <input type="hidden" value="`+item.brandName+`" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][brandName]">
                                <input type="hidden" value="" name=CodeGenerationsItems[`+indexOfCodeGenerations+`][codeGenerationsItemId]" id="codeGenerationsItemId">
                                <input type="text" value="`+indexSr+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][IndexRow]" class="form-control hide-input-field ordernumber-event IndexRow-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="IndexRow">
                                 </th>
                                <th ><input type="text" value="`+item.item_name+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][itemName]" class="form-control hide-input-field ordernumber-event itemName-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="itemName"></th>
                                <td><input type="text" value="`+item.gens_qty+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][gensQty]" class="form-control hide-input-field itemname-event gensQty-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="gensQty"></td>
                                <td><input type="text" value="`+item.gens_rate+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][gensRate]" class="form-control hide-input-field barcode-event gensRate-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="gensRate"></td>
                                <td><input type="text" value="`+item.ladies_qty+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][ladiesQty]" class="form-control hide-input-field stock-event ladiesQty-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="ladiesQty"></td>
                                <td><input type="text" value="`+item.ladies_rate+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][ladiesRate]" class="form-control hide-input-field rate-price ladiesRate-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="ladiesRate"></td>
                                <td><input type="checkbox" checked value="1" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][generatedStatus]" class="form-control hide-input-field discount-event generatedStatus-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="generatedStatus"></td>
                                <td><input type="text" value="`+item.item_febrics+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][febricsItem]" class="form-control hide-input-field discount-event febricsItem-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="febricsItem"></td>
 								<td><input type="text" value="`+item.patterns_type+`" name="CodeGenerationsItems[`+indexOfCodeGenerations+`][patternType]" class="form-control hide-input-field discount-event patternTypeItem-`+indexOfCodeGenerations+`" data-key-index="`+indexOfCodeGenerations+`" id="patternType"></td>
							  </tr>`;
                        });


                        $('tbody#getCodeGenerationLeftBlock').append(html);
                    }
                });
            });

        });

		$(document).on('change', 'select#item_name', function() {
			var itemId	=$(this).val();

			var post_data = {
				'id': itemId,
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
			};

			var url = "<?php echo base_url();?>Patterns/getPattern";

			$.ajax({
				url : url,
				type : 'POST',
				data: post_data,
				success : function(result)
				{
					if (result) {
						var obj = JSON.parse(result);
						$('select#patterns_type').find('option').remove();
						$('select#patterns_type').append($('<option/>', {
							value: '',
							text: 'Select Patterns'
						}));

						for (var i = 0; i < obj.length; i++) {
							$('select#patterns_type').append($('<option/>', {
								value: obj[i]['patterns_id'],
								text: obj[i]['pattern_name'],
								dataPatternName :obj[i]['pattern_name'],
							}));
						}
					}else{
						$('select#patterns_type').find('option').remove();
						$('select#patterns_type').append($('<option/>', {
							value: '',
							text: 'Select Patterns'
						}));
					}
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
