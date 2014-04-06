<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staff_model extends CI_Model {

    function norole($username) {
	try {
	    $sql = "SELECT * FROM users WHERE username = :username AND role = 0";
	    $none = $this->db->conn_id->prepare($sql);
	    $none->bindParam(':username', $username);
	    $none->execute();

	    if ($none) {
		if ($none->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M25");
	}
    }

    function studentrole($username) {
	try {
	    $sql = "SELECT * FROM users WHERE username = :username AND role = 1";
	    $is_student = $this->db->conn_id->prepare($sql);
	    $is_student->bindParam(':username', $username);
	    $is_student->execute();

	    if ($is_student) {
		if ($is_student->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M48");
	}
    }

    function staffmember($username) {
	try {
	    $sql = "SELECT * FROM users WHERE username = :username AND role = 2";
	    $staffmember = $this->db->conn_id->prepare($sql);
	    $staffmember->bindParam(':username', $username);
	    $staffmember->execute();

	    if ($staffmember) {
		if ($staffmember->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M71");
	}
    }

    function is_admin($username) {
	try {
	    $sql = "SELECT * FROM users WHERE username = :username AND role = 3";
	    $is_admin = $this->db->conn_id->prepare($sql);
	    $is_admin->bindParam(':username', $username);
	    $is_admin->execute();

	    if ($is_admin) {
		if ($is_admin->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M94");
	}
    }

    function is_p($username) {
	try {
	    $sql = "SELECT * FROM users WHERE username = :username AND role = 4";
	    $is_p = $this->db->conn_id->prepare($sql);
	    $is_p->bindParam(':username', $username);
	    $is_p->execute();

	    if ($is_p) {
		if ($is_p->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M117");
	}
    }

}
