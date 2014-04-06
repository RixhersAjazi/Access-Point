<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_controller extends MY_logincontroller {

    function generate() {
        $this -> load -> model('reports_model');
        $reports = $this -> input -> post('reports');

        if (!empty($reports)) {
            if ($this -> input -> post('reports') == '1') {
                $data['totalwait'] = $this -> reports_model -> studenttotalwait();
                $data['main_content'] = 'reports/tables/1';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '2') {
                $data['performance'] = $this -> reports_model -> counselorperformance();
                $data['main_content'] = 'reports/tables/2';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '3') {
                $data['avgperformance'] = $this -> reports_model -> avgperformance();
                $data['main_content'] = 'reports/tables/3';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '4') {
                $data['reasons'] = $this -> reports_model -> reasons();
                $data['main_content'] = 'reports/tables/4';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '5') {
                $data['avgperformance'] = $this -> reports_model -> aidyears();
                $data['main_content'] = 'reports/tables/5';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '6') {
                $data['aidperday'] = $this -> reports_model -> aidperday();
                $data['main_content'] = 'reports/tables/6';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '7') {
                $data['aidperhour'] = $this -> reports_model -> perhour();
                $data['main_content'] = 'reports/tables/7';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '8') {
                $data['perweekday'] = $this -> reports_model -> perweekday();
                $data['main_content'] = 'reports/tables/8';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '9') {
                $data['totalever'] = $this -> reports_model -> students();
                $data['main_content'] = 'reports/tables/9';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '10') {
                $this -> load -> library('encrypt');
                $data['allemails'] = $this -> reports_model -> studentemails();
                $data['main_content'] = 'reports/tables/10';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '11') {
                $data['totals'] = $this -> reports_model -> counselorperformance();
                $data['main_content'] = 'reports/tables/11';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '12') {
                $data['status'] = $this -> reports_model -> session_status();
                $data['main_content'] = 'reports/tables/12';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '13') {
                $data['phone'] = $this -> reports_model -> phone_calls();
                $data['main_content'] = 'reports/tables/13';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
            if ($this -> input -> post('reports') == '14') {
                $data['hourlycalls'] = $this -> reports_model -> hourly_phones();
                $data['main_content'] = 'reports/tables/14';
                $this -> load -> view('includes/reports/reports_template', $data);
            }
        } else {
            $this -> session -> set_flashdata('reports', 'Please choose a report');
            redirect('staff_controller/reports', 'location');
        }

    }

    function deepdown() {
        $vals = "";
        $id = urldecode($this -> uri -> segment(3));

        if ((strlen($id) == 5) && (!ctype_alpha(str_replace(' ', '', $id)))) {
            $vals[':aidyear'] = $id;
            $data['message'] = "$id aid year students";
        } elseif (ctype_alpha(str_replace(' ', '', $id))) {
            $vals[':reason'] = $id;
            $data['message'] = "List of students that came in for $id";
        } else {
            $vals[':status'] = str_replace('status-', '', $id);
            $data['message'] = "List of students that were " . str_replace('status-', '', $id);
        }

        $this -> load -> model('reports_model');
        $this -> load -> library('email');

        $data['deepdown'] = $this -> reports_model -> deepdown($vals);
        $data['main_content'] = 'reports/tables/11';
        $this -> load -> view('includes/reports/reports_template', $data);

    }

    function dynamic() {
        $this -> load -> model('email_model');
        $data['reasons'] = $this -> email_model -> reasons();
        $data['main_content'] = 'reports/dynamic';
        $this -> load -> view('includes/no_js/template', $data);

        $this -> session -> unset_userdata('date1');
        $this -> session -> unset_userdata('date2');
        $this -> session -> unset_userdata('aidyear');
        $this -> session -> unset_userdata('and');
        $this -> session -> unset_userdata('or');
        $this -> session -> unset_userdata('count');

    }

    function dynamic_reporting() {
        $this -> load -> library('form_validation');

        $this -> form_validation -> set_rules('year1', '', '');
        $this -> form_validation -> set_rules('month1', '', '');
        $this -> form_validation -> set_rules('day1', '', '');

        if ($this -> input -> post('year1')) {
            $this -> form_validation -> set_rules('year2', 'End Year', 'required');
        }

        if ($this -> input -> post('month1')) {
            $this -> form_validation -> set_rules('month2', 'End Month', 'required');
        }

        if ($this -> input -> post('day1')) {
            $this -> form_validation -> set_rules('day2', 'End Day', 'required');
        }

        $this -> form_validation -> set_rules('aidyear', '', '');
        $this -> form_validation -> set_rules('totalselect', '', '');
        $this -> form_validation -> set_rules('and', '', '');
        $this -> form_validation -> set_rules('or', '', '');

        if (($this -> input -> post('count') !== '') || ($this -> input -> post('operator')) !== '') {
            $this -> form_validation -> set_rules('count', 'Number of times', 'required');
            $this -> form_validation -> set_rules('operator', 'The operator', 'required');
        }

        if ($this -> form_validation -> run() == FALSE) {
            $this -> dynamic();
        } else {
            $date1 = "";
            $date2 = "";
            $and = array();
            $or = array();
            $count = "";

            if (($this -> input -> post('year1')) && ($this -> input -> post('month1')) && ($this -> input -> post('day1'))) {
                $date1 = '4' . $this -> input -> post('month1') . '/' . $this -> input -> post('day1') . '/' . $this -> input -> post('year1') . '';
            } elseif (($this -> input -> post('month1')) && ($this -> input -> post('day1'))) {
                $date1 = '3' . $this -> input -> post('month1') . '/' . $this -> input -> post('day1');
            } elseif (($this -> input -> post('year1')) && ($this -> input -> post('month1'))) {
                $date1 = '2' . $this -> input -> post('month1') . '/' . $this -> input -> post('year1') . '';
            } else {
                if ($this -> input -> post('year1')) {
                    $date1 = '1' . $this -> input -> post('year1');
                }
            }

            if (($this -> input -> post('year2')) && ($this -> input -> post('month2')) && ($this -> input -> post('day2'))) {
                $date2 = '4' . $this -> input -> post('month2') . '/' . $this -> input -> post('day2') . '/' . $this -> input -> post('year2') . '';
            } elseif (($this -> input -> post('month2')) && ($this -> input -> post('day2'))) {
                $date2 = '3' . $this -> input -> post('month2') . '/' . $this -> input -> post('day2');
            } elseif (($this -> input -> post('year2')) && ($this -> input -> post('month2'))) {
                $date2 = '2' . $this -> input -> post('month2') . '/' . $this -> input -> post('year2') . '';
            } else {
                if ($this -> input -> post('year2')) {
                    $date2 = '1' . $this -> input -> post('year2');
                }
            }
            if ($this -> input -> post('and')) {
                $andarray = $this -> input -> post('and');

                if (preg_grep("/reason_/", $andarray)) {
                    foreach (preg_grep("/reason_/", $andarray) as $value) {
                        $and['why_and'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/status_/", $andarray)) {
                    foreach (preg_grep("/status_/", $andarray) as $value) {
                        $and['status_and'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/aidyear_/", $andarray)) {
                    foreach (preg_grep("/aidyear_/", $andarray) as $value) {
                        $and['aidyear_and'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/action_/", $andarray)) {
                    foreach (preg_grep("/action_/", $andarray) as $value) {
                        $and['counselorcomments_and'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/noemail/", $andarray)) {
                    $and['email_and'][] = 'NULL';
                }
                if (preg_grep("/yesemail/", $andarray)) {
                    $and['email_and'][] = 'NOT NULL';
                }
            }
            if ($this -> input -> post('or')) {
                $orarray = $this -> input -> post('or');

                if (preg_grep("/reason_/", $orarray)) {
                    foreach (preg_grep("/reason_/", $orarray) as $value) {
                        $or['why_or'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/status_/", $orarray)) {
                    foreach (preg_grep("/status_/", $orarray) as $value) {
                        $or['status_or'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/aidyear_/", $orarray)) {
                    foreach (preg_grep("/aidyear_/", $orarray) as $value) {
                        $or['aidyear_or'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/action_/", $orarray)) {
                    foreach (preg_grep("/action_/", $orarray) as $value) {
                        $or['counselorcomments_or'][] = end(explode('_', $value));
                    }
                }
                if (preg_grep("/noemail/", $orarray)) {
                    $or['email_or'][] = 'NULL';
                }
                if (preg_grep("/yesemail/", $orarray)) {
                    $or['email_or'][] = 'NOT NULL';
                }
            }
            if (($this -> input -> post('count')) && ($this -> input -> post('operator'))) {
                $count = $this -> input -> post('operator') . ' ' . $this -> input -> post('count');
            }

            $this -> session -> set_userdata('date1', $date1);
            $this -> session -> set_userdata('date2', $date2);
            $this -> session -> set_userdata('and', $and);
            $this -> session -> set_userdata('or', $or);
            $this -> session -> set_userdata('count', $count);
            redirect('reports_controller/dynamictable');
        }

    }

    function dynamictable() {
        $date1 = $this -> session -> userdata('date1');
        $date2 = $this -> session -> userdata('date2');
        $and = $this -> session -> userdata('and');
        $or = $this -> session -> userdata('or');
        $count = $this -> session -> userdata('count');

        $this -> load -> model('reports_model');
        $this -> load -> library('encrypt');
        $data['dynamic'] = $this -> reports_model -> dynamic($date1, $date2, $and, $or, $count);
        $data['main_content'] = 'reports/tables/dynamicreport';
        $this -> load -> view('includes/reports/reports_template', $data);
    }

}
