<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studenthistory_controller extends MY_logincontroller {

    function index() {
	$this->session->unset_userdata('anum');
	$data['main_content'] = 'history/main';
	$this->load->view('includes/no_js/template', $data);
    }

    function findstudent() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('anum', 'A Number', 'alpha_numeric|exact_length[9]');
	$this->form_validation->set_rules('fname', 'First Name', 'alpha|max_length[20]');
	$this->form_validation->set_rules('lname', 'Last Name', 'alpha|max_length[20]');

	if (($this->input->post('fname')) || ($this->input->post('lname'))) {
	    $this->form_validation->set_rules('choosetable', '', '');
	} else {
	    $this->form_validation->set_rules('choosetable', 'Filter', 'required');
	}

	if ($this->form_validation->run() == FALSE) {
	    $this->index();
	} else {
	    $anum = $this->input->post('anum');

	    if (($anum)) {
		if ($this->input->post('choosetable') == 'all') {
		    redirect('studenthistory_controller/history/' . $anum . '', 'location');
		}

		if ($this->input->post('choosetable') == 'fin') {
		    redirect('studenthistory_controller/fin_history/' . $anum . '', 'location');
		}

		if ($this->input->post('choosetable') == 'left') {
		    redirect('studenthistory_controller/left_history/' . $anum . '', 'location');
		}
		if ($this->input->post('choosetable') == 'term') {
		    redirect('studenthistory_controller/term_history/' . $anum . '', 'location');
		}

		if ($this->input->post('choosetable') == 'aba') {
		    redirect('studenthistory_controller/aba_history/' . $anum . '', 'location');
		}
		if ($this->input->post('choosetable') == 'form') {
		    redirect('studenthistory_controller/forms_history/' . $anum . '', 'location');
		}
	    } else {
		$first = $this->input->post('fname');
		$last = $this->input->post('lname');

		$location = 'studenthistory_controller/studentlists';

		if ($first) {
		    $location .= '/' . $first . '';
		} else {
		    $location .= '/void';
		}

		if ($last) {
		    $location .= '/' . $last . '';
		} else {
		    $location .= '/void';
		}

		redirect($location, 'location');
	    }
	}
    }

    function studentlists() {
	$first = $this->uri->segment('3');
	$last = $this->uri->segment('4');

	if ($first !== 'void') {
	    $params['first'] = $first;
	    $data['first'] = $first;

	    if ($last !== 'void') {
		$data['last'] = ' and ' . $last . '';
		$params['last'] = $last;
	    }
	} else {
	    if ($last !== 'void') {
		$params['last'] = $last;
		$data['last'] = $last;
	    }
	}

	$this->load->model('studenthistory_model');
	$this->load->library('encrypt');
	$data['history'] = $this->studenthistory_model->findstudent($params);
	$this->load->view('history/findstudent', $data);
    }

    function history() {
	$anum = $this->uri->segment(3);

	$this->load->model('studenthistory_model');
	$data['history'] = $this->studenthistory_model->history($anum);
	$this->load->view('history/historicqueue', $data);
    }

    function fin_history() {
	$anum = $this->uri->segment(3);

	$this->load->model('studenthistory_model');
	$data['history'] = $this->studenthistory_model->fin_history($anum);
	$this->load->view('history/finishedhistory', $data);
    }

    function left_history() {
	$anum = $this->uri->segment(3);

	$this->load->model('studenthistory_model');
	$data['history'] = $this->studenthistory_model->left_history($anum);
	$this->load->view('history/lefthistory', $data);
    }

    function term_history() {
	$anum = $this->uri->segment(3);

	$this->load->model('studenthistory_model');
	$data['history'] = $this->studenthistory_model->term_history($anum);
	$this->load->view('history/termhistory', $data);
    }

    function aba_history() {
	$anum = $this->uri->segment(3);

	$this->load->model('studenthistory_model');
	$data['history'] = $this->studenthistory_model->aba_history($anum);
	$this->load->view('history/abahistory', $data);
    }

    function forms_history() {
	$anum = $this->uri->segment(3);

	$this->load->model('studenthistory_model');
	$data['history'] = $this->studenthistory_model->forms_history($anum);
	$this->load->view('history/forms', $data);
    }

}