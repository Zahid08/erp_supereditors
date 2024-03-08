<?php
$customerDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1")->result();
$karigarDetails = $this->db->query("SELECT * FROM karigar_master e where is_active = 1")->result();
$itemDetails = $this->db->query("SELECT * FROM items WHERE is_active = 1 and item_type_id=2")->result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SuperEditors || Karigar-Item Rate Linking Master</title>
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/client_asstes/images/favicon.png">
</head>
<style>
    label {
        margin-top: 17px!important;
    }
</style>
<body class="header-fix fix-sidebar">
    <div id="main-wrapper">

       <?php include("includes/header.php") ?>
        <?php include("includes/sidenav.php") ?>

        <div class="page-wrapper">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Karigar-Item Rate Linking Master</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Karigar-Item Rate Linking Master</li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
            <section id="enquiry_section" name="enquiry_section">
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        
                        <h5 class="card-title">Add Karigar-Item Rate Linking Master</h5>
                        <hr>
                        <form method="post" action="<?php echo base_url() ?>KarigarItemRatedLink/save_karigar_item_rated_data" autocomplete="off" enctype="multipart/form-data">
                           <div class="row">

                               <div class="col-sm-6">
                                   <label>Karigar Type</label>
                                   <select class="form-control" id="karigar_type" name="karigar_type" required>
                                       <option value="">Select Karigar Type</option>
                                       <option value="cutter_master">Cutter Master</option>
                                       <option value="worker_master">Worker Master</option>
                                       <option value="embroidery_master">Embroidery Master</option>
                                       <option value="pressing_master">Pressing Master</option>
                                   </select>
                               </div>

                               <div class="col-sm-6">
                                   <label>Karigar Name</label>
                                   <select class="form-control" id="karigar_name" name="karigar_name" required>
                                       <option value="">Select Karigar Name</option>
                                       <?php foreach($karigarDetails as $getSingleKarigarData){ ?>
                                       <option value="<?=$getSingleKarigarData->name?>" dataId="<?=$getSingleKarigarData->id?>"><?=$getSingleKarigarData->name?></option>
                                       <?php } ?>
                                   </select>
                               </div>

                               <div class="col-sm-6">
                                   <label>Item Name</label>
                                   <select class="form-control" id="item_name" name="item_name" required>
                                       <option value="">Select Item Name</option>
                                       <?php foreach($itemDetails as $dataItem){ ?>
                                       <option value="<?=$dataItem->item_name?>"><?=$dataItem->item_name?></option>
                                       <?php } ?>
                                   </select>
                               </div>

                               <div class="col-sm-6">
                                   <label>Company Name</label>
                                   <select class="form-control " name="company_name"   id="company_name" required>
                                       <option value="">Select Company Name</option>
                                       <option value = "SuperEditors">SuperEditors</option>
                                       <option value = "MannaMenswear">MannaMenswear</option>
                                   </select>
                               </div>

                               <div class="col-sm-6">
                                   <label>Customer</label>
                                   <select class="form-control" id="customer_name" name="customer_name" required>
                                       <option value="">Select Customer</option>
                                       <?php foreach($customerDetails as $getcustomerDetails){ ?>
                                       <option value="<?php echo $getcustomerDetails->name ?>"><?php echo $getcustomerDetails->name ?></option>
                                       <?php } ?>
                                   </select>
                               </div>

                               <div class="col-sm-6">
                                   <label>Rate (With Cutting)</label>
                                   <input type="text" class="form-control" name="rate_with_cutting" id="rate_with_cutting"  placeholder="Rate (With Cutting)">
                               </div>

                               <div class="col-sm-6">
                                   <label>Rate (Without Cutting)</label>
                                   <input type="text" class="form-control" name="rate_without_cutting" id="rate_without_cutting"  placeholder="Rate (Without Cutting)">
                               </div>

                               <div class="col-sm-6">
                                   <label>Pressing</label>
                                   <input type="text" class="form-control" name="pressing" id="pressing"  placeholder="Enter Pressing">
                               </div>

                               <div class="col-sm-6">
                                   <label>Finishing (Kaj-Button)</label>
                                   <input type="text" class="form-control" name="finishing_kaj_button" id="finishing_kaj_button"  placeholder="Finishing (Kaj-Button)">
                               </div>

                               <div class="col-sm-6">
                                   <label>Embroidery (Per Piece)</label>
                                   <input type="text" class="form-control" name="embroidery_per_piece" id="embroidery_per_piece"  placeholder="Embroidery (Per Piece)">
                               </div>

                               <div class="col-sm-6">
                                   <label>Embroidery (Developing)</label>
                                   <input type="text" class="form-control" name="embroidery_developing" id="embroidery_developing"  placeholder="Embroidery (Developing)">
                               </div>

                              </div>

                              <div class="row">
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
            <?php include("includes/footer.php") ?>
        </div>
    </div>

        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/sidebarmenu.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/webticker/jquery.webticker.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/peitychart/jquery.peity.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/custom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/dashboard-1.js"></script>
        
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

<script>
    $( document ).ready(function() {

        jQuery('input#rate_with_cutting,input#rate_without_cutting,input#pressing,input#finishing_kaj_button,input#embroidery_per_piece,input#embroidery_developing').keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g,'');
        });

        $('select#karigar_type').change(function(){

            var url = "<?php echo base_url('KarigarItemRatedLink/get_karigar_list_by_type'); ?>";
            var post_data = {
                'karigar_type':$(this).val(),
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
            };

            $.ajax({
                url : url,
                type : 'POST',
                data: post_data,
                success : function(result)
                {

                    var obj = JSON.parse(result);
                    $('select#karigar_name').find('option').remove();
                    $('select#karigar_name').append($('<option/>', {
                        value: '',
                        text : 'Select Karigar Name',
                    }));

                    for(var i=0;i<obj.length;i++)
                    {
                        $('select#karigar_name').append($('<option/>', {
                            value: obj[i]['name'],
                            text : obj[i]['name'],
                        }));
                    }
                }

            });

        });
    });
</script>

</html>