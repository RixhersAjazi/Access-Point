<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studenthistory_model extends CI_Model {

    function history($anum) {
	$sql3 = "SELECT
		    DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
		    session.anum,
                    student.first,
                    student.last,
                    reasons.reason,
                    session.studentcomments AS comment,
                    session.aidyear,
                    session_status.state as state
                 FROM session
                    INNER JOIN student
                    	ON student.anum = session.anum
                    INNER JOIN reasons
                    	ON reason_id = session.why
		    INNER JOIN session_status
			ON session_status.status = session.status
                 WHERE session.anum = :anum AND session.status IN (3,4) OR session.status IN (5,6)
                 GROUP BY session.session_id";
	$q2 = $this->db->conn_id->prepare($sql3);
	$q2->bindParam(':anum', $anum);
	$q2->execute();

	if ($q2) {
	    if ($q2->rowCount() > 0) {
		return $q2->fetchall();
	    }
	}
    }

    function findstudent($params) {
	$sql = "SELECT * FROM student WHERE 1";

	foreach ($params as $key => $value) {
	    $sql .= sprintf(' AND `%s` LIKE :%s', $key, $key);
	}
	$query = $this->db->conn_id->prepare($sql);

	foreach ($params as $key => $value) {
	    $query->bindValue(':' . $key, '%' . $value . '%');
	}
	$query->execute();

	if ($query) {
	    if ($query->rowCount() > 0) {
		return $query->fetchall();
	    }
	}
    }

    function fin_history($anum) {
	$sql3 = "SELECT
		    DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
		    session.anum,
                    student.first,
                    student.last,
                    reasons.reason,
                    session.studentcomments AS comment,
                    session.aidyear,
                    users.fname,
                    support.counselorcomments,
                    TIMEDIFF(u.fin, session.signintime) AS time
		 FROM session
                    INNER JOIN student
                    	ON student.anum = session.anum
                    INNER JOIN reasons
                    	ON reason_id = session.why
		    LEFT JOIN support
                    	ON support.session_id = session.session_id
                    INNER JOIN users
                    	ON users.username = support.counselor
                    LEFT JOIN (select support.session_id, MAX(support.finishtime) fin FROM support GROUP BY support.session_id) u
    	                ON u.session_id = session.session_id
                 WHERE session.anum = :anum AND session.status = '3'
                 GROUP BY session.session_id";
	$q2 = $this->db->conn_id->prepare($sql3);
	$q2->bindParam(':anum', $anum);
	$q2->execute();

	if ($q2) {
	    if ($q2->rowCount() > 0) {
		return $q2->fetchall();
	    }
	}
    }

    function left_history($anum) {
	$sql = "SELECT DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
		       student.anum,
		       student.first,
		       student.last,
		       stopped.reasons,
		       stopped.comments,
		       users.fname,
		       TIMEDIFF(stopped.time, session.signintime) AS time
		 FROM student
		       INNER JOIN session
			    ON session.anum = student.anum
		       LEFT JOIN stopped
			    ON stopped.session_id = session.session_id
		       INNER JOIN users
			    ON stopped.user = users.username
		WHERE session.status = '4' AND student.anum = :anum";

	$query = $this->db->conn_id->prepare($sql);
	$query->bindParam(':anum', $anum);
	$query->execute();

	if ($query) {
	    if ($query->rowCount() > 0) {
		return $query->fetchall();
	    }
	}
    }

    function term_history($anum) {
	$sql = "SELECT DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
		       student.anum,
		       student.first,
		       student.last,
		       terminationreason,
		       users.fname
		FROM student
		       INNER JOIN session
			    ON session.anum = student.anum
		       LEFT JOIN termination
			    ON termination.session_id = session.session_id
		       INNER JOIN users
			    ON termination.username = users.username
		WHERE session.status = '5' AND student.anum = :anum";

	$query = $this->db->conn_id->prepare($sql);
	$query->bindParam(':anum', $anum);
	$query->execute();

	if ($query) {
	    if ($query->rowCount() > 0) {
		return $query->fetchall();
	    }
	}
    }

    function aba_history($anum) {
	$sql = "SELECT DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
		       student.anum,
		       student.first,
		       student.last,
		       abandonreason,
		       users.fname
		FROM student
		       INNER JOIN session
			    ON session.anum = student.anum
		       LEFT JOIN abandoned
			    ON abandoned.session_id = session.session_id
		       INNER JOIN users
			    ON abandoned.username = users.username
		WHERE session.status = '6' AND student.anum = :anum";

	$query = $this->db->conn_id->prepare($sql);
	$query->bindParam(':anum', $anum);
	$query->execute();

	if ($query) {
	    if ($query->rowCount() > 0) {
		return $query->fetchall();
	    }
	}
    }

    function forms_history($anum) {
	$sql = "SELECT
	              DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
		      student.anum,
		      student.first,
		      student.last,
		      users.fname,
		      forms.forms
		FROM student
		      INNER JOIN session
			ON session.anum = student.anum
		      LEFT JOIN givenforms
			ON givenforms.session_id = session.session_id
		      LEFT JOIN forms
			ON forms.form_id = givenforms.form_id
                      LEFT JOIN support
                        ON support.session_id = session.session_id
		      INNER JOIN users
			ON users.username = support.counselor
	              WHERE session.status = '3' AND student.anum = :anum;";

	$query = $this->db->conn_id->prepare($sql);
	$query->bindParam(':anum', $anum);
	$query->execute();

	if ($query) {
	    if ($query->rowCount() > 0) {
		return $query->fetchall();
	    }
	}
    }

}