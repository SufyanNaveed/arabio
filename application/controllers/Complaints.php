<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/vendor/autoload.php';
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\EscposImage;

use Omnipay\Omnipay;
use Endroid\QrCode\QrCode;

use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class Complaints extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Complaints_model', 'complaints');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(9)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'emp';
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Complaints List';
        $data['complaints'] = $this->complaints->list_complaints();
        $this->load->view('fixed/header', $head);
        $this->load->view('complaints/list', $data);
        $this->load->view('fixed/footer');
    }

    
    public function add()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Complaint';
        $data['dept'] = $this->complaints->department_list(0);
        $this->load->view('fixed/header', $head);
        $this->load->view('complaints/add', $data);
        $this->load->view('fixed/footer');
    }

    public function submit_user()
    {
        $data = array(
            'emp_id' => $this->aauth->get_user()->id,
            'request' => $this->input->post('request', true),
            'date' => $this->input->post('date', true),
            'emp_name' => $this->input->post('emp_name', true),
            'department' => $this->input->post('department', true),
            'emp_title' => $this->input->post('emp_title', true),
            'network_Id' => $this->input->post('network_Id', true),
            'primary_phone' => $this->input->post('primary_phone', true),
            'email_address' => $this->input->post('email_address', true),
            'sap_position' => $this->input->post('sap_position', true),
            'system_access' => count($this->input->post('system_access', true)) > 0 ? implode(',',$this->input->post('system_access', true)) : '',
            'SAP_role' => $this->input->post('SAP_role', true),
            'serialization_role' => $this->input->post('serialization_role', true),
            'shared_role' => $this->input->post('shared_role', true),
            'acrobat_role' => $this->input->post('acrobat_role', true),
            'microsoft_role' => $this->input->post('microsoft_role', true),
            'fortinet_role' => $this->input->post('fortinet_role', true),
            'other_role' => $this->input->post('other_role', true),
            'microsoft_365' => count($this->input->post('microsoft_365', true)) > 0 ? implode(',',$this->input->post('microsoft_365', true)) : '',
            'justification' => $this->input->post('justification', true),
            'machine' => count($this->input->post('machine', true)) > 0 ? implode(',',$this->input->post('machine', true)) : '',
            'machine_comment' => $this->input->post('machine_comment', true),
            'accessories' => count($this->input->post('accessories', true)) > 0 ? implode(',',$this->input->post('accessories', true)) : '',
            'accessories_comment' => $this->input->post('accessories_comment', true),
            'wireless_mouse' => $this->input->post('wireless_mouse', true),
            'wireless_mouse_comment' => $this->input->post('wireless_mouse_comment', true),
            'other' => $this->input->post('other', true),
            'requestor' => $this->input->post('requestor', true),
            'signature_req' => $this->input->post('signature_req', true),
            'date_req' => $this->input->post('date_req', true),
            'bbo_hod' => $this->input->post('bbo_hod', true),
            'signature_hod' => $this->input->post('signature_hod', true),
            'date_hod' => $this->input->post('date_hod', true),
            'it_manager' => $this->input->post('it_manager', true),
            'signature_it' => $this->input->post('signature_it', true),
            'date_it' => $this->input->post('date_it', true)
        );

        // echo '<pre>'; print_r($data); exit;
        $res = $this->complaints->add_complaints($data);        
        if($res){
            $this->session->set_flashdata('messagePr', 'Application submitted successfully.');
            redirect(base_url() . 'complaints/index', 'refresh'); 
        } else {
            $this->session->set_flashdata('messagePr', 'There has been an error, please try again.');
            redirect(base_url() . 'complaints/add', 'refresh'); 
        }
    }

    public function printTicket($tid)
    { 
        $data['ticket'] = $this->complaints->complaints_details($tid);        
        // echo '<pre>'; print_r($data['ticket']);exit;
        ini_set('memory_limit', '64M');
        $html = $this->load->view('print_files/print_ticket', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load_split(array('margin_top' => 5));
        $pdf->WriteHTML($html);
        //echo $html; exit;
        if ($this->input->get('d')) {
            $pdf->Output('Ticket #' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Ticket #' . $tid . '.pdf', 'I');
        }
    }

    public function invoices()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Invoices';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices_list()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->invoice_datatables($eid);
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            switch ($invoices->status) {
                case "paid" :
                    $out = '<span class="label label-success">Paid</span> ';
                    break;
                case "due" :
                    $out = '<span class="label label-danger">Due</span> ';
                    break;
                case "canceled" :
                    $out = '<span class="label label-warning">Canceled</span> ';
                    break;
                case "partial" :
                    $out = '<span class="label label-primary">Partial</span> ';
                    break;
                default :
                    $out = '<span class="label label-info">Pending</span> ';
                    break;
            }
            $row[] = $out;
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->invoicecount_all($eid),
            "recordsFiltered" => $this->employee->invoicecount_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function transactions()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function translist()
    {
        $eid = $this->input->post('eid');
        $list = $this->employee->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = $prd->account;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);

            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function disable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {

            $this->db->select('banned');
            $this->db->from('geopos_users');
            $this->db->where('id', $uid);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($result['banned'] == 0) {
                $this->aauth->ban_user($uid);
            } else {
                $this->aauth->unban_user($uid);
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile updated successfully!'));


        }
    }

    function enable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {


            $a = $this->aauth->unban_user($uid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile disabled successfully!'));


        }
    }

    function delete_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('empid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not delete yourself!'));
        } else {

            $this->db->delete('geopos_employees', array('id' => $uid));

            $this->db->delete('geopos_users', array('id' => $uid));

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile deleted successfully! Please refresh the page!'));


        }
    }


    public function calc_income()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->money_details($eid)) {
            $details = $this->employee->money_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                '<br> Total Income: ' . amountExchange($details['credit'], 0, $this->aauth->get_user()->loc) . '<br> Total Expenses: ' . amountExchange($details['debit'], 0, $this->aauth->get_user()->loc)));

        }


    }

    public function calc_sales()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->sales_details($eid)) {
            $details = $this->employee->sales_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'Total Sales (Paid Payment):  ' . amountExchange($details['total'], 0, $this->aauth->get_user()->loc)));

        }


    }

    public function update()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');
        if ($this->input->post()) {
            $eid = $this->input->post('eid', true);
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $phonealt = $this->input->post('phonealt', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $location = $this->input->post('location', true);
            $salary = numberClean($this->input->post('salary', true));
            $department = $this->input->post('department', true);
            $commission = $this->input->post('commission', true);
            $roleid = $this->input->post('roleid', true);
            $this->employee->update_employee($eid, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $location, $salary, $department, $commission, $roleid);

        } else {
            $head['usernm'] = $this->aauth->get_user($id)->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['dept'] = $this->employee->department_list($id, $this->aauth->get_user()->loc);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edit', $data);
            $this->load->view('fixed/footer');
        }


    }


    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editpicture($id, $img);
        }


    }


    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }


    }


    public function updatepassword()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("form_validation");

        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');


        if ($this->input->post()) {
            $eid = $this->input->post('eid');
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {

                $newpassword = $this->input->post('newpassword');
                echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));
                $this->aauth->update_user($eid, false, $newpassword, false);
            }


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';
            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/password', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function permissions()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Permissions';
        $data['permission'] = $this->employee->employee_permissions();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/permissions', $data);
        $this->load->view('fixed/footer');


    }

    public function permissions_update()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Permissions';
        $permission = $this->employee->employee_permissions();

        foreach ($permission as $row) {
            $i = $row['id'];
            $name1 = 'r_' . $i . '_1';
            $name2 = 'r_' . $i . '_2';
            $name3 = 'r_' . $i . '_3';
            $name4 = 'r_' . $i . '_4';
            $name5 = 'r_' . $i . '_5';
            $name6 = 'r_' . $i . '_6';
            $name7 = 'r_' . $i . '_7';
            $name8 = 'r_' . $i . '_8';
            $val1 = 0;
            $val2 = 0;
            $val3 = 0;
            $val4 = 0;
            $val5 = 0;
            $val6 = 0;
            $val7 = 0;
            $val8 = 0;
            if ($this->input->post($name1)) $val1 = 1;
            if ($this->input->post($name2)) $val2 = 1;
            if ($this->input->post($name3)) $val3 = 1;
            if ($this->input->post($name4)) $val4 = 1;
            if ($this->input->post($name5)) $val5 = 1;
            if ($this->input->post($name6)) $val6 = 1;
            if ($this->input->post($name7)) $val7 = 1;
            if ($this->aauth->get_user()->roleid == 5 && $i == 9) $val5 = 1;
            $data = array('r_1' => $val1, 'r_2' => $val2, 'r_3' => $val3, 'r_4' => $val4, 'r_5' => $val5, 'r_6' => $val6, 'r_7' => $val7);
            $this->db->set($data);
            $this->db->where('id', $i);
            $this->db->update('geopos_premissions');
        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }


    public function holidays()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Holidays';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/holidays');
        $this->load->view('fixed/footer');

    }


    public function hday_list()
    {
        $list = $this->employee->holidays_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $obj) {
            $datetime1 = date_create($obj->val1);
            $datetime2 = date_create($obj->val2);
            $interval = date_diff($datetime1, $datetime2);
            $day = $interval->format('%a days');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->val1;
            $row[] = $obj->val2;
            $row[] = $day;
            $row[] = $obj->val3;
            $row[] = "<a href='" . base_url("employee/editholiday?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->holidays_count_all(),
            "recordsFiltered" => $this->employee->holidays_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_hday()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteholidays($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function addhday()
    {

        if ($this->input->post()) {

            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note', true);

            $date1 = new DateTime($from);
            $date2 = new DateTime($todate);
            if ($date1 <= $date2) {


                if ($this->employee->addholidays($this->aauth->get_user()->loc, $from, $todate, $note)) {
                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "   <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR') . '- Invalid'));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/addholyday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function editholiday()
    {

        if ($this->input->post()) {


            $id = $this->input->post('did');
            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note', true);

            if ($this->employee->edithday($id, $this->aauth->get_user()->loc, $from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['hday'] = $this->employee->hday_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edithday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function departments()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department_list'] = $this->employee->department_list($this->aauth->get_user()->loc);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/departments', $data);
        $this->load->view('fixed/footer');

    }

    public function department()
    {

        $data['id'] = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
        $data['department_list'] = $this->employee->department_elist($data['id']);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/department', $data);
        $this->load->view('fixed/footer');

    }

    public function delete_dep()
    {

        $id = $this->input->post('deleteid');


        if ($this->employee->deletedepartment($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function adddep()
    {

        if ($this->input->post()) {

            $name = $this->input->post('name', true);


            if ($this->employee->adddepartment($this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/adddep');
            $this->load->view('fixed/footer');
        }

    }

    public function editdep()
    {

        if ($this->input->post()) {

            $name = $this->input->post('name', true);
            $id = $this->input->post('did');

            if ($this->employee->editdepartment($id, $this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/editdep', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function payroll_create()
    {
        $this->load->library("Custom");
        $data['dual'] = $this->custom->api_config(65);
        $this->load->model('transactions_model', 'transactions');
        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_create', $data);
        $this->load->view('fixed/footer');

    }

    public function emp_search()
    {

        $name = $this->input->get('keyword', true);


        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (geopos_users.loc=' . $this->aauth->get_user()->loc . ') AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_employees.* ,geopos_users.email FROM geopos_employees  LEFT JOIN geopos_users ON geopos_users.id=geopos_employees.id  WHERE $whr (UPPER(geopos_employees.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_employees.phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectPay('" . $row['id'] . "','" . $row['name'] . " ','" . amountFormat_general($row['salary']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function payroll()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll');
        $this->load->view('fixed/footer');
    }

    public function payroll_emp()
    {

        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_employee', $data);
        $this->load->view('fixed/footer');
    }


    public function payrolllist()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->pay_get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;

            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;
            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span> View</a> <a  href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a> ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->pay_count_all($eid),
            "recordsFiltered" => $this->employee->pay_count_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function attendances()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Attendance';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/attendance_list');
        $this->load->view('fixed/footer');

    }

    public function attendance()
    {
        if ($this->input->post()) {
            $emp = $this->input->post('employee');
            $adate = datefordatabase($this->input->post('adate'));
            $from = timefordatabase($this->input->post('from'));
            $todate = timefordatabase($this->input->post('to'));
            $note = $this->input->post('note');

            if ($this->employee->addattendance($emp, $adate, $from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='attendance' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='attendances' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/attendance', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function auto_attendance()
    {
        if ($this->input->post()) {
            $auto_attand = $this->input->post('attend');

            if ($this->employee->autoattend($auto_attand)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $this->load->model('plugins_model', 'plugins');

            $data['auto'] = $this->plugins->universal_api(62);


            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/autoattend', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function att_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->employee->attendance_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = dateformat($obj->adate) . ' &nbsp; ' . $obj->tfrom . ' - ' . $obj->tto;
            $row[] = round((strtotime($obj->tto) - strtotime($obj->tfrom)) / 3600, 2);
            $row[] = round($obj->actual_hours / 3600, 2);
            $row[] = $obj->note;

            $row[] = '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->attendance_count_all($cid),
            "recordsFiltered" => $this->employee->attendance_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_attendance()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteattendance($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


}