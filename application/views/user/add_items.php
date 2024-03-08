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
    <title>SuperEditors || Items Page</title>
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
                    <h3 class="text-primary">Items</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Items</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <section id="enquiry_section" name="enquiry_section">
               <center>
                    <p style="color:green"><?php echo $this->session->flashdata('role_message') ?></p>
                </center>
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        
                        <h5 class="card-title">Add Items</h5>
                        <hr>
                        <form method="post" action="<?php echo base_url() ?>Items/save_item_data" autocomplete="off">
                            
                           <div class="row">
                              <div class="col-sm-8">
                                  <label>Item Type</label>
                                  <select class="form-control" name="item_type" id="item_type" required>
                                      <?php foreach($item_type as $item_key => $item_value)
                                      {
                                        ?>
                                        <option value="<?php echo $item_value['item_type_id']; ?>"><?php echo $item_value['item_type']; ?></option>
                                        <?php
                                      }
                                      ?>
                                  </select>
                              </div>
                              </div>
                              
                              <div class="appending_div">
                             <div class="row">
                              <div class="col-sm-2">
                                   <label>Item Name 1</label>
                                 <input class="form-control" name="item_name[]" id="item_name"  placeholder="Item Name" required>
                              </div>
                              <div class="col-sm-2">
                                   <label>HSN 1</label>
                                 <input class="form-control" name="hsn_code[]" id="hsn_code"  placeholder="HSN Code" required>
                              </div>
                              <div class="col-sm-2">
                                   <label>IGST 1</label>
                                 <input class="form-control" name="igst[]" id="igst" data-id="1"  placeholder="IGST" required onfocusout="divide_igst(this)">
                              </div>
                              <div class="col-sm-2">
                                   <label>CGST 1</label>
                                 <input class="form-control" name="cgst[]" id="cgst_1"  placeholder="CGST" readonly required>
                              </div>
                              <div class="col-sm-2">
                                   <label>SGST 1</label>
                                 <input class="form-control" name="sgst[]" id="sgst_1"  placeholder="SGST" readonly required>
                              </div>
                              <div class="col-sm-1">
                                  <span class="fa fa-plus add"></span>
                                  </div>
                              </div>
                              </div>
                              <input type="hidden" name="counter" id="counter" value="1">
                              <div class="row">
                              <div class="col-sm-12">
                                <p>&nbsp;</p>  
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
               
            
            <!-- Start Page Content -->   
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
     $(document).ready(function() {
         
    $('#item_type').on('change',function()
    {
       var i = 1;
       var type = $(this).val();
       var brand = <?php echo json_encode($brand); ?>;
       var brand_select = '<select name="brand[]" id="brand" data-id="'+i+'" class="form-control" onchange="getitem_name(this)">';
       
       for(var j=0;j<brand.length;j++)
       {
           brand_select += '<option value="'+brand[j]['brand_id']+'">'+brand[j]['brand_name']+'</option>';
       }
       
       brand_select += '</select>';
       
       if(type == '3')
       {
           var result = '<div class="row" id="item_name'+i+'">\
           <div class="col-sm-2 itemname_div"><label>Brand Name</label>';
           result += brand_select; 
           result += '</div>\
           <div class="col-sm-2"><label>Item Name '+i+'</label>\
           <select name="item_name[]" id="item_name_'+i+'" class="form-control" required><option value="0">Select Item Name</option></select>\
                         </div>\
                         <div class="col-sm-2"><label>HSN '+i+'</label><input class="form-control" name="hsn_code[]" id="hsn_code"  placeholder="HSN Code" required>\
                         </div><div class="col-sm-2"><label>IGST '+i+'</label><input class="form-control" name="igst[]" id="igst" data-id="'+i+'"  placeholder="IGST" required onfocusout="divide_igst(this)">\
                         </div><div class="col-sm-2"><label>CGST '+i+'</label><input class="form-control" name="cgst[]" id="cgst_'+i+'"  placeholder="CGST" readonly required>\
                         </div><div class="col-sm-2"><label>SGST '+i+'</label><input class="form-control" name="sgst[]" id="sgst_'+i+'"  placeholder="SGST" readonly required>\
                         </div><div class="col-sm-1" onclick="add_itme()"><span class="fa fa-plus"></span></div></div>';
           $('.appending_div').html(result);
       }
       else
       {
           var result = '<div class="row" id="item_name'+i+'">\
                         <div class="col-sm-2"><label>Item Name '+i+'</label>\
                         <input class="form-control" name="item_name[]" id="item_name"  placeholder="Item Name" required></div>\
                         <div class="col-sm-2"><label>HSN '+i+'</label><input class="form-control" name="hsn_code[]" id="hsn_code"  placeholder="HSN Code" required>\
                         </div><div class="col-sm-2"><label>IGST '+i+'</label><input class="form-control" name="igst[]" id="igst" data-id="'+i+'"  placeholder="IGST" required onfocusout="divide_igst(this)">\
                         </div><div class="col-sm-2"><label>CGST '+i+'</label><input class="form-control" name="cgst[]" id="cgst_'+i+'"  placeholder="CGST" readonly required>\
                         </div><div class="col-sm-2"><label>SGST '+i+'</label><input class="form-control" name="sgst[]" id="sgst_'+i+'"  placeholder="SGST" readonly required>\
                         </div><div class="col-sm-1" onclick="add_normal_item()"><span class="fa fa-plus"></span></div></div>';
                         $('.appending_div').html(result);
       }
       $('#counter').val(i);
    });
         

  $('.add').on('click', function() {
var i = parseInt($('#counter').val())+1;
    var field = '<div class="row" id="item_name'+i+'"><div class="col-sm-2"><label>Item Name '+i+'</label><input class="form-control" name="item_name[]" id="item_name"  placeholder="Item Name" required></div>\
    <div class="col-sm-2"><label>HSN Code '+i+'</label><input class="form-control" name="hsn_code[]" id="hsn_code"  placeholder="HSN Code" required></div>\
    <div class="col-sm-2"><label>IGST '+i+'</label><input class="form-control" name="igst[]" id="igst" data-id="'+i+'"  placeholder="IGST" required onfocusout="divide_igst(this)"></div>\
    <div class="col-sm-2"><label>CGST '+i+'</label><input class="form-control" name="cgst[]" id="cgst_'+i+'"  placeholder="CGST" readonly required></div>\
    <div class="col-sm-2"><label>SGST '+i+'</label><input class="form-control" name="sgst[]" id="sgst_'+i+'"  placeholder="SGST" readonly required></div>\
    <div class="col-sm-1"><span class="fa fa-minus minus" id="item_name'+i+'" onclick="minus(this)"></span></div></div></div>';
    $('.appending_div').append(field);

    $('#counter').val(i);
    
  });
  
  $("#igst").focusout(function(){
  var id = $(this).val();
});
});

function add_normal_item()
{
    var i = parseInt($('#counter').val())+1;
    var field = '<div class="row" id="item_name'+i+'"><div class="col-sm-2"><label>Item Name '+i+'</label><input class="form-control" name="item_name[]" id="item_name"  placeholder="Item Name" required></div>\
    <div class="col-sm-2"><label>HSN Code '+i+'</label><input class="form-control" name="hsn_code[]" id="hsn_code"  placeholder="HSN Code" required></div>\
    <div class="col-sm-2"><label>IGST '+i+'</label><input class="form-control" name="igst[]" id="igst" data-id="'+i+'"  placeholder="IGST" required onfocusout="divide_igst(this)"></div>\
    <div class="col-sm-2"><label>CGST '+i+'</label><input class="form-control" name="cgst[]" id="cgst_'+i+'"  placeholder="CGST" readonly required></div>\
    <div class="col-sm-2"><label>SGST '+i+'</label><input class="form-control" name="sgst[]" id="sgst_'+i+'"  placeholder="SGST" readonly required></div>\
    <div class="col-sm-1"><span class="fa fa-minus minus" id="item_name'+i+'" onclick="minus(this)"></span></div></div></div>';
    $('.appending_div').append(field);

    $('#counter').val(i);
}
  function divide_igst(obj)
  {
    var data_id = $(obj).attr('data-id');
    var id = $(obj).val();
    if(id != "")
    {
    var half = parseInt(id)/2;
    $('#cgst_'+data_id).val(half);
    $('#sgst_'+data_id).val(half); 
    }
    else
    {
        $('#cgst_'+data_id).val('');
        $('#sgst_'+data_id).val(''); 
    }
  }
  
  function getitem_name(obj)
  {
     var id = $(obj).find(":selected").val();
     var data_id = $(obj).attr('data-id');
	    var post_data = {
        'id': id,
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
    };
	  
	  var url = "<?php echo base_url();?>Items/getitem_name";

	  $.ajax({
		 url : url,
		 type : 'POST',
		 data: post_data,
		 success : function(result)
		 {
		   var obj = JSON.parse(result);
		    $('#item_name_'+data_id).find('option').remove();
		    $('#item_name_'+data_id).append($('<option/>', { 
        value: '0',
        text : 'Select Item Name'
    }));
		   for(var i=0;i<obj.length;i++)
		   {
		        $('#item_name_'+data_id).append($('<option/>', { 
        value: obj[i]['fabric_name'],
        text : obj[i]['fabric_name'] 
    }));
		   }
		 }

	   });
  }
    
  function add_itme()
  {
 var i = parseInt($('#counter').val())+1;
var brand = <?php echo json_encode($brand); ?>;
       var brand_select = '<select name="brand" id="brand" data-id="'+i+'" class="form-control" onchange="getitem_name(this)">';
       
       for(var j=0;j<brand.length;j++)
       {
           brand_select += '<option value="'+brand[j]['brand_id']+'">'+brand[j]['brand_name']+'</option>';
       }
       
       brand_select += '</select>';
       
    var field = '<div class="row" id="item_name'+i+'">\
           <div class="col-sm-2 itemname_div"><label>Brand Name</label>';
           field += brand_select; 
           field += '</div>\
           <div class="col-sm-2"><label>Item Name '+i+'</label>\
           <select name="item_name[]" id="item_name_'+i+'" class="form-control" required><option value="0">Select Item Name</option></select></div>\
    <div class="col-sm-2"><label>HSN Code '+i+'</label><input class="form-control" name="hsn_code[]" id="hsn_code"  placeholder="HSN Code" required></div>\
    <div class="col-sm-2"><label>IGST '+i+'</label><input class="form-control" name="igst[]" id="igst" data-id="'+i+'"  placeholder="IGST" required onfocusout="divide_igst(this)"></div>\
    <div class="col-sm-2"><label>CGST '+i+'</label><input class="form-control" name="cgst[]" id="cgst_'+i+'"  placeholder="CGST" readonly required></div>\
    <div class="col-sm-2"><label>SGST '+i+'</label><input class="form-control" name="sgst[]" id="sgst_'+i+'"  placeholder="SGST" readonly required></div>\
    <div class="col-sm-1"><span class="fa fa-minus minus_item" id="item_name'+i+'" onclick="minus(this)"></span></div></div></div>';
    $('.appending_div').append(field);

    $('#counter').val(i);
  }
  



function minus(obj)
{
     var id = $(obj).attr('id');
      $('#'+id).remove();
}
 </script>
   
</body>

</html>