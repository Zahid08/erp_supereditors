<?php
error_reporting(0);
$supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();
$transportDetailsValue = $this->db->query("SELECT * FROM transport WHERE is_active = 1")->result();

$company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
$fromDate = isset($_POST['from_date']) ? $_POST['from_date'] : '';
$toDate = isset($_POST['to_date']) ? $_POST['to_date'] : '';
$party_name = isset($_POST['party_name']) ? $_POST['party_name'] : '';

$where = "WHERE 1=1 AND s.is_active = 1 ";
if (!empty($company_name)) {
    $where .= "AND s.company_name = '$company_name' ";
}
if (!empty($_POST['party_name']) && !empty($_POST['party_name_type'])) {
   $party_name = $_POST['party_name'];
   $data_type = $_POST['party_name_type'];
   if ($data_type === 'supplier') {
       $where .= " AND s.supplier_id = '$party_name'";
   } elseif ($data_type === 'transport') {
       $where .= " AND t.transport_id = '$party_name'";
   }
}
if (!empty($fromDate) && !empty($toDate)) {
    $where .= "AND (s.created_date BETWEEN '$fromDate' AND '$toDate') ";
} elseif (!empty($fromDate) && empty($toDate)) {
    $where .= "AND s.created_date >= '$fromDate' ";
} elseif (empty($fromDate) && !empty($toDate)) {
    $where .= "AND s.created_date <= '$toDate' ";
}
$party_name = isset($_POST['party_name']) ? $_POST['party_name'] : '';
$party_name_type = isset($_POST['party_name_type']) ? $_POST['party_name_type'] : '';

if (empty($party_name_type) || $party_name_type === 'supplier') {
   $perchaseDetails = $this->db->query("SELECT 
       p.discountamount,
       p.purchase_item_id,
       pt.*,
       sup.supplier_name,
       sup.gst as s_gst,
       s.purchase_item_entry_id,
       s.challan_no,
       s.inward_no as p_inward_no,
       s.inward_date as p_inward_date,
       s.shaowroom_name as shaowroom_name,
       t.transport_name as transport_name,
       s.supplier_id,
       SUM(s.no_of_packs) as no_of_packs,
       SUM(s.billing_qty) as billing_qty,
       SUM(s.qty_per_pack) as qty_per_pack,
       SUM(s.rate) as rate,
       SUM(s.mrp) as mrp,
       SUM(s.amount) as amount,
       (
          SELECT GROUP_CONCAT(DISTINCT tax_per SEPARATOR '/') 
          FROM purchase_item_entry 
          WHERE inward_no = s.inward_no
       ) as tax_per,
       SUM(s.igst_tpt) as igst,
       SUM(s.cgst_tpt) as cgst,
       SUM(s.sgst_tpt) as sgst
       FROM  
       purchase_item_entry s
       LEFT JOIN purchase_item p ON p.purchase_item_entry_id = s.purchase_item_entry_id
       LEFT JOIN supplier sup ON sup.supplier_id = s.supplier_id
       LEFT JOIN purchase_transport pt ON pt.purchase_item_id = p.purchase_item_id
       LEFT JOIN transport t ON t.transport_id = pt.transport_id
       $where AND
       s.is_active = 1
       GROUP BY 
       s.inward_no, s.company_name, s.shaowroom_name
       ORDER BY 
           s.inward_no DESC;")->result();
}

if (empty($party_name_type) || $party_name_type === 'transport') {
   $transportDetails = $this->db->query("SELECT pt.*,
       t.gst,
       sup.supplier_name,
       pt.lr_no,
       pt.lr_qty,
       s.inward_date,
       p.netamt,
       p.purchase_item_id,
       t.transport_name,
       s.inward_no as p_inward_no
       FROM  
       purchase_transport pt
       LEFT JOIN purchase_item p ON p.purchase_item_id = pt.purchase_item_id
       LEFT JOIN transport t ON t.transport_id = pt.transport_id
       LEFT JOIN supplier sup ON sup.supplier_id = pt.supplier_id
       LEFT JOIN purchase_item_entry s ON s.purchase_item_entry_id = p.purchase_item_entry_id
       $where AND
       pt.is_active = 1
       GROUP BY 
       pt.inward_no
       ORDER BY 
           pt.inward_no DESC;")->result();
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
      <title>SuperEditors || Purchase Paid </title>
      <!-- Custom CSS -->
      <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
      <style>
         .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
            line-height: 11px;
        }
        .table td{
            padding: 0.4em;
        }
      </style>
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
            <!-- Container fluid  -->
            <div class="container-fluid">
              <center>
                  <p style="color:green"><?php echo $this->session->flashdata('purchase_message') ?></p>
               </center>
               <!-- Start Page Content -->
               <div class="card">
                  <div class="card-body">
                     <h4 class="text-primary">Purchase Item</h4>
                     <div class=" card-title">
                        <form  method="post" action="">
                            <div class="row">
                           <div class="col-sm-3">
                              <select class="form-control " name="company_name"   id="company_name">
                                 <option value="">Company/Firm Name </option>
                                 <option value="SuperEditors" <?php if($company_name == 'SuperEditors'){ ?> selected <?php } ?> >SuperEditors </option>
                                 <option value="MannaMenswear" <?php if($company_name == 'MannaMenswear'){ ?> selected <?php } ?>>MannasMensWear </option>
                              </select>

                           </div>
                            <div class="col-sm-3">
                              <select class="form-control" name="party_name"   id="party_name" >
                                  <option value="">Party Name</option>
                                    <?php foreach($supplierDetailsValue as $getsupplierDetails){ ?>
                                    <option value="<?php echo $getsupplierDetails->supplier_id ?>" data-type="supplier"><?php echo $getsupplierDetails->supplier_name  ?></option>
                                    <?php } ?>
                                    <?php foreach($transportDetailsValue as $gettransportDetails){ ?>
                                    <option value="<?php echo $gettransportDetails->transport_id ?>" data-type="transport"><?php echo $gettransportDetails->transport_name ?></option>
                                    <?php } ?>
                                 </select>
                           </div>
                           <div class="col-sm-2">
                                 
                               <input type = "text" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?php echo $fromDate ?>" onfocus="this.type='date'">
                          
                           </div>
                            <div class="col-sm-2">
                               
                               <input type = "text" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?php echo $toDate ?>" onfocus="this.type='date'">
                           </div>
                            <div class="col-sm-2 ">
                              <input type="hidden" name="party_name_type" id="party_name_type">
                               <button type="submit" name="save" class="btn btn-primary">Search</button>
                           </div>
                           </div>
                        </form>
                     </div>
                     <div class="table-responsive">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                           <thead>
                              <tr>
                                 <th>Sr.No</th>
                                 <th>Inward No</th>
                                 <th>Supplier Name</th>
                                 <th>GST</th>
                                 <th>Bill No/Challan No </th>
                                 <th>No of Pack</th>
                                 <th>Stock QTy</th>
                                 <th>Showroom Name</th>
                                 <th>Transport Inward No</th>
                                 <th>Transport Name</th>
                                 <th>Inward Date</th>
                                 <th>Discount Amount</th>
                                 <th>Purchase Amount</th>
                                 <th>Total IGST</th>
                                 <th>Total CGST</th>
                                 <th>Total SGST</th>
                                 <th>Total Tax</th>
                                 <th>Created By</th>
                                 <th>Action</th>
                              </tr>
                              <?php
                                 $i=1;
                                 $totalDisamt=0;
                                 $totalQty=0;
                                 $totalPurchaseAmount = 0;
                                 $totalIGST = 0;
                                 $totalCGST = 0;
                                 $totalSGST = 0;
                                    foreach($perchaseDetails as $getperchaseDetails){ 
                                    $totalDisamt += $getperchaseDetails->discountamount;
                                    $totalQty += $getperchaseDetails->billing_qty;
                                    $totalPurchaseAmount += $getperchaseDetails->amount;
                                    $totalIGST += $getperchaseDetails->igst;
                                    $totalCGST += $getperchaseDetails->cgst;
                                    $totalSGST += $getperchaseDetails->sgst;
                                    }
                                    foreach ($transportDetails as $getDetails) {
                                       $totalPurchaseAmount += $getDetails->netamt;
                                   }
                                   ?>
                              <tr>
                                 <td colspan="9"></td>
                                 <td>Total</td>
                                 <td><?php echo $totalDisamt; ?></td>
                                 <td><?php echo $totalQty; ?></td>
                                 <td><?php echo $totalPurchaseAmount; ?></td>
                                 <td><?php echo $totalIGST; ?></td>
                                 <td><?php echo $totalCGST; ?></td>
                                 <td><?php echo $totalSGST; ?></td>
                                 <td colspan="3"></td>
                              </tr>
                           </thead>
                           <tbody>
                           <?php
                           $i = 1;
                           foreach ($perchaseDetails as $getperchaseDetails) {
                           ?>
                              <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><a href="<?php echo base_url(); ?>Purchase/add_purchase?inward_no=<?php echo $getperchaseDetails->p_inward_no; ?>"><?php echo $getperchaseDetails->p_inward_no; ?></a></td>
                                    <td><?php echo $getperchaseDetails->supplier_name; ?></td>
                                    <td><?php echo $getperchaseDetails->s_gst; ?></td>
                                    <td><?php echo $getperchaseDetails->challan_no; ?></td>
                                    <td><?php echo $getperchaseDetails->no_of_packs; ?></td>
                                    <td><?php echo $getperchaseDetails->billing_qty; ?></td>
                                    <td><?php echo $getperchaseDetails->shaowroom_name; ?></td>
                                    <td><?php echo $getperchaseDetails->inward_no; ?></td>
                                    <td><?php echo $getperchaseDetails->transport_name; ?></td>
                                    <td><?php echo $getperchaseDetails->p_inward_date; ?></td>
                                    <td><?php echo $getperchaseDetails->discountamount; ?></td>
                                    <td><?php echo $getperchaseDetails->amount; ?></td>
                                    <td><?php echo $getperchaseDetails->igst; ?></td>
                                    <td><?php echo $getperchaseDetails->cgst; ?></td>
                                    <td><?php echo $getperchaseDetails->sgst; ?></td>
                                    <td><?php echo $getperchaseDetails->tax_per; ?></td>
                                    <td><?php echo ($getperchaseDetails->created_by == NULL) ? 'Self' : 'Admin'; ?></td>
                                    <td>
                                       <a href="<?php echo base_url(); ?>Purchase/view_purchase?inward_no=<?php echo $getperchaseDetails->p_inward_no; ?>">
                                          <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                       </a>
                                       <?php if (!empty($getperchaseDetails->purchase_item_id)) {
                                          echo "<a href=" . base_url() . "Purchase/item_barcode?purchase_item_id=" . $getperchaseDetails->purchase_item_id . ">
                                          <button type='button' class='btn btn-primary btn-sm'>View Barcodes</button></a>";
                                       } ?>
                                    </td>
                              </tr>
                           <?php
                           }
                           ?>

                           <?php
                           foreach ($transportDetails as $getDetails) {
                           ?>
                              <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><a href="<?php echo base_url(); ?>Purchase/add_purchase?inward_no=<?php echo $getDetails->inward_no; ?>"><?php echo $getDetails->inward_no; ?></a></td>
                                    <td><?php echo $getDetails->transport_name; ?></td>
                                    <td><?php echo $getDetails->gst; ?></td>
                                    <td><?php echo $getDetails->lr_no; ?></td>
                                    <td><?php echo $getDetails->lr_qty; ?></td>
                                    <td><?php echo $getDetails->supplier_name; ?></td>
                                    <td><?php echo $getDetails->p_inward_no; ?></td>
                                    <td><?php echo $getDetails->transport_name; ?></td>
                                    <td><?php echo $getDetails->inward_date; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $getDetails->netamt; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                       <a href="<?php echo base_url(); ?>Purchase/view_purchase?inward_no=<?php echo $getDetails->p_inward_no; ?>">
                                          <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                       </a>
                                       <?php if (!empty($getDetails->purchase_item_id)) {
                                          echo "<a href=" . base_url() . "Purchase/item_barcode?purchase_item_id=" . $getDetails->purchase_item_id . ">
                                          <button type='button' class='btn btn-primary btn-sm'>View Barcodes</button></a>";
                                       } ?>
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
               <!-- The Modal -->
            </div>
         </div>
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
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/dataTables.min.js"></script>
      <script>
         document.getElementById('party_name').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            console.log('party_name:',selectedOption );
            var partyType = selectedOption.getAttribute('data-type');
            $('input#party_name_type').val(partyType);
         });
</script>
   </body>
</html>