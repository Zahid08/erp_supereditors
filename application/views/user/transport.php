<?php
error_reporting(0);
$transodataDetails = $this->db->query("SELECT * FROM state WHERE country_id=1")->result();

$transport_id =$_GET['transport_id'];
 if(!empty($transport_id)){
       $transportDetails = $this->db->query("SELECT * FROM transport WHERE is_active = 1 AND transport_id = $transport_id  ORDER BY transport_id DESC")->result();       
       foreach($transportDetails as $gettransportDetails){
           $transport_id = $gettransportDetails->transport_id;
           $transport_name = $gettransportDetails->transport_name;
           $address = $gettransportDetails->address;
           $gst = $gettransportDetails->gst;
           $pan_no = $gettransportDetails->pan_no;
           $state = $gettransportDetails->state;
           $credit_day = $gettransportDetails->credit_day;
           $credit_limit = $gettransportDetails->credit_limit;
           $bank_name = $gettransportDetails->bank_name;
           $branch = $gettransportDetails->branch;
           $acountno = $gettransportDetails->account_no;
           $ifsc = $gettransportDetails->ifsc;
       }
 $contactDetails = $this->db->query("SELECT * FROM transport_contact_details WHERE is_active = 1 AND  transport_id= $transport_id  ORDER BY transport_contact_id ASC")->result();
 foreach($contactDetails as $getDetails)
       {
         $contact_name = $getDetails->contact_name;
         $designation = $getDetails->designation;
         $email = $getDetails->email;
         $phone = $getDetails->phone;
         $dob = $getDetails->dob;
         $marrige_anniversary = $getDetails->marrige_anniversary;
         $land_line = $getDetails->land_line;
       }
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
    <title>SuperEditors || Transport Page</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
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
                    <h3 class="text-primary">Transport</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Transport</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                
             <section id="transport_section" name="enquiry_section">
               <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#enquiryform" >Transport</button>
               <div id="enquiryform" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        <center>
                           <p style="color:green"><?php echo $this->session->flashdata('tranport_message') ?></p>
                        </center>
                        <h5 class="card-title">Transport</h5>
                        <form method="post" action="<?php echo base_url(); ?>Transport/save_trasport_data" >
                            
                           <div class="row">
                               <div class="col-sm-6 mt-3">
                                  <label>Transport Name</label>
                                 <input class="form-control" name="transport_name" type="text" id="transport_name" value="<?php echo $transport_name ?>" placeholder="Transport Name" required>
                              </div>
                             <div class="col-sm-6 mt-3"> 
                                <label>Address</label>
                            <input class="form-control" type="text" name="address" id="address" placeholder="Address" value="<?php echo $address ?>"  required>
                              </div>
                              
                              <div class="col-sm-3 mt-3">  
                              <label>GST</label>
                            <input class="form-control"  name="gst" id="gst" type="text"  placeholder="GST" value="<?php echo $gst ?>"minlength="15" maxlength="15" required>
                            <span id="gstError" style="color: red;"></span>
                              </div>
                           <div class="col-sm-3 mt-3">  
                              <label>Pan Number</label>
                              <input class="form-control" type="text" name="pan_no" id="pan_no"  placeholder="Pan No" value="<?php echo $pan_no ?>" minlength="10" maxlength="10" required>
                              <span id="panError" style="color: red;"></span>
                           </div>
                             <div class="col-sm-6 mt-3"> 
                              <label>State</label>
                            <select name="state"  type="text" class="form-control" placeholder="State" id="state">
                                <?php foreach($transodataDetails as $gettransodataDetails){ ?>
                                <option value="<?php echo $gettransodataDetails->id?>"><?php echo $gettransodataDetails->state?></option>
                                <?php } ?>
                            </select>
                              </div>
                              <div class="col-sm-6 mt-3">  
                              <label>Credit Day</label>
                            <input class="form-control" type="number" name="credit_day" id="credit_day" value="<?php echo $credit_day ?>" placeholder="Credit Day"  required>
                              </div>
                              <div class="col-sm-6 mt-3">  
                              <label>Credit Limit</label>
                            <input class="form-control" type="number"  name="credit_limit" id="credit_limit" value="<?php echo $credit_limit ?>" placeholder="Credit Limit"   required>
                              </div>
                              <div class="col-sm-6 mt-3"> 
                              <label>Bank Name</label>
                            <input class="form-control" type="text"  name="bank_name" id="bank_name" value="<?php echo $bank_name ?>" placeholder="Bank Name" required>
                              </div>
                              <div class="col-sm-6 mt-3"> 
                              <label>Branch</label>
                            <input class="form-control" type="text"  name="branch" id="branch" value="<?php echo $branch ?>" placeholder="Branch"  required>
                              </div>
                              <div class="col-sm-6 mt-3">  
                              <label>Acount No</label>
                            <input class="form-control"  pattern="\d*" minlength="8" maxlength="15" name="acount_no" id="acount_no" value="<?php echo $acountno ?>" placeholder="Acount"  required>
                              </div>
                              <div class="col-sm-6 mt-3">
                                  <label>IFSC</label>  
                            <input class="form-control" type="text"  name="ifsc" id="ifsc" value="<?php echo $ifsc ?>" placeholder="IFSC"  required>
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
                            <form method="post" action="<?= base_url()?>Transport/save_contact_transport_data" autocomplete="off">
                                    <div class="col-sm-12">
										<input class="form-control" type="hidden" name="transport_id" id="transport_id" value="<?php echo $_GET['transport_id'] ?>">
                                    </div>
										<div class="row">
											<div class="col-sm-6">
												<input class="form-control" name="name" id="name" placeholder="Contact Name" value="<?php echo $contact_name ?>"required>
											</div>
											<div class="col-sm-6">
												<select class="form-control" name="designation" id="designation" >
                                    <option value="">Designation</option>
                                    <option value="Owner"<?php if($designation == 'Owner'){ ?> selected <?php } ?>>Owner</option>
                                    <option value="Manager/Admin"<?php if($designation == 'Manager/Admin'){ ?> selected <?php } ?>>Manager/Admin</option>
                                    <option value="Purchase"<?php if($designation == 'Purchase'){ ?> selected <?php } ?>>Purchase</option>
                                    <option value="HR"<?php if($designation == 'HR'){ ?> selected <?php } ?>>HR</option>
                                    <option value="Account"<?php if($designation == 'Account'){ ?> selected <?php } ?>>Account</option>
                                    <option value="Sales"<?php if($designation == 'Sales'){ ?> selected <?php } ?>>Sales</option>
                                    <option value="Co-ordinator"<?php if($designation == 'Co-ordinator'){ ?> selected <?php } ?>>Co-ordinator</option>
                                    <option value="Store"<?php if($designation == 'Store'){ ?> selected <?php } ?>>Store</option>
												</select>
											</div>
											<div class="col-sm-6">
												<input class="form-control"  name="dob" id="dob" placeholder="DOB" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>" value="<?php echo $dob ?>">
											</div>
											<div class="col-sm-6">
												<input class="form-control"  name="marriage_anniversary_date" id="marriage_anniversary_date" placeholder="Marriage Anniversary Date" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>"value="<?php echo $marrige_anniversary?>">
											</div>
										</div>

										<div id="contactPersonDiv">
											<div class="row wrapping">
												<div class="col-sm-3">
													<input class="form-control" name="Contact[0][mobile_no]" id="mobile_no" maxlength="10" placeholder="Mobile No." value="<?php echo $phone?>"required>
												</div>
												<div class="col-sm-3">
													<input class="form-control" name="Contact[0][landline]" id="landline" placeholder="Landline No." value="<?php echo $land_line?>"required>
												</div>
												<div class="col-sm-3">
													<input class="form-control" name="Contact[0][email]" id="email" placeholder="Email" value="<?php echo $email?>" required>
													<?php echo form_error('email'); ?> 
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
                                          <th>Email</th>
                                          <th>Mobile</th>
                                          <th>DOB</th>
                                          
                                         <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                          foreach($contactDetails as $getcontactDetails){ ?>
                                       <tr>
                                          <td><?php echo $getcontactDetails->contact_name ?></td>
                                          <td><?php echo $getcontactDetails->designation ?></td>
                                          <td><?php echo $getcontactDetails->email ?></td>
                                          <td><?php echo $getcontactDetails->phone ?></td>
                                          <td><?php echo $getcontactDetails->dob ?></td>
                                         <td>
                                               <a href="<?php echo base_url(); ?>Transport/delete_contact_transport_data?transport_contact_id=<?php echo $getcontactDetails->transport_contact_id ?>&transport_id=<?php echo $getcontactDetails->transport_id?>">
                                                        <button type="button" onclick="return confirm('Are you sure you want to delete this records?');"  class="btn btn-primary" >
                                                          Delete
                                                        </button>
                                                        </a>
                                                        
                                            <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editContact<?php echo $getcontactDetails->transport_contact_id ?>"><i class="fa fa-edit"></i> Edit</button>
                                         <!--Contact Modal-->
     
                                                <!-- Modal -->
                                               
                                                <div class="modal fade" id="editContact<?php echo $getcontactDetails->transport_contact_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Contact</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                            <form method="post" action="<?php echo base_url(); ?>Transport/save_edit_contact_trasport_data" autocomplete="off">
                                                               <div class="row">
                                                                  <div class="col-sm-12">
                                                                     <input class="form-control" type="hidden" name="transport_contact_id" id="transport_contact_id" value="<?php echo $getcontactDetails->transport_contact_id ?>">
                                                                  </div>
                                                                  <div class="col-sm-12">
                                                                     <input class="form-control" type="hidden" name="transport_id" id="transport_id" value="<?php echo $_GET['transport_id']?>">
                                                                  </div>
                                                                  <div class="col-sm-6">
                                                                     <input class="form-control" name="name" id="name" placeholder="Contact Name" value="<?php echo $getcontactDetails->contact_name ?>" required>
                                                                  </div>
                                                                  <div class="col-sm-6">
                                                                     <input class="form-control" name="designation" id="designation" value="<?php echo $getcontactDetails->designation ?>" placeholder="Mobile No./Landline No." required>
                                                                  </div>
                                                                  <div class="col-sm-6">
                                                                     <input class="form-control"  name="dob" id="dob" placeholder="DOB" value="<?php echo $getcontactDetails->dob ?>" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
                                                                  </div>
                                                                  <div id="editcontactPersonDiv_<?php echo $getcontactDetails->transport_contact_id ?>">
                                                                     <div class="row wrapping" id="edit_MainWraaping_<?php echo $getcontactDetails->transport_contact_id ?>">
                                                                        <div class="col-sm-3">
                                                                           <input class="form-control" name="Contact[0][mobile_no]" id="mobile_no" placeholder="Mobile No." maxlength="10" value="<?php echo $getcontactDetails->phone?>">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                           <input class="form-control" name="Contact[0][landline]" id="landline" placeholder="Landline No." value="<?php echo $getcontactDetails->land_line ?>">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                           <input class="form-control" name="Contact[0][email]" id="email" placeholder="Email" value="<?php echo $getcontactDetails->email ?>">
                                                                        </div>
                                                                     </div>
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
        <script>
         document.getElementById('pan_no').addEventListener('input', function() {
            var panInput = this.value;
            var panError = document.getElementById('panError');
            
            if (panInput.length > 10 || panInput.length < 10) {
                  panError.textContent = 'PAN number should be exactly 10 digits.';
                  console.log(panError.textContent)
            } else {
                  panError.textContent = '';
            }
         });
         document.getElementById('gst').addEventListener('input', function() {
            var gstInput = this.value;
            var gstError = document.getElementById('gstError');
            
            if (gstInput.length > 15 || gstInput.length < 15) {
                  gstError.textContent = 'GST number should be exactly 15 digits.';
            } else {
                  gstError.textContent = '';
            }
         });
         var indexContactLength = $('#contactPersonDiv .wrapping').length;
         $(document).on('click', '#addMoreContact', function () {
            var html=`<div class="row wrapping" id="mainWraaping_${indexContactLength}" style="margin-left:1px;">
                     <div class="col-sm-3 mt-2">
                        <input class="form-control" name="Contact[${indexContactLength}][mobile_no]" id="mobile_no" maxlength="10" placeholder="Mobile No." required>
                     </div>
                     <div class="col-sm-3 mt-2">
                        <input class="form-control" name="Contact[${indexContactLength}][landline]" id="landline" placeholder="Landline No." required>
                     </div>
                     <div class="col-sm-3 mt-2">
                        <input class="form-control" name="Contact[${indexContactLength}][email]" id="email" placeholder="Email" required>
                     </div>
                     <div class="col-sm-3 mt-2">
                     <button data-index="${indexContactLength}" style="margin-top: 5px;" type="button" class="btn btn-primary text-white" onclick="deleteContact(${indexContactLength})"><i class="fa fa-trash"></i> Delete</button>
                     </div>
                  </div>`;

               $('#contactPersonDiv').append(html);
            indexContactLength++;
         });
         function deleteContact(index){
			let text = 'Are you sure you want to remove this item?';
			if (confirm(text) == true) {
				$('div#mainWraaping_' + index + '').remove();
			}
		}
      $(document).on('click', '#editAddMoreContact', function () {
			var contactId=$(this).data('contactid');
			var indexEditContactLength = $('#editcontactPersonDiv_'+contactId+' .wrapping_owner').length+1;
			var html=`<div class="row wrapping" id="edit_MainWraaping_${indexEditContactLength}">
						<div class="col-sm-3">
							<input class="form-control" name="Contact[${indexEditContactLength}][mobile_no]" maxlength="10" id="mobile_no" placeholder="Mobile No." required>
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
      </script>
</body>

</html>