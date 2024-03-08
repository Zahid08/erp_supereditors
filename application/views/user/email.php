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
                    <h3 class="text-primary">Email</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Email</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <a href="<?php echo base_url()?>Email/add_email" target="_blank"><button type="button" class="btn btn-primary  text-white" >Add Email</button></a>
          
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Email</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Email</th>
                                                <th>Name</th>
                                                <th>Created By</th>
                                                <th>Created Date</th>
                                                <th>View Access</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach($email_data as $key => $value){ ?>
                                                <tr>
                                                    <td><?php echo $value['email']; ?></td>
                                                    <td><?php echo ucwords($value['email_name']); ?></td>
                                                    <td><?php echo ucwords($value['name']); ?></td>
                                                    <td><?php echo date_format(date_create($value['created_date']),"d-m-Y"); ?></td>
                                                    <td>
                                                        <button class="btn btn-primary editemail" id="<?php echo $value['client_email_id']; ?>" data-id="<?php echo ucwords($value['email_name']); ?>" data-email="<?php echo $value['email']; ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit text-black"></i></button>
                                                        <button class="btn btn-primary deleteemail" id="<?php echo $value['client_email_id']; ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash text-black"></i></button>
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



    <div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Email</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         
        <label>Email Address</label>
        <input type="text" name="edit_email_email" id="edit_email_email" class="form-control" required>
        
        <label>Email Name</label>
        <input type="text" name="edit_email_name" id="edit_email_name" class="form-control" required>
        <input type="hidden" name="email_id" id="email_id" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
         <button type="button" class="btn btn-primary edit_email_save" data-dismiss="modal">Save</button>
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
        <h4 class="modal-title">Delete Email</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
       <input type="hidden" name="email_delete_id" id="email_delete_id" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="button" class="btn btn-primary delete_email_save" data-dismiss="modal">Delete</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

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

 <script>
     
      $(document).ready(function() 
      {
        $('.editemail').click(function() 
        {
     
            var id = $(this).attr('id'); 
            $('#email_id').val(id);
     
            var email_name = $(this).attr('data-id'); 
            $('#edit_email_name').val(email_name);
            
            var email_email = $(this).attr('data-email'); 
            $('#edit_email_email').val(email_email);
      
        });
        
        $('.edit_email_save').click(function()
        {
            var id = $('#email_id').val();
            var name = $('#edit_email_name').val();
            var email = $('#edit_email_email').val();
            
      		var url = '<?php echo base_url();?>Email/edit_email';

			var post_data = {
			    'id': id,
				'name':name,
				'email':email
			};
			$.ajax({
					url : url,
					type : 'post',
					data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Email updated successfully.');
								window.location.replace('<?php echo base_url(); ?>Email');
							}else{
								alert("Failed to update the Email...Try again");
								window.location.replace('<?php echo base_url(); ?>Email');
							}
						}
					});
  });
  
    $('.deleteemail').click(function()
  {
     var id = $(this).attr('id'); 
     $('#email_delete_id').val(id);
  });
  
      $('.delete_email_save').click(function()
  {
      var id = $('#email_delete_id').val();
      
      					var url = '<?php echo base_url();?>Email/delete_email';

					var post_data = {
						'id': id,
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Email deleted successfully.');
								window.location.replace('<?php echo base_url(); ?>Email');
							}else{
								alert("Failed to delete the Email...Try again");
								window.location.replace('<?php echo base_url(); ?>Email');
							}
						}
					});
  });
  
      });
  </script>
   
</body>

</html>