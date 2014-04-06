<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_controller extends CI_Controller {

    function index() {
	$data['main_content'] = 'index/login_view';
	$this->load->view('includes/no_js/template', $data);
	$this -> session -> sess_destroy();
    }

    function validate_credentials() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[4]|max_length[15]');
	$this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|alpha_dash|max_length[20]');

	if ($this->form_validation->run() == FALSE) {
	    $this->index();
	} else {
	    $this->load->library('encrypt');
	    $this->load->library('bcrypt');
	    $this->load->model('login_model');

	    $username = $this->input->post('username');
	    $pass = $this->input->post('password');

	    if ($this->login_model->checkPW($username, $pass)) {
		redirect('login_controller/PWPage', 'location');
	    } else {
		if ($this->login_model->validate_login($username, $pass)) {
		    if ($this->login_model->activated($username)) {
			$session_array = array('username' => $this->input->post('username'), 'loggedin' => TRUE);
			$this->session->set_userdata($session_array);
			redirect('staff_controller/index');
		    } else {
			$this->session->sess_destroy();
			$this->load->view('messages/accessdenied_view');
			$this->output->_display();
			die();
		    }
		} else {
		    $this->session->set_flashdata('login', 'Wrong Username or Password');
		    redirect('login_controller/index', 'location');
		}
	    }
	}
    }

    function PWPage() {
	$data['main_content'] = 'index/PWpage';
	$this->load->view('includes/no_js/template', $data);
    }

    function changePW() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[4]|max_length[15]');
	$this->form_validation->set_rules('currentpass', 'Current Password', 'required');
	$this->form_validation->set_rules('password', 'New Password', 'required|min_length[7]|alpha_dash|max_length[20]');
	$this->form_validation->set_rules('passconf', 'Confirmation Password', 'required|min_length[7]|max_length[20]|matches[password]|alpha_dash');
	$this->form_validation->set_rules('code', 'Secret Code', 'required');

	if ($this->form_validation->run() == FALSE) {
	    $this->PWPage();
	} else {
	    $this->load->library('bcrypt');
	    $this->load->model('login_model');

	    $username = $this->input->post('username');
	    $code = $this->input->post('code');
	    $password = $this->input->post('password');
	    $pass = $this->input->post('currentpass');

	    if ($this->login_model->checkcode($username, $code)) {
		if ($this->login_model->checkPW($username, $pass)) {
		    if (($this->login_model->changePW($username, $password)) && ($this->login_model->removecode($username))) {
			$this->session->set_flashdata('login', 'Password Successfully Updated!');
			redirect('login_controller/index', 'location');
		    } else {
			$this->error_email();
			$this->session->set_flashdata('PWchange', 'Password Could Not Be Updated');
			redirect('login_controller/PWpage', 'location');
		    }
		} else {
		    $this->error_email();
		    $this->session->set_flashdata('PWchange', 'Current Password Does Not Match');
		    redirect('login_controller/PWpage', 'location');
		}
	    } else {
		$this->error_email();
		$this->session->set_flashdata('PWchange', 'Code Does Not Match');
		redirect('login_controller/PWpage', 'location');
	    }
	}
    }

    function error_email() {
	    $this->load->model('login_model');
	    $this->load->library('email');
	    $this->load->library('encrypt');

	    $username = $this->input->post('username');
	    $emails = $this->login_model->admin_email();

	    $this->email->from('sunyorangetestemail@gmail.com');
	    $this->email->to($emails);
	    $this->email->subject(''. $username . ' Invalid Passwod Update');
	    $this->email->message('This is a automated email aleart to notify administrators that account with User Name ' . $username . ' has had a failed password update change. Please be cautious in activation of this account.');

	    $this->email->send();
    }

    function request_account() {
	$data['main_content'] = 'index/request_account_view';
	$this->load->view('includes/no_js/template', $data);
    }

    function email_request() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('fname', 'First Name', 'required|alpha|max_length[20]');
	$this->form_validation->set_rules('lname', 'Last Name', 'required|alpha|max_length[20]');
	$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');

	if ($this->form_validation->run() == FALSE) {
	    $this->request_account();
	} else {
	    $this->load->model('login_model');
	    $this->load->library('email');
	    $this->load->library('encrypt');

	    foreach ($this->login_model->admin_email() as $emails) {
		$admin_emails[] = $emails;
	    }

	    $first = $this->input->post('fname');
	    $last = $this->input->post('lname');
	    $email = $this->input->post('email');

	    $this->email->from($email);
	    $this->email->to($admin_emails);
	    $this->email->reply_to($email);
	    $this->email->subject('' . $first . ' ' . $last . ' Account Request');
	    $this->email->message('{unwrap}Hello this is ' . $first . ' ' . $last . ', I am requesting to be added to the staff log-in.{/unwrap}');

	    if (!$this->email->send()) {
		$this->session->set_flashdata('email', 'Email Was Not Sent!');
		$this->request_account();
	    } else {
		$this->session->set_flashdata('login', 'Request Sent!');
		redirect('login_controller/index', 'location');
	    }
	}
    }

    function logout() {
	$this->session->unset_userdata('loggedin');
	$this->session->unset_userdata('username');
	$this->session->unset_userdata('admin');
	$this->session->sess_destroy();
	$this->output->_display();
	redirect('login_controller/index', 'refresh');
	die();
    }

}
