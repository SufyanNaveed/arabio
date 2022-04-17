<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Ticket # <?php echo $ticket['id']; ?></title>
    <style>
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }

        .invoice-box {
            width: 210mm;
            height: 150mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal {
            page-break-inside: avoid;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: 1px solid #ddd;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right: 20pt;
        }

        .invoice-box table td {
            padding: 10pt 4pt 8pt 4pt;
            vertical-align: top;
        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;
        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;
        }

        table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td {
            border: 1px solid #ddd;
        }

        table tr.b_class td {
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td {
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 400pt;
        }

        .myco2 {
            width: 200pt;
        }

        .myw {
            width: 300pt;
            font-size: 14pt;
            line-height: 14pt;
        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;
        }

        .party {
            border: #ccc 1px solid;

        }

        .top_logo {
            max-height: 180px;
            max-width: 250px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
        } 
        .stamp {
                margin: 5pt;
                padding: 3pt;
                border: 3pt solid #111;
                text-align: center;
                font-size: 20pt;
                color
            }
        .signature {
            border: 0;
            border-bottom: 2px solid #000;
            margin-top: 20px;
            width: 150%;
        } 
    </style>
</head>
<body dir="<?= LTR ?>">
<div class="invoice-box">
    <h3 style="text-align: center;"> Access Request Form </h3>
    <small><b>* All fields must be completed for anyNew User or Change of Access for an Existing User.</b></small>
    <p><b>Part 1: *EMPLOYEE INFORMATION</b></p>
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr>
            <td width="15rem">
                <?php if($ticket['request'] == 'new_request'){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> New Request </span>
            </td>
            <td width="15rem">
                <?php if($ticket['request'] == 'change_request'){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?>
                <span style="padding-top:-30px;" > Change Request</span>
            </td>
            <td>
                <p><b>Date: </b>&nbsp;&nbsp;<u><?php echo $ticket['date']; ?></u></p>
            </td> 
        </tr>
        <tr>
            <td width="15rem" colspan="2">
                <p><b>Employee Name: </b>&nbsp;&nbsp; <u><?php echo $ticket['emp_name']; ?></u> </p>
            </td>
            <td>
                <p><b>Department: </b> &nbsp;&nbsp; <u><?php echo $ticket['department']; ?></u></p>
            </td> 
        </tr>
        <tr>
            <td width="15rem" colspan="2">
                <p><b>Employee Title: </b>&nbsp;&nbsp; <u><?php echo $ticket['emp_title']; ?></u></p>
            </td>
            <td>
                <p><b>Network ID: </b> &nbsp;&nbsp; <u><?php echo $ticket['network_Id']; ?></u></p>
            </td> 
        </tr>
        <tr>
            <td width="15rem" colspan="2">
                <p><b>Primary phone number: </b> &nbsp;&nbsp; <u><?php echo $ticket['primary_phone']; ?></u></p>
            </td>
            <td>
                <p><b>Email address: </b> &nbsp;&nbsp; <u><?php echo $ticket['email_address']; ?></u></p>
            </td> 
        </tr>
        <tr>
            <td width="15rem" colspan="3">
                <p><b>SAP Position</b><small>(For New Staff)</small><b>:</b>&nbsp;&nbsp; <u><?php echo $ticket['sap_position']; ?></u></p>
            </td>
        </tr>
    </table>
    <br><p><b>Part 2:  SYSTEM ACCESS</b></p>
    <small>Please indicate for which applications, shares, and environments you are requesting access.  If role-based access exists, please identify the role requested.</small>
    <table>
        <tr>
            <td width="25rem"><strong> Application</strong></td>
            <td><strong>Role</strong></td>
        </tr>
    </table>
    <table class="subtotal">
        <tr>
            <td width="25rem">
                <?php if(in_array("1",explode(',',$ticket['system_access']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php }  ?>
                <span> SAP </span>
            </td>
            <td><?php echo $ticket['SAP_role']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("2",explode(',',$ticket['system_access']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?>
                <span> Serialization </span>
            </td>
            <td><?php echo $ticket['serialization_role']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("3",explode(',',$ticket['system_access']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Shared Drive </span>
            </td>
            <td><?php echo $ticket['shared_role']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("4",explode(',',$ticket['system_access']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Acrobat Writer </span>
            </td>
            <td><?php echo $ticket['acrobat_role']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("5",explode(',',$ticket['system_access']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php }  ?> 
                <span> Microsoft Access </span>
            </td>
            <td><?php echo $ticket['microsoft_role']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("6",explode(',',$ticket['system_access']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Fortinet Mobile </span>
            </td>
            <td><?php echo $ticket['fortinet_role']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("7",explode(',',$ticket['system_access']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Other </span>
            </td>
            <td><?php echo $ticket['other_role']; ?></td>
        </tr>
        
        
        
    </table>
    <p><b> Microsoft 365(Including email) </b></p>
    <table class="subtotal">
        <tr>
            <td>
                <?php if(in_array("1",explode(',',$ticket['microsoft_365']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Business Standard (Suitable for office-based users) </span>
            </td> 
        </tr>
        <tr>
            <td>
                <?php if(in_array("2",explode(',',$ticket['microsoft_365']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Basic (Suitable for non-office-based users)</span>
            </td> 
        </tr>
        <tr>
            <td>
                <?php if(in_array("3",explode(',',$ticket['microsoft_365']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?>
                <span> None </span>
            </td> 
        </tr> 
        <tr>
            <td><b>Justification</b></td> 
        </tr> 
        <tr>
            <td><?php echo $ticket['justification'] ? $ticket['justification'] : '&nbsp;'; ?></td>
        </tr> 
        
        
        
    </table>
    <br>
    <p><b>Part 3:  HARDWARE REQUIRMENTS </b></p>
    <small>Please indicate any specific hardware needed.</small>
    <table>
        <tr>
            <td width="25rem"><strong> Equipment</strong></td>
            <td><strong>Comments</strong></td>
        </tr>
    </table>    
    <table class="subtotal">
        <tr>
            <td width="25rem">
                <?php if(in_array("1",explode(',',$ticket['machine']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Laptop </span>&nbsp;&nbsp;

                <?php if(in_array("2",explode(',',$ticket['machine']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Desktop </span>
            </td>
            <td><?php echo $ticket['machine_comment']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("1",explode(',',$ticket['accessories']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php }  ?> 
                <span> Headsets </span> &nbsp;&nbsp;

                <?php if(in_array("2",explode(',',$ticket['accessories']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Monitor </span>&nbsp;&nbsp;

                <?php if(in_array("3",explode(',',$ticket['accessories']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Docking Station </span>
            </td>
            <td><?php echo $ticket['accessories_comment']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("1",explode(',',$ticket['wireless_mouse']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php }  ?> 
                <span> Wireless Mouse/Keyboard </span> 
            </td>
            <td><?php echo $ticket['wireless_mouse_comment']; ?></td>
        </tr>
        <tr>
            <td width="25rem">
                <?php if(in_array("1",explode(',',$ticket['other']))){ ?>
                    <img style="height:15px;"  src="<?php echo base_url('app-assets/images/check-mark.png') ?>" >
                <?php } else { ?>
                    <img style="height:13px;"  src="<?php echo base_url('app-assets/images/square.png') ?>" >
                <?php } ?> 
                <span> Other </span> 
            </td>
            <td><?php echo $ticket['other_comment']; ?></td>
        </tr>
    </table>
    
    <p><b>Part 4:  APPROVALS </b></p>
    <table class="subtotal">
        <tr>
            <td width="1rem;"> Requestor: </td>
            <td><?php echo $ticket['requestor']; ?></td>
            <td width="1rem;"> Signature: </td>
            <td><?php echo $ticket['signature_req']; ?></td>
            <td width="1rem;"> Date: </td>
            <td><?php echo $ticket['date_req']; ?></td>
        </tr>
        <tr>
            <td width="1rem;"> BBO/HOD: </td>
            <td><?php echo $ticket['bbo_hod']; ?></td>
            <td width="1rem;"> Signature: </td>
            <td><?php echo $ticket['signature_hod']; ?></td>
            <td width="1rem;"> Date: </td>
            <td><?php echo $ticket['date_hod']; ?></td>
        </tr>
        <tr>
            <td width="1rem;"> IT-Manager: </td>
            <td><?php echo $ticket['it_manager']; ?></td>
            <td width="1rem;"> Signature: </td>
            <td><?php echo $ticket['signature_it']; ?></td>
            <td width="1rem;"> Date: </td>
            <td><?php echo $ticket['date_it']; ?></td>
        </tr>       
    </table>
    <br>
    <small><b>BBO: Business Process Owner</b></small><br>
    <small><b>Please return the form to IT (keep a copy for your own records)</b></small>
</div>
</body>
</html>