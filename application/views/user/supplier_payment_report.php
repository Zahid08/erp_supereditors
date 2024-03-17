<?php
error_reporting(0);
$supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();
$c_name = $_POST['c_name'];


$fromDate=$toDate='';
if (isset($_POST['from_date'])){
    $fromDate   =$_POST['from_date'];
    $toDate     =$_POST['to_date'];
}
$company_name='';

if (isset($_POST['company_name'])){
    $company_name=$_POST['company_name'];
}

if(!empty($company_name) && !empty($fromDate) AND !empty($toDate) ){
    $where = "WHERE supplier_id='$company_name' AND ";
}else{
    $where = "WHERE ";
}

$paymentMode='';
if (isset($_REQUEST['payment_mode'])){
    $paymentMode=$_REQUEST['payment_mode'];
}

if(!empty($company_name) && !empty($fromDate) && isset($toDate) ){
    $where = "WHERE supplier_id='$company_name' AND payment_mode='$paymentMode' AND ";
}else{
    $where = "";
}

if(!empty($c_name) ){
    $where .= " a.company_name = $c_name";
}

if(!empty($fromDate) && !empty($toDate)){
    $where .= "(created_date >='$fromDate' AND created_date <='$toDate')";
}else if(!empty($fromDate) && empty($toDate)){
    $where .= "(created_date >='$fromDate')";
}else if(empty($fromDate) && !empty($toDate)){
    $where .= "(created_date >='$toDate')";
}

$getAllSupplier = $this->db->query("SELECT * FROM supplier_payment_entry $where order by supplier_payment_id")->result();

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
    <title>SuperEditors || Supplier Paid </title>
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
</head>
<body class="header-fix fix-sidebar">
<!-- Main wrapper  -->
<style>
    .form-control {
        height: 34px!important;
    }
    .dataTables_wrapper {
        padding-top: 0!important;
    }
</style>
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
                <h3 class="text-primary">Supplier Payment Report</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Supplier Payment</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start Page Content -->
            <div class="card">
                <div class=" card-title">
                    <form  method="post" action="">
                        <div class="row">
                            <div class="col-sm-3">
                                   <label>Company Name</label>
                                <select class="form-control " name="company_name"   id="company_name" required>
                                    <option value="">Company Name</option>
                                   <option value = "SuperEditors">SuperEditors</option>
                                    <option value = "MannaMenswear">MannaMenswear</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Form Date</label>
                                <input type = "text" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?php echo $fromDate ?>" onfocus="this.type='date'" required>
                            </div>
                            <div class="col-sm-3">
                                <label>To Date</label>
                                <input type = "text" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?php echo $toDate ?>" onfocus="this.type='date'" required>
                            </div>
                            <div class="col-sm-3">
                                <label>Party Name</label>
                                <select class="form-control " name="company_name"   id="company_name" required>
                                    <option value="">Company/Firm Name </option>
                                    <?php foreach($supplierDetailsValue as $getsupplierDetails){  echo "<pre>";
                                        ?>
                                        <option value="<?php echo $getsupplierDetails->supplier_id  ?>"><?php echo $getsupplierDetails->supplier_name  ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Payment Mode</label>
                                <select type = "text" class="form-control" name="payment_mode" id="payment_mode" required>
                                    <option value="">Mode of Payment</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                    <option value="IMPS">IMPS</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Google Pay">Google Pay</option>
                                    <option value=" Phone Pay"> Phone Pay</option>
                                </select>
                            </div>
                            <div class="col-sm-3 " style="margin-top: 23px;">
                                <button type="submit" name="save" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Voucher Number</th>
                            <th>Company Name</th>
                            <th>Party Name</th>
                            <th>Payment Date</th>
                            <th>Amt Paid</th>
                            <th>TDS Ded</th>
                            <th>Other Ded</th>
                            <th>Pay Mode</th>
                            <th>Bank Details</th>
                            <th>Cheque No</th>
                            <th>Total Adv Adjusted</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $key=0;
                        $totalPaidAmount=0;
                        $totalAdjustAmount=0;
                        $totalOtherDeductions=0;
                        $totalTdsDecutions=0;
                        foreach ($getAllSupplier as $index=>$item){
                            $totalPaidAmount+=$item->amount_paid;
                            $totalAdjustAmount=$item->amount_adjusted;
                            $totalOtherDeductions+=$item->total_other_deduction;
                            $totalTdsDecutions+=$item->total_tds_deducted;

                            $supplierId=$item->supplier_id;
                            $getSupplier = $this->db->query("SELECT supplier_name FROM supplier where supplier_id=$supplierId")->row();

                            $key++;
                            ?>
                            <tr>
                                <td><?=$key?></td>
                                <td><a target="_blank" href="<?php base_url() ?>generatedPdf?vc=<?php echo $item->voucher_no;?>&supplier=<?php echo $supplierId;?>&company=<?php echo $item->company_name;?>"><?=$item->voucher_no?></a></td>
                                <td><?=$item->company_name?></td>
                                 <td><?=$getSupplier->supplier_name?></td>
                                <td><?=date('d-m-Y',strtotime($item->payment_date))?></td>
                                <td><?=$item->amount_paid?></td>
                                <td><?=$item->total_tds_deducted?></td>
                                <td><?=$item->total_other_deduction?></td>
                                <td><?=$item->payment_mode?></td>
                                <td><?=$item->bank_detail?></td>
                                <td><?=$item->cheque_no?></td>
                                <td><?=$item->amount_adjusted?></td>
                                <td>
                                    <a target="_blank" href="<?php base_url() ?>generatedPdf?vc=<?php echo $item->voucher_no;?>&supplier=<?php echo $supplierId;?>&company=<?php echo $item->company_name;?>">
                                        <button type="button" class="btn btn-primary btn-sm" >
                                            View Report
                                        </button></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 28px;display: flex">
                    <h4 style="padding: 17px;">Total Paid Amount: <?=$totalPaidAmount?></h4>
                    <h4 style="padding: 17px;">Total Adjust Amount: <?=$totalAdjustAmount?></h4>
                    <h4 style="padding: 17px;">Total Other Deductions: <?=$totalOtherDeductions?></h4>
                    <h4 style="padding: 17px;">Total TDS Deductions: <?=$totalTdsDecutions?></h4>
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
</body>
</html>
