<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model {

    function checkstudent($anum, $first, $last) {
	try {
	    $sql = "SELECT * from student WHERE anum = :anum AND first = :first AND last = :last";
	    $check = $this->db->conn_id->prepare($sql);
	    $check->bindParam(':anum', $anum);
	    $check->bindParam(':first', $first);
	    $check->bindParam(':last', $last);
	    $check->execute();

	    if ($check) {
		if ($check->rowCount() > 0) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occurred, Contact System Admin - Err: L_M");
	}
    }

    function checkanum($anum) {
	try {
	    $sql = "SELECT * from student WHERE anum = :anum";
	    $check = $this->db->conn_id->prepare($sql);
	    $check->bindParam(':anum', $anum);
	    $check->execute();

	    if ($check) {
		if ($check->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occurred, Contact System Admin - Err: L_M");
	}
    }

    function checkfirst($first) {
	try {
	    $sql = "SELECT * from student WHERE first = :first";
	    ;
	    $check = $this->db->conn_id->prepare($sql);
	    $check->bindParam(':first', $first);
	    $check->execute();

	    if ($check) {
		if ($check->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occurred, Contact System Admin - Err: L_M");
	}
    }

    function checklast($last) {
	try {
	    $sql = "SELECT * from student WHERE last = :last";
	    ;
	    $check = $this->db->conn_id->prepare($sql);
	    $check->bindParam(':last', $last);
	    $check->execute();

	    if ($check) {
		if ($check->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occurred, Contact System Admin - Err: L_M");
	}
    }

    function emails($anum, $first, $last) {
	try {
	    $sql = "SELECT * from student WHERE anum = :anum AND first = :first AND last = :last";
	    $find = $this->db->conn_id->prepare($sql);
	    $find->bindParam(':anum', $anum);
	    $find->bindParam(':first', $first);
	    $find->bindParam(':last', $last);
	    $find->execute();

	    if ($find) {
		if ($find->rowCount() == 1) {
		    $row = $find->fetch();

		    return $email = $this->encrypt->decode($row['email']);
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occurred, Contact System Admin - Err: L_M");
	}
    }

    function checkemail($anum, $first, $last) {
	try {
	    $sql = "SELECT * from student WHERE anum = :anum AND first = :first AND last = :last AND email = NULL";
	    $find = $this->db->conn_id->prepare($sql);
	    $find->bindParam(':anum', $anum);
	    $find->bindParam(':first', $first);
	    $find->bindParam(':last', $last);
	    $find->execute();

	    if ($find) {
		if ($find->rowCount() !== 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occurred, Contact System Admin - Err: L_M");
	}
    }

    function reasons() {
	$sql ="SELECT * FROM reasons";
	$query = $this->db->conn_id->prepare($sql);
	$query->execute();

	if($query) {
	    return $query -> fetchall();
	}
    }

}