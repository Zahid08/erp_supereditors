<?php
error_reporting(0);
$allocate_id =$_GET['allocate_id'];
$result=array();
 if(!empty($allocate_id))
    {
       $allocateDetails = $this->db->query("SELECT a.*,k.name,i.item_name FROM allocate_order a LEFT JOIN karigar_master k ON k.id = a.karigar_name LEFT JOIN items i ON i.item_id=a.item_name WHERE allocated_order_id = $allocate_id")->result();
       $febricdetails = $this->db->query("SELECT f.*,k.name as karigar,u.name as user,b.brand_name FROM febric_allicate_tailor f LEFT JOIN karigar_master k ON k.id = f.karigar_name LEFT JOIN brand b ON b.brand_id=f.brand_name LEFT JOIN user u ON u.user_id = f.created_by WHERE allocate_order_no = $allocate_id")->result();
       foreach($allocateDetails as $value)
       {
            $ids=explode(",",$value->AuthorizationsItem);
            foreach($ids as $val)
            {
                $this->db->select("*");
                $this->db->where("order_authorization_id=",$val);
                $this->db->from('allocate_order_authorization');
                $result_obj = $this->db->get();
                $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
                $result[]=$result_arr;
            }
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
    <title>SuperEditors || Outboard order details Page</title>
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
                    <h3 class="text-primary">Outboard order details</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Outboard order details</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <section id="Outboard_order_section" name="Outboard_order_section">
                <br>
               <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" >Outboard order details</button>
               <div class="table-responsive m-t-40">
                    <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Company Name</th>
                                <th>Chalan Number</th>
                                <th>Billing Date</th>
                                <th>Karigar Name</th>
                                <th>Karigar Type</th>
                                <th>Customer</th>
                                <th>Code Number</th>
                                <th>Item name</th>
                                <th>Gens qty total</th>
                                <th>Gens mrp</th>
                                <th>Ladies qty total</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($allocateDetails as $value){ ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $value->company_name ?></td>
                                    <td><?php echo $value->chalan_number ?></td>
                                    <td><?php echo $value->billing_date ?></td>
                                    <td><?php echo $value->name ?></td>
                                    <td><?php echo $value->karigar_type ?></td>
                                    <td><?php echo $value->customer ?></td>
                                    <td><?php echo $value->code_number ?></td>
                                    <td><?php echo $value->item_name ?></td>
                                    <td><?php echo $value->gens_qty_total; ?></td>
                                    <td><?php echo $value->gens_mrp; ?></td>
                                    <td><?php echo $value->ladies_qty_total;?></td>
                                    <td><?php echo $value->created_at;?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section id="authorizations_item_section" name="authorizations_item_section">
                <br>
               <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" >Authorizations Item</button>
               <div class="table-responsive m-t-40">
                    <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Authorization Id</th>
                                <th>Id</th>
                                <th>Authorization Status</th>
                                <th>Unique Code</th>
                                <th>Item name</th>
                                <th>Gender</th>
                                <th>Mesurement</th>
                                <th>MRP</th>
                                <th>Mesurement Remark</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($result as $value){ ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $value[0]['authorizationId'] ?></td>
                                    <td><?php echo $value[0]['id']?></td>
                                    <td><?php echo $value[0]['authorization_status'] ?></td>
                                    <td><?php echo $value[0]['unique_code'] ?></td>
                                    <td><?php echo $value[0]['item_name']?></td>
                                    <td><?php echo $value[0]['gender']?></td>
                                    <td><?php echo $value[0]['mesurement']?></td>
                                    <td><?php echo $value[0]['mrp'] ?></td>
                                    <td><?php echo $value[0]['mesurement_remark'] ?></td>
                                    <td><?php echo $value[0]['created_at'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </section>
            <!--Febric list-->
            <section id="febric_details_section" name="febric_details_section">
                <br>
               <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" >Febric Details</button>
               <div class="table-responsive m-t-40">
                    <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Company Name</th>
                                <th>Challan Number</th>
                                <th>Challan Date</th>
                                <th>Party Name</th>
                                <th>Karigar name</th>
                                <th>Total Gents Mts</th>
                                <th>Ladies Mts</th>
                                <th>Total Orders Mts</th>
                                <th>Already Allocated</th>
                                <th>Balance to allocate</th>
                                <th>Brand Name</th>
                                <th>Febric Name</th>
                                <th>Total Tags</th>
                                <th>Total Mts</th>
                                <th>User Name</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($febricdetails as $value){ ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $value->company_name ?></td>
                                    <td><?php echo $value->challan_no?></td>
                                    <td><?php echo $value->challan_date ?></td>
                                    <td><?php echo $value->party_name ?></td>
                                    <td><?php echo $value->karigar?></td>
                                    <td><?php echo $value->total_gents_mts?></td>
                                    <td><?php echo $value->ladies_mts?></td>
                                    <td><?php echo $value->total_orders_mts ?></td>
                                    <td><?php echo $value->already_allocated ?></td>
                                    <td><?php echo $value->bal_to_allocated ?></td>
                                    <td><?php echo $value->brand_name?></td>
                                    <td><?php echo $value->febric_name ?></td>
                                    <td><?php echo $value->total_tages ?></td>
                                    <td><?php echo $value->total_mts ?></td>
                                    <td><?php echo $value->user?></td>
                                    <td><?php echo $value->created_at ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            
                        </tbody>
                    </table>
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
</body>

</html>