<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

    function valid_admin($username, $password) {
	try {
	    $bcrypt = new Bcrypt(17);

	    $sql = "SELECT * FROM users WHERE username = :username AND role = 3 AND status = 'Activated';";
	    $admin = $this->db->conn_id->prepare($sql);
	    $admin->bindParam(':username', $username);
	    $admin->execute();

	    if ($admin) {
		if ($admin->rowCount() == 1) {
		    $row = $admin->fetch();
		    $hash = $row['password'];

		    if ($bcrypt->verify($password, $hash)) {
			return TRUE;
		    }
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: A_M33");
	}
    }

    function activatetable() {
	try {
	    $sql2 = "SELECT username,
						reg_data,
						fname,
						lname,
						users.status,
						userstatus.status as Role
				 FROM users
				 		INNER JOIN userstatus
				 			ON userstatus.code = users.role;";
	    $activated = $this->db->conn_id->prepare($sql2);
	    $activated->execute();

	    if ($activated) {
		if ($activated->rowCount() > 0) {
		    return $activated->fetchall();
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: A_M63");
	}
    }

    function activate($status, $username, $first) {
	try {
	    $sql4 = "UPDATE users SET status = :status WHERE username = :user AND fname = :name";
	    $insertactivate = $this->db->conn_id->prepare($sql4);
	    $insertactivate->bindParam(':status', $status);
	    $insertactivate->bindParam(':user', $username);
	    $insertactivate->bindParam(':name', $first);
	    $insertactivate->execute();

	    if ($insertactivate) {
		if ($insertactivate->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: A_M88");
	}
    }

    function updaterole($role, $username, $fname) {
	try {
	    $sql5 = "UPDATE users SET role = :role WHERE username = :user and fname = :name ";
	    $updatestaff = $this->db->conn_id->prepare($sql5);
	    $updatestaff->bindParam(':role', $role);
	    $updatestaff->bindParam(':user', $username);
	    $updatestaff->bindParam(':name', $fname);
	    $updatestaff->execute();

	    if ($updatestaff) {
		if ($updatestaff->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: A_M113");
	}
    }

    function create_employee($username, $email, $fname, $lname, $password, $secretcode) {
	try {
	    $sql = "INSERT INTO users (username, email, fname, lname, password, secretcode) VALUES (:user, :email, :fname, :lname, :pass, :secretcode)";
	    $create_emp = $this->db->conn_id->prepare($sql);
	    $create_emp->bindParam(':user', $username);
	    $create_emp->bindParam(':email', $email);
	    $create_emp->bindParam(':fname', $fname);
	    $create_emp->bindParam(':lname', $lname);
	    $create_emp->bindParam(':pass', $password);
	    $create_emp->bindParam(':secretcode', $secretcode);
	    $create_emp->execute();

	    if ($create_emp) {
		if ($create_emp->rowCount() == 1) {
		    return TRUE;
		}
	    }
	} catch (PDOException $e) {
	    error_log($e->getMessage());
	    die("An Error Occured, Contact System Admin - Err: A_M141");
	}
    }

    function checkanum($anum) {
	$sql = "SELECT * FROM student WHERE anum = :anum;";
	$check = $this->db->conn_id->prepare($sql);
	$check->bindParam(':anum', $anum);
	$check->execute();

	if ($check) {
	    if ($check->rowCount() == 1) {
		RETURN TRUE;
	    }
	}
    }

    function updatefirst($anum, $first) {
	$sql = "UPDATE student SET first = :first WHERE anum = :anum;";
	$update = $this->db->conn_id->prepare($sql);
	$update->bindParam(':first', $first);
	$update->bindParam(':anum', $anum);
	$update->execute();

	if ($update) {
	    if ($update->rowcount() == 1) {
		return TRUE;
	    }
	}
    }

    function updatelast($anum, $last) {
	$sql = "UPDATE student SET last = :last WHERE anum = :anum;";
	$update = $this->db->conn_id->prepare($sql);
	$update->bindParam(':last', $last);
	$update->bindParam(':anum', $anum);
	$update->execute();

	if ($update) {
	    if ($update->rowcount() == 1) {
		return TRUE;
	    }
	}
    }

    function updateemail($anum, $safeemail) {
	$sql = "UPDATE student SET email = :email WHERE anum = :anum;";
	$update = $this->db->conn_id->prepare($sql);
	$update->bindParam(':email', $safeemail);
	$update->bindParam(':anum', $anum);
	$update->execute();

	if ($update) {
	    if ($update->rowcount() == 1) {
		return TRUE;
	    }
	}
    }

    function insertstudent($anum, $first, $last, $safeemail) {

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

}
