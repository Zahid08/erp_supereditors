<?php
$supplier_name='';
$amount_to_adjust='';
if(isset($_POST['party_name'])){

    $supplier_name = $_POST['party_name'];
    $company_name = $_POST['company_name'];

    $getValuesQuery = $this->db->query("SELECT * FROM supplier s
                                             INNER JOIN advance_payment_entry a ON s.supplier_id = a.supplier_id
                                             WHERE s.supplier_name LIKE '%$supplier_name%' AND a.company_name = '$company_name'  LIMIT 1")->result();

    foreach($getValuesQuery as $getValuesQueryvalue){
        $voucher_no = $getValuesQueryvalue->voucher_no;
        $supplier_id = $getValuesQueryvalue->supplier_id;
    }

  redirect('Payment_Paid_Entry_Supplier?vc='.$voucher_no.'&supplier='.$supplier_id.'&company='.$company_name);
}


$voucher_no=$supplier_id='';
if (isset($_GET['vc'])) {
    $voucher_no = $_GET['vc'];
}
if (isset($_GET['supplier'])) {
    $supplier_id = $_GET['supplier'];
}

if(!empty($voucher_no) && !empty($supplier_id)){
    $where = "WHERE s.is_active = 1 AND a.supplier_id = $supplier_id AND a.voucher_no = $voucher_no";
}else{
    $where = "WHERE s.is_active = 1";
}

$supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();
$adjustmentDetails = $this->db->query("SELECT * FROM supplier s
                                             INNER JOIN advance_payment_entry a ON s.supplier_id = a.supplier_id
                                             $where")->result();

if(!empty($voucher_no) && !empty($supplier_id)){
    foreach($adjustmentDetails as $getadjustmentDetails){
        $supplier_name = $getadjustmentDetails->supplier_name;
        $payment_date = $getadjustmentDetails->payment_date;
        $amount_to_adjust = $getadjustmentDetails->amount_paid - $getadjustmentDetails->amount_adjusted;
        $voucher_no = $getadjustmentDetails->voucher_no;
    }
}


if(!empty($supplier_id)){
    $purchase_where = "where p.supplier_id = $supplier_id";
}else{
    $purchase_where = '';
}
$purchaseSupDetails='';
if(!empty($supplier_id) && !empty($voucher_no) ){
    $purchaseSupDetails = $this->db->query("SELECT *,p.created_date as sup_created_date FROM  purchase_supplier_payment pp
                                            INNER JOIN purchase_supplier p ON p.purchase_supplier_id = pp.purchase_supplier_id
                                             INNER JOIN supplier s ON s.supplier_id = p.supplier_id
                                             $purchase_where ORDER BY 1 DESC")->result();
}


$initPayment = $this->db->query("SELECT SUM(amount_adjusted) as amount_adjusted FROM supplier_payment_entry")->row();
$adjustAmount=0;
if ($initPayment){
    $adjustAmount=$initPayment->amount_adjusted;
    if ($amount_to_adjust) {
        $amount_to_adjust = $amount_to_adjust - $adjustAmount;
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
    <title>SuperEditors || Purchase Paid </title>
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
    <style>
        .dt-buttons  {
            display: none;
        }
        .dataTables_filter {
            display: none;
        }
        table.dataTable thead .sorting::after {
            display:none;
        }
        .dataTables_info, .dataTables_length {
            display: none;
        }
        .hide-input-field {
            display: none;
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
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Supplier Payment Entry</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Purchase Paid Entry</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">

        </div>
        <div class="container-fluid">
            <!--    <a href="<?php echo base_url()?>Purchase/add_purchase" target="_blank"><button type="button" class="btn btn-primary  text-white" >Add Purchase</button></a>
                  -->
            <center>
                <p style="color:green"><?php echo $this->session->flashdata('purchase_message') ?></p>
            </center>
            <!-- Start Page Content -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Purchase Paid Entry</h4>
                    <form method="post" action="" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-4">
                                   <label>Company Name</label>
                                <select class="form-control " name="company_name"   id="company_name" required>
                                    <option value="">Company Name</option>
                                    <option value = "SuperEditors" <?php if(isset($_GET['company'] ) && $_GET['company'] == 'SuperEditors'){ ?> selected <?php } ?>>SuperEditors</option>
                                    <option value = "MannaMenswear" <?php if(isset($_GET['company']) && $_GET['company'] == 'MannaMenswear'){ ?> selected <?php } ?> >MannaMenswear</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Party Name</label>
                                <input type="text" list="supp_names"  class="form-control" name="party_name" id="party_name" value="<?php echo $supplier_name ?>" placeholder="Party Name" >
                                <datalist id="supp_names">
                                    <?php foreach($supplierDetailsValue as $getsupplierDetails){ ?>
                                    <option value="<?php echo $getsupplierDetails->supplier_name  ?>">
                                        <?php } ?>
                                </datalist>
                            </div>
                            <div class="col-sm-1 mt-3">
                                <br>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-sm-2">
                                <label>Voucher</label>
                                <input type="text" class="form-control" name="" id="" value="<?php echo $voucher_no ?>" placeholder="Advance To Adjust" style="pointer-events: none" >
                            </div>
                            <div class="col-sm-2">
                                <label>Amount To Adjust</label>
                                <input type="text" class="form-control" name="amount_to_adjust" id="amount_to_adjust" value="<?php echo $amount_to_adjust ?>" placeholder="Advance To Adjust" value="<?php echo isset($_POST['advance_adjust']) ?$_POST['advance_adjust']:''?>" >
                            </div>
                        </div>
                    </form>

                    <form method="post" action="<?php base_url() ?>Payment_Paid_Entry_Supplier/payment_update?vc=<?php echo $voucher_no ?>&supplier=<?php echo $supplier_id ?>">
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>
                                        Select<br/>
<!--                                        <input type="checkbox" id="select_all1">-->
                                    </th>
                                    <th>Inward No</th>
                                    <th>Bill No</th>
                                    <th>Company Name</th>
                                    <th>Party Name</th>
                                    <th>Purchase Amount</th>
                                    <th style="width: 100%!important;">Amt Paid</th>
                                    <th>TDS Ded</th>
                                    <th>Other Ded</th>
                                    <th>Adv Adjust</th>
                                    <th>Balance</th>
                                    <th>Payment Mode</th>
                                    <th>Cheque Number</th>
                                    <th>Pay Paid By</th>
                                    <th>Due Date</th>
                                    <th>Stock Received</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=1;$purchaseAmountTotal=$totalbalanceAmount=0;
                                if ($purchaseSupDetails){
                                foreach($purchaseSupDetails as $key=>$getpurchaseSupDetails){
                                    $purchaseAmountTotal+=$getpurchaseSupDetails->total_purchase_amount;
                                    $totalbalanceAmount+=$getpurchaseSupDetails->balance;
                                    ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td>
                                            <input type="checkbox" id="purchase_supplier_payment_id" data-key-index="<?=$key?>" value="<?php echo $getpurchaseSupDetails->purchase_supplier_payment_id ?>" name="PurchasePaymentId[<?=$key?>][purchase_supplier_payment_id]" />
                                        </td>
                                        <td><?php echo $getpurchaseSupDetails->inward_no ?></td>
                                        <td><?php echo $getpurchaseSupDetails->challan_no ?></td>
                                        <td><?php echo $getpurchaseSupDetails->company_name ?></td>
                                        <td><?php echo $getpurchaseSupDetails->supplier_name ?></td>
                                        <td>
                                            <span id="purchasingAmount_<?=$key?>" ><?php echo $getpurchaseSupDetails->total_purchase_amount ?></span>
                                        </td>
                                        <td style="width: 100%;">
                                            <span class="previous-amount-paid" id="amountPaidSpan_<?=$key?>" ><?php echo $getpurchaseSupDetails->amount_paid ?></span>
                                            <input type="text" data-key-index="<?=$key?>" name="PurchasePaymentId[<?=$key?>][amount_paid]" id="amountPaidTextField_<?=$key?>" class="form-control hide-input-field amount-payment-change-event" value="<?php echo $getpurchaseSupDetails->amount_paid ?>">
                                        </td>
                                        <td>
                                            <span class="previous-amount-paid" id="tdsDeducationsAmountSpan_<?=$key?>" ><?php echo $getpurchaseSupDetails->tds_deduction ?></span>
                                            <input type="text" data-key-index="<?=$key?>" name="PurchasePaymentId[<?=$key?>][tds_deduction]" id="tdsDeducationsAmount_<?=$key?>" class="form-control hide-input-field amount-payment-change-event" value="<?php echo $getpurchaseSupDetails->tds_deduction ?>">
                                        </td>
                                        <td>
                                            <span class="previous-amount-paid" id="otherDeductionsSpan_<?=$key?>" ><?php echo $getpurchaseSupDetails->other_deduction ?></span>
                                            <input type="text" data-key-index="<?=$key?>"  name="PurchasePaymentId[<?=$key?>][other_deduction]" id="otherDeductionsTextField_<?=$key?>" class="form-control hide-input-field amount-payment-change-event" value="<?php echo $getpurchaseSupDetails->other_deduction ?>">
                                        </td>
                                        <td>
                                            <span class="previous-amount-paid" id="advanceAdjustSpan_<?=$key?>" ><?php echo $getpurchaseSupDetails->advance_adjusted ?></span>
                                            <input type="text" data-key-index="<?=$key?>"  name="PurchasePaymentId[<?=$key?>][advance_adjusted]" id="advanceAdjustField_<?=$key?>" class="form-control hide-input-field amount-payment-change-event advace-adjust-payment" value="<?php echo $getpurchaseSupDetails->advance_adjusted ?>">
                                        </td>
                                        <td>
                                            <span id="totalBalance_<?=$key?>" data-previous-total-balance="<?php echo $getpurchaseSupDetails->balance ?>"><?php echo $getpurchaseSupDetails->balance ?></span>
                                        </td>
                                        <td><?php echo $getpurchaseSupDetails->payment_mode ?></td>
                                        <td><?php echo $getpurchaseSupDetails->chq_no ?></td>
                                        <td><?php echo $getpurchaseSupDetails->paid_by ?></td>
                                        <td>
                                        </td>
                                        <td>

                                            <a href="<?php echo base_url(); ?>Payment_Paid_Entry_Supplier/status_update?purchase_supplier_id=<?php echo $getpurchaseSupDetails->purchase_supplier_id ?>&stock_received=<?php echo $getpurchaseSupDetails->stock_received ?>&vc=<?php echo $voucher_no ?>&supplier=<?php echo $supplier_id ?>">
                                                <button type="button" onclick="return confirm('Please confirm the stock has been received');"  class="btn btn-primary" >
                                                    <?php if( $getpurchaseSupDetails->stock_received == 0) { echo 'NO'; }elseif($getpurchaseSupDetails->stock_received == 1){ echo 'YES'; }  ?>
                                                </button>
                                            </a>

                                    </tr>
                                <?php }?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div style="display: flex;">
                            <div class="col-sm-3" style="font-size: 13px;margin-top: 20px;">
                                <label>Total Purchasing Amount:</label>
                                <span><?=$purchaseAmountTotal?></span>
                            </div>
                            <div class="col-sm-3" style="font-size: 13px;margin-top: 20px;">
                                <label>Total Balance Amount:</label>
                                <span><?=($purchaseAmountTotal-$totalbalanceAmount)?></span>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>

                        <input type ="hidden" class="form-control" name="companyName" id="companyName"  placeholder="companyName"  value="<?php echo isset($_GET['company'])?$_GET['company']:'';?>">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Total Amt Paid</label>
                                <input type ="number" class="form-control" name="total_amount_paid" id="total_amount_paid"  placeholder="Total Amount Paid"  required>
                            </div>
                            <div class="col-sm-3">
                                <label>Total Adv Adjusted</label>
                                <input type ="number" class="form-control" name="total_adv_adjusted" id="total_adv_adjusted" <?php if($amount_to_adjust <=0){ ?> readonly <?php } ?>  placeholder="Total Adv Adjusted"  >
                            </div>
                            <div class="col-sm-3">
                                <label>Total Other Ded.</label>
                                <input type ="number" class="form-control" name="total_other_deduction" id="total_other_deduction"  placeholder="Total Other Ded."  >
                            </div>
                            <div class="col-sm-3">
                                <label>Total TDS Dec.</label>
                                <input type ="number" class="form-control" name="total_tds_deducted" id="total_tds_deducted"  placeholder="Total TDS Dec."  >
                            </div>
                            <div class="col-sm-3">
                                <label>Payment Mode</label>
                                <select type = "text" class="form-control" name="payment_mode" id="payment_mode"  required>
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
                            <div class="col-sm-3">
                                <label>Payment Date</label>
                                <input type ="date" class="form-control" name="payment_date" id="payment_date"  placeholder="Payment Date" required >
                            </div>
                            <div class="col-sm-3">
                                <label>Bank Details</label>
                                <input type ="text" class="form-control" name="bank_details" id="bank_details"  placeholder="Bank Details"  >
                            </div>
                            <div class="col-sm-3">
                                <label>Cheque No./Transaction ID</label>
                                <input type ="text" class="form-control" name="chq_no" id="chq_no"  placeholder="Chq No."  required>
                            </div>
                            <div class="col-sm-3">
                                <label>Paid By</label>
                                <input type ="text" class="form-control" name="paid_by" id="paid_by"  placeholder="Paid By"  required>
                            </div>
                            <div class="col-sm-12">
                                <br>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
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

    <script>
        $( document ).ready(function() {

            var errorImage      ='<?php echo base_url(); ?>assets/alert_image/error.svg';
            var successImage    ='<?php echo base_url(); ?>assets/alert_image/logo.png';

            $('input[type="checkbox"]').click(function(){
                var currenIndex                     =$(this).data('key-index');
                var amountPaidTextFiledObject       ='input#amountPaidTextField_'+currenIndex+'';
                var amountPaidSpanObject            ='span#amountPaidSpan_'+currenIndex+'';

                var tdsDedeuctionsFieldObject       ='input#tdsDeducationsAmount_'+currenIndex+'';
                var tdsDedeuctionsSpanObject         ='span#tdsDeducationsAmountSpan_'+currenIndex+'';

                var otherDeductionsTextField      ='input#otherDeductionsTextField_'+currenIndex+'';
                var otherDeductionsSpan        ='span#otherDeductionsSpan_'+currenIndex+'';

                var advanceAdjustField      ='input#advanceAdjustField_'+currenIndex+'';
                var advanceAdjustSpan        ='span#advanceAdjustSpan_'+currenIndex+'';
                var previousTotalBalance    =$('span#totalBalance_'+currenIndex+'').data('previous-total-balance');


                if($(this).prop("checked") == true){
                    $(amountPaidTextFiledObject).removeClass('hide-input-field');
                    $(amountPaidSpanObject).addClass('hide-input-field');
                    $(amountPaidTextFiledObject).val($(amountPaidSpanObject).text());

                    $(tdsDedeuctionsFieldObject).removeClass('hide-input-field');
                    $(tdsDedeuctionsSpanObject).addClass('hide-input-field');
                    $(tdsDedeuctionsFieldObject).val($(tdsDedeuctionsSpanObject).text());

                    $(otherDeductionsTextField).removeClass('hide-input-field');
                    $(otherDeductionsSpan).addClass('hide-input-field');
                    $(otherDeductionsTextField).val($(otherDeductionsSpan).text());

                    $(advanceAdjustField).removeClass('hide-input-field');
                    $(advanceAdjustSpan).addClass('hide-input-field');
                    $(advanceAdjustField).val($(advanceAdjustSpan).text());

                    $(amountPaidTextFiledObject).val(previousTotalBalance);
                }
                else if($(this).prop("checked") == false){
                    $(amountPaidTextFiledObject).addClass('hide-input-field');
                    $(amountPaidSpanObject).removeClass('hide-input-field');
                    $(amountPaidTextFiledObject).val($(amountPaidSpanObject).text());

                    $(tdsDedeuctionsFieldObject).addClass('hide-input-field');
                    $(tdsDedeuctionsSpanObject).removeClass('hide-input-field');
                    $(tdsDedeuctionsFieldObject).val($(tdsDedeuctionsSpanObject).text());

                    $(otherDeductionsTextField).addClass('hide-input-field');
                    $(otherDeductionsSpan).removeClass('hide-input-field');
                    $(otherDeductionsTextField).val($(otherDeductionsSpan).text());

                    $(advanceAdjustField).addClass('hide-input-field');
                    $(advanceAdjustSpan).removeClass('hide-input-field');
                    $(advanceAdjustField).val($(advanceAdjustSpan).text());

                    $('span#totalBalance_'+currenIndex+'').text(previousTotalBalance);
                    $(amountPaidTextFiledObject).val(parseFloat(0).toFixed(2));
                }

                summationsToptalInformations();
                balanceCalcualted(currenIndex);
            });


            function summationsToptalInformations(){
                var totalAmountOfPaid=0;
                var totalTdsDeductions=0;
                var totalOtherDeductions=0;
                var advanceAdjustmentAmount=0;

                $("input:checkbox[type=checkbox]:checked").each(function(){
                    var index                   =$(this).data('key-index');
                    totalAmountOfPaid           =totalAmountOfPaid+Number($('input#amountPaidTextField_'+index+'').val());
                    totalTdsDeductions          =totalTdsDeductions+Number($('input#tdsDeducationsAmount_'+index+'').val());
                    totalOtherDeductions        =totalOtherDeductions+Number($('input#otherDeductionsTextField_'+index+'').val());
                    advanceAdjustmentAmount     =advanceAdjustmentAmount+Number($('input#advanceAdjustField_'+index+'').val());
                });

                $('input#total_amount_paid').val(parseFloat(totalAmountOfPaid).toFixed(2));
                $('input#total_tds_deducted').val(parseFloat(totalTdsDeductions).toFixed(2));
                $('input#total_other_deduction').val(parseFloat(totalOtherDeductions).toFixed(2));
                $('input#total_adv_adjusted').val(parseFloat(advanceAdjustmentAmount).toFixed(2));
            }

            $("input.amount-payment-change-event").blur(function(){
                var currenIndex                     =$(this).data('key-index');
                balanceCalcualted(currenIndex);
                summationsToptalInformations();
            });

            //Advance payment amount validations
            $("input.advace-adjust-payment").blur(function(){
                var currenIndex                     =$(this).data('key-index');
                var maximumAdjustmentAmount         =$('input#amount_to_adjust').val();
                var adjustmentPrice=summationsOfAdjustmentPrice();
                if (adjustmentPrice>Number(maximumAdjustmentAmount)){
                    cuteAlert({
                        type:"error",
                        title:'Adjustment amount',
                        message:'Adjustment amount can not be greater than '+maximumAdjustmentAmount+'.',
                        buttonText: "Okay",
                        img: errorImage,
                    });
                    $('input#advanceAdjustField_'+currenIndex+'').val(parseFloat(0).toFixed(2));
                }
            });

             function summationsOfAdjustmentPrice(){
                var advanceAdjustmentAmount=0;
                $("input:checkbox[type=checkbox]").each(function(){
                    var index                   =$(this).data('key-index');
                    advanceAdjustmentAmount     =advanceAdjustmentAmount+Number($('input#advanceAdjustField_'+index+'').val());
                });

                return advanceAdjustmentAmount;
            }

            function balanceCalcualted(index) {
                var amountPaid           =Number($('input#amountPaidTextField_'+index+'').val()||0);
                var tdsDeductions        =Number($('input#tdsDeducationsAmount_'+index+'').val()||0);
                var otherDeductions      =Number($('input#otherDeductionsTextField_'+index+'').val()||0);
                var advanceAdjustField   =Number($('input#advanceAdjustField_'+index+'').val()||0);
                var balance               =Number($('span#totalBalance_'+index+'').text()||0);
                var previousTotalBalance   =$('span#totalBalance_'+index+'').data('previous-total-balance');

                var summationsBalance       =previousTotalBalance-(amountPaid+tdsDeductions+otherDeductions+advanceAdjustField);
                $('span#totalBalance_'+index+'').text(parseFloat(summationsBalance).toFixed(2));

                var totalSpendAmount      =(amountPaid+tdsDeductions+otherDeductions+advanceAdjustField);
                if (Number(totalSpendAmount)>Number(previousTotalBalance)){
                    cuteAlert({
                        type:"error",
                        title:'Paid amount',
                        message:'Paid amount can not be greater than balance '+previousTotalBalance+'.',
                        buttonText: "Okay",
                        img: errorImage,
                    });
                    $('span#totalBalance_'+index+'').text(parseFloat(previousTotalBalance).toFixed(2));
                    $('input#amountPaidTextField_'+index+'').val(parseFloat(0).toFixed(2));
                    $('input#tdsDeducationsAmount_'+index+'').val(parseFloat(0).toFixed(2))
                    $('input#otherDeductionsTextField_'+index+'').val(parseFloat(0).toFixed(2))
                    $('input#advanceAdjustField_'+index+'').val(parseFloat(0).toFixed(2))
                }
            }

        });
    </script>

</body>
</html>
