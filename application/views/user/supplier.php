<?php
error_reporting(0);
$itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();
$itemNames =$this->db->query("SELECT * FROM items WHERE is_active=1")->result();
$transodataDetails = $this->db->query("SELECT * FROM state WHERE country_id=1")->result();

$supplier_id = $_GET['supplier_id'];
if(!empty($supplier_id)){
       $transportDetails = $this->db->query("SELECT * FROM supplier WHERE is_active = 1 AND supplier_id = $supplier_id   ORDER BY supplier_id ASC")->result();   
       foreach($transportDetails as $gettransportDetails){
           $name = $gettransportDetails->supplier_name;
           $address = $gettransportDetails->address;
           $pan_no = $gettransportDetails->pan_no;
           $item_type = $gettransportDetails->item_type;
           $item = $gettransportDetails->item;
           $gst = $gettransportDetails->gst;
           $tax_type = $gettransportDetails->tax_type;
           $state = $gettransportDetails->state_id;
           $credit_day = $gettransportDetails->credit_day;
           $credit_limit = $gettransportDetails->credit_limit;
           $bank_name = $gettransportDetails->bank_name;
           $branch = $gettransportDetails->branch;
           $acountno = $gettransportDetails->account_no;
           $ifsc = $gettransportDetails->ifsc;
       }
       $contactDetails = $this->db->query("SELECT * FROM supplier_contact_details WHERE is_active = 1 AND  supplier_id= $supplier_id  ORDER BY supplier_contact_id DESC")->result();
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
	<title>SuperEditors || Home Page</title>
	<!-- Custom CSS -->
	<link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
	<!--============For Editor===========-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/client_asstes/css/lib/html5-editor/bootstrap-wysihtml5.css" />
	<!--============For Editor===========-->
	<!--============For Accordian===========-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <style>
        .custom-height {
            height: 25px;
        }
        select.custom-height {
            height: 30px !important;
         }
   </style>
	<!--============For Accordian===========-->
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

		<!-- End Bread crumb -->
		<!-- Container fluid  -->
		<div class="container-fluid" id="fullScreenDiv">
      <div class="col-sm-12">
         <div class="row" style="border-style: ridge; margin-left: 1%; padding-top: 0;">
            <div class="col-sm-6">
               <div class="row" style="border-style: ridge;margin-top: 3px;">
               &nbsp<h4 class="text-primary"> Supplier</h4>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                  <center>
                     <p style="color:green"><?php echo $this->session->flashdata('supplier_message') ?></p>
                  </center>
                  <form method="post" action="<?php echo base_url(); ?>Supplier/save_supplier_data" >
                     <div class="form-group" style="padding:10px;">
                        <div class="row">
                           <div class="col-sm-4 mt-1">
                              <label>Supplier Name</label>
                              <input class="form-control custom-height" type="text" name="supplier_name" id="supplier_name" value="<?php echo $name ?>" placeholder="Supplier Name" required>
                           </div>
                           <div class="col-sm-4 mt-2">
                              <label>Item Category</label>
                              <select class="form-control custom-height" name="item_type" id="item_type" required>
                              <option value="">Select</option>
                                 <?php foreach($itemtypeDetails as $getitemtypeDetails){ ?>
                                 <option value="<?php echo $getitemtypeDetails->item_type_id ?>"<?php if($getitemtypeDetails->item_type_id == $item_type){ ?>selected<?php } ?>><?php echo $getitemtypeDetails->item_type  ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="col-sm-4 mt-2">
                              <label>Item Name</label>
                              <select class="form-control custom-height" name="item_name" id="item_name" required>
                                 <option value="">Choose Item Name</option>
                              </select>
                           </div>
                           <div class="col-sm-4 mt-1"> 
                              <label>Address</label>
                              <input class="form-control custom-height" type="address" name="address" id="address" placeholder="Address" value="<?php echo $address ?>"  required>
                           </div>
                           <div class="col-sm-4 mt-1">  
                              <label>GST</label>
                              <input class="form-control custom-height" type="text" name="gst" id="gst"  placeholder="GST" minlength="15" maxlength="15" value="<?php echo $gst ?>" required>
                              <span id="gstError" style="color: red;"></span>
                           </div>
                           <div class="col-sm-4 mt-1">  
                              <label>Pan Number</label>
                              <input class="form-control custom-height" type="text" name="pan_no" id="pan_no"  placeholder="Pan No" minlength="10" maxlength="10" value="<?php echo $pan_no ?>" required>
                              <span id="panError" style="color: red;"></span>
                           </div>
                           <div class="col-sm-4 mt-1"> 
                              <label>State</label>
                              <select name="state" value="<?php echo $state ?>" class="form-control custom-height"placeholder="State" id="state">
                                 <?php foreach($transodataDetails as $gettransodataDetails){ ?>
                                    <option value="<?php echo $gettransodataDetails->id  ?>"<?php if($gettransodataDetails->id == $state){ ?>selected<?php } ?>><?php echo $gettransodataDetails->state ?></option>
                                    <?php } ?>
                              </select>
                           </div>
                           <div class="col-sm-4 mt-1">  
                              <label>Credit Day</label>
                              <input class="form-control custom-height" type="number" name="credit_day" id="credit_day" value="<?php echo $credit_day ?>" placeholder="Credit Day"  required>
                           </div>
                           <div class="col-sm-4 mt-1">  
                              <label>Credit Limit</label>
                                 <input class="form-control custom-height" type="number" name="credit_limit" id="credit_limit" value="<?php echo $credit_limit ?>" placeholder="Credit Limit"   required>
                           </div>
                           <div class="col-sm-4 mt-1"> 
                              <label>Bank Name</label>
                                 <input class="form-control custom-height" type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name ?>" placeholder="Bank Name" required>
                           </div>
                           <div class="col-sm-4 mt-1"> 
                              <label>Branch</label>
                                 <input class="form-control custom-height" type="text" name="branch" id="branch" value="<?php echo $branch ?>" placeholder="Branch"  required>
                           </div>
                           <div class="col-sm-4 mt-1">  
                              <label>Acount No</label>
                                 <input class="form-control custom-height"  pattern="\d*" minlength="8" maxlength="15" name="acount_no"   id="acount_no" value="<?php echo $acountno ?>"  placeholder="Acount No"  required>
                           </div>
                           <div class="col-sm-4 mt-1">
                              <label>IFSC</label>  
                              <input class="form-control custom-height" type="text" name="ifsc" id="ifsc" value="<?php echo $ifsc ?>" placeholder="IFSC"  required>
                           </div>
                           <div class="col-sm-4">
                              <br>
                              <button type="submit"  class="btn btn-primary   text-white" >Save</button>
                           </div>
                        </div>
                     </div>
                  </form>
                  &nbsp<h4 class="text-primary">Contact Persons</h4>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                  <center>
                     <p style="color:green"><?php echo $this->session->flashdata('contact_message') ?></p>
                  </center>
                     <form method="post" action="<?php echo base_url(); ?>Supplier/save_contact_data"  autocomplete="off">
                        <div class="form-group" style="padding:10px;">
                           <div class="row">
                              <input class="form-control custom-height" type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $_GET['supplier_id'] ?>">
                              <div class="col-sm-6">
                                 <input class="form-control custom-height" name="name" id="name" placeholder="Contact Name" required>
                              </div>
                              <div class="col-sm-6">
                                 <select class="form-control custom-height" name="designation" id="designation">
                                    <option>Designation</option>
                                    <option>Owner</option>
                                    <option>Manager/Admin</option>
                                    <option>Purchase</option>
                                    <option>HR</option>
                                    <option>Account</option>
                                    <option>Sales</option>
                                    <option>Co-ordinator</option>
                                    <option>Store</option>
                                 </select>
                              </div>
                              <div class="col-sm-6">
                                 <input class="form-control custom-height"  name="dob" id="dob" placeholder="DOB" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
                              </div>
                              <div class="col-sm-6">
                                 <input class="form-control custom-height"  name="marriage_anniversary_date" id="marriage_anniversary_date" placeholder="Marriage Anniversary Date" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
                              </div>
                              <div id="contactPersonDiv">
                                 <div class="row wrapping" style="margin-left:1px;">
                                    <div class="col-sm-3 mt-2">
                                       <input class="form-control custom-height" name="Contact[0][mobile_no]" id="mobile_no" placeholder="Mobile No." maxlength="10"  required>
                                    </div>
                                    <div class="col-sm-3 mt-2">
                                       <input class="form-control custom-height" name="Contact[0][landline]" id="landline" placeholder="Landline No."  required>
                                    </div>
                                    <div class="col-sm-3 mt-2">
                                       <input class="form-control custom-height" name="Contact[0][email]" id="email" placeholder="Email"  required>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                       <button type="button" class="btn btn-primary text-white" id="addMoreContact" ><i class="fa fa-plus"></i>Add More</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <br>
                                 <button type="submit" class="btn btn-primary  text-white" >Save</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            <div class="col-sm-6">
               <div class="row" style="border-style: ridge;margin-top: 3px;">
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
                                    <a href="<?php echo base_url(); ?>Supplier/delete_contact_supplier_data?supplier_contact_id=<?php echo $getcontactDetails->supplier_contact_id ?>&supplier_id=<?php echo $getcontactDetails->supplier_id?>">
                                             <button type="button" onclick="return confirm('Are you sure you want to delete this Record?');"  class="btn btn-primary  " >
                                                Delete
                                             </button>
                                             </a>
                                             
                                 <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editContact<?php echo $getcontactDetails->supplier_contact_id ?>"><i class="fa fa-edit"></i> Edit</button>
                              <!--Contact Modal-->

                                    <!-- Modal -->
                                    
                                    <div class="modal fade" id="editContact<?php echo $getcontactDetails->supplier_contact_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                       <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Contact</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="font-size:30px;position: absolute;top: 10px;">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                                <form method="post" action="<?php echo base_url(); ?>Supplier/save_contact_supplier_data" >
                                                   <div class="row">
                                                      <div class="col-sm-12">
                                                         <input class="form-control custom-height" type="hidden" name="supplier_contact_id" id="supplier_contact_id" value="<?php echo $getcontactDetails->supplier_contact_id ?>">
                                                      </div>
                                                      <div class="col-sm-12">
                                                         <input class="form-control custom-height" type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $_GET['supplier_id'] ?>">
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <input class="form-control custom-height" name="name" id="name" placeholder="Contact Name" value="<?php echo $getcontactDetails->contact_name ?>" required>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <input class="form-control custom-height" name="designation" id="designation" value="<?php echo $getcontactDetails->designation ?>" placeholder="Mobile No./Landline No." required>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <input class="form-control custom-height"  name="dob" id="dob" placeholder="DOB" value="<?php echo $getcontactDetails->dob ?>" onfocus="this.type='date'" max="<?php echo date("Y-m-d") ?>">
                                                      </div>
                                                      <div id="editcontactPersonDiv_<?php echo $getcontactDetails->supplier_contact_id ?>">
                                                         <div class="row wrapping" id="edit_MainWraaping_<?php echo $getcontactDetails->supplier_contact_id ?>">
                                                            <div class="col-sm-3">
                                                               <input class="form-control custom-height" name="Contact[0][mobile_no]" id="mobile_no" placeholder="Mobile No." maxlength="10" value="<?php echo $getcontactDetails->phone ?>">
                                                            </div>
                                                            <div class="col-sm-3">
                                                               <input class="form-control custom-height" name="Contact[0][landline]" id="landline" placeholder="Landline No." value="<?php echo $getcontactDetails->land_line ?>">
                                                            </div>
                                                            <div class="col-sm-3">
                                                               <input class="form-control custom-height" name="Contact[0][email]" id="email" placeholder="Email" value="<?php echo $getcontactDetails->email ?>">
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

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
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
                        <input class="form-control custom-height" name="Contact[${indexContactLength}][mobile_no]" id="mobile_no" maxlength="10" placeholder="Mobile No." required>
                     </div>
                     <div class="col-sm-3 mt-2">
                        <input class="form-control custom-height" name="Contact[${indexContactLength}][landline]" id="landline" placeholder="Landline No." required>
                     </div>
                     <div class="col-sm-3 mt-2">
                        <input class="form-control custom-height" name="Contact[${indexContactLength}][email]" id="email" placeholder="Email" required>
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
							<input class="form-control custom-height" name="Contact[${indexEditContactLength}][mobile_no]" maxlength="10" id="mobile_no" placeholder="Mobile No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control custom-height" name="Contact[${indexEditContactLength}][landline]" id="landline" placeholder="Landline No." required>
						</div>
						<div class="col-sm-3">
							<input class="form-control custom-height" name="Contact[${indexEditContactLength}][email]" id="email" placeholder="Email" required>
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
      $(document).on('change', 'select#item_type', function() {
            var item_type_id = $(this).val();
            var post_data = {
               'item_type_id': item_type_id,
               '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };

            var url = "<?php echo base_url();?>Supplier/getItemName";

            $.ajax({
               url: url,
               type: 'POST',
               data: post_data,
               success: function(result) {
                     var obj = JSON.parse(result);
                     $('select#item_name').find('option').remove();
                     $('select#item_name').append($('<option/>', {
                        value: '',
                        text: 'Select Item Name',
                     }));

                     for (var i = 0; i < obj.length; i++) {
                        $('select#item_name').append($('<option/>', {
                           value: obj[i]['item_id'],
                           text: obj[i]['item_name']
                        }));
                     }
               }
            });
         });
      $(document).ready(function() {
         $('#item_type').select2({
            placeholder: 'Select Category',
            allowClear: true,
         });
         $('#state').select2({
            placeholder: 'Select State',
            allowClear: true,
         });
         $('#item_name').select2({
            placeholder: 'Select Item',
            allowClear: true,
         });
      });
      $(document).ready(function () {
        var initialItemTypeId = $('#item_type').val();
        if (initialItemTypeId) {
            $('#item_type').trigger('change');
        }
      });      
      </script>   
</body>

</html>