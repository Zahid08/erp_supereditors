<?php

function AmountInWords(float $amount)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ''.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
        else $string[] = null;
    }
    $implode_to_Rupees = implode('', array_reverse($string));
    $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10]."".$change_words[$amount_after_decimal % 10]) . ' Paise' : '';
    return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}

if (isset($_REQUEST['vc'])){
    $voucherNumber=$_REQUEST['vc'];
    $advancePaymentDetails = $this->db->query("SELECT * FROM advance_payment_entry where voucher_no=$voucherNumber")->row();
    if ($advancePaymentDetails){
        $supplierId=$advancePaymentDetails->supplier_id;
        $getSupplier = $this->db->query("SELECT supplier_name FROM supplier where supplier_id=$supplierId")->row();
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
    <title>SuperEditors || Payment ||</title>
    <style>
        td.middle-positions, th.middle-positions {
            border-bottom: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 8px;
        }
    </style>
</head>
<body>
<div class="main-wrap">
    <div style="text-align: center;height: 120px;border-bottom: 2px solid gray;">
        <h2 style="margin: 8px 0; font-size: 25px;">Super Editors</h2>
        <h5 style="margin: 0; font-size: 14px;">598/600 shukraw ar Peth, Near Vanraj Mitra Mandal , Shivaji Road, Pune 411 042</h5>
        <h5 style="margin: 0; font-size: 14px;">Phone : 24430981 / Mobile : 94220  28861</h5>
        <h3 style="text-align: center;font-size: 18px;">Advance Payment Voucher</h3>
    </div>

    <div style="margin-bottom: 5px;" >
        <p align="left" style="height: 8px;"><strong>Voucher No : <?=$advancePaymentDetails->voucher_no?></strong> <span style="float:right;"><strong>Voucher date :</strong><?=date('d/m/Y',strtotime($advancePaymentDetails->created_date))?></span></p>
        <p style="height: 8px;">Party Name : <strong><?=$getSupplier->supplier_name?></strong></p>
      <p style="height: 8px;">Amount in Words : <?=ucwords(strtolower(AmountInWords($advancePaymentDetails->amount_paid)))?></p>
    </div>

    <table style="border-collapse: collapse; width: 100%; margin-top: 15px;  font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;">
        <tr>
            <th style="padding: 6px;" class="middle-positions">SrNo</th>
            <th style="padding: 6px;" class="middle-positions">Amt Paid</th>
            <th style="padding: 6px;" class="middle-positions">Amt Adj</th>
        </tr>
        <tr style="border-collapse: collapse; text-align: center; border-bottom : 2px solid #000;">
            <td style="padding: 6px; text-align: center;" class="middle-positions">1</td>
            <td style="padding: 6px; text-align: center;" class="middle-positions"><?=$advancePaymentDetails->amount_paid?></td>
            <td style="padding: 6px; text-align: center;" class="middle-positions"><?=$advancePaymentDetails->amount_adjusted?></td>
        </tr>
        <tr style="border-bottom : 2px solid #000;">
            <td style="padding: 6px; text-align: center;" class="middle-positions"><strong>Total :</strong></td>
            <td style="padding: 6px; text-align: center;" class="middle-positions"><?=$advancePaymentDetails->amount_paid?></td>
            <td style="padding: 6px; text-align: center;" class="middle-positions"><?=$advancePaymentDetails->amount_adjusted?></td>
        </tr>
    </table>

    <table style="width: 85%;margin-top: 15px;">
        <tr style="height: 15px;">
            <td width="25%">By <?=$advancePaymentDetails->payment_mode?></td>
            <td width="30%">Cheque No :- <?=$advancePaymentDetails->cheque_no?></td>
            <td width="30%">Dated No :- <?=date('d/m/Y',strtotime($advancePaymentDetails->payment_date))?></td>
        </tr>
        <tr style="height: 15px;">
            <td width="25%">Bank :- <?=$advancePaymentDetails->bank_detail?> </td>
            <td  colspan="2"></td>
        </tr>
    </table>

    <div style="text-align: right;display: inline-block;width: 100%;margin-top: 15px;">
        <div style="text-align: left;float: left">
            Payment made by cheque / Credit Card are Subject to Realizations.<br/>Subject to pune Jurisdiction
        </div>
        <div style="height: 65px; width: 65px; padding: 0;float: right;margin-top: -50px;
                border: 1px solid #000;"></div>

        <div style="margin-top: 20px;margin-right: -10px;text-align:right;padding-left: 50px">
            For Super Editors
        </div>
    </div>

    <table style="height: 50px;width: 80%">
        <tr>
            <td width="80%"></td>
        </tr>
    </table>
</div>
</body>
</html>
<?php }} ?>
