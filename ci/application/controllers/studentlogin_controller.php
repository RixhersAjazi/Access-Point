<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentlogin_controller extends MY_logincontroller {

    function signin_info() {

        if ($this -> session -> userdata('phone') == 'yes') {
            $data['main_content'] = 'studentsignin/staff_signin_info';
        } else {
            $data['main_content'] = 'studentsignin/signin_info';
        }
        $this -> load -> view('includes/no_js/template', $data);

    }

    function studentlogin() {
        $this -> load -> model('studentlogin_model');

        $this -> session -> unset_userdata('anum');
        $this -> session -> unset_userdata('first');
        $this -> session -> unset_userdata('last');
        $this -> session -> unset_userdata('aidyear');
        $this -> session -> unset_userdata('why');
        $this -> session -> unset_userdata('hour');
        $this -> session -> unset_userdata('counselor');
        $this -> session -> unset_userdata('min');
        $this -> session -> unset_userdata('comments');
        $this -> session -> unset_userdata('email');
        $this -> session -> unset_userdata('phone');

        $data['reasons'] = $this -> studentlogin_model -> reasonstoview();
        $data['reasons1'] = $this -> studentlogin_model -> reasonstoview1();
        $data['staff'] = $this -> studentlogin_model -> stafftoview();

        if (($this -> session -> userdata('username') == 'StudentAccount') || ($this -> session -> userdata('username') == 'studentaccount')) {
            $this -> load -> view('studentsignin/studentlogin', $data);
        } else {
            $this -> load -> view('studentsignin/staff_studentlogin', $data);
        }

    }

    function validstudent() {

        $this -> load -> library('form_validation');

        if ($this -> input -> post('push') === 'yes') {
            $this -> form_validation -> set_rules('phoneline', 'Phone Line', 'required');
            $this -> form_validation -> set_rules('push', '', '');
        } else {

            if (!$this -> input -> post('student') == 'yes') {
                $this -> form_validation -> set_rules('anum', 'A Number', 'required|is_valid_student_id|exact_length[9]');
            }

            $this -> form_validation -> set_rules('fname', 'First Name', 'required|max_length[20]');
            $this -> form_validation -> set_rules('lname', 'Last Name', 'required|max_length[20]');
            $this -> form_validation -> set_rules('aidyear', 'Aid Year', 'required|exact_length[5]');
            $this -> form_validation -> set_rules('why', 'Reason', 'required|min_length[1]|max_length[2]');
            $this -> form_validation -> set_rules('comments', 'Comments', 'max_length[80]');

            if ($this -> input -> post('student') == 'yes') {
                $this -> form_validation -> set_rules('email', 'Email', 'max_length[40]|valid_email');
            } else {
                $this -> form_validation -> set_rules('email', 'Email', 'max_length[40]|valid_email|required');
            }

            if ($this -> input -> post('phone') == 'yes') {
                $this -> form_validation -> set_rules('phoneline', 'Phone Line', 'required');
            }

            if ($this -> input -> post('why') == 12) {
                $this -> form_validation -> set_rules('why1', 'Other Reason', 'required|min_length[1]|max_length[2]');
            }

            if (($this -> input -> post('why1') == 20) && ($this -> input -> post('why') == 12)) {
                $this -> form_validation -> set_rules('comments', 'Comments', 'required|max_length[80]');
            }

            if (($this -> input -> post('why1') == 14) && ($this -> input -> post('why') == 12)) {
                $this -> form_validation -> set_rules('counselor', 'Counselor', 'required');
                $this -> form_validation -> set_rules('hour', 'Hour', 'required|numeric');
                $this -> form_validation -> set_rules('min', 'Minute', 'required|numeric');
            }

            $this -> form_validation -> set_rules('phone', '', '');
            $this -> form_validation -> set_rules('student', '', '');
        }
        if ($this -> form_validation -> run() == FALSE) {
            $this -> studentlogin();
        } else {
            if ($this -> input -> post('student') == 'yes') {
                $this -> session -> set_userdata('anum', mt_rand(100000000, 999999999));
            } else {
                $this -> session -> set_userdata('anum', $anum = $this -> input -> post('anum'));
            }
            if ($this -> input -> post('push') == 'yes') {
                $this -> session -> set_userdata('phone', 'yes');

                $this -> session -> set_userdata('anum', mt_rand(100000000, 999999999));
                $this -> session -> set_userdata('first', 'On');
                $this -> session -> set_userdata('last', 'Phone');
                $this -> session -> set_userdata('aidyear', '9999');
                $this -> session -> set_userdata('why', '20');
                $this -> session -> set_userdata('comments', 'Student on line ' . $this -> input -> post('phoneline') . '');
            } else {

                $this -> session -> set_userdata('first', $first = $this -> input -> post('fname'));
                $this -> session -> set_userdata('last', $last = $this -> input -> post('lname'));
                $this -> session -> set_userdata('aidyear', $aidyear = $this -> input -> post('aidyear'));

                if (($this -> input -> post('why') == 12) && ($this -> input -> post('why1') >= 13)) {
                    $this -> session -> set_userdata('why', $why = $this -> input -> post('why1'));
                } else {
                    if (($this -> input -> post('why') <= 11) && ($this -> input -> post('why') >= 1)) {
                        $this -> session -> set_userdata('why', $why = $this -> input -> post('why'));
                    }
                }
                if (($this -> input -> post('why1') == 14) && ($this -> input -> post('why') == 12)) {
                    $counselor = $this -> input -> post('counselor');
                    $hour = $this -> input -> post('hour');
                    $min = $this -> input -> post('min');

                    $this -> session -> set_userdata('comments', $comments = 'I have an appointment at ' . $hour . ':' . $min . ' with ' . $counselor . '');
                }

                if ($this -> input -> post('phone') == 'yes') {
                    $this -> session -> set_userdata('phone', 'yes');
                    $comments = 'Student on line ' . $this -> input -> post('phoneline') . '';

                    if (($this -> input -> post('why') == 12) && ($this -> input -> post('why1') == 20)) {
                        $comments .= ' - ' . $this -> input -> post('comments') . '';
                    }

                    if (($this -> input -> post('why') == 12) && ($this -> input -> post('why1') == 14)) {
                        $comments .= ' - I have an appointment at ' . $hour . ':' . $min . ' with ' . $counselor . '';
                    }
                    $this -> session -> set_userdata('comments', $comments);
                }

                if (($this -> input -> post('phone') !== 'yes') && ($this -> input -> post('why') == 12) && ($this -> input -> post('why1') == 20)) {
                    $this -> session -> set_userdata('comments', $this -> input -> post('comments'));
                }

                $this -> session -> set_userdata('email', $email = $this -> input -> post('email'));
            }
            $this -> load -> model('email_model');
            $this -> load -> model('studentlogin_model');

            if ($this -> input -> post('student') == 'yes') {
                if ($this -> input -> post('phone') !== 'yes') {
                    redirect('studentlogin_controller/signin_info', 'location');
                } else {
                    redirect('studentlogin_controller/signin_info', 'location');
                }
            } else {
                if ($this -> studentlogin_model -> checkstudent($anum, $first, $last)) {
                    redirect('studentlogin_controller/signin_info', 'location');
                } else {
                    if (!$this -> studentlogin_model -> checkfirst($anum, $first)) {
                        $error = '<li><p class="error">First Name Does Not Match Corresponding A-Number</p></li>';
                    }
                    if (!$this -> studentlogin_model -> checklast($anum, $last)) {
                        $error .= '<li><p class="error">Last Name Does Not Match Corresponding A-Number</p></li>';
                    }

                    $data['info'] = $this -> studentlogin_model -> confirm($anum);
                    $data['main_content'] = 'studentsignin/confirm';
                    $data['error'] = $error;
                    $this -> load -> view('includes/no_js/template', $data);
                }
            }
        }

    }

    function agree() {
        $this -> load -> model('studentlogin_model');
        $this -> load -> library('email');
        $this -> load -> model('login_model');
        $this -> load -> library('encrypt');

        $anum = $this -> session -> userdata('anum');
        $first = $this -> session -> userdata('first');
        $last = $this -> session -> userdata('last');
        $aidyear = $this -> session -> userdata('aidyear');
        $why = $this -> session -> userdata('why');
        $comments = $this -> session -> userdata('comments');
        $email = $this -> session -> userdata('email');

        if ($email) {
            $safeemail = $this -> encrypt -> encode($email);
        } else {
            $safeemail = NULL;
        }

        if ($this -> session -> userdata('phone') !== 'yes') {
            if ($this -> input -> post('options') == 'agree') {
                if ($this -> session -> userdata('anum', 'first', 'last', 'aidyear', 'why', 'comments', 'email')) {
                    if ($this -> studentlogin_model -> checkanum($anum)) {
                        if (($this -> studentlogin_model -> student($anum, $first, $last, $safeemail)) && ($this -> studentlogin_model -> session($anum, $why, $aidyear, $comments))) {

                            $this -> session -> unset_userdata('anum');
                            $this -> session -> unset_userdata('first');
                            $this -> session -> unset_userdata('last');
                            $this -> session -> unset_userdata('aidyear');
                            $this -> session -> unset_userdata('why');
                            $this -> session -> unset_userdata('comments');
                            $this -> session -> unset_userdata('email');
                            $this -> session -> unset_userdata('phone');

                            redirect('studentlogin_controller/studentlogin', 'location');
                        }
                    } else {
                        if ($this -> studentlogin_model -> session($anum, $why, $aidyear, $comments)) {
                            if ($this -> studentlogin_model -> updateemail($anum, $safeemail)) {
                                if ($this -> studentlogin_model -> emailover($anum, $aidyear)) {

                                    $this -> load -> library('email');
                                    $this -> load -> model('login_model');
                                    $this -> load -> library('encrypt');

                                    $anum = $this -> session -> userdata('anum');
                                    $first = $this -> session -> userdata('first');
                                    $last = $this -> session -> userdata('last');
                                    $aidyear = $this -> session -> userdata('aidyear');

                                    foreach ($this -> login_model -> admin_email() as $emails) {
                                        $admin_emails[] = $emails;
                                    }

                                    $this -> email -> from('sunyorangetestemail@gmail.com');
                                    $this -> email -> to($admin_emails);
                                    $this -> email -> subject('Administrator Review Required');
                                    $this -> email -> message('This is a automated email alert to notify System Administrators that ' . $first . ' ' . $last . ', with the A Number ' . $anum . ' has visited the Financial Aid Office several times and still has outstanding requirements for aid year ' . $aidyear . '. Please review student file.');

                                    $this -> email -> send();
                                }

                                $this -> session -> unset_userdata('anum');
                                $this -> session -> unset_userdata('first');
                                $this -> session -> unset_userdata('last');
                                $this -> session -> unset_userdata('aidyear');
                                $this -> session -> unset_userdata('why');
                                $this -> session -> unset_userdata('comments');
                                $this -> session -> unset_userdata('email');
                                $this -> session -> unset_userdata('phone');

                                redirect('studentlogin_controller/studentlogin', 'location');
                            }
                        }
                    }
                } else {
                    redirect('studentlogin_controller/studentlogin', 'location');
                }
            } else {
                $this -> session -> set_flashdata('signin_info', 'You must check box below if you agree to the terms!');
                redirect('studentlogin_controller/signin_info', 'location');
            }
        } else {
            if ($this -> session -> userdata('anum', 'first', 'last', 'aidyear', 'why', 'comments', 'email', 'phone')) {
                if ($this -> studentlogin_model -> checkanum($anum)) {
                    if (($this -> studentlogin_model -> student($anum, $first, $last, $safeemail)) && ($this -> studentlogin_model -> session($anum, $why, $aidyear, $comments))) {

                        $this -> session -> unset_userdata('anum');
                        $this -> session -> unset_userdata('first');
                        $this -> session -> unset_userdata('last');
                        $this -> session -> unset_userdata('aidyear');
                        $this -> session -> unset_userdata('why');
                        $this -> session -> unset_userdata('comments');
                        $this -> session -> unset_userdata('email');
                        $this -> session -> unset_userdata('phone');

                        redirect('studentlogin_controller/studentlogin', 'location');
                    }
                } else {
                    if ($this -> studentlogin_model -> session($anum, $why, $aidyear, $comments)) {
                        if ($this -> studentlogin_model -> updateemail($anum, $safeemail)) {
                            if ($this -> studentlogin_model -> emailover($anum, $aidyear, $first, $last)) {

                                $anum = $this -> session -> userdata('anum');
                                $first = $this -> session -> userdata('first');
                                $last = $this -> session -> userdata('last');
                                $aidyear = $this -> session -> userdata('aidyear');

                                $emails = $this -> login_model -> admin_email();
                                $this -> email -> from('sunyorangetestemail@gmail.com');
                                $this -> email -> to($emails);
                                $this -> email -> subject('Administrator Review Required');
                                $this -> email -> message('This is a automated email alert to notify System Administrators that ' . $first . ' ' . $last . ', with the A Number ' . $anum . ' has visited the Financial Aid Office several times and still has outstanding requirements for aid year ' . $aidyear . '. Please review student file.');

                                $this -> email -> send();
                            }

                            $this -> session -> unset_userdata('anum');
                            $this -> session -> unset_userdata('first');
                            $this -> session -> unset_userdata('last');
                            $this -> session -> unset_userdata('aidyear');
                            $this -> session -> unset_userdata('why');
                            $this -> session -> unset_userdata('comments');
                            $this -> session -> unset_userdata('email');
                            $this -> session -> unset_userdata('phone');

                            redirect('studentlogin_controller/studentlogin', 'location');
                        }
                    }
                }
            } else {
                redirect('studentlogin_controller/studentlogin', 'location');
            }
        }

    }

}
