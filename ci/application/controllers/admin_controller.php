<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_controller extends MY_admincontroller {
	

    function index() {
	$data['main_content'] = 'admin/admin_panel';
	$this->load->view('includes/no_js/template', $data);
    }

    function create_view() {
	$data['main_content'] = 'admin/create_account_view';
	$this->load->view('includes/no_js/template', $data);
    }

    function activate() {
	$this->load->model('admin_model');

	$data['users'] = $this->admin_model->activatetable();
	$data['main_content'] = 'admin/activate';
	$this->load->view('includes/js/js_template', $data);
    }

    function updatestudent() {
	$data['main_content'] = 'admin/updatestudent';
	$this->load->view('includes/no_js/template', $data);
    }

    function activated() {
	$this->load->model('admin_model');
	$this->load->library('form_validation');

	$this->form_validation->set_rules('options', 'Options', 'required');

	if ($this->form_validation->run() == FALSE) {
	    $this->activate();
	} else {
	    if ($this->input->post('options') == 'activate') {
		$status = 'Activated';
		$username = $this->uri->segment(3);
		$first = $this->uri->segment(4);

		if ($this->admin_model->activate($status, $username, $first)) {
		    redirect('admin_controller/activate', 'location');
		} else {
		    redirect('admin_controller/activate', 'location');
		}
	    }
	    if ($this->input->post('options') == 'deactivate') {
		$status = 'Deactivated';
		$username = $this->uri->segment(3);
		$first = $this->uri->segment(4);

		if ($this->admin_model->activate($status, $username, $first)) {
		    redirect('admin_controller/activate', 'location');
		} else {
		    redirect('admin_controller/activate', 'location');
		}
	    }
	    if ($this->input->post('options') == 'student') {
		$role = 1;
		$username = $this->uri->segment(3);
		$fname = $this->uri->segment(4);

		if ($this->admin_model->updaterole($role, $username, $fname)) {
		    redirect('admin_controller/activate', 'location');
		}
	    }
	    if ($this->input->post('options') == 'staff') {
		$role = 2;
		$username = $this->uri->segment(3);
		$fname = $this->uri->segment(4);

		if ($this->admin_model->updaterole($role, $username, $fname)) {
		    redirect('admin_controller/activate', 'location');
		} else {
		    redirect('admin_controller/activate', 'location');
		}
	    }
	    if ($this->input->post('options') == 'admin') {
		$role = 3;
		$username = $this->uri->segment(3);
		$fname = $this->uri->segment(4);

		if ($this->admin_model->updaterole($role, $username, $fname)) {
		    redirect('admin_controller/activate', 'location');
		} else {
		    redirect('admin_controller/activate', 'location');
		}
	    }
	    if ($this->input->post('options') == 'vp') {
		$role = 4;
		$username = $this->uri->segment(3);
		$fname = $this->uri->segment(4);

		if ($this->admin_model->updaterole($role, $username, $fname)) {
		    redirect('admin_controller/activate', 'location');
		} else {
		    redirect('admin_controller/activate', 'location');
		}
	    }
	    if ($this->input->post('options') == 'sv') {
		$role = 5;
		$username = $this->uri->segment(3);
		$fname = $this->uri->segment(4);

		if ($this->admin_model->updaterole($role, $username, $fname)) {
		    redirect('admin_controller/activate', 'location');
		} else {
		    redirect('admin_controller/activate', 'location');
		}
	    }




	}
    }

    function create() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('fname', 'First Name', 'required|alpha|max_length[20]');
	$this->form_validation->set_rules('lname', 'Last Name', 'required|alpha|max_length[20]');
	$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
	$this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]|required|alpha_numeric||min_length[4]|max_length[15]');

	if ($this->form_validation->run() == FALSE) {
	    $this->create_view();
	} else {
	    $this->load->library('encrypt');
	    $this->load->model('admin_model');
	    $this->load->library('bcrypt');

	    $hash = md5($this->input->post('username'));
	    $hash .= md5($this->input->post('email'));
	    $user = $this->input->post('username');
	    $email = $this->encrypt->encode($this->input->post('email'));
	    $fname = $this->input->post('fname');
	    $lname = $this->input->post('lname');
	    $password = $this->encrypt->encode('sunyorange');
	    $secretcode = $hash;

	    if ($this->admin_model->create_employee($user, $email, $fname, $lname, $password, $secretcode)) {
		$this->load->library('email');

		$first = $this->input->post('fname');
		$last = $this->input->post('lname');
		$email = $this->input->post('email');

		$this->email->from('sunyorangetestemail@gmail.com');
		$this->email->to($email);
		$this->email->subject($first . ' ' . $last . ' ' . 'Private Code');
		$this->email->message('This code must be used when updating your current password upon first login attempt. Your user name is ' . $user . ' and your temporary password will be provided by your Access Point Administrator. This is your code: ' . $hash . '');

		if (!$this->email->send()) {
		    $this->ceate_view();
		} else {
		    $this->load->library('email');
		    $this->load->model('login_model');
		    $this->load->library('encrypt');

		    $first = $this->input->post('fname');
		    $last = $this->input->post('lname');

		    foreach ($this->login_model->admin_email() as $emails) {
			$admin_emails[] = $emails;
		    }

		    $this->email->from('sunyorangetestemail@gmail.com');
		    $this->email->to($admin_emails);
		    $this->email->subject('Account created for ' . $first . ' ' . $last . ' ' . '');
		    $this->email->message('This is a email to notify Administrators that a account has been created for ' . $first . ' ' . $last . '. ' . 'If you have any questions please speak with the System Administrators in the Financial Aid Office.');


		    if (!$this->email->send()) {
			$this->create_view();
		    } else {
			$this->index();
		    }
		}
	    }
	}
    }

    function updatenow() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('anum', 'A Number', 'required|exact_length[9]');
	$this->form_validation->set_rules('fname', 'First Name', 'alpha|max_length[60]');
	$this->form_validation->set_rules('lname', 'Last Name', 'alpha|max_length[60]');
	$this->form_validation->set_rules('email', 'Email Address', 'valid_email');

	if ($this->form_validation->run() == FALSE) {
	    $this->updatestudent();
	} else {
	    $anum = $this->input->post('anum');
	    $first = $this->input->post('fname');
	    $last = $this->input->post('lname');
	    $email = $this->input->post('email');

	    $this->load->model('admin_model');

	    if ($this->admin_model->checkanum($anum)) {

		if ($first) {
		    if ($this->admin_model->updatefirst($anum, $first)) {
			$success = "<p class='error'>First Name Successfuly Updated!</p>";
		    }
		}
		if ($last) {
		    if ($this->admin_model->updatelast($anum, $last)) {
			$success .= "<p class='error'>Last Name Successfuly Updated!</p>";
		    }
		}
		if ($email) {

		    $safeemail = $this->encrypt->encode($email);

		    if ($this->admin_model->updateemail($anum, $safeemail)) {
			$success .= "<p class='error'>Email Successfuly Updated!</p>";
		    }
		}

		$data['main_content'] = 'admin/updatestudent';
		$data['success'] = $success;
		$this->load->view('includes/no_js/template', $data);
	    } else {
		$this->form_validation->set_rules('anum', 'A Number', 'required|exact_length[9]');
		$this->form_validation->set_rules('fname', 'First Name', 'required|alpha|max_length[60]');
		$this->form_validation->set_rules('lname', 'Last Name', 'required|alpha|max_length[60]');
		$this->form_validation->set_rules('email', 'Email Address', 'valid_email');

		if ($this->form_validation->run() == FALSE) {
		    $this->updatestudent();
		} else {

		    if ($email) {

			$safeemail = $this->encrypt->encode($email);
		    } else {
			$safeemail = NULL;
		    }
		    if ($this->admin_model->insertstudent($anum, $first, $last, $safeemail)) {
			$data['main_content'] = 'admin/updatestudent';
			$data['success'] = "<p class='error'>" . $first . " " . $last . " with A-Number " . $anum . " is now in our records!</p>";
			$this->load->view('includes/no_js/template', $data);
		    }
		}
	    }
	}
    }

}

