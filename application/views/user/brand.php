<?php
error_reporting(1);

$rolesDetails = $this->db->query("SELECT * FROM roles r LEFT JOIN user u ON u.user_id = r.created_by WHERE r.is_active = 1 ORDER BY id DESC")->result();
//$brandDetails = $this->db->query("SELECT * FROM roles r LEFT JOIN user u ON u.user_id = r.created_by WHERE r.is_active = 1 ORDER BY id DESC")->result();
//$measureDetails = $this->db->query("SELECT * FROM measure WHERE is_active = 1")->result();
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
    <title>SuperEditors || Brand Page</title>
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
                    <h3 class="text-primary">Brand</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Brand</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <a href="<?php echo base_url()?>Brand/add_brand" target="_blank"><button type="button" class="btn btn-primary  text-white" >Add Brand</button></a>
                
                <center>
                    <p style="color:green"><?php echo $this->session->flashdata('brand_message') ?></p>
                </center>
            <!-- Start Page Content -->
                          <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Brand</h4>
                              
                              <div class="panel-group" id="accordion">
                                 <?php foreach($brand_data as $key=>$brand_name){ 
                                  if($key == 0)
                                  {
                                  ?>

                                 <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a class="link_head" data-toggle="collapse" data-parent="#accordion" href="<?php echo '#collapse'.$key; ?>"><?php echo ucwords($brand_name['brand_name']['brand_name']); ?></a>
                                      <button class="delete_type" id="<?php echo $brand_name['brand_name']['brand_id']; ?>"  data-toggle="modal" data-target="#deletetypeModal"><i class="fa fa-trash text-white"></i></button>
                                      <button class="add_name_type" id="<?php echo $brand_name['brand_name']['brand_id']; ?>"  data-toggle="modal" data-target="#addNameModal"><i class="fa fa-plus text-white"></i></button>
                                    </h4>
                                  </div>
                                  <div id="<?php echo 'collapse'.$key; ?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                                        <tr>
                                                                            <th>Fabric Name</th>
                                                                            <th>Created By</th>
                                                                            <th>Created Date Time</th>
                                                                            <th>View Access</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                             <?php foreach($brand_name['fabric_name'] as $name_key => $name_value)
                                            {
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords($name_value['fabric_name']); ?></td>
                                                <td><?php echo $name_value['uname']; ?></td>
                                                <td><?php echo date_format(date_create($name_value['created_date']),"d-m-Y"); ?></td>
                                                <td>
                                                    <button class="btn btn-primary editname" id="<?php echo $name_value['fabric_id']; ?>" data-id="<?php echo $name_value['fabric_name']; ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit text-black"></i></button>
                                                    <button class="btn btn-primary deletename" id="<?php echo $name_value['fabric_id']; ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash text-black"></i></button>
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
                                </div>
                                <?php
                                  }
    else
    {
        ?>
            <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
  <a class="link_head" data-toggle="collapse" data-parent="#accordion" href="<?php echo '#collapse'.$key; ?>"><?php echo ucwords($brand_name['brand_name']['brand_name']); ?></a>
  <button class="delete_type" id="<?php echo $brand_name['brand_name']['brand_id']; ?>"  data-toggle="modal" data-target="#deletetypeModal"><i class="fa fa-trash text-white"></i></button>
  <button class="add_name_type" id="<?php echo $brand_name['brand_name']['brand_id']; ?>"  data-toggle="modal" data-target="#addNameModal"><i class="fa fa-plus text-white"></i></button>
    </h4>
      </div>
      <div id="<?php echo 'collapse'.$key; ?>" class="panel-collapse collapse">
        <div class="panel-body">
                        <div class="table-responsive">
                <table class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                                                <tr>
                                                  <th>Fabric Name</th>
                                                  <th>Created By</th>
                                                  <th>Created Date Time</th>
                                                  <th>View Access</th>
                                                </tr>
                                                  </thead>
                                                   <tbody>
                                                  <?php foreach($brand_name['fabric_name'] as $name_key => $name_value)
                                                 {
                                                ?>
                                                        <tr>
                                                <td><?php echo ucwords($name_value['fabric_name']); ?></td>
                                                <td><?php echo $name_value['uname']; ?></td>
                                                <td><?php echo date_format(date_create($name_value['created_date']),"d-m-Y"); ?></td>
                                                <td>
                                                     <button class="btn btn-primary editname" id="<?php echo $name_value['fabric_id']; ?>" data-id="<?php echo $name_value['fabric_name']; ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit text-black"></i></button>
                                                    <button class="btn btn-primary deletename" id="<?php echo $name_value['fabric_id']; ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash text-black"></i></button>
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
                                </div>
                                  <?php
                                }
                                                                  
                                 }
                                ?>
                          </div> 
                            </div>
                        </div>   
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/footer.php") ?>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    
    
     <div class="modal" id="addNameModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Fabric</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         
          <label>Fabric Name</label>
        <input type="text" name="fabric_add_name" id="fabric_add_name" class="form-control" required>
        <input type="hidden" name="brand_addnameType_id" id="brand_addnameType_id"  required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
         <button type="button" class="btn btn-primary add_brand_name_save" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

    
    
    
    <div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Fabric</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         
          <label>Fabric Name</label>
        <input type="text" name="fabric_edit_name" id="fabric_edit_name" class="form-control" required>
        <input type="hidden" name="fabric_edit_id" id="fabric_edit_id" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
         <button type="button" class="btn btn-primary edit_fabric_save" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

    
    <div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Fabric</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
       <input type="hidden" name="fabric_delete_id" id="fabric_delete_id" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="button" class="btn btn-primary delete_fabric_save" data-dismiss="modal">Delete</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
    
    
     <div class="modal" id="deletetypeModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Brand</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
       <input type="hidden" name="brand_deletetype_id" id="brand_deletetype_id" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="button" class="btn btn-primary brand_deletetype_save" data-dismiss="modal">Delete</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
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
         
        $(document).ready(function() {
 $('.editname').click(function() {
    
     
     var id = $(this).attr('id'); 
     $('#fabric_edit_id').val(id);
     
     var fabric_name = $(this).attr('data-id'); 
     $('#fabric_edit_name').val(fabric_name);
      
  });
  
    $('.deletename').click(function()
  {
     
     var id = $(this).attr('id'); 
     $('#fabric_delete_id').val(id);
  });
  
 
  

    $('.delete_type').click(function()
  {
      
      var type_id = $(this).attr('id');
        $('#brand_deletetype_id').val(type_id);
      
  });
  
  $('.add_name_type').click(function()
  {
      var type_id = $(this).attr('id');
      
        $('#brand_addnameType_id').val(type_id);
  });
       
       $('.brand_deletetype_save').click(function()
  {
     
     var type_id = $('#brand_deletetype_id').val();  
     
     	var url = '<?php echo base_url();?>Brand/delete_type';

					var post_data = {
						'type_id': type_id,
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Brand  deleted successfully.');
								window.location.replace('<?php echo base_url(); ?>Brand');
							}else{
								alert("Failed to delete the Brand Type...Try again");
								window.location.replace('<?php echo base_url(); ?>Brand');
							}
						}
					});
     
  });
  
    
  $('.edit_fabric_save').click(function()
  {
      
      var id = $('#fabric_edit_id').val();
     var name = $('#fabric_edit_name').val();
      					var url = '<?php echo base_url();?>Brand/edit_brand';

					var post_data = {
						'fabric_edit_id': id,
						'fabric_edit_name':name,
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Fabric updated successfully.');
								window.location.replace('<?php echo base_url(); ?>Brand');
							}else{
								alert("Failed to update the fabric...Try again");
								window.location.replace('<?php echo base_url(); ?>Brand');
							}
						}
					});
  });
  
  $('.delete_fabric_save').click(function()
  {
      var id = $('#fabric_delete_id').val();
      
      					var url = '<?php echo base_url();?>Brand/delete_fabric';

					var post_data = {
						'fabric_delete_id': id,
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Fabric deleted successfully.');
								window.location.replace('<?php echo base_url(); ?>Brand');
							}else{
								alert("Failed to delete the Fabric...Try again");
								window.location.replace('<?php echo base_url(); ?>Brand');
							}
						}
					});
  });
  
  
   $('.add_brand_name_save').click(function()
  {
      
    var id = $('#brand_addnameType_id').val();
    
     var name = $('#fabric_add_name').val();
     
      				var url = '<?php echo base_url();?>Brand/add_brand_save';

					var post_data = {
						'brand_addnameType_id': id,
						'fabric_add_name':name,
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(response){
						    
							if(response==1){
								alert('Fabric added successfully.');
								window.location.replace('<?php echo base_url(); ?>Brand');
							}else{
								alert("Failed to add the fabric...Try again");
								window.location.replace('<?php echo base_url(); ?>Brand');
							}
						}
					});
  });
        });
       </script>
 
   
</body>

</html>