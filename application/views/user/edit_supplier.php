<?php
error_reporting(0);
$supplierid = $_GET["supplier_id"];
$id=$_GET["id"];
$supplierDetails = $this->db->query("SELECT * FROM supplier WHERE is_active = 1 AND supplier_id=$supplierid")->result();
$supplierdataDetails = $this->db->query("SELECT * FROM state WHERE country_id=1")->result();
$itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();
$itemNames =$this->db->query("SELECT * FROM items WHERE is_active=1")->result();
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
    <title>SuperEditors || Roles Page</title>
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
                    <h3 class="text-primary">Measure</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <section id="enquiry_section" name="enquiry_section">
               <center>
                    <p style="color:green"><?php echo $this->session->flashdata('supplier_message') ?></p>
                </center>
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        
                        <h5 class="card-title">supplier</h5>
                        <?php foreach($supplierDetails as $getsupplierDetails){ ?>
                    <form method="post" action="<?php echo base_url() ?>Supplier/save_edit_supplier_data" onsubmit="return confirm('Supplier Data successfully updated');" autocomplete="off">
                               <input class="form-control" type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $supplierid ?>" required>
                              <div class="row">
                              <div class="col-sm-6">
                                  <label>Supplier Name</label>
                                 <input class="form-control" name="name" id="name" value="<?php echo $getsupplierDetails->supplier_name ?>" placeholder="Supplier Name" required>
                              </div>
                             <div class="col-sm-6 mt-3"> 
                                <label>Address</label>
                            <input class="form-control" type="address" name="address" id="address" placeholder="Address" value="<?php echo $getsupplierDetails->address ?>"  required>
                              </div>
                              <div class="col-sm-6 mt-2">
                              <label>Item Category</label>
                              <select class="form-control" name="item_type" id="item_type" required>
                              <option value="">Select</option>
                                 <?php foreach($itemtypeDetails as $getitemtypeDetails){ ?>
                                 <option value="<?php echo $getitemtypeDetails->item_type_id ?>"<?php if($getitemtypeDetails->item_type_id == $getsupplierDetails->item_type){ ?>selected<?php } ?>><?php echo $getitemtypeDetails->item_type  ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="col-sm-6 mt-2">
                              <label>Item Name</label>
                              <select class="form-control" name="item_name" id="item_name" required>
                                 <option value="">Choose Item Name</option>
                              </select>
                           </div>
                              <div class="col-sm-3 mt-2">  
                              <label>gst</label>
                            <input class="form-control" type="text" name="gst" id="gst"  placeholder="GST" minlength="15" maxlength="15" value="<?php echo $getsupplierDetails->gst ?>" required>
                            <span id="gstError" style="color: red;"></span>
                              </div>
                              <div class="col-sm-3 mt-1">  
                              <label>Pan Number</label>
                              <input class="form-control" type="text" name="pan_no" id="pan_no"  placeholder="Pan No" minlength="10" maxlength="10" value="<?php echo $getsupplierDetails->pan_no ?>" required>
                              <span id="panError" style="color: red;"></span>
                           </div>
                             <div class="col-sm-6 mt-2"> 
                              <label>State</label>
                               <select class="form-control" name="state" id="state"  required>
                                           <?php foreach($supplierdataDetails as $getsupplierdataDetails){ ?>
                                      <option value="<?php echo $getsupplierdataDetails->id ?>"<?php if($getsupplierdataDetails->id == $getsupplierDetails->state_id){ ?>selected<?php } ?>><?php echo $getsupplierdataDetails->state  ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                              <div class="col-sm-6 mt-3">  
                              <label>Credit Day</label>
                            <input class="form-control" tyep="number" name="credit_day" id="credit_day" value="<?php echo $getsupplierDetails->credit_day ?>" placeholder="Credit Day"  required>
                              </div>
                              <div class="col-sm-6 mt-3">  
                              <label>Credit Limit</label>
                            <input class="form-control" type="number" name="credit_limit" id="credit_limit" value="<?php echo $getsupplierDetails->credit_limit ?>" placeholder="Credit Limit"   required>
                              </div>
                              <div class="col-sm-6 mt-3"> 
                              <label>Bank Name</label>
                            <input class="form-control" type="text" name="bank_name" id="bank_name" value="<?php echo $getsupplierDetails->bank_name ?>" placeholder="Bank Name" required>
                              </div>
                              <div class="col-sm-6 mt-3"> 
                              <label>Branch</label>
                            <input class="form-control" type="text" name="branch" id="branch" value="<?php echo $getsupplierDetails->branch ?>" placeholder="Branch"  required>
                              </div>
                              <div class="col-sm-6 mt-3">  
                              <label>Acount No</label>
                            <input class="form-control" type="number" name="acount_no" id="acount_no" value="<?php echo $getsupplierDetails->account_no ?>" placeholder="Acount"  required>
                              </div>
                              <div class="col-sm-6 mt-3">
                                  <label>IFSC</label>  
                            <input class="form-control" type="text" name="ifsc" id="ifsc" value="<?php echo $getsupplierDetails->ifsc ?>" placeholder="IFSC"  required>
                              </div>
                               <div class="col-sm-12">
                                <p>&nbsp;</p>  
                              </div>
                              <div class="col-sm-12">
                                 <br>
                                 <button type="submit" class="btn btn-primary  text-white" >Save</button>
                              </div>
                           </div>
                        </form>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </section>
               
            
            <!-- Start Page Content -->   
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