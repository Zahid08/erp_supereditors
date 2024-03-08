<?php
error_reporting(0);

$CheckSms = $this->db->query("SELECT * FROM sms_communication WHERE status IN (0,1) AND track = 0 ")->result();

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
      <title>SuperEditors || Home Page</title>
      <!-- Custom CSS -->
      <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
      <!--============For Editor===========-->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/client_asstes/css/lib/html5-editor/bootstrap-wysihtml5.css" />
      <!--============For Editor===========-->
      <!--============For Accordian===========-->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!--============For Accordian===========-->
      <!--============For Dropdown Search and Multi Select===========-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
      <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
      <script>
         $(document).ready(function(){
             var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
             removeItemButton: true,
             maxItemCount:10,
             searchResultLimit:10,
             renderChoiceLimit:10
             });
         });
      </script>
      <!--============For Dropdown Search and Multi Select===========-->
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
               <h3 class="text-primary">Communication</h3>
            </div>
            <div class="col-md-7 align-self-center">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item active">Communication</li>
               </ol>
            </div>
         </div>
         <!-- End Bread crumb -->
         <!-- Container fluid  -->
         <div class="container-fluid">
            <!-- Start Page Content -->
            <section id="communication_section" name="communication_section">
               <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#communication_section" >Communication</button>
               <div id="communication_section" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        <center>
                           <p style="color:green">
                               <?php
                               if(isset($_SESSION['communication_message'])){
                                   echo $_SESSION['communication_message'];
                                   unset($_SESSION['communication_message']);
                               }
                               ?>
                           </p>
                        </center>

                        <h5 class="card-title">Communication</h5>
                        <form method="post" action="<?php echo base_url() ?>Communication/save_sms_data" autocomplete="off" enctype='multipart/form-data'>
                           <div class="row">

                              <div class="col-sm-12" style="display:none">
                                <p><b>Choose The Filters To Send Mail Notification:</b></p>
                                  <input type="checkbox" id="all_agents" name="all_agents" value="<?php echo $_GET['allagents'] ?>" <?php if(!empty($_GET['allagents'])){ ?>  checked <?php } ?>>
                                  <label for="all_agents">All Agents</label><br>
                                  <input type="checkbox" id="all_enquiry" name="all_enquiry" value="<?php echo $_GET['allenquiry'] ?>" <?php if(!empty($_GET['allenquiry'])){ ?>  checked <?php } ?>>
                                  <label for="all_enquiry">All Enquiry</label><br>
                                  <input type="checkbox" id="all_customer" name="all_customer" value="all_customer">
                                  <label for="all_customer">All Customers</label><br>
                              </div>

                              <div class="col-sm-12">
                                  <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                       <tr>
                                          <th><input type="checkbox" id="select_all" name="select_all" onchange="checkAll(this)" value="All"> Select All</th>
                                          <th>Mobile #</th>
                                          <?php if(empty($_GET['allagents'])) { ?>
                                          <th>Company</th>
                                          <?php } ?>
                                          <th>Designation</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if(!empty($_GET['allagents']) && empty($_GET['allenquiry']))
                                       $query = "SELECT mobile,user_id as id,'Agent' as designation,'SuperEditors' as company FROM user ";
                                       if(empty($_GET['allagents']) && !empty($_GET['allenquiry']))
                                       $query = "SELECT mobile_no as mobile,contact_id as id,designation, (SELECT e.name FROM enquiry e WHERE e.enquiry_id = c.enquiry_id) as company FROM contact_person c ";
                                       if(!empty($_GET['allagents']) && !empty($_GET['allenquiry']))
                                       $query = "SELECT mobile,user_id as id,'Agent' as designation,'SuperEditors' as company FROM user  UNION ALL SELECT mobile_no as mobile,contact_id as id,designation,(SELECT e.name FROM enquiry e WHERE e.enquiry_id = c.enquiry_id) as company FROM contact_person c WHERE email LIKE '%@%'";
                                       $contactDetails = $this->db->query("$query")->result();
                                       $i = 0;
                                          foreach($contactDetails as $getcontactDetails){
                                          $i++;
                                          ?>
                                       <tr>
                                          <td><input type="checkbox" id="mobile_select_<?php echo $i ?>" name="mobile_select_<?php echo $i ?>" value="<?php echo $getcontactDetails->mobile  ?>"></td>
                                          <td><?php echo $getcontactDetails->mobile ?></td>
                                          <?php if(empty($_GET['allagents'])) { ?>
                                          <td><?php echo $getcontactDetails->company ?></td>
                                          <?php } ?>
                                          <td><?php echo $getcontactDetails->designation ?></td>
                                       </tr>
                                       <?php
                                          }
                                          ?>
                                    </tbody>
                                 </table>
                              </div>
                              <br>
                               <div class="col-sm-12">
                                 <input class="form-control" type="text" name="addon_mob" id="addon_mob" placeholder="Any Other Mobile Number : (use comma to separate more than one mob)">
                              </div>
                              <div class="col-sm-12">
                                  <lable>Select SMS Template:</lable>
                                 <select class="form-control" name="sms_template" id="sms_template">
                                     <option>Choose Template</option>
                                      <?php $smsTemplates = $this->db->query("SELECT * FROM sms_templates where is_active = 1")->result();
                                      foreach($smsTemplates as $getsmsTemplates){ ?>
                                        <option value="<?php echo $getsmsTemplates->template_code ?>"><?php echo $getsmsTemplates->template_code?></option>
                                      <?php } ?>
                                 </select>
                              </div>
                              <br><br>
                              <div class="col-sm-12">
                                  <textarea name="template_string" id="template_string" class="form-control"  style="height:150px;" placeholder="Template String" readonly></textarea>
                              </div>


                              <div class="col-sm-12">
                                 <br><button type="submit" class="btn btn-primary  text-white" >Save and Send SMS</button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
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
      <!--text editor kit -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/wysihtml5-0.3.0.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/bootstrap-wysihtml5.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/wysihtml5-init.js"></script>


      <!-- Bootstrap Modal -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <!--select all-->
    <script>
        function checkAll(ele) {
             var checkboxes = document.getElementsByTagName('input');
             if (ele.checked) {
                 for (var i = 0; i < checkboxes.length; i++) {
                     if (checkboxes[i].type == 'checkbox') {
                         checkboxes[i].checked = true;
                     }
                 }
             } else {
                 for (var i = 0; i < checkboxes.length; i++) {
                     console.log(i)
                     if (checkboxes[i].type == 'checkbox') {
                         checkboxes[i].checked = false;
                     }
                 }
             }
         }
    </script>

    <script>
    $('#sms_template').change( function() {
        $("#template_string").removeAttr("readonly");
            let formData = new FormData(); ;
            formData.append("sms_template",this.value);
            console.log(formData);
            $("#template_string").html("");

            $.ajax({
    			url: "<?php echo base_url() ?>Communication/ajaxCall_getTemplateString",
    			type: "POST",
    			data:formData,
    			enctype: 'multipart/form-data',
    			processData: false,
    			contentType: false,
    			success: function(response) {
    			    /*alert(response);
    			    console.log(response);*/
                    $("#template_string").html(response);
    			},
    			error: function(error) {

    			}
    		});
        });



    </script>

   </body>
</html>
