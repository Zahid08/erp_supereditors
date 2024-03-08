<?php
$karigarId = $_GET["karigar_id"];
$singleKarigarData = $this->db->query("SELECT * FROM karigar_master WHERE is_active = 1 AND id=$karigarId")->row();
$file_location =base_url()."/assets/karigar_image/".$singleKarigarData->image."";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SuperEditors || Items Page</title>
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
                    <h3 class="text-primary">Karigar Master</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Karigar Master</li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
            <section id="enquiry_section" name="enquiry_section">
               <!--<center>-->
               <!--     <p style="color:green"><?php echo $this->session->flashdata('role_message') ?></p>-->
               <!-- </center>-->
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        
                        <h5 class="card-title">Add Karigar</h5>
                        <hr>
                        <form method="post" action="<?php echo base_url() ?>Workermaster/save_edit_karigar_data" autocomplete="off" enctype="multipart/form-data" id="addKarigarFOrm">
                            <input class="form-control" type="hidden" name="karigar_id" id="karigar_id" value="<?php echo $karigarId ?>" required>
                           <div class="row">

                               <div class="col-sm-6">
                                   <label>Karigar Type</label>
                                   <select class="form-control" id="karigar_type" name="karigar_type" required>
                                       <option value="">Select Karigar Type</option>
                                       <option value="cutter_master" <?php if($singleKarigarData->karigar_type == 'cutter_master'){ ?> selected <?php } ?>>Cutter Master</option>
                                       <option value="worker_master" <?php if($singleKarigarData->karigar_type == 'worker_master'){ ?> selected <?php } ?>>Worker Master</option>
                                       <option value="embroidery_master" <?php if($singleKarigarData->karigar_type == 'embroidery_master'){ ?> selected <?php } ?>>Embroidery Master</option>
                                       <option value="pressing_master" <?php if($singleKarigarData->karigar_type == 'pressing_master'){ ?> selected <?php } ?>>Pressing Master</option>
                                   </select>
                               </div>

                                  <div class="col-sm-6">
                                      <label>Karigar Name</label>
                                     <input type="text" class="form-control" name="name" id="name"  placeholder="Enter Karigar Name" value="<?=$singleKarigarData->name?>">
                                  </div>
                                   <div class="col-sm-6">
                                       <label>Contact No</label>
                                       <input type="text" class="form-control" name="contact_no" id="contact_no"  placeholder="Enter Contact Number" value="<?=$singleKarigarData->contact_no?>">
                                   </div>

                                   <div class="col-sm-6">
                                       <label>ID Proof</label>
                                       <input type="text" class="form-control" name="id_proof" id="id_proof"  placeholder="ID Proof" value="<?=$singleKarigarData->id_proof?>">
                                   </div>
                                   <div class="col-sm-6">
                                       <label>GST No</label>
                                       <input type="text" class="form-control" name="gst_no" id="gst_no"  placeholder="Enter Contact Number" value="<?=$singleKarigarData->gst_no?>">
                                   </div>
                                   <div class="col-sm-12">
                                       <label>Address</label>
                                       <textarea style="height: 90px!important;" class="form-control" rows="20" cols="50" name="address" id="address" placeholder="Enter Descrition Here"><?=$singleKarigarData->address?></textarea>
                                   </div>
                                   <div class="col-sm-12">
                                       <label>Remark</label>
                                       <textarea style="height: 90px!important;" class="form-control" rows="20" cols="50" name="remark" id="remark" placeholder="Enter Descrition Here"><?=$singleKarigarData->remark?></textarea>
                                   </div>

                               <div class="col-sm-12">
                                   <label>Upload Image</label>
                                   <input class="form-control" type="file" id="formFileMultiple" multiple name="image">
                                   <span>
                                    <img src="<?php echo $file_location; ?>" style="width: 100px; height: 90px;border: 1px solid gray;border-radius: 5px;">
                                   </span>
                                   <input class="form-control" type="hidden" name="previousFileName" id="previousFileName" value="<?php echo $singleKarigarData->image ?>" required>
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
<!--<script>-->
<!--    $("form#addKarigarFOrm").submit(function(e) {-->
<!--        var charLength=$('input#gst_no').val().length;-->
<!--        if ($('input#gst_no').val()) {-->
<!--            if (charLength < 22) {-->
<!--                alert('Length is short, minimum 22 required.');-->
<!--                return false;-->
<!--            } else if (charLength > 22) {-->
<!--                alert('Length is not valid, maximum 22 allowed.');-->
<!--                return false;-->
<!--            } else {-->
<!--                return true;-->
<!--            }-->
<!--        }else {-->
<!--            return true;-->
<!--        }-->
<!--    });-->
<!--</script>-->
</html>
