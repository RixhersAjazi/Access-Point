<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

}

//This is the controller for pages that require you to be a staff member where staffmember == 1
class MY_logincontroller extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this -> load -> model('login_model');
		$loggedin = $this -> session -> userdata('loggedin');
		$username = $this -> session -> userdata('username');
		
		if ((!isset($loggedin)) || ($loggedin != TRUE) || (!$activated = $this -> login_model -> activated($username))) {
			$this -> session -> unset_userdata('loggedin');
			$this -> session -> unset_userdata('username');
			$this -> session -> unset_userdata('admin');
			$this -> session -> sess_destroy();
			$this -> load -> view('messages/accessdenied_view');
			$this -> output -> _display();
			die();
		}
		$this -> output -> set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this -> output -> set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this -> output -> set_header('Pragma: no-cache');
		$this -> output -> set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

		$admin = $this -> session -> userdata('admin');
		
		if ((isset($admin)) || ($admin = TRUE)) {
			$this -> session -> unset_userdata('admin');
		}
	}

}

class MY_admincontroller extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$admin = $this -> session -> userdata('admin');
		$loggedin = $this -> session -> userdata('loggedin');
		if ((!isset($admin)) || ($admin != TRUE) || (!isset($loggedin)) || ($loggedin != TRUE)) {
			$this -> session -> unset_userdata('loggedin');
			$this -> session -> unset_userdata('username');
			$this -> session -> unset_userdata('admin');
			$this -> session -> sess_destroy();
			$this -> load -> view('messages/accessdenied_view');
			$this -> output -> _display();
			die();
		}
		$this -> output -> set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this -> output -> set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this -> output -> set_header('Pragma: no-cache');
		$this -> output -> set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
}

/* end of file /application/core/MY_Controller.php */
