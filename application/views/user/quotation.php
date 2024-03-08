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
                            <form method="post" action="<?php echo base_url() ?>Enquiry/save_quotation_heading_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
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
                                        <select class="form-control" name="to_email" id="choices-multiple-remove-button" placeholder="Select Name" multiple required>
                                            <?php foreach($communication as $getcommunication){ ?>
                                                <option name="<?php echo $getcommunication->name ?>"  <?php if($to_email == $getcommunication->name){ ?> selected <?php  } ?>><?php echo $getcommunication->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-12">
                                        <select class="form-control" name="address_type" id="address_type"  placeholder="Address Type" required>
                                            <option name="Corporate Office">Corporate Office</option>
                                            <option name="Factory Address" >Factory Address</option>
                                            <option name="Branch Address"  >Branch Address</option>
                                        </select>
                                    </div>


                                    <div class="col-sm-12">
                                        <br>

                                        <button type="submit" class="btn btn-primary  text-white" >Save</button>

                                    </div>
                                </div>
                            </form>
                            <br>
                            <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editQuotationHeading<?php echo $heading_id ?>"><i class="fa fa-edit"></i> Edit</button>
                            <!-- Modal -->

                            <div class="modal fade" id="editQuotationHeading<?php echo $heading_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Heading</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="<?php echo base_url() ?>Enquiry/edit_quotation_heading" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="hidden" name="heading_id" id="heading_id" value="<?php echo $heading_id?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="company" name="company" required>
                                                            <option>Choose Comapany</option>
                                                            <option value="SuperEditors" <?php if($company == 'SuperEditors'){ ?> selected <?php } ?>>SuperEditors</option>
                                                            <option value="MannasMensWear" <?php if($company == 'MannasMensWear'){ ?> selected <?php } ?>>MannasMensWear</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" name="heading" id="heading" placeholder="Quotation Title" value="<?php echo $heading ?>" required>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="to_email" id="choices-multiple-remove-button" placeholder="Select Name" multiple required>
                                                            <?php foreach($communication as $getcommunication){ ?>
                                                                <option name="<?php echo $getcommunication->name ?>"  <?php if($to_email == $getcommunication->name){ ?> selected <?php  } ?>><?php echo $getcommunication->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="address_type" id="address_type"  placeholder="Address Type" required>
                                                            <option name="Corporate Office">Corporate Office</option>
                                                            <option name="Factory Address" >Factory Address</option>
                                                            <option name="Branch Address"  >Branch Address</option>
                                                        </select>
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
                            <!--==========================================-->
                        </div>
                    </div>
                </div>
            </section>
            <section id="item_section" name="item_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#quotation_item_details" >Item Details</button>
                <div id="quotation_item_details" class="collapse in">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Item Details</h5>
                            <form method="post" action="<?php echo base_url() ?>Enquiry/save_quotation_item_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="heading_id" id="heading_id" value="<?php echo $_GET['header_id'] ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="name" id="name" placeholder="Item Name">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type = "number" class="form-control" name="quantity" id="quantity" placeholder="Quantity">
                                    </div>
                                    <!--<div class="col-sm-3">
                                       <input class="form-control"  name="unit" id="unit" placeholder="Rate">
                                    </div>-->
                                    <div class="col-sm-3">
                                        <input class="form-control" type="number" name="rate" id="rate" placeholder="Rate">
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" rows="5" cols="50" name="description" id="description" placeholder="Enter Descrition Here"></textarea>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary  text-white" >Save</button>
                                    </div>
                                </div>
                            </form>
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('quotation_item_message') ?></p>
                                <p style="color:green"><?php echo $this->session->flashdata('quotation_del_item_message') ?></p>
                            </center>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="example22" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <!-- <th>Unit</th>-->
                                                <th>Rate</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($itemDetails as $getitemDetails){ ?>
                                                <tr>
                                                    <td><?php echo $getitemDetails->item_name ?></td>
                                                    <td><?php echo $getitemDetails->quantity ?></td>
                                                    <!--<td><?php echo $getitemDetails->unit ?></td>-->
                                                    <td><?php echo $getitemDetails->rate ?></td>
                                                    <td><?php echo $getitemDetails->rate * $getitemDetails->quantity  ?></td>
                                                    <td><?php echo $getitemDetails->description ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary text-white" onclick="myDeletePrompt('<?php echo $enquiry_id ?>','<?php echo $getitemDetails->quotation_item_id ?>','<?php echo $heading_id ?>')"><i class="fa fa-trash"></i> Delete</button>
                                                        <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editItemQuotation<?php echo $getitemDetails->quotation_item_id ?>"><i class="fa fa-edit"></i> Edit</button>
                                                        <!-- Modal -->

                                                        <div class="modal fade" id="editItemQuotation<?php echo $getitemDetails->quotation_item_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Item</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="<?php echo base_url() ?>Enquiry/edit_item_data_quotation" autocomplete="off">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="item_id" id="item_id" value="<?php echo $getitemDetails->quotation_item_id ?>">
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="heading_id" id="heading_id" value="<?php echo $_GET['header_id'] ?>">
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <input class="form-control" name="name" id="name" placeholder="Item Name" value="<?php echo $getitemDetails->item_name ?>">
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <input type = "number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo $getitemDetails->quantity ?>">
                                                                                </div>
                                                                                <!--<div class="col-sm-3">
                                                                                   <input class="form-control"  name="unit" id="unit" placeholder="Rate">
                                                                                </div>-->
                                                                                <div class="col-sm-3">
                                                                                    <input class="form-control" type="number" name="rate" id="rate" placeholder="Rate" value="<?php echo $getitemDetails->rate ?>">
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <textarea class="form-control" rows="5" cols="50" name="description" id="description" placeholder="Enter Descrition Here" ><?php echo $getitemDetails->description ?></textarea>
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
                                                        <!--==========================================-->
                                                    </td>

                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="enquiry_details_section" name="enquiry_details_section">
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#quotationheadingdetailsform" >Quotation Details</button>
                <div id="quotationheadingform" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('quotation_heading_details_message') ?></p>
                            </center>
                            <h5 class="card-title">Quotation Details</h5>
                            <form method="post" action="<?php echo base_url() ?>Enquiry/save_quotation_heading_details_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="heading_id" id="heading_id" value="<?php echo $_GET['header_id'] ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="moq" id="moq" placeholder="MOQ" value="<?php echo $moq ?>" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- <input class="form-control" name="gst" id="gst" placeholder="GST % Extra" value="<?php echo $gst ?>" required>-->
                                        <select class="form-control" name="gst" id="gst" required>
                                            <option>GST % Extra</option>
                                            <option value="5%" <?php if($gst == '5%'){ ?> selected <?php } ?>>5%</option>
                                            <option value="12%" <?php if($gst == '12%'){ ?> selected <?php } ?>>12% </option>
                                            <option value="18%" <?php if($gst == '18%'){ ?> selected <?php } ?>>18%  </option>
                                            <option value="28%" <?php if($gst == '28%'){ ?> selected <?php } ?>>28%</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="delivery_period" id="delivery_period" placeholder="Delivery Period" value="<?php echo $delivery_period ?>" required>
                                        <!--<select class="form-control" name="delivery_period" id="delivery_period" required>
                                    <option>Delivery Period</option> 
                                    <option value="At door step" <?php if($delivery_period == 'At door step'){ ?> selected <?php } ?>>At door step</option> 
                                    <option value="Freight charges extra" <?php if($delivery_period == 'Freight charges extra'){ ?> selected <?php } ?>>Freight charges extra </option>
                                    <option value="To Pay" <?php if($delivery_period == 'To Pay'){ ?> selected <?php } ?>>To Pay </option>
                                 </select>-->
                                    </div>
                                    <div class="col-sm-4">
                                        <!--<input class="form-control" name="delivery_charges" id="delivery_charges" placeholder="Delivery Charges" value="<?php echo $delivery_charges ?>" required>-->
                                        <select class="form-control" name="delivery_charges" id="delivery_charges" required>
                                            <option>Delivery Charges</option>
                                            <option value="At door step" <?php if($delivery_charges == 'At door step'){ ?> selected <?php } ?>>At door step</option>
                                            <option value="Freight charges extra" <?php if($delivery_charges == 'Freight charges extra'){ ?> selected <?php } ?>>Freight charges extra </option>
                                            <option value="To Pay" <?php if($delivery_charges == 'To Pay'){ ?> selected <?php } ?>>To Pay </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="payment_terms" name="payment_terms" required>
                                            <option>Choose Payment Terms</option>
											<?php foreach ($patternList as $key=>$data) :?>
                                            <option value="<?=$data->payment_terms?>" <?php if($payment_terms ==$data->payment_terms){ ?> selected <?php } ?>><?=$data->payment_terms?></option>>
                                            <?php endforeach; ?>
										</select>
                                    </div>
                                    <!--<div class="col-sm-4">
                                 <input class="form-control" name="sampling" id="sampling" placeholder="Sampling" value="<?php echo $sampling ?>" required>
                              </div>-->
                                    <div class="col-sm-4">
                                        <!--<input class="form-control" name="delivery_period" id="delivery_period" placeholder="Delivery Period" value="<?php echo $delivery_period ?>" required>-->
                                        <select class="form-control" name="remark" id="remark" required>
                                            <option>Remark</option>
                                            <option value="1" <?php if($remark == "1"){ ?> selected <?php } ?>>Yes</option>
                                            <option value="0" <?php if($remark == "0"){ ?> selected <?php } ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                           <textarea class="form-control" rows="10" placeholder="Enter text ..." name="extra_text" id="extra_text_editor" style="height:150px" ><?php echo $extra_text ?></textarea>
                                           
                                        <!--<input class="form-control" name="extra_text" id="extra_text" placeholder="Other Text" value="<?php echo $extra_text ?>" >-->
                                    </div>

                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary  text-white" >Save</button>
                                        <a href="<?php echo base_url() ?>GeneratePdfController?enquiry_id=<?php echo $enquiry_id ?>&heading_id=<?php echo $heading_id ?>" target="_blank"><button type="button" class="btn btn-primary  text-white" >View Quotation</button> </a>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <!--Ready Quations-->
            <section id="item_section" name="item_section">
               <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#quotation_item_details" >Ready Quotation</button>
                <center>
                    <p style="color:green"><?php echo $this->session->flashdata('quotation_email_sent_message') ?></p>
                </center>

				<div id="quotation_item_details" class="collapse in">
					<div class="card">
						<div class="card-body">
							<center>
								<p style="color:green"><?php echo $this->session->flashdata('quotation_upload_heading_message') ?></p>
							</center>
							<form method="post" action="<?php echo base_url() ?>Enquiry/save_uploaded_heading_data" autocomplete="off" enctype="multipart/form-data" id="addUplaodedQuations">
								<div class="row">
									<div class="col-sm-12">
										<input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
									</div>
									<div class="col-sm-3">
										<select class="form-control" id="company" name="company" required>
											<option>Choose Comapany</option>
											<option value="SuperEditors" <?php if($company == 'SuperEditors'){ ?> selected <?php } ?>>SuperEditors</option>
											<option value="MannasMensWear" <?php if($company == 'MannasMensWear'){ ?> selected <?php } ?>>MannasMensWear</option>
										</select>
									</div>
									<div class="col-sm-3">
										<input class="form-control" type="file" id="formFileMultiple" multiple name="uploadedAttachment" required>
									</div>
									<button type="submit" class="btn btn-primary  text-white" >Uploaded Quations</button>
								</div>
							</form>

						</div>
					</div>
				</div>


                <div id="quotation_item_details" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive m-t-40">
                                <table id="example22" class="display nowrap table table-hover table-striped table-bordered email-sent-area" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>View Quotation</th>
										<th>To Company Name</th>
                                        <th>Quotation Ref No.</th>
                                        <th>Company Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($getAllQuotationsDetials as $key=>$getquotationDetails){
                                    	$key++;

										$ToCompany = $this->db->query("SELECT * FROM enquiry WHERE isactive = 1 AND enquiry_id = $enquiry_id ")->row();
										$toCName='';
										if ($ToCompany){
											$toCName=$ToCompany->name;
										}

										$company = $getquotationHeadingDetails->company;
										$integer =  str_pad($getquotationDetails->heading_id, 4, '0', STR_PAD_LEFT);

										$nextyear = date("y",strtotime($getquotationHeadingDetails->created_datetime)) + 1;
										if($company == 'SuperEditors' || $company == 'Coose Company')
											$reference_no = 'SE'.date("Y",strtotime($getquotationHeadingDetails->created_datetime)).'-'.$nextyear .'/'.$integer;
										else
											$reference_no = 'MW'.date("Y",strtotime($getquotationHeadingDetails->created_datetime)).'-'.$nextyear .'/'.$integer;
                                    	?>
                                        <tr>
                                            <td><?php echo $key; ?></td>
                                            
                                            <td>
                                                <?php
                                                if ($getquotationDetails->quation_status==1) {
                                                    $file_location = base_url() . "/assets/upload_quations/" . $getquotationDetails->upload_quations_image."";
                                                    ?>
                                                    <a href="<?=$file_location?>" target="_blank"><?=$getquotationDetails->to_email?></a>
                                               <?php }else{ ?>
                                                    <a href="<?php echo base_url() ?>GeneratePdfController?enquiry_id=<?php echo $enquiry_id?>&heading_id=<?php echo $getquotationDetails->heading_id ?>" target="_blank"><?=$getquotationDetails->to_email?></a>
                                                 <?php } ?>

                                            </td>
											<td><?=$toCName?></td>
											<td><?=$reference_no?></td>
                                            <td>
												<?=$getquotationDetails->company?>
											</td>
                                            <td>
                                                <?php
                                                if ($getquotationDetails->mail_sent_status==1){
                                                    echo "<span>Sent Email</span>";
                                                }else{
                                                    echo "<span>Not Sent</span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#sentEmailQuations<?php echo $getquotationDetails->heading_id ?>"><i class="fa fa-envelope"></i> Sent Email</button>
                                                <button class="btn btn-primary deletename" id="deleteButton" data-enquiryid="<?php echo $getquotationDetails->heading_id; ?>"><i class="fa fa-trash text-black"></i>  Delete</button>

                                                <!--Sent Email Modal -->
                                                <div class="modal fade" id="sentEmailQuations<?php echo $getquotationDetails->heading_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Sent  Quotation</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="<?php echo base_url() ?>Enquiry/sent_global_email" autocomplete="off">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $enquiry_id ?>">
                                                                            <input class="form-control" type="hidden" name="heading_id" id="heading_id" value="<?php echo $getquotationDetails->heading_id ?>">
                                                                            <?php
                                                                            if ($getquotationDetails->quation_status==1) { ?>
                                                                                <input class="form-control" type="hidden" name="quation_status" id="quationsStatus" value="1">
                                                                                <input class="form-control" type="hidden" name="quation_image" id="quation_image" value="<?=$getquotationDetails->upload_quations_image?>">
                                                                           <?php }else{ ?>
                                                                                <input class="form-control" type="hidden" name="quation_status" id="quationsStatus" value="">
                                                                                <input class="form-control" type="hidden" name="quation_image" id="quation_image" value="">
                                                                         <?php } ?>

                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <label>Select Email ID : </label>
                                                                            <select class="form-control" name="sent_to_email[]" id="sent-email-choices-multiple-remove-button" placeholder="Select Name" multiple required>
                                                                                <?php foreach($communication as $getcommunication){ ?>
                                                                                    <option value="<?php echo $getcommunication->email ?>"><?php echo $getcommunication->name ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-12" style="margin-top: 17px;">
                                                                            <label>Quotation Message</label>
                                                                            <textarea class="textarea_editor-<?=$key?> form-control" rows="10" placeholder="Enter text ..." name="quotation_msg" id="quotation_msg" style="height:100px" required></textarea>
                                                                        </div>

                                                                        <div class="col-sm-12" style="margin-top: 17px;">
                                                                            <label>Signature</label>
                                                                            <textarea class="textarea_editor_signature-<?=$key?> form-control" rows="10" placeholder="Enter text ..." name="signature_msg" id="signature_msg" style="height:100px" required><?=$signature?></textarea>
                                                                        </div>

                                                                        <div class="col-sm-12">
                                                                            <br>
                                                                            <button type="submit" class="btn btn-primary  text-white" >Send Email</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--==========================================-->
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>
            </section>
            <!--Ready Quations END-->


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

        var rowCount = $('table.email-sent-area tbody tr').length;

        for (key =0; key<= rowCount; ++key) {
            $('.textarea_editor_signature-'+key+'').wysihtml5();
            $('.textarea_editor-'+key+'').wysihtml5();
        }

        $('#extra_text_editor').wysihtml5();

        function myDeletePrompt(enquiry_id,quotation_item_id,heading_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_quotation_item_data?enquiry_id=" + enquiry_id + "&quotation_item_id=" + quotation_item_id+ "&heading_id=" + heading_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry/quotation?enquiry_id="+enquiry_id;
            }
        }

        var successImage    ='<?php echo base_url(); ?>assets/alert_image/success.svg';
        $(document).on('click', 'button#deleteButton', function() {
            var enqId=$(this).data('enquiryid');
            var actionUrl = "<?php echo base_url('Enquiry/deleteQuations'); ?>";


            cuteAlert({
                type: "success", // or 'info', 'error', 'warning'
                title: 'Quations',
                message: "Are you sure you want to delete this record?",
                buttonText: "Okay",
                img: successImage,
            }).then((e)=>{
                if ( e === ("ok")){
                    var post_data = {
                        'enqId': enqId,
                    };
                    $.ajax({
                        type: "POST",
                        url: actionUrl,
                        data:post_data, // serializes the form's elements.
                        success: function(result)
                        {
                            var responseData = JSON.parse(result);
                            if (responseData) {
                                $('tr#quationsRow'+enqId+'').remove();
                                cuteToast({
                                    type: "success", // or 'info', 'error', 'warning'
                                    message: "Successfully delete",
                                    timer: 5000,
                                    img: successImage,
                                });
                            }else {
                                alert("Somethings wrong");
                            }
                        }
                    });
                }
            });

        });

    </script>
</body>
</html>
