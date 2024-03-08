<?php
error_reporting(0);
$createdby = $this->session->userdata['user_id'];
   $enquiry_id = $_GET['enquiry_id'];
   
   $enquiryDetails = $this->db->query("SELECT * FROM enquiry WHERE isactive = 1  and is_customer = 1 and enquiry_id = $enquiry_id ORDER BY enquiry_id DESC")->result();

  foreach($enquiryDetails as $getenquiryDetails){
      $name = $getenquiryDetails->name;
      $pan_no = $getenquiryDetails->pan_no;
      $tan_no = $getenquiryDetails->tan_no;
      $gst = $getenquiryDetails->gst_no;
      $credit_limit = $getenquiryDetails->credit_limit;
      $credit_days = $getenquiryDetails->credit_days;
      $company_name = $getenquiryDetails->company_name;
      $state = $getenquiryDetails->state;
      $billing_address = $getenquiryDetails->billing_address;
      $shipping_address = $getenquiryDetails->shipping_address;
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
                  <li class="breadcrumb-item active">PO</li>
               </ol>
            </div>
         </div>
         <!-- End Bread crumb -->
         <!-- Container fluid  -->
         <div class="container-fluid">
             
            
            <!-- Start Page Content -->
            <section id="po_section" name="po_section">
               <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#poform" >PO</button>
               <div id="poform" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        <center>
                           <p style="color:green"><?php echo $this->session->flashdata('po_message') ?></p>
                        </center>
                        <h5 class="card-title">PO For (<?=$name?>)</h5>
                        <form method="post" action="Po/update_po_data" autocomplete="off" enctype="multipart/form-data">
                           <div class="row">
                               <div class="col-lg-12">
                                    <p><b style="color:black"><br>Attach PO</b></p>
                                    <?php if($enquiry_id <> NULL || $enquiry_id <> ''){ ?>
                                        
                                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">PO Documents List</h4>

                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>View File</th>
                                                <th>Added Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $poDetails = $this->db->query("SELECT * FROM po_document WHERE is_active = 1   and enquiry_id = $enquiry_id ORDER BY id DESC")->result();
                                            foreach($poDetails as $getpoDetails){ ?>
                                            <tr>
                                               <td><?php echo $getpoDetails->document_name ?></td> 
                                               <td><a target="_blank" href="<?php echo base_url()."assets/client_asstes/PO/".$getpoDetails->document_name ?>">   Click to View  </a></td>
                                               <td><?php echo date("d-m-Y", strtotime($getpoDetails->created_date)); ?></td>
                                            </tr>
                                        <?php } } ?>
                                           
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                                    
                                    <div id="inputFormRow">
                                        <div class="input-group mb-3"> 
                                            <input type="file" name="po_doc[]" id="po_doc" accept=".jpg,.jpeg,.png" onchange="validateFileType()" class="form-control m-input" placeholder="Enter title" autocomplete="off" multiple required>
                                            <!--<div class="input-group-append">                
                                                <button id="removeRow" type="button" class="btn btn-primary"><i class="fa fa-trash-o"></i></button>
                                            </div>-->
                                        </div>
                                    </div>
                                    <div id="newRow"></div>
                                    <button id="addRow" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                    <p>&nbsp;</p>
                                </div>
                              <div class="col-sm-12">
                                 <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>" required>
                              </div>
                               <div class="col-sm-4">
                                   <label>Company Name</label>
                                <select class="form-control " name="company_name"   id="company_name" required>
                                    <option value="">Company Name</option>
                                   <option <?php if($company_name=='SuperEditors'){ echo 'selected';}?> value = "SuperEditors">SuperEditors</option>
                                    <option <?php if($company_name=='MannaMenswear'){ echo 'selected';}?> value = "MannaMenswear">MannaMenswear</option>
                                </select>
                            </div>
                              <div class="col-sm-4">
                                  <label>Pan No</label>
                                 <input class="form-control" name="pan_no" type="text" maxlength="10"  id="pan_no" placeholder="PAN No." value="<?php echo $pan_no ?>" required>
                              </div>
                             <!-- <div class="col-sm-4">
                                  <label>Tan No</label>
                                 <input class="form-control" name="tan_no" id="tan_no" placeholder="TAN No."  value="<?php echo $tan_no ?>"  required>
                              </div>-->
                              <div class="col-sm-4">
                                  <label>Credit Days</label>
                                 <input class="form-control" type="number" name="credit_days" id="credit_days" value="<?php echo $credit_days ?>"  placeholder="Credit Days" required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Credit Limit</label>
                                 <input class="form-control" type="number" name="credit_limit" id="credit_limit" value="<?php echo $credit_limit ?>"  placeholder="Credit Limit"  required>
                              </div>
                              <div class="col-sm-4">
                                  <label>GST No</label>
                                 <input class="form-control" type="text"  maxlength="15" name="gst_no" id="gst_no" placeholder="GST No." value="<?php echo $gst ?>"   required>
                              </div>
                              <div class="col-sm-4">
                                  <label>State</label>
                                 <input class="form-control" name="state" id="state" placeholder="State" value="<?php echo $state ?>"  required>
                              </div>
                              <div class="col-sm-6">
                                  <label>Shipping Address</label>
                                 <input class="form-control" name="shipping_address" id="shipping_address" placeholder="Shipping Address" value="<?php echo $shipping_address ?>"  required>
                              </div>
                              <div class="col-sm-6">
                                  <label>Billing Address</label>
                                 <input class="form-control" name="billing_address" id="billing_address" placeholder="Billing Address" value="<?php echo $billing_address ?>"  required>
                              </div>
                              <div class="col-sm-6">
                              <p>&nbsp;</p>
                                 <input type="checkbox" id="customer" name="customer" checked value="1">
                                <label for="customer"> <b>&nbsp;&nbsp;Convert to Customer</b></label><br>
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
    <script type="text/javascript">
        // add row
        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="file" accept=".jpg,.jpeg,.png" name="po_doc[]" class="form-control m-input" placeholder="Enter title"  autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-primary"><i class="fa fa-trash-o"></i></button>';
            html += '</div>';
            html += '</div>';
    
            $('#newRow').append(html);
        });
    
        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });
    </script>

    <script type="text/javascript">
    function validateFileType(){
        var fileName = document.getElementById("po_doc").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
        }else{
            alert("Only jpg/jpeg and png files are allowed!");
            return false
        }   
    }

     $(document).ready(function() {       
        $('#po_doc').bind('change', function() {
        var a=(this.files[0].size);
        if(a < 2000000) {
            alert('Please select image size less than 2 MB');
            return false;
        };
    });
});
</script>
      
   </body>
</html>
