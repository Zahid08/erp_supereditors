<?php
$supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();


$company_name='';
$fromDate=$toDate='';

if (isset($_POST['from_date'])){
    $fromDate   =$_POST['from_date'];
    $toDate     =$_POST['to_date'];
}

if (isset($_POST['company_name'])){
    $company_name=$_POST['company_name'];
}

if(!empty($company_name) && !empty($fromDate) AND !empty($toDate) ){
    $where = "WHERE company_name='$company_name' AND ";
}else{
    $where = " ";
}



if(!empty($fromDate) && !empty($toDate)){
    $where .= "(created_date >='$fromDate' AND created_date <='$toDate')";
}else if(!empty($fromDate) && empty($toDate)){
    $where .= "(created_date >='$fromDate')";
}else if(empty($fromDate) && !empty($toDate)){
    $where .= "(created_date >='$toDate')";
}


$generalBilling = $this->db->query("SELECT * FROM general_billing_entry $where ORDER BY `billing_id`")->result();
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
    <title>SuperEditors || Billing Report List </title>
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
            <div class="col-md-5 align-self-center">Billing Supplier Payment Report</h3>
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
                <h4 class="">Billing Report</h4>
                <br>
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

                            <div class="col-sm-3 " style="margin-top: 32px;">
                                <button type="submit" name="save" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Serial No</th>
                            <th>Billing No</th>
                            <th>Company Name</th>
                            <th>Chalan No</th>
                            <th>Bill Type</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Net Amt</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $key=0;
                        $totalPaidAmount=0;
                        foreach ($generalBilling as $index=>$item){
                            $totalPaidAmount+=$item->net_bill_amount;
                            $key++;
                            ?>
                            <tr>
                                <td><?=$item->billing_serial?></td>
                                <td>
                                    <a target="_blank" href="<?php base_url() ?>get_billing_report?billing_serial=<?php echo $item->billing_serial;?>">
                                    <?php
                                    if($item->billing_number<10){
                                        echo 'SE-0'.$item->billing_number;
                                    }else{
                                        echo 'SE-'.$item->billing_number;
                                    }
                                    ?>
                                    </a>
                                </td>
                                 <td><?=$item->company_name?></td>
                                <td><?=$item->chalan_number?></td>
                                <td><?=$item->billing_type?></td>
                                <td><?=date('d-m-Y',strtotime($item->billing_date))?></td>
                                <td><?=$item->billing_customer?></td>
                                <td><?=$item->net_bill_amount?></td>
                                <td>
                                    <a target="_blank" href="<?php base_url() ?>get_billing_report?billing_serial=<?php echo $item->billing_serial;?>">
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
                    <h4 style="padding: 17px;">Total Net Amount: <?=$totalPaidAmount?></h4>
                    <h4 style="padding: 17px;">Total Billing Generations: <?=$key?></h4>
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
