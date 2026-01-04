<?php
 
    include_once("includes/config.php");
    include_once("includes/functions.php");

if (isset($_GET['mem_id'])) {
    $_SESSION['mem_id'] = $_GET['mem_id'];  // Store in session
}

   
    if(!isset($_SESSION['mem_id']) || $_SESSION['mem_id']==""){
        header("Location:../clients-management.php");
        exit;
    }

    $sql = "SELECT client_portal_information FROM firm_info WHERE id = '1'";
    $rs = mysql_query($sql);
    $row_cms=mysql_fetch_assoc($rs);

    $sql="SELECT balance,id FROM members WHERE id='".$_SESSION['mem_id']."'";
    $rs_mem=mysql_query($sql);
    $row_mem=mysql_fetch_assoc($rs_mem);
    $pg = "client_account";

    function get_client_cases($id) {
        $case_id = '0';
        $row_query = "SELECT * FROM case_cases WHERE fkclientid = '$id'";
        $row_result = mysql_query($row_query) or die(mysql_error());
        while($case = mysql_fetch_assoc($row_result)) {
            $case_id .= ','.$case['caseid'];
        }

        return $case_id;
    }

    function count_outstanding_payment($id) {
        $case_id = get_client_cases($id);
        $case_id = str_replace('0,', '', $case_id);
        $total = 0;

        $query = "SELECT * FROM case_outstanding_payment WHERE is_deleted = 0 AND caseid IN ($case_id)";
        $result = mysql_query($query);
        while($row =  mysql_fetch_assoc($result)) {
            $total += $row['total_owed'];
        }

        return number_format($total, 2);
    }

    function count_number_of_matters($id) {
        $row_query = "SELECT * FROM case_cases WHERE fkclientid = '$id'";
        $row_result = mysql_query($row_query);
        return mysql_num_rows($row_result);
    }

    function count_number_of_invoice($id) {
        $row_query = "SELECT * FROM invoice_cs WHERE userID = '$id'";
        $row_result = mysql_query($row_query);
        return mysql_num_rows($row_result);
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>Client Profile | Hybrid CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include_once("includes/inc_css_client.php"); ?>
    <link href="https://translate.googleapis.com/translate_static/css/translateelement.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Quicksand:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <meta http-equiv="content-Language" content="EN">
    <link rel="stylesheet" href="css/style_new_client.css">
    <link rel="stylesheet" href="css/mob.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <style type="text/css">
        #container_slider {width:730px; margin: 0 auto; margin-left:4px;}
        #container_slider ol, ul {list-style: none;}
        #buttons {
            float:right;
        }
    </style>
</head>
<body> 
    <?php include_once("includes/inc_header_new.php"); ?>
    <div class="container-fluid sb2">
        <div class="row">
            <?php include_once("includes/inc_menu_client_account_new.php"); ?>
            <div class="sb2-2">
                
                <div class="sb2-2-2">
                    <ul>
                        <li>
                            <a href="my-profile.php">
                                <i class="fa fa-home" aria-hidden="true"></i> 
                                Home
                            </a>
                        </li>
                        <li class="active-bre">
                            <a href="#"> 
                                Client Section 
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
				                    <div class="row">
					                    <div class="col-sm-4">
                                            <a href="my-case-list.php">
                                                <div class="card-normal">
                                                    Number Of Matters <br /><?= count_number_of_matters($row_mem['id']);?>
                                                </div>
                                            </a>
	                             	    </div>
					                    
                                        <div class="col-sm-4">
                                            <a href="outstanding_payment.php">
                                                <div class="myaccount_balance">
                                                    Outstanding Payments <br />&pound;<?= count_outstanding_payment($row_mem['id']);?>
                                                </div>
                                            </a>
	                             	    </div>

                                        <div class="col-sm-4" >
                                            <a href="outstand.php">
                                                <div class=" myaccount_balance_r pull_right">
                                                    Number of Invoices <br /> <?= count_number_of_invoice($row_mem['id']) ?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm-12 main_content">
                                            <?=stripslashes($row_cms['client_portal_information'])?>
                                        </div>	
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
