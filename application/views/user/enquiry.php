<?php
error_reporting(0);
$enquiry_id = $_GET['enquiry_id'];
if(!empty($enquiry_id)){
    $enquiryDetails = $this->db->query("SELECT * FROM enquiry WHERE isactive = 1 AND enquiry_id = $enquiry_id   ORDER BY enquiry_id ASC")->result();
    foreach($enquiryDetails as $getenquiryDetails){
        $party_name = $getenquiryDetails->name;
        $party_type = $getenquiryDetails->type;
        $month = $getenquiryDetails->month;
        $is_existing_customer = $getenquiryDetails->is_existing_customer;
    }
    $addressDetails = $this->db->query("SELECT * FROM address WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY address_id ASC")->result();
    $contactDetails = $this->db->query("SELECT * FROM contact_person WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY contact_id ASC")->result();
    $ownerDetails = $this->db->query("SELECT * FROM owner_details WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY owner_id ASC")->result();
    $itemDetails = $this->db->query("SELECT * FROM item_details WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY item_id ASC")->result();
    $remarkDetails = $this->db->query("SELECT * FROM remarks WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY remark_id ASC")->result();
    $appointmentDetails = $this->db->query("SELECT * FROM appointment WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY appointment_id ASC")->result();
    $quotationDetails = $this->db->query("SELECT * FROM quotation WHERE isactive = 1 AND enquiry_id = $enquiry_id  ORDER BY quotation_id DESC")->result();
    $communication = $this->db->query("SELECT DISTINCT email,mobile_no FROM(SELECT email,mobile_no FROM owner_details WHERE isactive = 1 AND enquiry_id = $enquiry_id
                                   UNION ALL
                                   SELECT email,mobile_no FROM contact_person WHERE isactive = 1 AND enquiry_id = $enquiry_id) T
                                   ")->result();


}
if($enquiry_id=='' || $enquiry_id== null)
    $enquiry_id = 0;
$HeadingDetails= $this->db->query("SELECT * FROM quotation_heading WHERE isactive = 1 AND enquiry_id = $enquiry_id ORDER BY 1 DESC LIMIT 1 ")->result();
foreach($HeadingDetails as $getHeadingDetails){
    $latestheadingid = $getHeadingDetails->heading_id;
}
$enquiryDetailsdata = $this->db->query("SELECT * FROM enquiry WHERE isactive = 1")->result();

// echo "<pre>";
// print_r($contactDetails);
// exit();

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
            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
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
    	<style>
		.row.wrapping {
			margin-top: 25px;
		}
	</style>
	
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
                <h3 class="text-primary">Enquiry</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Enquiry</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-10">
                    <p>&nbsp;</p>
                </div>
                <div class="col-sm-2">
                    <a href="<?php base_url() ?>Enquiry/quotation?enquiry_id=<?php echo $enquiry_id ?>&header_id=<?php echo $latestheadingid ?>" target="_blank"><button type="button" class="btn btn-primary  text-white" >Generate Quotation</button> </a>
                    <!--<button type="submit" class="btn btn-primary  text-white" >Save and Send Mail</button> -->
                </div>
            </div>

            <br>
            <!-- Start Page Content -->
            <section id="enquiry_section" name="enquiry_section">
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#enquiryform" >Enquiry</button>
                <div id="enquiryform" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('enquiry_message') ?></p>
                            </center>
                            <h5 class="card-title">Enquiry</h5>
                            <form method="post" action="Enquiry/save_enquiry_data?enquiry_id=<?php echo $_GET['enquiry_id'] ?>" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input class="form-control" list="party_name_enquiry" name="party_name" id="party_name" value="<?php echo $party_name ?>" placeholder="Party Name" required>
                                        <datalist id="party_name_enquiry">
                                            <?php foreach($enquiryDetailsdata as $getenquiryDetailsvalue){ ?>
                                                <option  <?php if($getenquiryDetailsvalue->enquiry_id == $enquiry_id){ ?>selected<?php } ?> ><?php echo $getenquiryDetailsvalue->name  ?></option>
                                            <?php } ?>
                                        </datalist>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="party_type" id="party_type">
                                            <option name="Industry/Company" <?php if($party_type == 'Industry/Company'){ ?> selected <?php } ?> >Industry/Company</option>
                                            <option name="Hospital" <?php if($party_type == 'Hospital'){ ?> selected <?php } ?> >Hospital</option>
                                            <option name="Hotel" <?php if($party_type == 'Hotel'){ ?> selected <?php } ?> >Hotel</option>
                                            <option name="School" <?php if($party_type == 'School'){ ?> selected <?php } ?> >School</option>
                                            <option name="College" <?php if($party_type == 'School'){ ?> selected <?php } ?> >Colleges</option>
                                            <option name="Others" <?php if($party_type == 'Others'){ ?> selected <?php } ?> >Others</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="enquiry_opening_month" id="enquiry_opening_month">
                                            <option >Enquiry Opening Month</option>
                                            <option name="Jan" <?php if($month == 'Jan'){ ?> selected <?php } ?>>Jan</option>
                                            <option name="Feb" <?php if($month == 'Feb'){ ?> selected <?php } ?>>Feb</option>
                                            <option name="March" <?php if($month == 'March'){ ?> selected <?php } ?>>March</option>
                                            <option name="April" <?php if($month == 'April'){ ?> selected <?php } ?>>April</option>
                                            <option name="May" <?php if($month == 'May'){ ?> selected <?php } ?>>May</option>
                                            <option name="June" <?php if($month == 'June'){ ?> selected <?php } ?>>June</option>
                                            <option name="July" <?php if($month == 'July'){ ?> selected <?php } ?>>July</option>
                                            <option name="August" <?php if($month == 'August'){ ?> selected <?php } ?>>August</option>
                                            <option name="Sept" <?php if($month == 'Sept'){ ?> selected <?php } ?>>Sept</option>
                                            <option name="Oct" <?php if($month == 'Oct'){ ?> selected <?php } ?>>Oct</option>
                                            <option name="Nov" <?php if($month == 'Nov'){ ?> selected <?php } ?>>Nov</option>
                                            <option name="Dec" <?php if($month == 'Dec'){ ?> selected <?php } ?>>Dec</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="is_existing_customer" id="is_existing_customer">
                                            <option >Is Existing Customer</option>
                                            <option name="Yes" <?php if($is_existing_customer == 'Yes'){ ?> selected <?php } ?>>Yes</option>
                                            <option name="No" <?php if($is_existing_customer == 'No'){ ?> selected <?php } ?>>No</option>
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
            </section>

            <section id="address_section" name="address_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#address" >Address</button>
                <div id="address" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('address_message') ?></p>
                                <p style="color:red"><?php echo $this->session->flashdata('quotation_del_address_message') ?></p>

                            </center>
                            <h5 class="card-title">Address</h5>
                            <form method="post" action="Enquiry/save_address_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="address_type" id="address_type"  placeholder="Address Type" required>
                                            <option name="Corporate Office">Corporate Office</option>
                                            <option name="Factory Address" >Factory Address</option>
                                            <option name="Branch Address"  >Branch Address</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="address_line_1" id="address_line_1"  placeholder="Address Line 1" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="address_line_2" id="address_line_2"  placeholder="Address Line 2">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="country" id="country" placeholder="Country" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="state" id="state"  placeholder="State" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="city" id="city" placeholder="City" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="street" id="street" placeholder="Street" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control" name="pincode" id="pincode" placeholder="Pincode" required>
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
                <div class="card">
                    <div class="card-body">
                        <center>
                            <p style="color:green"><?php echo $this->session->flashdata('address_update_msg') ?></p>
                        </center>
                        <div class="table-responsive m-t-40">
                            <table id="example22" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Address Type</th>
                                    <th>Add Line 1</th>
                                    <th>Add Line 2</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Street</th>
                                    <th>Pincode</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach($addressDetails as $getaddressDetails){ ?>
                                    <tr>
                                        <td><?php echo $getaddressDetails->address_type ?></td>
                                        <td><?php echo $getaddressDetails->address_line_1 ?></td>
                                        <td><?php echo $getaddressDetails->address_line_2 ?></td>
                                        <td><?php echo $getaddressDetails->country ?></td>
                                        <td><?php echo $getaddressDetails->state ?></td>
                                        <td><?php echo $getaddressDetails->city ?></td>
                                        <td><?php echo $getaddressDetails->street ?></td>
                                        <td><?php echo $getaddressDetails->pincode ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary text-white" onclick="myDeletePromptAddress('<?php echo $enquiry_id ?>','<?php echo $getaddressDetails->address_id ?>')"><i class="fa fa-trash"></i> Delete</button>
                                            <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editAddress<?php echo $getaddressDetails->address_id ?>"><i class="fa fa-edit"></i> Edit</button>

                                            <!--Address Modal-->

                                            <!-- Modal -->

                                            <div class="modal fade" id="editAddress<?php echo $getaddressDetails->address_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Address</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="Enquiry/edit_address_data" autocomplete="off">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <input type="hidden" class="form-control" name="address_id" id="address_id"  value="<?php echo $getaddressDetails->address_id ?>"  placeholder="AddressId" required>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <select class="form-control" name="address_type" id="address_type"  placeholder="Address Type" required>
                                                                            <option name="Corporate Office"  <?php if($getaddressDetails->address_type = 'Corporate Office'){ ?> selected  <?php } ?> >Corporate Office</option>
                                                                            <option name="Factory Address" <?php if($getaddressDetails->address_type = 'Factory Address'){ ?> selected  <?php } ?> >Factory Address</option>
                                                                            <option name="Branch Address"  <?php if($getaddressDetails->address_type = 'Branch Address'){ ?> selected  <?php } ?> >Branch Address</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input class="form-control" name="address_line_1" id="address_line_1"  placeholder="Address Line 1" value="<?php echo $getaddressDetails->address_line_1 ?>" required>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input class="form-control" name="address_line_2" id="address_line_2"  placeholder="Address Line 2" value="<?php echo $getaddressDetails->address_line_2 ?>">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input class="form-control" name="country" id="country" placeholder="Country" required value="<?php echo $getaddressDetails->country ?>">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input class="form-control" name="state" id="state"  placeholder="State" required value="<?php echo $getaddressDetails->state ?>">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input class="form-control" name="city" id="city" placeholder="City" required  value="<?php echo $getaddressDetails->city ?>">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input class="form-control" name="street" id="street" placeholder="Street" required  value="<?php echo $getaddressDetails->street ?>">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input class="form-control" name="pincode" id="pincode" placeholder="Pincode" required  value="<?php echo $getaddressDetails->pincode ?>" >
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
                    </div>
                </div>
            </section>

            <section id="contact_section" name="contact_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#contact_persons" >Contact Persons</button>
                <div id="contact_persons" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('contact_message') ?></p>
                                <p style="color:red"><?php echo $this->session->flashdata('quotation_del_contact_message') ?></p>
                            </center>
							<div class="" style="display: flex;justify-content: space-between">
								<h5 class="card-title">Contact Persons </h5>
							</div>
                            <form method="post" action="<?= base_url()?>/Enquiry/save_contact_data" autocomplete="off">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>

										<div class="row">
											<div class="col-sm-6">
												<input class="form-control" name="name" id="name" placeholder="Contact Name" required>
											</div>
											<div class="col-sm-6">
												<select class="form-control" name="designation" id="designation" >
													<option value="">Designation</option>
													<option value="Owner">Owner</option>
													<option value="Manager/Admin">Manager/Admin</option>
													<option value="Purchase">Purchase</option>
													<option value="HR">HR</option>
													<option value="Account">Account</option>
													<option value="Sales">Sales</option>
													<option value="Co-ordinator">Co-ordinator</option>
													<option value="Store">Store</option>
												</select>
											</div>
											<div class="col-sm-6">
												<input class="form-control"  name="dob" id="dob" placeholder="DOB" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
											</div>
											<div class="col-sm-6">
												<input class="form-control"  name="marriage_anniversary_date" id="marriage_anniversary_date" placeholder="Marriage Anniversary Date" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
											</div>
										</div>

										<div id="contactPersonDiv">
											<div class="row wrapping">
												<div class="col-sm-3">
													<input class="form-control" name="Contact[0][mobile_no]" id="mobile_no" placeholder="Mobile No." required>
												</div>
												<div class="col-sm-3">
													<input class="form-control" name="Contact[0][landline]" id="landline" placeholder="Landline No." required>
												</div>
												<div class="col-sm-3">
													<input class="form-control" name="Contact[0][email]" id="email" placeholder="Email" required>
												</div>
												<div class="col-md-3">
													<button type="button" class="btn btn-primary text-white" id="addMoreContact" ><i class="fa fa-plus"></i>Add More</button>
												</div>
											</div>
										</div>

									<div class="col-sm-12">
										<br>
										<button type="submit" class="btn btn-primary  text-white" >Save</button>
									</div>
                            </form>
                            <div class="card">
                                <center>
                                    <p style="color:green;"><?php echo $this->session->flashdata('contact_update_msg') ?></p>
                                </center>
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="example22" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Designation</th>
												<th>Mobile No</th>
												<th>Landline No</th>
												<th>Email</th>
												<th>DOB</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($contactDetails as $getcontactDetails){
                                            	?>
                                                <tr>
                                                    <td><?php echo $getcontactDetails->name ?></td>
                                                    <td><?php echo $getcontactDetails->designation ?></td>
                                                    <td><?php echo $getcontactDetails->mobile_no ?></td>
                                                    <td><?php echo $getcontactDetails->landline ?></td>
                                                    <td><?php echo $getcontactDetails->email ?></td>
                                                    <td><?php echo $getcontactDetails->dob ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary text-white" onclick="myDeletePromptContact('<?php echo $enquiry_id ?>','<?php echo $getcontactDetails->contact_id ?>')"><i class="fa fa-trash"></i> Delete</button>
                                                        <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editContact<?php echo $getcontactDetails->contact_id ?>"><i class="fa fa-edit"></i> Edit</button>
                                                        <!--Contact Modal-->

                                                        <!-- Modal -->

                                                        <div class="modal fade" id="editContact<?php echo $getcontactDetails->contact_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Contact</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
																	<form method="post" action="<?= base_url()?>/Enquiry/edit_contact_data" autocomplete="off">
																			<div class="row">
																				<div class="col-sm-12">
																					<input class="form-control" type="hidden" name="contact_id" id="contact_id" value="<?php echo $getcontactDetails->contact_id ?>">
																				</div>
																				<div class="col-sm-12">
																					<input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
																				</div>
																				<div class="col-sm-6">
																					<input class="form-control" name="name" id="name" placeholder="Contact Name" value="<?php echo $getcontactDetails->name ?>" required>
																				</div>
																				<div class="col-sm-6">
                                                                                <select class="form-control" name="designation" id="designation" >
                                                                                    <option value="">Designation</option>
                                                                                    <option value="Owner" <?php if($getcontactDetails->designation == "Owner"){ ?>selected<?php } ?> >Owner</option>
                                                                                    <option value="Manager/Admin" <?php if($getcontactDetails->designation == "Manager/Admin"){ ?>selected<?php } ?> >Manager/Admin</option>
                                                                                    <option value="Purchase" <?php if($getcontactDetails->designation == "Purchase"){ ?>selected<?php } ?> >Purchase</option>
                                                                                    <option value="HR" <?php if($getcontactDetails->designation == "HR"){ ?>selected<?php } ?> >HR</option>
                                                                                    <option value="Account" <?php if($getcontactDetails->designation == "Account"){ ?>selected<?php } ?> >Account</option>
                                                                                    <option value="Sales" <?php if($getcontactDetails->designation == "Sales"){ ?>selected<?php } ?> >Sales</option>
                                                                                    <option value="Co-ordinator" <?php if($getcontactDetails->designation == "Co-ordinator"){ ?>selected<?php } ?> >Co-ordinator</option>
                                                                                    <option value="Store" <?php if($getcontactDetails->designation == "Store"){ ?>selected<?php } ?> >Store</option>
                                                                                </select>
																				</div>
																				<div class="col-sm-6">
																					<input class="form-control"  name="dob" id="dob" placeholder="DOB" value="<?php echo $getcontactDetails->dob ?>" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
																				</div>
																				<div class="col-sm-6">
																					<input class="form-control"  name="marriage_anniversary_date" id="marriage_anniversary_date" value="<?php echo $getcontactDetails->marriage_anniversary_date ?>" placeholder="Marriage Anniversary Date" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
																				</div>
																			</div>

																			<div id="editcontactPersonDiv_<?php echo $getcontactDetails->contact_id ?>">
																				<div class="row wrapping" id="edit_MainWraaping_<?php echo $getcontactDetails->contact_id ?>">
																					<div class="col-sm-3">
																						<input class="form-control" name="Contact[0][mobile_no]" id="mobile_no" placeholder="Mobile No." value="<?php echo $getcontactDetails->mobile_no ?>">
																					</div>
																					<div class="col-sm-3">
																						<input class="form-control" name="Contact[0][landline]" id="landline" placeholder="Landline No." value="<?php echo $getcontactDetails->landline ?>">
																					</div>
																					<div class="col-sm-3">
																						<input class="form-control" name="Contact[0][email]" id="email" placeholder="Email" value="<?php echo $getcontactDetails->email ?>">
																					</div>
																					<div class="col-sm-3">
																						<button type="button" class="btn btn-primary text-white" id="editAddMoreContact" data-contactid="<?php echo $getcontactDetails->contact_id ?>"><i class="fa fa-plus"></i>Add More</button>
																					</div>
																				</div>
																			</div>
																			<div class="col-sm-12">
																				<br>
																				<button type="submit" class="btn btn-primary  text-white" >Save</button>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="owner_section" name="owner_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#owner_details" >Owner Details</button>
                <div id="owner_details" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('owner_message') ?></p>
                                <p style="color:red"><?php echo $this->session->flashdata('quotation_del_owner_message') ?></p>
                            </center>
                            <h5 class="card-title">Owner Details</h5>
                            <form method="post" action="<?= base_url()?>/Enquiry/save_owner_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="name" id="name" placeholder="Owner Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control"  name="dob" id="dob" placeholder="DOB" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control"  name="marriage_anniversary_date" id="marriage_anniversary_date" placeholder="Marriage Anniversary Date" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
                                    </div>
                                </div>
								<div id="ownerContactDiv" style="margin-top: 18px;">
									<div class="row wrapping_owner">
										<div class="col-sm-3">
											<input class="form-control" name="ContactOwner[0][mobile_no]" id="mobile_no" placeholder="Mobile No." required>
										</div>
										<div class="col-sm-3">
											<input class="form-control" name="ContactOwner[0][landline]" id="landline" placeholder="Landline No." required>
										</div>
										<div class="col-sm-3">
											<input class="form-control" name="ContactOwner[0][email]" id="email" placeholder="Email" required>
										</div>
										<div class="col-md-3">
											<button type="button" class="btn btn-primary text-white" id="addMoreOwnerContact" ><i class="fa fa-plus"></i>Add More</button>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<br>
									<button type="submit" class="btn btn-primary  text-white" >Save</button>
								</div>
                            </form>
                            <div class="card">
                                <center>
                                    <p style="color:green"><?php echo $this->session->flashdata('owner_update_msg') ?></p>
                                </center>
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="example22" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Landline</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($ownerDetails as $getownerDetails){ ?>
                                                <tr>
                                                    <td><?php echo $getownerDetails->name ?></td>
                                                    <td><?php echo $getownerDetails->email ?></td>
                                                    <td><?php echo $getownerDetails->mobile_no ?></td>
                                                    <td><?php echo $getownerDetails->landline ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary text-white" onclick="myDeletePromptOwner('<?php echo $enquiry_id ?>','<?php echo $getownerDetails->owner_id ?>')"><i class="fa fa-trash"></i> Delete</button>
                                                        <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editOwner<?php echo $getownerDetails->owner_id ?>"><i class="fa fa-edit"></i> Edit</button>
                                                        <!--Contact Modal-->

                                                        <!-- Modal -->

														<div class="modal fade" id="editOwner<?php echo $getownerDetails->owner_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
															<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Owner</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">

																		<form method="post" action="<?= base_url()?>/Enquiry/edit_owner_data" autocomplete="off">
																			<div class="col-sm-12">
																				<input class="form-control" type="hidden" name="owner_id" id="owner_id" value="<?php echo $getownerDetails->owner_id ?>">
																			</div>
																			<div class="row">
																				<div class="col-sm-12">
																					<input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
																				</div>
																				<div class="col-sm-6">
																					<input class="form-control" name="name" id="name" placeholder="Owner Name" value="<?php echo $getownerDetails->name ?>">
																				</div>
																				<div class="col-sm-6">
																					<input class="form-control"  name="dob" id="dob" placeholder="DOB" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>"  value="<?php echo $getownerDetails->dob ?>">
																				</div>
																				<div class="col-sm-6">
																					<input class="form-control"  name="marriage_anniversary_date" id="marriage_anniversary_date" placeholder="DOB" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>"  value="<?php echo $getownerDetails->marriage_anniversary_date ?>">
																				</div>
																			</div>

																			<div id="editownerContactDiv_<?php echo $getownerDetails->owner_id ?>" style="margin-top: 18px;">
																				<div class="row wrapping_owner">
																					<div class="col-sm-3">
																						<input class="form-control" name="ContactOwner[0][mobile_no]" id="mobile_no" placeholder="Mobile No." value="<?php echo $getownerDetails->mobile_no ?>">
																					</div>
																					<div class="col-sm-3">
																						<input class="form-control" name="ContactOwner[0][landline]" id="landline" placeholder="Landline No." value="<?php echo $getownerDetails->landline ?>">
																					</div>
																					<div class="col-sm-3">
																						<input class="form-control" name="ContactOwner[0][email]" id="email" placeholder="Email" value="<?php echo $getownerDetails->email ?>">
																					</div>
																					<div class="col-md-3">
																						<button type="button" class="btn btn-primary text-white" data-ownerid="<?php echo $getownerDetails->owner_id ?>" id="EditMoreEditOwnerContact" ><i class="fa fa-plus"></i>Add More</button>
																					</div>
																				</div>
																			</div>
																			<div class="col-sm-12">
																				<br>
																				<button type="submit" class="btn btn-primary  text-white" >Save</button>
																			</div>
																		</form>

																		<!--                                                                        <form method="post" action="Enquiry/" autocomplete="off">-->
																		<!--                                                                            <div class="row">-->
																		<!--                                                                                <div class="col-sm-12">-->
																		<!--                                                                                    <input class="form-control" type="hidden" name="owner_id" id="owner_id" value="--><?php //echo $getownerDetails->owner_id ?><!--">-->
																		<!--                                                                                </div>-->
																		<!--                                                                                <div class="col-sm-12">-->
																		<!--                                                                                    <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="--><?php //echo $_GET['enquiry_id'] ?><!--">-->
																		<!--                                                                                </div>-->
																		<!--                                                                                <div class="col-sm-4">-->
																		<!--                                                                                    <input class="form-control" name="name" id="name" placeholder="Owner Name"  value="--><?php //echo $getownerDetails->name ?><!--">-->
																		<!--                                                                                </div>-->
																		<!--                                                                                <div class="col-sm-4">-->
																		<!--                                                                                    <input class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No."  value="--><?php //echo $getownerDetails->mobile_no ?><!--">-->
																		<!--                                                                                </div>-->
																		<!--																				<div class="col-sm-4">-->
																		<!--																					<input class="form-control" name="landline" id="landline" placeholder="Landline No."  value="--><?php //echo $getownerDetails->landline ?><!--">-->
																		<!--																				</div>-->
																		<!--                                                                                <div class="col-sm-4">-->
																		<!--                                                                                    <input class="form-control" name="email" id="email" placeholder="Owner Email"  value="--><?php //echo $getownerDetails->email ?><!--">-->
																		<!--                                                                                </div>-->
																		<!--                                                                                <div class="col-sm-4">-->
																		<!--                                                                                    <input class="form-control"  name="dob" id="dob" placeholder="DOB" onfocus="this.type='date'" max="--><?php //echo date("Y-m-d") ?><!--"  value="--><?php //echo $getownerDetails->dob ?><!--">-->
																		<!--                                                                                </div>-->
																		<!--                                                                                <div class="col-sm-4">-->
																		<!--                                                                                    <input class="form-control"  name="marriage_anniversary_date" id="marriage_anniversary_date"  value="--><?php //echo $getownerDetails->marriage_anniversary_date ?><!--" placeholder="Marriage Anniversary Date" onfocus="this.type='date'" max="--><?php //echo date("Y-m-d") ?><!--">-->
																		<!--                                                                                </div>-->
																		<!--                                                                                <div class="col-sm-12">-->
																		<!--                                                                                    <br>-->
																		<!--                                                                                    <button type="submit" class="btn btn-primary  text-white" >Save</button>-->
																		<!--                                                                                </div>-->
																		<!--                                                                            </div>-->
																		<!--                                                                        </form>-->
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="item_section" name="item_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#item_details" >Item Details</button>
                <div id="item_details" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('item_message') ?></p>
                                <p style="color:red"><?php echo $this->session->flashdata('quotation_del_itemdetails_message') ?></p>
                            </center>
                            <h5 class="card-title">Item Details</h5>
                            <form method="post" action="<?php echo base_url(); ?>Enquiry/save_item_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="name" id="name" placeholder="Item Details">
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="approximate_value" id="approximate_value" placeholder="Approximate Value">
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="approximate_quantity" id="approximate_quantity" placeholder="Approximate Quantity">
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary  text-white" >Save</button>
                                    </div>
                                </div>
                            </form>
                            <div class="card">
                                <center>
                                    <p style="color:green"><?php echo $this->session->flashdata('item_update_msg') ?></p>
                                </center>
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="example22" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Item Details</th>
                                                <th>Approximate Value</th>
                                                <th>Approximate Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($itemDetails as $getitemDetails){ ?>
                                                <tr>
                                                    <td><?php echo $getitemDetails->name ?></td>
                                                    <td><?php echo $getitemDetails->approximate_value ?></td>
                                                    <td><?php echo $getitemDetails->approximate_quantity ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary text-white" onclick="myDeletePromptItemdetails('<?php echo $enquiry_id ?>','<?php echo $getitemDetails->item_id ?>')"><i class="fa fa-trash"></i> Delete</button>
                                                        <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editItem<?php echo $getitemDetails->item_id ?>"><i class="fa fa-edit"></i> Edit</button>
                                                        <!--Contact Modal-->

                                                        <!-- Modal -->

                                                        <div class="modal fade" id="editItem<?php echo $getitemDetails->item_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Item</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="<?php echo base_url(); ?>Enquiry/edit_item_data" autocomplete="off">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="item_id" id="item_id" value="<?php echo $getitemDetails->item_id ?>">
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <input class="form-control" name="name" id="name" placeholder="Item Details" value="<?php echo $getitemDetails->name ?>">
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <input class="form-control" name="approximate_value" id="approximate_value" placeholder="Approximate Value" value="<?php echo $getitemDetails->approximate_value ?>">
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <input class="form-control" name="approximate_quantity" id="approximate_quantity" placeholder="Approximate Quantity" value="<?php echo $getitemDetails->approximate_quantity ?>">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="remarks_section" name="remarks_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#remark_details" >Remarks</button>
                <div id="remark_details" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('remark_message') ?></p>
                                <p style="color:red"><?php echo $this->session->flashdata('remark_delete_message') ?></p>
                            </center>
                            <h5 class="card-title">Remarks</h5>
                            <form method="post" action="<?php echo base_url() ?>Enquiry/save_remark_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="remark" id="remark" placeholder="Type here..."></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" onfocus="this.type='date'" class="form-control" name="call_back_date" id="call_back_date" placeholder="Call Back Date">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" onfocus="this.type='time'" class="form-control" name="call_back_time" id="call_back_time" placeholder="Call Back Time">
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary  text-white" >Save</button>
                                    </div>
                                </div>
                            </form>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="example22" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-right">Remark</th>
                                                <th class="text-right">Call Back Date</th>
                                                <th class="text-right">Call Back Time</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($remarkDetails as $getremarkDetails){ ?>
                                                <tr class="text-right">
                                                    <td><?php echo $getremarkDetails->remark ?></td>
                                                    <td><?php if($getremarkDetails->call_back_date == NULL){ echo 'N/A'; }else{ echo date("d-m-Y", strtotime($getremarkDetails->call_back_date)); } ?></td>
                                                    <td><?php if($getremarkDetails->call_back_time == NULL){ echo 'N/A'; }else{ echo $getremarkDetails->call_back_time; } ?></td>
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
                                                                        <form method="post" action="<?php echo base_url(); ?>Enquiry/edit_remark_data" autocomplete="off">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="remark_id" id="remark_id" value="<?php echo $getremarkDetails->remark_id ?>">
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
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
                        </div>
                    </div>
                </div>
            </section>

            <section id="appointment_section" name="appointment_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#appointment_details" >Appointment</button>
                <div id="appointment_details" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('appointment_message') ?></p>
                                <p style="color:red"><?php echo $this->session->flashdata('quotation_del_appointment_message') ?></p>
                            </center>
                            <h5 class="card-title">Appointment</h5>
                            <form method="post" action="<?php echo base_url() ?>Enquiry/save_appointment_data" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="hidden" name="agent_name" id="agent_name" value="<?php echo $this->session->userdata['name'] ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="date" id="date" onfocus="this.type='date'" placeholder="Appointment Date" min="<?php echo date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="time" id="time" onfocus="this.type='time'" placeholder="Appointment Time">
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="mail_to"  id="choices-multiple-remove-button" placeholder="Select Email" multiple>
                                            <?php foreach($communication as $getcommunication){ ?>
                                                <option name="<?php echo $getcommunication->email ?>"  ><?php echo $getcommunication->email ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="sms_to"  id="choices-multiple-remove-button" placeholder="Select Mobile" multiple>
                                            <?php foreach($communication as $getcommunication){ ?>
                                                <option name="<?php echo $getcommunication->mobile_no ?>"  ><?php echo $getcommunication->mobile_no ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary  text-white" >Save</button>
                                    </div>
                                </div>
                            </form>
                            <div class="card">
                                <center>
                                    <p style="color:green"><?php echo $this->session->flashdata('appointment_update_msg') ?></p>
                                </center>
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="example22" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($appointmentDetails as $getappointmentDetails){ ?>
                                                <tr>
                                                    <td><?php echo $getappointmentDetails->date ?></td>
                                                    <td><?php echo $getappointmentDetails->time ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary text-white" onclick="myDeletePromptAppointment('<?php echo $enquiry_id ?>','<?php echo $getappointmentDetails->appointment_id ?>')"><i class="fa fa-trash"></i> Delete</button>
                                                        <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editAppointment<?php echo $getitemDetails->appointment_id ?>"><i class="fa fa-edit"></i> Edit</button>
                                                        <!--Contact Modal-->

                                                        <!-- Modal -->

                                                        <div class="modal fade" id="editAppointment<?php echo $appointmentDetails->appointment_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Appointment</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="Enquiry/edit_appointment_data" autocomplete="off">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $appointmentDetails->appointment_id ?>">
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <input type="text" class="form-control" name="date" id="date" onfocus="this.type='date'" placeholder="Appointment Date" value="<?php echo $appointmentDetails->date ?>" min="<?php echo date('Y-m-d') ?>">
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <input type="text" class="form-control" name="time" id="time" onfocus="this.type='time'" value="<?php echo $appointmentDetails->time ?>" placeholder="Appointment Time">
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <select class="form-control" name="mail_to"  id="choices-multiple-remove-button" placeholder="Select Email" multiple>
                                                                                        <?php foreach($communication as $getcommunication){ ?>
                                                                                            <option name="<?php echo $getcommunication->email ?>"  ><?php echo $getcommunication->email ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <select class="form-control" name="sms_to"  id="choices-multiple-remove-button" placeholder="Select Mobile" multiple>
                                                                                        <?php foreach($communication as $getcommunication){ ?>
                                                                                            <option name="<?php echo $getcommunication->mobile_no ?>"  ><?php echo $getcommunication->mobile_no ?></option>
                                                                                        <?php } ?>
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
                        </div>
                    </div>
                </div>
            </section>

            <section id="quotation_section" name="quotation_section">
                <br>
                <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#quotation_details" >Quotation</button>
                <div id="quotation_details" class="collapse in">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <p style="color:green"><?php echo $this->session->flashdata('quotation_message') ?></p>
                            </center>
                            <h5 class="card-title">Quotation</h5>
                            <form method="post" action="Enquiry/save_quotation_data" autocomplete="off" enctype='multipart/form-data'>
                                <div class="row">
                                    <!--                              <div class="col-sm-12">
                                 <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>">
                              </div>
                              <div class="col-sm-12">
                                 <textarea class="textarea_editor form-control" rows="10" placeholder="Enter text ..." name="quotation_msg" id="quotation_msg" style="height:300px" required></textarea>
                              </div>
                              <div class="col-sm-6">
                                 <input type="file" class="form-control" name="attachment" id="attachment" required>
                              </div>
                              <div class="col-sm-6">
                                 <select class="form-control" name="mail_to" id="choices-multiple-remove-button" placeholder="Select Email" multiple required>
                                    <?php foreach($communication as $getcommunication){ ?>
                                    <option name="<?php echo $getcommunication->email ?>"  ><?php echo $getcommunication->email ?></option>
                                    <?php } ?>
                                 </select>
                              </div>-->

                                </div>
                            </form>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Quotation Sent</th>
                                                <th>Created Date</th>
                                                <th>To-Email</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($quotationDetails as $getquotationDetails){ ?>
                                                <tr id="quationsRow<?php echo $getquotationDetails->quotation_id ?>">
                                                    <td><a href="<?php echo base_url() ?>assets/client_asstes/quotations/<?php echo $getquotationDetails->attachment ?>" target="_blank">View Quotation</a></td>
                                                    <td><?php echo date("d-m-Y H:i",strtotime($getquotationDetails->created_datetime)) ?></td>
                                                    <td><?php echo $getquotationDetails->mail_to ?></td>
                                                    <td>
                                                        <button class="btn btn-primary deletename" id="deleteButton" data-enquiryid="<?php echo $getquotationDetails->quotation_id; ?>"><i class="fa fa-trash text-black"></i>  Delete</button>
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
                        </div>
                    </div>
                </div>
            </section>
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
        function myDeletePromptAddress(enquiry_id,quotation_address_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_quotation_address_data?enquiry_id=" + enquiry_id + "&quotation_address_id=" + quotation_address_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry?enquiry_id="+enquiry_id;
            }
        }
    </script>
    <script>
        function myDeletePromptContact(enquiry_id,quotation_contact_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_quotation_contact_data?enquiry_id=" + enquiry_id + "&quotation_contact_id=" + quotation_contact_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry?enquiry_id="+enquiry_id;
            }
        }
    </script>
    <script>
        function myDeletePromptOwner(enquiry_id,quotation_owner_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_quotation_owner_data?enquiry_id=" + enquiry_id + "&quotation_owner_id=" + quotation_owner_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry?enquiry_id="+enquiry_id;
            }
        }
    </script>
    <script>
        function myDeletePromptItemdetails(enquiry_id,quotation_itemdetails_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_quotation_itemdetails_data?enquiry_id=" + enquiry_id + "&quotation_itemdetails_id=" + quotation_itemdetails_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry?enquiry_id="+enquiry_id;
            }
        }
    </script>
    <script>
        function myDeletePromptRemarkdetails(enquiry_id,remark_itemdetails_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_remark_itemdetails_data?enquiry_id=" + enquiry_id + "&remark_itemdetails_id=" + remark_itemdetails_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry?enquiry_id="+enquiry_id;
            }
        }
    </script>

    <script>
        function myDeletePromptAppointment(enquiry_id,quotation_appointment_id) {
            var output = confirm('Are you sure you want to Delete?');
            if (output == true) {
                window.location.href = "<?php echo base_url() ?>Enquiry/delete_quotation_appointment_data?enquiry_id=" + enquiry_id + "&quotation_appointment_id=" + quotation_appointment_id;
            } else {
                window.location.href = "<?php echo base_url() ?>Enquiry?enquiry_id="+enquiry_id;
            }
        }


        var successImage    ='<?php echo base_url(); ?>assets/alert_image/success.svg';
        $(document).on('click', 'button#deleteButton', function() {
            var enqId=$(this).data('enquiryid');
            var actionUrl = "<?php echo base_url('Enquiry/deleteQuationsMain'); ?>";

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

		/*----Owner*/
		
		$(document).on('click', '#EditMoreEditOwnerContact', function () {
			var ownerId=$(this).data('ownerid');
			var editIndexOwnerCOntact = $('#editownerContactDiv_'+ownerId+' .wrapping_owner').length;
			var html=`<div class="row wrapping_owner" id="mainOwnerWraaping_${editIndexOwnerCOntact}">
						<div class="col-sm-3">
							<input class="form-control" name="ContactOwner[${editIndexOwnerCOntact}][mobile_no]" id="mobile_no" placeholder="Mobile No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="ContactOwner[${editIndexOwnerCOntact}][landline]" id="landline" placeholder="Landline No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="ContactOwner[${editIndexOwnerCOntact}][email]" id="email" placeholder="Email" required>
						</div>
						<div class="col-sm-3">
						<button data-index="${editIndexOwnerCOntact}" style="margin-top: 5px;" type="button" class="btn btn-primary text-white" onclick="deleteOwnerContact(${editIndexOwnerCOntact})"><i class="fa fa-trash"></i> Delete</button>
						</div>
					</div>`;

			$('#editownerContactDiv_'+ownerId+'').append(html);
			editIndexOwnerCOntact++;
		});

		var indexContactLength = $('#contactPersonDiv .wrapping').length;
		$(document).on('click', '#addMoreContact', function () {
			var html=`<div class="row wrapping" id="mainWraaping_${indexContactLength}">
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexContactLength}][mobile_no]" id="mobile_no" placeholder="Mobile No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexContactLength}][landline]" id="landline" placeholder="Landline No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexContactLength}][email]" id="email" placeholder="Email" required>
						</div>
						<div class="col-sm-3">
						<button data-index="${indexContactLength}" style="margin-top: 5px;" type="button" class="btn btn-primary text-white" onclick="deleteContact(${indexContactLength})"><i class="fa fa-trash"></i> Delete</button>
						</div>
					</div>`;

				$('#contactPersonDiv').append(html);
			indexContactLength++;
		});

		var indexEdit = $('#editPopOverItem .wrapping_edit').length;
		$(document).on('click', '#addMoreEditContact', function () {
			var html=`<div class="row wrapping_edit" id="wrapping_edit_${indexEdit}">
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexEdit}][mobile_no]" id="mobile_no" placeholder="Mobile No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexEdit}][landline]" id="landline" placeholder="Landline No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexEdit}][email]" id="email" placeholder="Email" required>
						</div>
						<div class="col-sm-3">
						<button data-index="${indexEdit}" style="margin-top: 5px;" type="button" class="btn btn-primary text-white" onclick="deleteContact(${indexEdit})"><i class="fa fa-trash"></i> Delete</button>
						</div>
					</div>`;

			$('#editPopOverItem').append(html);
			indexEdit++;
		});

	    $(document).on('click', '#editAddMoreContact', function () {
			var contactId=$(this).data('contactid');
			var indexEditContactLength = $('#editcontactPersonDiv_'+contactId+' .wrapping_owner').length+1;
			var html=`<div class="row wrapping" id="edit_MainWraaping_${indexEditContactLength}">
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexEditContactLength}][mobile_no]" id="mobile_no" placeholder="Mobile No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexEditContactLength}][landline]" id="landline" placeholder="Landline No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexEditContactLength}][email]" id="email" placeholder="Email" required>
						</div>
						<div class="col-sm-3">
						<button data-index="${indexEditContactLength}" style="margin-top: 5px;" type="button" class="btn btn-primary text-white" onclick="deleteEditAddContact(${indexEditContactLength})"><i class="fa fa-trash"></i> Delete</button>
						</div>
					</div>`;

				$('#editcontactPersonDiv_'+contactId+'').append(html);
			    indexEditContactLength++;
		});
		
		function deleteEditAddContact(index){
			let text = 'Are you sure you want to remove this item?';
			if (confirm(text) == true) {
				$('div#edit_MainWraaping_' + index + '').remove();
			}
		}
		
		function deleteContact(index){
			let text = 'Are you sure you want to remove this item?';
			if (confirm(text) == true) {
				$('div#mainWraaping_' + index + '').remove();
			}
		}

		function deleteContactEdit(index){
			let text = 'Are you sure you want to remove this item?';
			if (confirm(text) == true) {
				$('div#wrapping_edit_' + index + '').remove();
			}
		}

		/*----Owner*/
		var indexOwnerCOntact = $('#ownerContactDiv .wrapping_owner').length;
		$(document).on('click', '#addMoreOwnerContact', function () {
			var html=`<div class="row wrapping_owner" id="mainOwnerWraaping_${indexOwnerCOntact}">
						<div class="col-sm-3">
							<input class="form-control" name="ContactOwner[${indexOwnerCOntact}][mobile_no]" id="mobile_no" placeholder="Mobile No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="ContactOwner[${indexOwnerCOntact}][landline]" id="landline" placeholder="Landline No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control" name="ContactOwner[${indexOwnerCOntact}][email]" id="email" placeholder="Email" required>
						</div>
						<div class="col-sm-3">
						<button data-index="${indexOwnerCOntact}" style="margin-top: 5px;" type="button" class="btn btn-primary text-white" onclick="deleteOwnerContact(${indexOwnerCOntact})"><i class="fa fa-trash"></i> Delete</button>
						</div>
					</div>`;

			$('#ownerContactDiv').append(html);
			indexOwnerCOntact++;
		});

		function deleteOwnerContact(index){
			let text = 'Are you sure you want to remove this item?';
			if (confirm(text) == true) {
				$('div#mainOwnerWraaping_' + index + '').remove();
			}
		}

    </script>
</body>
</html>
