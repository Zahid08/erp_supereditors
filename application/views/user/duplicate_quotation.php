<?php
error_reporting(0);
$enquiry_id = $_GET['enquiry_id'];
$heading_id = $_GET['header_id'];
if(!empty($enquiry_id)){
    if($heading_id == NULL || $heading_id == '')
    $heading_id = 0;
    $quotationHeadingDetails = $this->db->query("SELECT * FROM quotation_heading WHERE isactive = 1 AND enquiry_id = $enquiry_id and heading_id = $heading_id ")->result();
    foreach($quotationHeadingDetails as $getquotationHeadingDetails){
        $heading = $getquotationHeadingDetails->heading_text;
        $to_email = $getquotationHeadingDetails->to_email;

        $company = $getquotationHeadingDetails->company;
        $moq = $getquotationHeadingDetails->moq;
        $gst = $getquotationHeadingDetails->gst;
        $delivery_period = $getquotationHeadingDetails->delivery_period;
        $delivery_charges = $getquotationHeadingDetails->delivery_charges;
        $payment_terms = $getquotationHeadingDetails->payment_terms;
        $sampling = $getquotationHeadingDetails->sampling;
        $extra_text = $getquotationHeadingDetails->extra_text;
        $remark = $getquotationHeadingDetails->remark;
    }


    $itemDetails = $this->db->query("SELECT * FROM quotation_items WHERE isactive = 1 AND enquiry_id = $enquiry_id and heading_id = $heading_id ORDER BY quotation_item_id ASC")->result();

    $communication = $this->db->query("SELECT DISTINCT email,mobile_no,name FROM (SELECT email,mobile_no,name FROM owner_details WHERE isactive = 1 AND enquiry_id = $enquiry_id
                                   UNION ALL
                                   SELECT email,mobile_no,name FROM contact_person WHERE isactive = 1 AND enquiry_id = $enquiry_id) T
                                   ")->result();

    $getAllQuotationsDetials = $this->db->query("SELECT * FROM quotation_heading WHERE isactive = 1 AND enquiry_id = $enquiry_id ORDER BY 1 DESC")->result();

    
    $userId=$this->session->userdata['user_id'];
    $getUser = $this->db->query("SELECT * FROM user WHERE user_id =$userId")->row();

    $signature='';
    if ($getUser){
        $signature=!empty($getUser->signature)?$getUser->signature:'';
    }
    
}

$patternList    = $this->db->query("SELECT * from payment_terms where status=1 order by id DESC")->result();
$enquiryDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1")->result();
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
    <!--============For Dropdown Search and Multi Select===========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script>
        $(document).ready(function(){
            var multipleCancelButton = new Choices('#choices-multiple-remove-button,#sent-email-choices-multiple-remove-button', {
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
                <h3 class="text-primary">Quotation</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Quotation</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start Page Content -->
            <section id="enquiry_section" name="enquiry_section">
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#quotationheadingform" >Quotation Details</button>
                <div id="quotationheadingform" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('quotation_heading_message') ?></p>
                            </center>
                            <h5 class="card-title">Quotation Details</h5>
                            <form method="post" action="<?php echo base_url() ?>Enquiry/save_duplicate_quotation_heading_data" autocomplete="off">
								<input type="hidden" value="<?=isset($_REQUEST['enquiry_id'])?$_REQUEST['enquiry_id']:''?>" name="previous_enqury_id">
								<input type="hidden" value="<?=isset($_REQUEST['header_id'])?$_REQUEST['header_id']:''?>" name="header_id">

								<div class="row">
									<div class="col-sm-3">
										<select class="form-control" name="enquiry_id" required  id="enquiry_id">
											<option value="">Select Enquiry</option>
											<?php foreach($enquiryDetails as $value){ ?>
												<option value="<?php echo $value->enquiry_id ?>"  ><?php echo $value->name ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-3">
										<select class="form-control" name="contact_name" required  id="enquery_name">
											<option value="">Select Name</option>
										</select>
									</div>

									<div class="col-sm-3">
										<select class="form-control" name="contact_email" required  id="mail_to">
											<option value="">Select Email</option>
										</select>
									</div>

									<div class="col-sm-3">
										<select class="form-control" name="contact_phone" required  id="sms_to">
											<option value="">Select Number</option>
										</select>
									</div>
								</div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-sm-3">
                                        <select class="form-control" id="company" name="company" required>
                                            <option>Choose Comapany</option>
                                            <option value="SuperEditors" <?php if($company == 'SuperEditors'){ ?> selected <?php } ?>>SuperEditors</option>
                                            <option value="MannasMensWear" <?php if($company == 'MannasMensWear'){ ?> selected <?php } ?>>MannasMensWear</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <input class="form-control" name="heading" id="heading" placeholder="Quotation Title" value="<?php echo $heading ?>" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <select class="form-control" name="address_type" id="address_type"  placeholder="Address Type" required>
                                            <option name="Corporate Office">Corporate Office</option>
                                            <option name="Factory Address" >Factory Address</option>
                                            <option name="Branch Address"  >Branch Address</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary  text-white" >Duplicate Quotation</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
		$('select#enquiry_id').select2();

        var rowCount = $('table.email-sent-area tbody tr').length;

        for (key =0; key<= rowCount; ++key) {
            $('.textarea_editor_signature-'+key+'').wysihtml5();
            $('.textarea_editor-'+key+'').wysihtml5();
        }

        function myDeletePrompt(enquiry_id,quotation_item_id,heading_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_quotation_item_data?enquiry_id=" + enquiry_id + "&quotation_item_id=" + quotation_item_id+ "&heading_id=" + heading_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry/quotation?enquiry_id="+enquiry_id;
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
	</script>

</body>
</html>
