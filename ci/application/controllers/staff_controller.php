<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staff_controller extends MY_logincontroller {

    function index() {
	$this->load->model('staff_model');
	$this->load->model('login_model');

	$username = $this->session->userdata('username');
	$this->session->unset_userdata('anum');

	if ($this->login_model->activated($username)) {
	    if ($this->staff_model->norole($username)) {
		$this->denied();
	    }
	    if ($this->staff_model->studentrole($username)) {
		$data['main_content'] = 'homepage/student_homepage_view';
		$this->load->view('includes/no_js/template', $data);
	    }
	    if ($this->staff_model->staffmember($username)) {
		$data['main_content'] = 'homepage/staff_homepage_view';
		$this->load->view('includes/no_js/template', $data);
	    }
	    if ($this->staff_model->is_admin($username)) {
		$data['main_content'] = 'homepage/admin_view';
		$this->load->view('includes/no_js/template', $data);
	    }
	    if ($this->staff_model->is_p($username)) {
		$data['main_content'] = 'homepage/p_homepage';
		$this->load->view('includes/no_js/template', $data);
	    }
	} else {
	    $this->denied();
	}
    }

    function admin_login() {
	$data['main_content'] = 'admin/admin_login';
	$this->load->view('includes/no_js/template', $data);
    }

    function valid_admin() {
	$this->load->library('form_validation');
	$this->load->library('bcrypt');

	$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[4]|max_length[15]');
	$this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|alpha_dash|max_length[20]');

	if ($this->form_validation->run() == FALSE) {
	    $this->admin_login();
	} else {
	    $this->load->library('bcrypt');
	    $this->load->model('admin_model');

	    $username = $this->input->post('username');
	    $password = $this->input->post('password');

	    if ($this->admin_model->valid_admin($username, $password)) {
		$session_admin = array('admin' => TRUE);
		$this->session->set_userdata($session_admin);
		redirect('admin_controller/index');
	    } else {
		$this->denied();
	    }
	}
    }

    function reports() {
	$data['main_content'] = 'reports/reports_view';
	$this->load->view('includes/no_js/template', $data);
    }

    function graphs() {
	$this->load->view('graphs/graphs');
    }

    function denied() {
	$this->session->unset_userdata('loggedin');
	$this->session->unset_userdata('username');
	$this->session->unset_userdata('admin');
	$this->session->sess_destroy();
	$this->load->view('messages/accessdenied_view');
	$this->output->_display();
	die();
    }

    function adminlogout() {
	$this->session->unset_userdata('admin');
	$this->output->_display();
	redirect('staff_controller/index', 'refresh');
	die();
    }

}
