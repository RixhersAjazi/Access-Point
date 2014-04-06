<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentlogin_model extends CI_Model {

    function checkanum($anum) {
	try {
	    $sql3 = "SELECT * FROM student WHERE anum = :anum";
	    $check = $this->db->conn_id->prepare($sql3);
	    $check->bindParam(':anum', $anum);
	    $check->execute();

	    if ($check) {
		if ($check->rowCount() == 0) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M140");
	}
    }

    function student($anum, $first, $last, $safeemail) {
	try {
	    $sql4 = "INSERT INTO student (anum, first, last, email) VALUES (:anum, :first, :last, :email)";
	    $studentinsert = $this->db->conn_id->prepare($sql4);
	    $studentinsert->bindParam(':anum', $anum);
	    $studentinsert->bindParam(':first', $first);
	    $studentinsert->bindParam(':last', $last);
	    $studentinsert->bindParam(':email', $safeemail);
	    $studentinsert->execute();

	    if ($studentinsert) {
		return TRUE;
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M164");
	}
    }

    function session($anum, $why, $aidyear, $comments) {
	try {
	    $time = NULL;

	    $sql2 = "INSERT INTO session (anum, why, aidyear, signintime, studentcomments) VALUES (:anum, :why, :aidyear, :signintime, :studentcomments)";
	    $sessioninsert = $this->db->conn_id->prepare($sql2);
	    $sessioninsert->bindParam(':anum', $anum);
	    $sessioninsert->bindParam(':why', $why);
	    $sessioninsert->bindParam(':aidyear', $aidyear);
	    $sessioninsert->bindParam(':signintime', $time);
	    $sessioninsert->bindParam(':studentcomments', $comments);
	    $sessioninsert->execute();

	    if ($sessioninsert) {
		return TRUE;
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M190");
	}
    }

    function emailover($anum, $aidyear) {
	$sql = "SELECT * FROM session
	        WHERE session.anum = :anum AND session.aidyear = :aidyear AND status = '3';";
	$emailover = $this->db->conn_id->prepare($sql);
	$emailover->bindParam(':anum', $anum);
	$emailover->bindParam(':aidyear', $aidyear);
	$emailover->execute();

	if ($emailover) {
	    if ($emailover->rowCount() >= 4) {
		return TRUE;
	    }
	}
    }

    function updateemail($anum, $safeemail) {
	try {
	    $sql4 = "UPDATE student SET email = :safeemail WHERE anum = :anum";
	    $update = $this->db->conn_id->prepare($sql4);
	    $update->bindParam(':anum', $anum);
	    $update->bindParam(':safeemail', $safeemail);
	    $update->execute();

	    if ($update) {
		if ($update->rowCount() == 1) {


		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M164");
	}
    }

    function reasonstoview() {
	try {
	    $sql4 = "SELECT * FROM reasons WHERE reason_id  BETWEEN '1' AND '12';";
	    $reasons = $this->db->conn_id->prepare($sql4);
	    $reasons->execute();

	    if ($reasons) {
		if ($reasons->rowCount() > 0) {
		    return $reasons->fetchall();
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M164");
	}
    }

    function reasonstoview1() {
	try {
	    $sql4 = "SELECT * FROM reasons WHERE reason_id > '12';";
	    $reasons1 = $this->db->conn_id->prepare($sql4);
	    $reasons1->execute();

	    if ($reasons1) {
		if ($reasons1->rowCount() > 0) {
		    return $reasons1->fetchall();
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: ST_M164");
	}
    }

    function checkstudent($anum, $first, $last) {
	$sql = "SELECT * from student WHERE anum = :anum;";
	$check = $this->db->conn_id->prepare($sql);
	$check->bindParam(':anum', $anum);
	$check->execute();

	if ($check) {
	    if ($check->rowCount() == 0) {
		return TRUE;
	    } else {
		$row = $check->fetch();

		$dbfirst = $row['first'];
		$dblast = $row['last'];

		if ((strcasecmp($dbfirst, $first) == 0) && (strcasecmp($dblast, $last)) == 0 ) {
		    return TRUE;
		}
	    }
	}
    }

    function checkfirst($anum, $first) {
	$sql = "SELECT * FROM student WHERE anum = :anum AND first = :first;";
	$name = $this->db->conn_id->prepare($sql);
	$name->bindParam(':anum', $anum);
	$name->bindParam(':first', $first);
	$name->execute();

	if ($name) {
	    if ($name->rowCount() == 1) {
		return TRUE;
	    }
	}
    }

    function checklast($anum, $last) {
	$sql = "SELECT * FROM student WHERE anum = :anum AND last = :last;";
	$name = $this->db->conn_id->prepare($sql);
	$name->bindParam(':anum', $anum);
	$name->bindParam(':last', $last);
	$name->execute();

	if ($name) {
	    if ($name->rowCount() == 1) {
		return TRUE;
	    }
	}
    }

    function confirm($anum) {
	$sql = "SELECT * FROM student WHERE anum = :anum;";
	$confirm = $this->db->conn_id->prepare($sql);
	$confirm->bindParam('anum', $anum);
	$confirm->execute();

	if ($confirm) {
	    if ($confirm->rowCount() == 1) {
		return $confirm->fetchall();
	    }
	}
    }

    function stafftoview() {
	$sql = "SELECT fname, lname FROM users WHERE status = 'Activated' AND role IN (2,3);";
	$confirm = $this->db->conn_id->prepare($sql);
	$confirm->execute();

	if ($confirm) {
	    if ($confirm->rowCount() > 0) {
		return $confirm->fetchall();
	    }
	}
    }

}