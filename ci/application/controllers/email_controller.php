<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_controller extends MY_logincontroller {

    function emailview() {
	$data['main_content'] = 'emailsystem/findstudent';
	$this->load->view('includes/no_js/template', $data);
    }

    function directemail() {
	$data['main_content'] = 'emailsystem/directemail';
	$this->load->view('includes/no_js/template', $data);
    }

    function email_rix() {
	$data['main_content'] = 'emailsystem/emailadmin';
	$this->load->view('includes/no_js/template', $data);
    }

    function send() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('your_email', 'Email', 'required|valid_email|max_length[40]');
	$this->form_validation->set_rules('your_fname', 'First Name', 'required|alpha|trim|max_length[40]');
	$this->form_validation->set_rules('your_lname', 'Last Name', 'required|alpha|trim|max_length[40]');
	$this->form_validation->set_rules('out_subject', 'Subject', 'required');
	$this->form_validation->set_rules('company', 'Company Name', 'required');
	$this->form_validation->set_rules('out_message', 'Email Message', 'required');

	if ($this->form_validation->run() == FALSE) {
	    $this->email_rix();
	} else {
	    $this->load->library('email');

	    $this->email->from('sunyorangetestemail@gmail.com');
	    $this->email->to('RixhersAjazi@gmail.com');
	    $this->email->reply_to($this->input->post('your_email'));
	    $this->email->subject($this->input->post('out_subject'));

	    $body = 'Hello Rixhers Ajazi,';
	    $body .= '<br><br>';
	    $body .= 'My name is ' . $this->input->post('your_fname') . ' ' . $this->input->post('your_lname') . '. ';
	    $body .= 'I represent ' . $this->input->post('company') . '';
	    $body .= '<br><br>';
	    $body .= 'My message to you is : ';
	    $body .= '<br><br>';
	    $body .= $this->input->post('out_message');

	    $this->email->message($body);

	    if ($this->email->send()) {
		redirect($this->input->post('redirect'));
	    }
	}
    }

    function sendemail() {
	$this->load->library('form_validation');

	$anum = $this->input->post('anum');
	$first = $this->input->post('fname');
	$last = $this->input->post('lname');

	if ((empty($anum)) || (empty($first)) || (empty($last))) {
	    $this->session->set_flashdata('emailview', 'You Must Use A Number, First Name And Last Name To Find Student');
	    redirect('email_controller/emailview', 'location');
	} else {

	    $this->form_validation->set_rules('anum', 'A Number', 'required|alpha_numeric|exact_length[9]');
	    $this->form_validation->set_rules('fname', 'First Name', 'required|alpha|max_length[20]');
	    $this->form_validation->set_rules('lname', 'Last Name', 'required|alpha|max_length[20]');
	    $this->form_validation->set_rules('subject', 'Subject', 'max_length[30]|min_length[5]|required');
	    $this->form_validation->set_rules('message', 'Message', 'max_length[100]|min_length[5]');

	    if ($this->form_validation->run() == FALSE) {
		$this->emailview();
	    } else {
		$this->load->model('email_model');

		if ($this->email_model->checkstudent($anum, $first, $last)) {

		    if (($_FILES['files']['error'][0] != 4) && ($_FILES['files']['name'][0] != "")) {

			$this->load->library('upload');

			$this->upload->initialize(array(
			    "upload_path" => "/usr/local/var/www/Test/ci/uploads/",
			    "overwrite" => TRUE,
			    "encrypt_name" => TRUE,
			    "remove_spaces" => TRUE,
			    "allowed_types" => "txt|pdf",
			    "max_size" => 300,
			    "xss_clean" => FALSE
			));

			if ($this->upload->do_multi_upload("files")) {
			    $return = $this->upload->get_multi_upload_data();

			    $this->load->library('email');
			    $this->load->library('encrypt');

			    $anum = $this->input->post('anum');
			    $first = $this->input->post('fname');
			    $last = $this->input->post('lname');

			    $email = $this->email_model->emails($anum, $first, $last);
			    $subject = $this->input->post('subject');
			    $body = $this->input->post('message');

			    $this->email->from('sunyorangetestemail@gmail.com');
			    $this->email->to($email);
			    $this->email->subject($subject);
			    $this->email->message($body);

			    foreach ($return as $file) {
				$this->email->attach($file['full_path']);
			    }


			    if (!$this->email->send()) {

				if ($this->email_model->checkemail($anum, $first, $last)) {
				    $data['main_content'] = 'emailsystem/findstudent';
				    $data['error'] = '<p class="error">Student Exists, But No Email On Record For ' . $first . ' ' . $last . ' with A Number : ' . $anum . '<br>Please use Direct Email Tab</p>';
				    $this->load->view('includes/no_js/template', $data);
				} else {
				    $data['main_content'] = 'emailsystem/findstudent';
				    $data['error'] = '<p class="error">Please Contact System Administator!</p>';
				    $this->load->view('includes/no_js/template', $data);
				}
			    } else {
				$this->session->set_flashdata('emailview', 'Email Sent To ' . $email . '. With A Number ' . $anum . '');
				redirect('email_controller/emailview', 'location');
			    }
			} else {
			    $data['main_content'] = 'emailsystem/findstudent';
			    $data['error'] = $this->upload->display_errors('<p class="error">', '</p>');
			    $this->load->view('includes/no_js/template', $data);
			}
		    } else {
			$this->load->library('email');
			$this->load->library('encrypt');

			$anum = $this->input->post('anum');
			$first = $this->input->post('fname');
			$last = $this->input->post('lname');

			$email = $this->email_model->emails($anum, $first, $last);
			$subject = $this->input->post('subject');
			$body = $this->input->post('message');

			$this->email->from('sunyorangetestemail@gmail.com');
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($body);

			if (!$this->email->send()) {

			    if ($this->email_model->checkemail($anum, $first, $last)) {
				$data['main_content'] = 'emailsystem/findstudent';
				$data['error'] = '<p class="error">Student Exists, But No Email On Record For ' . $first . ' ' . $last . ' with A Number : ' . $anum . '<br>Please use Direct Email Tab</p>';
				$this->load->view('includes/no_js/template', $data);
			    } else {
				$data['main_content'] = 'emailsystem/findstudent';
				$data['error'] = '<p class="error">Please Contact System Administator!</p>';
				$this->load->view('includes/no_js/template', $data);
			    }
			} else {
			    $this->session->set_flashdata('emailview', 'Email Sent To ' . $email . '. With A Number ' . $anum . '');
			    redirect('email_controller/emailview', 'location');
			}
		    }
		} else {

		    if ((!$this->email_model->checkanum($anum)) && (!$this->email_model->checkfirst($first)) && (!$this->email_model->checklast($last))) {
			$data['main_content'] = 'emailsystem/findstudent';
			$data['error'] = '<p class="error">Student Does Not Exist!</p>';
			$this->load->view('includes/no_js/template', $data);
		    } else {
			$anum = $this->input->post('anum');
			$first = $this->input->post('fname');
			$last = $this->input->post('lname');

			if (!$this->email_model->checkanum($anum)) {
			    $error = '<p class="error">Incorrect A Number</p>';
			}

			if (!$this->email_model->checkfirst($first)) {
			    $error .= '<p class="error">Incorrect First Name</p>';
			}

			if (!$this->email_model->checklast($last)) {
			    $error .= '<p class="error">Incorrect Last Name</p>';
			}

			$data['main_content'] = 'emailsystem/findstudent';
			$data['error'] = $error;
			$this->load->view('includes/no_js/template', $data);
		    }
		}
	    }
	}
    }

    function outside_email() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('out_email', 'Email', 'valid_email|required|max_length[50]');
	$this->form_validation->set_rules('out_subject', 'Subject', 'max_length[50]|min_length[5]|required');
	$this->form_validation->set_rules('out_message', 'Message', 'max_length[100]|min_length[5]');

	if ($this->form_validation->run() == FALSE) {
	    $this->directemail();
	} else {
	    if (($_FILES['files']['error'][0] != 4) && ($_FILES['files']['name'][0] != "")) {

		$this->load->library('upload');

		$this->upload->initialize(array(
		    "upload_path" => "/usr/local/var/www/Test/ci/uploads/",
		    "overwrite" => TRUE,
		    "encrypt_name" => TRUE,
		    "remove_spaces" => TRUE,
		    "allowed_types" => "txt|pdf",
		    "max_size" => 300,
		    "xss_clean" => FALSE
		));

		if ($this->upload->do_multi_upload("files")) {
		    $return = $this->upload->get_multi_upload_data();
		    $this->load->library('email');

		    $email = $this->input->post('out_email');
		    $subject = $this->input->post('out_subject');
		    $body = $this->input->post('out_message');

		    $this->email->from('sunyorangetestemail@gmail.com');
		    $this->email->to($email);
		    $this->email->subject($subject);
		    $this->email->message($body);

		    foreach ($return as $file) {
			$this->email->attach($file['full_path']);
		    }

		    if (!$this->email->send()) {
			$data['error'] = '<p class="error">Email Could Not Be Sent. Please Try Again</p>';
			$data['main_content'] = 'emailsystem/directemail';
			$this->load->view('includes/no_js/template', $data);
		    } else {
			$this->session->set_flashdata('emailview', 'Email Sent To ' . $email . '');
			redirect('email_controller/directemail', 'location');
		    }
		} else {
		    $data['error'] = $this->upload->display_errors('<p class="error">', '</p>');
		    $data['main_content'] = 'emailsystem/directemail';
		    $this->load->view('includes/no_js/template', $data);
		}
	    } else {
		$this->load->library('email');

		$email = $this->input->post('out_email');
		$subject = $this->input->post('out_subject');
		$body = $this->input->post('out_message');

		$this->email->from('sunyorangetestemail@gmail.com');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($body);


		if (!$this->email->send()) {
		    $data['error'] = '<p class="error">Email Could Not Be Sent. Please Try Again</p>';
		    $data['main_content'] = 'emailsystem/directemail';
		    $this->load->view('includes/no_js/template', $data);
		} else {
		    $this->session->set_flashdata('emailview', 'Email Sent To ' . $email . '');
		    redirect('email_controller/directemail', 'location');
		}
	    }
	}
    }

}