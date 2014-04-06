<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentonlyaccess_controller extends MY_logincontroller { 


 function student() {
        $this -> load -> view('studentqueue/studentonlyqueue');
    }

    function studentonlyqueue() {
    	$this -> load -> model('queue_model');
        $data['waiting'] = $this -> queue_model -> studentonlywaiting();
        $this -> output -> set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

}