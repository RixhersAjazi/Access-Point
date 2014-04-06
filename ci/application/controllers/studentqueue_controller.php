<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentqueue_controller extends MY_logincontroller {

    function index() {
        $this -> load -> view('studentqueue/studentqueue');
    }

    function student() {
        $this -> load -> view('studentqueue/studentonlyqueue');
    }

    function ajaxcall() {
        $this -> load -> model('queue_model');

        $data['waiting'] = $this -> queue_model -> waiting();
        $data['beingseen'] = $this -> queue_model -> beingseen();

        $this -> output -> set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    function history() {
        $anum = $this -> uri -> segment(3);
        $this -> load -> model('queue_model');
        $data['history'] = $this -> queue_model -> history($anum);
        $data['main_content'] = 'studentqueue/historicqueue';
        $this -> load -> view('includes/js/js_template', $data);
    }

    function start() {
        $this -> load -> model('queue_model');

        $session = $this -> uri -> segment(3);
        $counselor = $this -> session -> userdata('username');
        $status = 1;

        if (($this -> queue_model -> support($session, $counselor)) && ($this -> queue_model -> updatesession($status, $session))) {
            $data['first10'] = $this -> queue_model -> first10();
            $data['elevennine'] = $this -> queue_model -> elev9();
            $data['twenty5'] = $this -> queue_model -> twenty_5();
            $data['twen87'] = $this -> queue_model -> twen8thir7();
            $data['checklists'] = $this -> queue_model -> checklists();
            $data['counsview'] = $this -> queue_model -> counselorview($session);
            $data['reasons'] = $this -> queue_model -> get_reasons();

            $this -> load -> view('studentqueue/counselorscreen', $data);
        } else {
            echo "You Cant Restart A Session That You Just Finished. Please Return To Student Queue!";
        }
    }

    function stop() {
        $this -> load -> library('form_validation');

        $this -> form_validation -> set_rules('reason', 'Reason', 'required');

        if ($this -> input -> post('reason') == 'Other') {
            $this -> form_validation -> set_rules('stopcomments', 'Comments', 'required');
        }
        if ($this -> form_validation -> run() == FALSE) {
            $data['main_content'] = 'studentqueue/stop';
            $this -> load -> view('includes/no_js/template', $data);
        } else {
            $this -> load -> model('queue_model');

            $status = 4;
            $session = $this -> uri -> segment(3);
            $comments = $this -> input -> post('stopcomments');
            $user = $this -> session -> userdata('username');
            $reason = $this -> input -> post('reason');

            if ($this -> input -> post('submit')) {
                if (($this -> queue_model -> updatesession($status, $session)) && ($this -> queue_model -> stop($session, $reason, $comments, $user))) {
                    redirect('studentqueue_controller/index', 'location');
                }
            }
        }
    }

    function abandon() {
        $this -> load -> library('form_validation');

        $this -> form_validation -> set_rules('fname', 'First Name', 'required|alpha');
        $this -> form_validation -> set_rules('lname', 'Last Name', 'required|alpha');
        $this -> form_validation -> set_rules('abandoncomments', 'Comments', 'required');

        if ($this -> form_validation -> run() == FALSE) {
            $data['main_content'] = 'studentqueue/abandon';
            $this -> load -> view('includes/no_js/template', $data);
        } else {
            $this -> load -> model('queue_model');

            $status = 6;
            $session = $this -> uri -> segment(3);
            $first = $this -> input -> post('fname');
            $last = $this -> input -> post('lname');
            $comments = $this -> input -> post('abandoncomments');
            $user = $this -> session -> userdata('username');

            if ($this -> input -> post('submit')) {
                if (($this -> queue_model -> updatesession($status, $session)) && ($this -> queue_model -> abandon($session, $first, $last, $comments, $user))) {
                    redirect('studentqueue_controller/index', 'location');
                }
            }
        }
    }

    function terminate() {
        $this -> load -> model('queue_model');
        $this -> load -> library('form_validation');

        $this -> form_validation -> set_rules('fname', 'First Name', 'required|alpha');
        $this -> form_validation -> set_rules('lname', 'Last Name', 'required|alpha');
        $this -> form_validation -> set_rules('terminationcomments', 'Comments', 'required');

        if ($this -> form_validation -> run() == FALSE) {
            $data['main_content'] = 'studentqueue/sessionterminate';
            $this -> load -> view('includes/no_js/template', $data);
        } else {
            if ($this -> input -> post('submit')) {
                $status = 5;
                $session = $this -> uri -> segment(3);
                $first = $this -> input -> post('fname');
                $last = $this -> input -> post('lname');
                $terminate = $this -> input -> post('terminationcomments');
                $user = $this -> session -> userdata('username');

                if (($this -> queue_model -> updatesession($status, $session)) && ($this -> queue_model -> terminated($session, $first, $last, $terminate, $user))) {
                    redirect('studentqueue_controller/index', 'location');
                }
            }
        }
    }

    function cont() {
        $this -> load -> model('queue_model');

        $data['first10'] = $this -> queue_model -> first10();
        $data['elevennine'] = $this -> queue_model -> elev9();
        $data['twenty5'] = $this -> queue_model -> twenty_5();
        $data['twen87'] = $this -> queue_model -> twen8thir7();
        $data['checklists'] = $this -> queue_model -> checklists();
        $data['counsview'] = $this -> queue_model -> counselorview($this -> uri -> segment(3));
        $data['reasons'] = $this -> queue_model -> get_reasons();

        $this -> load -> view('studentqueue/counselorscreen', $data);
    }

    function input() {
        $this -> load -> library('form_validation');

        if ($this -> input -> post('hung') == 'yes') {
            $this -> form_validation -> set_rules('action', 'Action', '');
        } elseif ($this -> input -> post('no_info') == 'yes') {
            $this -> form_validation -> set_rules('action', '', '');
        } else {
            $this -> form_validation -> set_rules('action', 'Action', 'required');
        }

        $this -> form_validation -> set_rules('update', 'Update', '');
        $this -> form_validation -> set_rules('hung', 'hung', '');

        if ($this -> input -> post('action') == 'Additional') {
            $this -> form_validation -> set_rules('form', 'Forms', '');
            if ($this -> input -> post('addother')) {
                $this -> form_validation -> set_rules('emailcomments', 'Email Comments', 'required');
            } else {
                if (!$this -> input -> post('checklist')) {
                    $this -> form_validation -> set_rules('form', 'Forms', 'required');
                } else {
                    $this -> form_validation -> set_rules('checklist', 'CheckLists', 'required');
                }
            }
        }
        $this -> form_validation -> set_rules('no_info', '', '');

        if ($this -> input -> post('no_info') == 'yes') {
            $this -> form_validation -> set_rules('noinfo_comms', 'No Information Comments', 'required');
        }
        $this -> form_validation -> set_rules('addother', '', '');
        $this -> form_validation -> set_rules('office', '', '');

        if (($this -> input -> post('action') == 'Additional') && ($this -> input -> post('addother') == 'addotherinfo')) {
            $this -> form_validation -> set_rules('emailcomments', 'Email Comments', 'required');
        }

        if (($this -> input -> post('action') == 'Additional') && ($this -> input -> post('office') == 'notes')) {
            $this -> form_validation -> set_rules('officecomments', 'Office Comments', 'required');
        }

        if ($this -> input -> post('action') == 'Other') {
            $this -> form_validation -> set_rules('counselorcomments', 'Counselor Comments', 'required');
        }

        if (!$this -> input -> post('additional')) {

            if (($this -> input -> post('phone') == 'yes') && ($this -> input -> post('update') == 'yes')) {
                $this -> form_validation -> set_rules('anum', 'A Number', 'is_valid_student_id|exact_length[9]');
                $this -> form_validation -> set_rules('email', 'Email', 'max_length[40]|valid_email');
                $this -> form_validation -> set_rules('aidyear', 'Aid Year', 'required|exact_length[5]');
                $this -> form_validation -> set_rules('reasons', 'Reason', 'required|min_length[1]|max_length[2]');
                $this -> form_validation -> set_rules('fname', 'First Name', 'required|max_length[20]');
                $this -> form_validation -> set_rules('lname', 'Last Name', 'required|max_length[20]');
            }

            if (($this -> input -> post('update') == 'yes') && ($this -> input -> post('phone') !== 'yes')) {
                $this -> form_validation -> set_rules('anum', 'A Number', 'is_valid_student_id|exact_length[9]');
                $this -> form_validation -> set_rules('fname', 'First Name', 'max_length[20]');
                $this -> form_validation -> set_rules('lname', 'Last Name', 'max_length[20]');
                $this -> form_validation -> set_rules('email', 'Email', 'max_length[40]|valid_email');
                $this -> form_validation -> set_rules('aidyear', 'Aid Year', 'exact_length[5]');
                $this -> form_validation -> set_rules('reasons', 'Reason', 'min_length[1]|max_length[2]');
            }
        }
        if ($this -> form_validation -> run() == FALSE) {
            $this -> cont();
        } else {
            $this -> load -> model('queue_model');

            $session = $this -> uri -> segment(3);
            $counselor = $this -> session -> userdata('username');

            if ($this -> input -> post('update') == 'yes') {
                if ($this -> input -> post('anum')) {
                    $anum = $this -> input -> post('anum');
                } else {
                    $anum = "";
                }

                $curr_anum = $this -> uri -> segment(4);
                $first = $this -> input -> post('fname');
                $last = $this -> input -> post('lname');

                if ($this -> input -> post('email')) {
                    $email = $this -> encrypt -> encode($this -> input -> post('email'));
                }

                $aidyear = $this -> input -> post('aidyear');
                $why = $this -> input -> post('reasons');

                if ($anum !== "") {
                    if ($this -> queue_model -> check_anum($anum)) {
                        if ($this -> queue_model -> update_sess_anum($curr_anum, $anum)) {
                            $this -> queue_model -> deletestudent($curr_anum);
                        }
                    } else {
                        $this -> queue_model -> update_anum($curr_anum, $anum);
                    }
                }
                if ($first !== "") {
                    $this -> queue_model -> update_first($curr_anum, $anum, $first);
                }
                if ($last !== "") {
                    $this -> queue_model -> update_last($curr_anum, $anum, $last);
                }
                if (($email !== "") && ($email !== NULL)) {
                    $this -> queue_model -> update_email($curr_anum, $anum, $email);
                }
                if ($aidyear !== "") {
                    $this -> queue_model -> update_aidyear($session, $aidyear);
                }
                if ($why !== "") {
                    $this -> queue_model -> update_why($session, $why);
                }
            }

            if ($this -> input -> post('hung') == 'yes') {
                $this -> load -> model('queue_model');
                $status = 4;
                $session = $this -> uri -> segment(3);
                $comments = "Student was picked up and session started but call was disconnected";
                $user = $this -> session -> userdata('username');
                $reason = "Student Left";

                if ($this -> input -> post('finish')) {
                    if (($this -> queue_model -> updatesession($status, $session)) && ($this -> queue_model -> stop($session, $reason, $comments, $user))) {
                        redirect('studentqueue_controller/index', 'location');
                    }
                }
            }

            if ($this -> input -> post('additional')) {
                $additional_counseling = TRUE;
                $status = 2;
                if ($this -> input -> post('counselorcomments')) {
                    $comments = $this -> input -> post('counselorcomments');
                } else {
                    $comments = $this -> input -> post('action');
                }
                if (($this -> queue_model -> updatesession($status, $session)) && ($this -> queue_model -> finishtime($session, $counselor)) && ($this -> queue_model -> counselorcomments($comments, $session, $counselor))) {
                    redirect('studentqueue_controller/index', 'location');
                }
            }

            if ($this -> input -> post('form')) {
                foreach ($this->input->post('form') as $form_id) {
                    $this -> queue_model -> forms($session, $form_id);
                }
            }
            if ($this -> input -> post('action') == 'Additional') {
                $comments = $this -> input -> post('action');
                if ($this -> input -> post('addother') == 'addotherinfo') {
                    $comments .= '' . $this -> input -> post('action') . ' - ' . $this -> input -> post('emailcomments') . '';
                    if ($this -> input -> post('office') == 'notes') {
                        $comments .= ' - Office Notes : ' . $this -> input -> post('officecomments') . '';
                    }
                } else {
                    if ($this -> input -> post('office') == 'notes') {
                        $comments .= 'Office Notes : ' . $this -> input -> post('officecomments') . '';
                    }
                }
            }

            if ($this -> input -> post('action') == 'Other') {
                $comments = $this -> input -> post('counselorcomments');
            }

            if (($this -> input -> post('action') !== 'Other') && ($this -> input -> post('action') !== 'Additional')) {
                $comments = $this -> input -> post('action');
            }

            if ($this -> input -> post('no_info') == 'yes') {
                $comments = 'Student did not provide counselor with information. A message from the counselor : ' . $this -> input -> post('noinfo_comms') . '';
            }

            if ($this -> input -> post('finish')) {
                $status = 3;

                if (($this -> queue_model -> updatesession($status, $session)) && ($this -> queue_model -> finishtime($session, $counselor)) && ($this -> queue_model -> counselorcomments($comments, $session, $counselor))) {

                    $this -> load -> library('email');

                    if (($this -> input -> post('email')) && ($this -> input -> post('email') !== "") && ($this -> input -> post('email') !== NULL)) {
                        $sendemail = $this -> input -> post('email');
                    } else {
                        $sendemail = $this -> queue_model -> getemail($session, $counselor);
                    }

                    $today = date("F j, Y");

                    if (($this -> input -> post('action') !== 'Other') && ($this -> input -> post('action') !== 'Additional')) {

                        $subject = 'Recent activity with the Financial Aid on ' . $today . '';
                        $body = 'Thank you for contacting the Financial Aid Office at SUNY Orange,';
                        $body .= '<br>';
                        $body .= '<br>';

                        if ($this -> input -> post('action') == 'Complete Ready For Packaging') {
                            $body .= 'This is a automated message from the Financial Aid office to notify you that your file has been completed and your Financial Aid account is ready for review by an administrator.';
                            $body .= '<br>';
                            $body .= '<br>';
                        }

                        if ($this -> input -> post('action') == 'Deferment Given') {
                            $body .= 'This is a automated message from the Financial Aid office to notify you that you have been given a deferment.';
                            $body .= '<br>';
                            $body .= '<br>';
                        }

                        if ($this -> input -> post('action') == 'Packaged') {
                            $body .= 'This is a automated message from the Financial Aid office to notify you that a decision has been made on your Financial Aid, please view your Banner Self Service by clicking <a href="my.sunyorange.edu">on this link</a>.';
                            $body .= '<br>';
                            $body .= '<br>';
                        }

                        $body .= 'If this email was sent to an email other than your SUNY Orange email account please be advised that your SUNY Orange email is the official means of communication. All official correspondance will be sent to your SUNY Orange email account.';
                        $body .= '<br>';
                        $body .= '<br>';
                        $body .= 'If you are recieving this message in error please notify SUNY Orange Financial Aid personnel and delete this email.';

                        $this -> load -> library('email');
                        $this -> email -> from('sunyorangetestemail@gmail.com');
                        $this -> email -> to($sendemail);
                        $this -> email -> subject($subject);
                        $this -> email -> message($body);
                        $this -> email -> send();
                    }

                    if ($this -> input -> post('action') == 'Additional') {

                        $subject = 'SUNY Orange Financial Aid Info Request On ' . $today . '';
                        $body = 'Thank you for contacting the Financial Aid Office at SUNY Orange,';
                        $body .= '<br>';
                        $body .= '<br>';
                        if ($this -> input -> post('form')) {
                            foreach ($this->input->post('form') as $form_id) {
                                if ($form_id < 38) {
                                    $givenforms = '';
                                    $forms[] = $this -> queue_model -> getform($form_id);

                                    foreach ($forms as $givenform) {
                                        $givenforms .= '<li>' . $givenform . '</li>';
                                    }
                                }
                                if ($form_id > 37) {
                                    $givenchecklists = '';
                                    $forms1[] = $this -> queue_model -> getcheck($form_id);

                                    foreach ($forms1 as $givenchecklist) {
                                        $givenchecklists .= '<li>' . $givenchecklist . '</li>';
                                    }
                                }
                            }
                        }

                        if (isset($givenforms) && ($givenforms !== '')) {
                            $body .= 'The SUNY Orange Financial Aid Office has requested the following documentation : ';
                            $body .= '<br>';
                            $body .= '<ul>';
                            $body .= $givenforms;
                            $body .= '</ul>';
                            $body .= 'For more information on these forms please login into Banner Self Service by <a href="my.sunyorange.edu">clicking on this link</a> and go to the <b>Financial Aid</b> tab. Please be aware though some of these form(s) can not be submitted on line, you must download the PDF and then print it out. These PDF files are located <a href="http://www.sunyorange.edu/financialaid/forms/index.shtml">here</a>. Once completed you must submit the forms directly to the <b>Financial Aid</b> office.';
                            $body .= '<br>';
                            $body .= '<br>';
                        }

                        if (isset($givenchecklists) && ($givenchecklists !== '')) {
                            $body .= 'Please be advised for your own convience you were also given the following checklist(s) :';
                            $body .= '<ul>';
                            $body .= $givenchecklists;
                            $body .= '</ul>';
                            $body .= '<br>';
                        }

                        if (($this -> input -> post('action') == 'Additional') && ($this -> input -> post('addother') == 'addotherinfo')) {
                            $body .= 'A message from the counselor who saw you :';
                            $body .= '<ul>';
                            $body .= '<li>' . $this -> input -> post('emailcomments') . '</li>';
                            $body .= '<br>';
                            $body .= '</ul>';
                        }

                        $body .= 'If this email was sent to an email other than your SUNY Orange email account please be advised that your SUNY Orange email is the official means of communication. All official correspondance will be sent to your SUNY Orange email account.';
                        $body .= '<br>';
                        $body .= '<br>';
                        $body .= 'If you are recieving this message in error please notify SUNY Orange Financial Aid personnel and delete this email.';

                        $this -> email -> from('sunyorangetestemail@gmail.com');
                        $this -> email -> to($sendemail);
                        $this -> email -> subject($subject);
                        $this -> email -> message($body);

                        if (!$this -> email -> send()) {
                            $data['error'] = '<p class="error">Please Notify System Admin - Email did not get sent!</p>';
                            $data['first10'] = $this -> queue_model -> first10();
                            $data['elevennine'] = $this -> queue_model -> elev9();
                            $data['twenty5'] = $this -> queue_model -> twenty_5();
                            $data['twen87'] = $this -> queue_model -> twen8thir7();
                            $data['checklists'] = $this -> queue_model -> checklists();
                            $data['counsview'] = $this -> queue_model -> counselorview($this -> uri -> segment(3));
                            $this -> load -> view('studentqueue/counselorscreen', $data);
                        } else {
                            if ($this -> queue_model -> updateemail($session, $counselor)) {
                                redirect('studentqueue_controller/index', 'location');
                            }
                        }
                    }
                }
            }
            redirect('studentqueue_controller/index', 'location');
        }
    }

}
