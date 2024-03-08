<?php
error_reporting(1);
$createdby = $this->session->userdata['user_id'];

// Fetching initial data
if ($this->session->userdata['role'] == 2) {
    $enquiryDetails = $this->db->query("SELECT *,e.enquiry_id as en_id,e.created_datetime as created_datetime
        FROM enquiry e
        LEFT JOIN (SELECT * FROM address) a ON a.enquiry_id = e.enquiry_id
        LEFT JOIN (SELECT name as c_name, designation as c_designation, mobile_no as c_mobile_no, landline as c_landline, email as c_email, dob as c_dob, marriage_anniversary_date as c_mod, enquiry_id as c_enquiry_id FROM contact_person) c ON c.c_enquiry_id = e.enquiry_id
        LEFT JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
        LEFT JOIN (SELECT name as o_name, mobile_no as o_mobile_no, landline as o_landline, email as o_email, dob as o_dob, marriage_anniversary_date as o_mod, enquiry_id as o_enquiry_id FROM owner_details) o ON o.o_enquiry_id = e.enquiry_id
        WHERE ae.user_id = ?
            AND e.isactive = 1
        ORDER BY e.enquiry_id DESC", array($createdby))->result();
} else {
    $enquiryDetails = $this->db->query("SELECT *,e.enquiry_id as en_id,e.created_datetime as created_datetime,
    (
        SELECT name
        FROM user u
        WHERE u.user_id = e.created_by
    ) AS AgentName
FROM enquiry e
LEFT JOIN (SELECT * FROM address) a ON a.enquiry_id = e.enquiry_id
LEFT JOIN (SELECT name as c_name, designation as c_designation, mobile_no as c_mobile_no, landline as c_landline, email as c_email, dob as c_dob, marriage_anniversary_date as c_mod, enquiry_id as c_enquiry_id FROM contact_person) c ON c.c_enquiry_id = e.enquiry_id
LEFT JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
LEFT JOIN (SELECT name as o_name, mobile_no as o_mobile_no, landline as o_landline, email as o_email, dob as o_dob, marriage_anniversary_date as o_mod, enquiry_id as o_enquiry_id FROM owner_details) o ON o.o_enquiry_id = e.enquiry_id
WHERE e.isactive = 1
ORDER BY e.enquiry_id DESC;")->result();
}

// Fetching data with date range
if (isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $user_condition = ($this->session->userdata['role'] == 2) ? "AND e.created_by = $createdby" : "";

    $enquiryDetails = $this->db->query("SELECT *,e.enquiry_id as en_id,e.created_datetime as created_datetime
        FROM enquiry e
        LEFT JOIN (SELECT * FROM address) a ON a.enquiry_id = e.enquiry_id
        LEFT JOIN (SELECT name as c_name, designation as c_designation, mobile_no as c_mobile_no, landline as c_landline, email as c_email, dob as c_dob, marriage_anniversary_date as c_mod, enquiry_id as c_enquiry_id FROM contact_person) c ON c.c_enquiry_id = e.enquiry_id
        LEFT JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
        LEFT JOIN (SELECT name as o_name, mobile_no as o_mobile_no, landline as o_landline, email as o_email, dob as o_dob, marriage_anniversary_date as o_mod, enquiry_id as o_enquiry_id FROM owner_details) o ON o.o_enquiry_id = e.enquiry_id
        WHERE e.isactive = 1
            $user_condition
            AND e.created_datetime BETWEEN ? AND ?
        ORDER BY e.enquiry_id DESC", array($from_date, $to_date))->result();
} else {
    // Fetching data without date range
    $enquiryDetails = $this->db->query("SELECT *,e.enquiry_id as en_id,e.created_datetime as created_datetime,
    (
        SELECT name
        FROM user u
        WHERE u.user_id = e.created_by
    ) AS AgentName
FROM enquiry e
LEFT JOIN (SELECT * FROM address) a ON a.enquiry_id = e.enquiry_id
LEFT JOIN (SELECT name as c_name, designation as c_designation, mobile_no as c_mobile_no, landline as c_landline, email as c_email, dob as c_dob, marriage_anniversary_date as c_mod, enquiry_id as c_enquiry_id FROM contact_person) c ON c.c_enquiry_id = e.enquiry_id
LEFT JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
LEFT JOIN (SELECT name as o_name, mobile_no as o_mobile_no, landline as o_landline, email as o_email, dob as o_dob, marriage_anniversary_date as o_mod, enquiry_id as o_enquiry_id FROM owner_details) o ON o.o_enquiry_id = e.enquiry_id
WHERE e.isactive = 1 ORDER BY e.enquiry_id DESC;")->result();
}

// Fetching data with search
if (isset($_POST['search'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $agent_name = $_POST['agent_name'];
    $party_name = $_POST['party_name'];
    $enquiryQuery = "SELECT *,e.enquiry_id as en_id,e.name as name ,e.created_datetime as created_datetime,
        (
            SELECT name
            FROM user u
            WHERE u.user_id = e.created_by
        ) AS AgentName
    FROM enquiry e
    LEFT JOIN (SELECT * FROM address) a ON a.enquiry_id = e.enquiry_id
    LEFT JOIN user u ON u.user_id = e.created_by
    LEFT JOIN (SELECT name as c_name, designation as c_designation, mobile_no as c_mobile_no, landline as c_landline, email as c_email, dob as c_dob, marriage_anniversary_date as c_mod, enquiry_id as c_enquiry_id FROM contact_person) c ON c.c_enquiry_id = e.enquiry_id
    LEFT JOIN agent_enquiry ae ON ae.enquiry_id = e.enquiry_id
    LEFT JOIN (SELECT name as o_name, mobile_no as o_mobile_no, landline as o_landline, email as o_email, dob as o_dob, marriage_anniversary_date as o_mod, enquiry_id as o_enquiry_id FROM owner_details) o ON o.o_enquiry_id = e.enquiry_id
    WHERE e.isactive = 1";

    if (!empty($from_date) && !empty($to_date)) {
        $enquiryQuery .= " AND e.created_datetime BETWEEN ? AND ?";
    }

    if (!empty($agent_name)) {
        $user_condition = ($this->session->userdata['role'] == 2) ? " AND e.created_by = $createdby" : "";
        $enquiryQuery .= " AND u.name LIKE ?";
    }

    if (!empty($party_name)) {
        $enquiryQuery .= " AND e.name LIKE ?";
    }

    $enquiryQuery .= " ORDER BY e.enquiry_id DESC";

    // Prepare parameters for binding
    $params = array();
    $param_types = '';

    if (!empty($from_date) && !empty($to_date)) {
        $params[] = $from_date;
        $params[] = $to_date;
        $param_types .= 'ss';
    }

    if (!empty($agent_name)) {
        $params[] = "%$agent_name%";
        $param_types .= 's';
    }

    if (!empty($party_name)) {
        $params[] = "%$party_name%";
        $param_types .= 's';
    }

    // Execute the query
    $enquiryDetails = $this->db->query($enquiryQuery, $params, $param_types)->result();
}

//echo $this->db->last_query(); die;
//print_r($enquiryDetails); die;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/client_asstes/images/favicon.png">
    <title>SuperEditors || Enquiry List</title>
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">

    <!-- jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Your Datepicker Initialization -->
    <script>
        $(document).ready(function () {
            $("#from_date").datepicker({ dateFormat: 'yy-mm-dd' });
            $("#to_date").datepicker({ dateFormat: 'yy-mm-dd' });
        });
    </script>
    <style>
         .form-control{
            height:30px;
            font-size:1em;
            line-height:1;
        }
        .input{
            font-size:0;
            line-height:0;
        }
        #gettabledata td {
            height: 2px;
            padding: 2px; 
            overflow: hidden;
        }
    </style>
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
            <!-- Container fluid  -->
            <div class="container-fluid">
            <!-- Start Page Content -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="text-primary">Enquiry List</h4>
                                <form method="post" action="<?php echo base_url()."Enquiry/enquirylist" ?>" autocomplete="off" id="enquiryForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>From Date</label>
                                            <input class="form-control" type="text" name="from_date" id="from_date" required  value="<?php if(empty($from_date)){ echo date('2021-01-01') ; }else{ echo $from_date; } ?>" placeholder="From Date" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>To Date</label>
                                            <input class="form-control" type="text" name="to_date" id="to_date" required value="<?php echo $to_date ?>" placeholder="To Date" required>
                                        </div>
                                        <?php if($this->session->userdata['role'] == 1){ ?>
                                        <div class="col-sm-3">
                                            <label>Agent Name</label>
                                            <input class="form-control" type="text" name="agent_name" id="agent_name" list="agent_names" value="<?php echo $agent_name ?>" placeholder="Agent Name" >
                                            <datalist id="agent_names">
                                            <?php
                                            $AgentNameSearch = $this->db->query("SELECT name FROM user WHERE isactive = 1")->result();
                                            foreach($AgentNameSearch as $getAgentNameSearch){ ?>
                                             <option value="<?php echo $getAgentNameSearch->name ?>">
                                            <?php  } ?> 
                                            </datalist>
                                        </div>
                                        <?php } ?>
                                        <div class="col-sm-3">
                                            <label>Party Name</label>
                                            <input class="form-control" type="text" name="party_name" id="party_name" list="party_names" value="<?php echo $party_name ?>" placeholder="Party Name" >
                                            <datalist id="party_names">
                                            <?php
                                            $PartyNameSearch = $this->db->query("SELECT name FROM enquiry WHERE isactive = 1")->result();
                                            foreach($PartyNameSearch as $getPartyNameSearch){ ?>
                                             <option value="<?php echo $getPartyNameSearch->name ?>">
                                            <?php  } ?> 
                                            </datalist>
                                        </div>
                                        <div class="col-sm-2 mt-4">
                                            <button type="submit" name="search" id="search" class="btn btn-primary btn-rounded">Search</button>
                                        </div>       
                                        <div class="col-sm-4" style="margin-top: 15px;">
                                            <small>Upload File For Import</small>
                                            <input type="file" class="form-control" name="import_file" id="import_file">
                                        </div>
                                    </div>
                                </form>
                                <form method="post" action="" autocomplete="off" id="enquiryForm2" enctype="multipart/form-data">
                                    <button type="submit" name="saveButton" id="saveButton" class="btn btn-primary btn-rounded">Save uploaded data</button>
                                </form>
                                <div class="table-responsive">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Party Name</th>
                                                <th>Party Type</th>
                                                <th>Month</th>
                                                <th>Is Existing Customer</th>
                                                <?php if($_SESSION['role'] == 1){ ?>
                                                <th>Created By</th>
                                                <th>Created Date</th>
                                                <?php } ?>
                                                <th>Address</th>
                                                <th>Country</th>
                                                <th>State</th>
                                                <th>City</th>
                                                <th>Street</th>
                                                <th>Pincode</th>
                                                <th>Contact Name</th>
                                                <th>Designation</th>
                                                <th>Mobile No</th>
                                                <th>Landline No</th>
                                                <th>Email</th>
                                                <th>DOB</th>
                                                <th>Anniversary</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>        
                                                <th>Actions</th>
                                                <th>hsv</th>
                                            </tr>
                                        </thead>
                                        <tbody id="gettabledata">
                                            <?php
                                            $c = 0;
                                            $enquiry_ids = [];
                                                foreach ($enquiryDetails as $getenquiryDetails) {
                                                    $enquiry_id = $getenquiryDetails->en_id;
                                                    if (in_array($enquiry_id, $enquiry_ids)) {
                                                        $getenquiryDetails->name .= " --copy";
                                                    } else {
                                                        $enquiry_ids[] = $enquiry_id;
                                                    }
                                                    $c++;
                                                    if (!empty($enquiry_id)) {
                                                        $quotationDetails = $this->db->query("SELECT max(created_datetime) as createDate FROM quotation WHERE isactive = 1 AND enquiry_id = $enquiry_id")->row();
                                                        if($quotationDetails->createDate){
                                                            $getenquiryDetails->created_datetime=$quotationDetails->createDate;
                                                        }
                                                    } else {
                                                        $getenquiryDetails->created_datetime;
                                                    }
                                                    echo '<tr>';
                                                    echo '<td>' . $c . '</td>';
                                                    echo '<td><a href="' . base_url() . 'Enquiry?enquiry_id=' . $getenquiryDetails->en_id . '" target="_blank">' . $getenquiryDetails->name . '</a></td>';
                                                    echo '<td>' . $getenquiryDetails->type . '</td>';
                                                    echo '<td>' . $getenquiryDetails->month . '</td>';
                                                    echo '<td>' . $getenquiryDetails->is_existing_customer . '</td>';

                                                    if ($_SESSION['role'] == 1) {
                                                        echo '<td>' . $getenquiryDetails->AgentName . '</td>';
                                                        echo '<td>' . $getenquiryDetails->created_datetime. '</td>';
                                                    }
                                                    echo '<td>' . $getenquiryDetails->address_type . " " . $getenquiryDetails->address_line_1 . " " . $getenquiryDetails->address_line_2 . '</td>';
                                                    echo '<td>' . $getenquiryDetails->country . '</td>';
                                                    echo '<td>' . $getenquiryDetails->state . '</td>';
                                                    echo '<td>' . $getenquiryDetails->city . '</td>';
                                                    echo '<td>' . $getenquiryDetails->street . '</td>';
                                                    echo '<td>' . $getenquiryDetails->pincode . '</td>';
                                                    echo '<td>' . $getenquiryDetails->c_name . '</td>';
                                                    echo '<td>' . $getenquiryDetails->c_designation . '</td>';
                                                    echo '<td>' . $getenquiryDetails->c_mobile_no . '</td>';
                                                    echo '<td>' . $getenquiryDetails->c_landline . '</td>';
                                                    echo '<td>' . $getenquiryDetails->c_email . '</td>';
                                                    echo '<td>' . $getenquiryDetails->c_dob . '</td>';
                                                    echo '<td>' . $getenquiryDetails->c_mod . '</td>';
                                                    echo '<td>' . $getenquiryDetails->start_date . '</td>';
                                                    echo '<td>' . $getenquiryDetails->end_date . '</td>';
                                                    echo '<td>
                                                        <a href="' . base_url() . 'Enquiry?enquiry_id=' . $getenquiryDetails->en_id . '" target="_blank">
                                                            <button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">View Details</button>
                                                        </a>
                                                        <a href="' . base_url() . 'Enquiry/quotation?enquiry_id=' . $getenquiryDetails->en_id . '&header_id=' . $latestheadingid . '" target="_blank">
                                                            <button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">Quotation</button>
                                                        </a>
                                                        <a href="' . base_url() . 'Enquiry?enquiry_id=' . $getenquiryDetails->en_id . '#appointment_section" target="_blank">
                                                            <button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">Appointment</button>
                                                        </a>
                                                        <a href="' . base_url() . 'Po?enquiry_id=' . $getenquiryDetails->en_id . '" target="_blank">
                                                            <button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">PO</button>
                                                        </a>
                                                        <a href="' . base_url() . 'Enquiry/delete_enquiry_data?enquiry_id=' . $getenquiryDetails->en_id . '" target="_blank">
                                                            <button type="button" class="btn btn-primary btn-rounded m-b-10 m-l-5">Delete</button>
                                                        </a>
                                                    </td>';
                                                    echo '<th>'. $getenquiryDetails->en_id. '</th>';
                                                    echo '</tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
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
    <!-- End Wrapper -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/jquery.slimscroll.js"></script>
    <!-- Menu sidebar -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/sidebarmenu.js"></script>
    <!-- Sticky kit -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/webticker/jquery.webticker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/peitychart/jquery.peity.min.js"></script>
    <!-- Script for DataTables and related libraries -->
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables-init.js"></script>
    <!-- Include XLSX library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#saveButton').hide();
                var table;
                function initializeDataTable() {
                    if ($.fn.DataTable.isDataTable('#example23')) {
                        $('#example23').DataTable().destroy();
                    }
                    table = $('#example23').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                text: 'Export',
                                action: function () {
                                    exportTableHeaders();
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'csv',
                                text: 'CSV',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            'copy'
                        ]
                    });
                }

                // Call the initialize function
                initializeDataTable();
                function exportTableHeaders() {
                    var headers = [];
                    $('#example23 thead th').each(function () {
                        headers.push($(this).text());
                    });

                    var csvContent = headers.join(',') + '\n';
                    var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

                    var link = document.createElement('a');
                    if (link.download !== undefined) {
                        var url = URL.createObjectURL(blob);
                        link.setAttribute('href', url);
                        link.setAttribute('download', 'table_headers.csv');
                        link.style.visibility = 'hidden';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                }
            });
            $(document).ready(function () {
                $('#saveButton').hide();
                $(document).on('change', 'input#import_file', function (e) {
                    var table = $('#example23').DataTable();
                    table.clear().draw();
                    $('td.dataTables_empty').remove();

                    var fileInput = this;
                    var file = fileInput.files[0];

                    if (!file) {
                        alert('Please select a file.');
                        return;
                    }

                    var filename = file.name.split('.').pop().toLowerCase();
                    if (filename !== 'csv') {
                        alert('Please select a valid Excel file (csv format).');
                        return;
                    }

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var lines = e.target.result.split('\n');

                        table.clear().draw();
                        $('#saveButton').show();

                        for (var i = 1; i < lines.length; i++) {
                            var data = lines[i].split(',');
                            var html = '<tr>';
                            for (var j = 0; j < data.length; j++) {
                                html += '<td>' + data[j] + '</td>';
                            }
                            html += '</tr>';
                            table.rows.add($(html)).draw();
                        }

                        $('#saveButton').show();
                    };

                    reader.readAsText(file);
                });

                $('#saveButton').on('click', function (e) {
                    e.preventDefault();
                    var tableData = [];
                    $('#example23 tbody tr').each(function (index, tr) {
                        var rowData = [];
                        $(tr).find('td').each(function (index, td) {
                            rowData.push($(td).text());
                        });
                        tableData.push(rowData);
                    });

                    var url = "<?php echo base_url('Enquiry/saveEnquiry'); ?>";
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: { tableData: tableData },
                        success: function (response) {
                            console.log(response);
                            try {
                                var jsonData = JSON.parse(response);
                                if (jsonData.status === 'success') {
                                    alert('Data Saved successfully');
                                    window.location.href = "<?php echo base_url() ?>Enquiry/enquirylist";
                                }
                            } catch (error) {
                                console.error('Error parsing JSON:', error);
                            }
                        },
                    });
                });
            });
        </script>
</body>
</html>  