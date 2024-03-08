<?php
$roleID = $this->session->userdata['role'];
$accessDetails = $this->db->query("SELECT r.* FROM roles r WHERE r.id = $roleID")->row();

?>
<div class="left-sidebar" style="background-color:#ca2573">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav" >
                    <ul id="sidebar-menu">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        
                        
                        <?php if($accessDetails->dashboard == 1){ ?>
                        <li> <a class="has-arrow  " href="<?php echo base_url(); ?>Dashboard" aria-expanded="false"><i class="fa fa-tachometer text-white"></i><span class="hide-menu">Dashboard</span></a></li>
                        <?php } ?>
                        
                        
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><span class="hide-menu"><img src="<?php echo base_url(); ?>assets/client_asstes/images/search-15-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Enquiry  </span></a>
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                <?php if($accessDetails->add_enquiry == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Enquiry"><img src="<?php echo base_url(); ?>assets/client_asstes/images/add-list-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Add Enquiry </a></li>
                                <?php } ?>
                                
                                <?php if($accessDetails->enquiry_list == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Enquiry/enquirylist"><img src="<?php echo base_url(); ?>assets/client_asstes/images/activity-feed-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Enquiry List </a></li>
                                <?php } ?>
                                <?php if($accessDetails->quotation == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Enquiry/quotationlist"><img src="<?php echo base_url(); ?>assets/client_asstes/images/inbox-4-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Quotations </a></li>
                                <?php } ?>
                                <?php if($accessDetails->appointment == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Enquiry/appointmentlist"><img src="<?php echo base_url(); ?>assets/client_asstes/images/align-bottom-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Appointment </a></li>
                                     <li><a href="<?php echo base_url(); ?>Enquiry/ramarklist"><img src="<?php echo base_url(); ?>assets/client_asstes/images/align-bottom-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Opening Month/Callback </a></li>
                           
                                <?php } ?>
                            </ul>
                        </li>
                      
                            <?php if($accessDetails->customers == 1){ ?>
                            <li> 
                                <a class="has-arrow  " href="#" aria-expanded="false">
                                <img src="<?php echo base_url(); ?>assets/client_asstes/images/Customer.png" height="20px" width="20px" alt="homepage" />&ensp;
                            
                                <span class="hide-menu">Customers </span></a>
                                <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                    <li><a href="<?php echo base_url(); ?>Customer"><img src="<?php echo base_url(); ?>assets/client_asstes/images/add-user-2-xl.png" height="20px" width="20px" alt="homepage" />&ensp;Customers </a></li>
                                </ul>
                            </li>
                            <?php } ?>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false">
                            <img src="<?php echo base_url(); ?>assets/client_asstes/images/Communication.png" height="20px" width="20px" alt="homepage" />&ensp;
                            <span class="hide-menu">Communication </span></a>                          
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                <?php if($accessDetails->send_email == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Communication"><img src="<?php echo base_url(); ?>assets/client_asstes/images/reply-xl.png" height="20px" width="20px" alt="homepage" />&ensp;Send Email </a></li>
                                <?php } ?>
                                <?php if($accessDetails->check_mail_status == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Communication/mail_status"><img src="<?php echo base_url(); ?>assets/client_asstes/images/inbox-7-xl.png" height="20px" width="20px" alt="homepage" />&ensp;Check Mail Status </a></li>
                                <?php } ?>
                             
                                <li><a href="<?php echo base_url(); ?>Communication/bulk_mail_report"><img src="<?php echo base_url(); ?>assets/client_asstes/images/email-3-xl.png" height="20px" width="20px" alt="homepage" />&ensp;Bulk Email Report </a></li>
                           
                                <?php if($accessDetails->send_sms == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Communication/sms"><img src="<?php echo base_url(); ?>assets/client_asstes/images/messenger-xl.png" height="20px" width="20px" alt="homepage" />&ensp;Send SMS </a></li>
                                <?php } ?>
                                <?php if($accessDetails->check_sms_status == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Communication/sms_status"><img src="<?php echo base_url(); ?>assets/client_asstes/images/check-mark-11-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Check SMS Status </a></li>
                                <?php } ?>
                                <?php if($accessDetails->bulk_sms_report == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Communication/bulk_sms_report"><img src="<?php echo base_url(); ?>assets/client_asstes/images/restore-window-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Bulk SMS Report </a></li>
                                <?php } ?>
                                <?php if($accessDetails->send_whatsapp_msg == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Communication/whatsapp"><img src="<?php echo base_url(); ?>assets/client_asstes/images/whatsapp-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Send WhatsApp Msg</a></li>
                                <?php } ?>
                                <?php if($accessDetails->check_whatsapp_status == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Communication/whatsapp_status"><img src="<?php echo base_url(); ?>assets/client_asstes/images/viber-4-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Check WhatsApp Status </a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><span class="hide-menu"><img src="<?php echo base_url(); ?>assets/client_asstes/images/chess-33-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Master </span></a>
                            
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                <?php if($accessDetails->transport == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Transport"><img src="<?php echo base_url(); ?>assets/client_asstes/images/train-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Transport </a></li>
                               <?php } ?>
                                <?php if($accessDetails->measure == 1){ ?>
                               <li><a href="<?php echo base_url(); ?>Measure"><img src="<?php echo base_url(); ?>assets/client_asstes/images/dice-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Measure </a></li>
                                <?php } ?>
                                <?php if($accessDetails->supplier == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Supplier"><img src="<?php echo base_url(); ?>assets/client_asstes/images/workers-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Supplier </a></li>
                                <?php } ?>
                                <?php if($accessDetails->item == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Items"><img src="<?php echo base_url(); ?>assets/client_asstes/images/survival-bag-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Items </a></li>
                                <?php } ?>
                                <?php if($accessDetails->brand == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Brand"><img src="<?php echo base_url(); ?>assets/client_asstes/images/globe-3-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Brand </a></li>
                                <?php } ?>
                                <?php if($accessDetails->add_client_email == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Email"><img src="<?php echo base_url(); ?>assets/client_asstes/images/reply-xl (1).png" height="20px" width="20px" alt="homepage" />&ensp;Add Client Emails</a></li>
                                <?php } ?>
                                <li><a href="<?php echo base_url(); ?>Workermaster"><img src="<?php echo base_url(); ?>assets/client_asstes/images/workers-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Karigar Master </a></li>
                                <li><a href="<?php echo base_url(); ?>OutboardOrderBulk"><img src="<?php echo base_url(); ?>assets/client_asstes/images/workers-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Outboard Order Bulk</a></li>
                                <li><a href="<?php echo base_url(); ?>OrdersList"><img src="<?php echo base_url(); ?>assets/client_asstes/images/workers-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Outboard Order Chalan </a></li>
                                <li><a href="<?php echo base_url(); ?>KarigarItemRatedLink"><img src="<?php echo base_url(); ?>assets/client_asstes/images/workers-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Item Rate Linking Master</a></li>
                                <li><a href="<?php echo base_url(); ?>Patterns"><img src="<?php echo base_url(); ?>assets/client_asstes/images/train-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Patterns </a></li>
                                
                                 <li><a href="<?php echo base_url(); ?>PaymentTerms"><img src="<?php echo base_url(); ?>assets/client_asstes/images/train-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Payment Terms </a></li>
                                 
                                <?php if($accessDetails->sms_template==1){ ?>
                                <li><a href="<?php echo base_url(); ?>Smstemplate"><img src="<?php echo base_url(); ?>assets/client_asstes/images/reply-xl (1).png" height="20px" width="20px" alt="homepage" />&ensp;Add SMS Templates</a></li>
                                <?php } ?>

                            </ul>
                        </li>
                        <?php if($accessDetails->purchase == 1){ ?>
                         <li> <a class="has-arrow  " href="#" aria-expanded="false">
                            <img src="<?php echo base_url(); ?>assets/client_asstes/images/cart-70-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;
                            <!--created by-nikita auti-->
                            <!--on date-02/12/2021-->
                            <!--perpose-iconchange-->
                            <span class="hide-menu">Purchase </span></a>
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                <li><a href="<?php echo base_url(); ?>Purchase/add_purchase"><img src="<?php echo base_url(); ?>assets/client_asstes/images/cart-56-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Supplier Purchase Entry </a></li>
                            <li><a href="<?php echo base_url(); ?>Purchase"><img src="<?php echo base_url(); ?>assets/client_asstes/images/purchase-order-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Purchase Report </a></li>
                            <li><a href="<?php echo base_url(); ?>Purchase/item_barcode"><img src="<?php echo base_url(); ?>assets/client_asstes/images/barcode-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Barcodes </a></li>
                            
                            
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if($accessDetails->transport == 1){ ?>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/client_asstes/images/Setting.png" height="20px" width=20px alt="homepage" />&ensp;<span class="hide-menu">Transport </span></a>
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                  <li><a href="<?php echo base_url(); ?>Purchase/transportlisting"><img src="<?php echo base_url(); ?>assets/client_asstes/images/laptop-5-xl.png" height="20px" width="20px" alt="homepage" />Transport</a></li>
                                 
                                
                                
                            </ul>
                        </li>
                        <?php } ?>
                             
                              <li> <a class="has-arrow  " href="#" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/client_asstes/images/Setting.png" height="20px" width=20px alt="homepage" />&ensp;<span class="hide-menu">Payment </span></a>
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                               <li><a href="<?php echo base_url(); ?>Advance_payment_entry/advanceBillPay"><img src="<?php echo base_url(); ?>assets/client_asstes/images/checked-user-xxl.png" height="20px" width="20px" alt="homepage" />Bill To Bill Advanced Payment</a></li>
                                <li><a href="<?php echo base_url(); ?>Advance_payment_entry"><img src="<?php echo base_url(); ?>assets/client_asstes/images/checked-user-xxl.png" height="20px" width="20px" alt="homepage" />Supplier Advance Payment Paid</a></li>
                                <li><a href="<?php echo base_url(); ?>Payment_Paid_Entry_Supplier"><img src="<?php echo base_url(); ?>assets/client_asstes/images/checked-user-xxl.png" height="20px" width="20px" alt="homepage" />Supplier Payment Paid</a></li>
                                <li><a href="<?php echo base_url(); ?>Payment_Paid_Entry_Supplier/SupplierPaymentReport"><img src="<?php echo base_url(); ?>assets/client_asstes/images/checked-user-xxl.png" height="20px" width="20px" alt="homepage" />Supplier payment Report</a></li>
                                
                               <li><a href="<?php echo base_url(); ?>Payment_Paid_Entry"><img src="<?php echo base_url(); ?>assets/client_asstes/images/laptop-5-xl.png" height="20px" width="20px" alt="homepage" />Transport</a></li>
                               
                            </ul>
                        </li>
                        
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/client_asstes/images/Setting.png" height="20px" width=20px alt="homepage" />&ensp;<span class="hide-menu">Bills </span></a>
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                  <li><a href="<?php echo base_url(); ?>BillGeneration"><img src="<?php echo base_url(); ?>assets/client_asstes/images/laptop-5-xl.png" height="20px" width="20px" alt="homepage" />Generate Bill</a></li>
                                  <li><a href="<?php echo base_url(); ?>BillGeneration/BillingReport"><img src="<?php echo base_url(); ?>assets/client_asstes/images/checked-user-xxl.png" height="20px" width="20px" alt="homepage" />Billing Report</a></li>
                            </ul>
                        </li>
                        
                       <li> <a class="has-arrow  " href="#" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/client_asstes/images/Setting.png" height="20px" width=20px alt="homepage" />&ensp;<span class="hide-menu">Codes </span></a>
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                <li><a href="<?php echo base_url(); ?>CodeGeneration"><img src="<?php echo base_url(); ?>assets/client_asstes/images/laptop-5-xl.png" height="20px" width="20px" alt="homepage" />Generate Codes</a></li>
                                <li><a href="<?php echo base_url(); ?>CodeGeneration/Codeauthorize"><img src="<?php echo base_url(); ?>assets/client_asstes/images/checked-user-xxl.png" height="20px" width="20px" alt="homepage" />Codes Authorized</a></li>
                                <li><a href="<?php echo base_url(); ?>CodeGeneration/Measurements"><img src="<?php echo base_url(); ?>assets/client_asstes/images/settings-20-xxl.png" height="20px" width="20px" alt="homepage" /> Codes Measurements</a></li>
                            </ul>
                        </li>
                             
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/client_asstes/images/Setting.png" height="20px" width=20px alt="homepage" />&ensp;<span class="hide-menu">Setting </span></a>
                    
                            <ul aria-expanded="false" class="collapse" style="background-color:#ca2573">
                                <?php if($accessDetails->config == 1){ ?>
                               <li><a href="<?php echo base_url(); ?>Setting"><img src="<?php echo base_url(); ?>assets/client_asstes/images/laptop-5-xl.png" height="20px" width="20px" alt="homepage" />&ensp;Config </a></li>
                                <?php } ?>
                                <?php if($accessDetails->users == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>User"><img src="<?php echo base_url(); ?>assets/client_asstes/images/checked-user-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Users </a></li>
                                <?php } ?>
                                <?php if($accessDetails->roles == 1){ ?>
                                <li><a href="<?php echo base_url(); ?>Roles"><img src="<?php echo base_url(); ?>assets/client_asstes/images/settings-20-xxl.png" height="20px" width="20px" alt="homepage" />&ensp;Roles </a></li>
                                <?php } ?>
                                <?php if($accessDetails->sms_template==1){ ?>
                                <li><a href="<?php echo base_url(); ?>Setting/sms_template"><img src="<?php echo base_url(); ?>assets/client_asstes/images/sms-3-xxl (1).png" height="20px" width="20px" alt="homepage" />&ensp;Sms Templates </a></li>
                               <?php } ?>
                                
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>