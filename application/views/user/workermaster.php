<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/client_asstes/images/favicon.png">
    <title>SuperEditors || Roles Page</title>
    
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
                    <h3 class="text-primary">Karigar Master</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Karigar Master</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <a href="<?php echo base_url()?>Workermaster/add_karigar" target="_blank"><button type="button" class="btn btn-primary  text-white" >Add Karigar</button></a>
          
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Karigar Master</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Karigar Type</th>
                                                <th>ContactNo</th>
                                                <th>ID Proof</th>
                                                <th>GST No</th>
                                                <th>State</th>
                                                <th>Created Date</th>
                                                <th>View Access</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach($karigarData as $key => $value){
                                                $file_location =base_url()."/assets/karigar_image/".$value['image']."";
                                                ?>
                                                <tr>
                                                    <td><img src="<?php echo $file_location; ?>" style="width: 54px; height: 41px;border: 1px solid gray;border-radius: 5px;"></td>
                                                    <td><?php echo $value['name']; ?></td>
                                                    <td><?php echo $value['karigar_type']; ?></td>
                                                    <td><?php echo $value['contact_no']; ?></td>
                                                    <td><?php echo $value['id_proof']; ?></td>
                                                    <td><?php echo $value['gst_no']; ?></td>
                                                    <td><?php echo ucwords($value['state']); ?></td>
                                                    <td><?php echo date_format(date_create($value['created_date']),"d-m-Y"); ?></td>


                                                    <td>
                                                        <a href="<?php base_url() ?>Workermaster/edit_karigar?karigar_id=<?php echo $value['id'] ?>">
                                                            <button type="button" class="btn btn-primary btn-sm" >
                                                                Edit
                                                            </button>
                                                        </a>
                                                        <a href="<?php base_url() ?>Workermaster/delete_karigar?karigar_id=<?php echo $value['id'] ?>">
                                                            <button type="button" onclick="return confirm('Are you sure you want to delete this records?');"  class="btn btn-primary btn-sm " >
                                                                Delete
                                                            </button>
                                                        </a>
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
            <?php include("includes/footer.php") ?>

        </div>

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
</html>