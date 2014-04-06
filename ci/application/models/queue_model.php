<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Queue_model extends CI_Model {

    function waiting() {
        try {
            $sql = "SELECT DISTINCT
					session.session_id as id,
					session.anum,
					student.first,
					student.last,
					SEC_TO_TIME(TIMESTAMPDIFF(SECOND, signintime, NOW())) as SECOND,
					reasons.reason,
					session.studentcomments,
					session.aidyear,
					support.counselorcomments
				FROM session
        			INNER JOIN student
        				ON student.anum = session.anum
        			LEFT JOIN support
            			ON session.session_id = support.session_id
        			INNER JOIN reasons
        				ON reasons.reason_id = session.why
        			LEFT JOIN support support2
			            ON support.session_id = support2.session_id
            				AND support.starttime < support2.starttime
				WHERE session.status IN (0,2) AND support2.session_id IS NULL
				ORDER BY id asc;";
            $q = $this -> db -> conn_id -> prepare($sql);
            $q -> execute();

            if ($q) {
                if ($q -> rowCount() > 0) {
                    return $q -> fetchall();
                } else {
                    return $q = array();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M44");
        }
    }

    function studentonlywaiting() {
        $sql = "SELECT DISTINCT student.first, 
                                student.last, 
                                MAX(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, session.signintime, NOW()))) as SECOND 
                        FROM student 
                        LEFT JOIN session ON session.anum = student.anum 
                        WHERE session.status IN (0,2) AND studentcomments NOT LIKE '%Student on line%' 
                        GROUP BY session.anum 
                        ORDER BY SECOND desc";

        $student = $this -> db -> conn_id -> prepare($sql);
        $student -> execute();

        if ($student) {
            if ($student -> rowCount() > 0) {
                return $student -> fetchall();
            } else {
                return $student = array();
            }
        }

    }

    function beingseen() {
        try {
            $sql1 = "SELECT DISTINCT
		session.session_id as id,
		session.anum,
		student.first,
		student.last,
		session.signintime,
		users.fname,
		support.starttime,
		TIMEDIFF(support.starttime, session.signintime) as TIME
FROM session
	INNER JOIN student
		ON student.anum = session.anum
	LEFT JOIN support
		ON session.session_id = support.session_id
	LEFT JOIN support support2
		ON support.session_id = support2.session_id
			AND support.starttime < support2.starttime
	INNER JOIN users
		ON users.username = support.counselor
WHERE session.status = 1 AND support2.session_id IS NULL
ORDER by id asc;";
            $q1 = $this -> db -> conn_id -> prepare($sql1);
            $q1 -> execute();

            if ($q1) {
                if ($q1 -> rowCount() > 0) {
                    return $q1 -> fetchall();
                } else {
                    return $q1 = array();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M85");
        }
    }

    function support($session, $counselor) {
        try {
            $time = NULL;
            $sql5 = "INSERT INTO support (session_id, counselor, starttime) VALUES (:session, :couns, :time)";
            $supportinsert = $this -> db -> conn_id -> prepare($sql5);
            $supportinsert -> bindParam(':session', $session);
            $supportinsert -> bindParam(':couns', $counselor);
            $supportinsert -> bindParam(':time', $time);
            $supportinsert -> execute();

            if ($supportinsert) {
                if ($supportinsert -> rowCount() > 0) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M157");
        }
    }

    function updatesession($status, $session) {
        try {
            $sql6 = "UPDATE `session` SET status = :status WHERE session_id = :id";
            $update = $this -> db -> conn_id -> prepare($sql6);
            $update -> bindParam(':status', $status);
            $update -> bindParam('id', $session);
            $update -> execute();

            if ($update) {
                if ($update -> rowCount() > 0) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M181");
        }
    }

    function finishtime($session, $counselor) {
        try {
            $time = NULL;
            $sql8 = "UPDATE `support` SET finishtime = :time WHERE (support.session_id = :id AND support.counselor = :couns)";
            $finishtime = $this -> db -> conn_id -> prepare($sql8);
            $finishtime -> bindParam(':time', $time);
            $finishtime -> bindParam(':id', $session);
            $finishtime -> bindParam(':couns', $counselor);
            $finishtime -> execute();

            if ($finishtime) {
                if ($finishtime -> rowCount() > 0) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M207");
        }
    }

    function counselorcomments($comments, $session, $counselor) {
        try {
            $sql9 = "UPDATE `support` SET counselorcomments = :comments WHERE (support.session_id = :id AND support.counselor = :couns)";
            $counselorcomments = $this -> db -> conn_id -> prepare($sql9);
            $counselorcomments -> bindParam(':comments', $comments);
            $counselorcomments -> bindParam(':id', $session);
            $counselorcomments -> bindParam(':couns', $counselor);
            $counselorcomments -> execute();

            if ($counselorcomments) {
                if ($counselorcomments -> rowCount() > 0) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M232");
        }
    }

    function forms($session, $form_id) {
        $sql9 = "INSERT INTO givenforms (session_id, form_id) VALUES (:session, :form)";
        $form = $this -> db -> conn_id -> prepare($sql9);
        $form -> bindParam(':session', $session);
        $form -> bindParam(':form', $form_id);
        $form -> execute();

        if ($form) {
            if ($form -> rowCount() > 0) {
                return TRUE;
            }
        }
    }

    function givenform($session, $counselor) {
        $sql9 = "UPDATE `support` SET forms = '1' WHERE (support.session_id = :id AND support.counselor = :couns)";
        $given = $this -> db -> conn_id -> prepare($sql9);
        $given -> bindParam(':id', $session);
        $given -> bindParam(':couns', $counselor);
        $given -> execute();

        if ($given) {
            if ($given -> rowCount() > 0) {
                return TRUE;
            }
        }
    }

    function counselorview($session) {
        try {
            $sql7 = "SELECT
                 	session.session_id AS id,
                    session.anum,
                    student.first,
                    student.last,
                    reasons.reason,
                    session.studentcomments,
                    support.counselorcomments,
                    session.aidyear,
                    users.fname
                 FROM student
                 	INNER JOIN session
                 		ON student.anum = session.anum
                    INNER JOIN reasons
                    	ON reason_id = session.why
                    LEFT JOIN support
                    	ON session.session_id = support.session_id
                 	INNER JOIN users
                    	ON users.username = support.counselor
                 WHERE session.session_id = :id";

            $q7 = $this -> db -> conn_id -> prepare($sql7);
            $q7 -> bindParam(':id', $session);
            $q7 -> execute();

            if ($q7) {
                if ($q7 -> rowCount() > 0) {
                    return $q7 -> fetchall();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M275");
        }
    }

    function terminated($session, $first, $last, $terminate, $user) {
        try {
            $time = NULL;
            $sql10 = "INSERT INTO termination (session_id, First, Last, terminationreason, termination_time, username) VALUES (:session, :first, :last, :reason, :time, :user)";
            $terminated = $this -> db -> conn_id -> prepare($sql10);
            $terminated -> bindParam(':session', $session);
            $terminated -> bindParam(':first', $first);
            $terminated -> bindParam(':last', $last);
            $terminated -> bindParam(':reason', $terminate);
            $terminated -> bindParam(':time', $time);
            $terminated -> bindParam(':user', $user);
            $terminated -> execute();

            if ($terminated) {
                if ($terminated -> rowCount() > 0) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M304");
        }
    }

    function abandon($session, $first, $last, $comments, $user) {
        try {
            $time = NULL;
            $sql14 = "INSERT INTO abandoned (session_id, First, Last, abandonreason, time, username) VALUES (:session, :first, :last, :abandonreason, :time, :user)";
            $abandon = $this -> db -> conn_id -> prepare($sql14);
            $abandon -> bindParam(':session', $session);
            $abandon -> bindParam(':first', $first);
            $abandon -> bindParam(':last', $last);
            $abandon -> bindParam(':time', $time);
            $abandon -> bindParam(':abandonreason', $comments);
            $abandon -> bindParam(':user', $user);
            $abandon -> execute();

            if ($abandon) {
                if ($abandon -> rowCount() > 0) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M333");
        }
    }

    function stop($session, $reason, $comments, $user) {
        try {
            $sql = "INSERT INTO stopped (session_id, reasons, comments, user) VALUES (:session, :reason, :comments, :user)";
            $stop = $this -> db -> conn_id -> prepare($sql);
            $stop -> bindParam(':session', $session);
            $stop -> bindParam(':reason', $reason);
            $stop -> bindParam(':comments', $comments);
            $stop -> bindParam(':user', $user);
            $stop -> execute();

            if ($stop) {
                if ($stop -> rowCount() > 0) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: Q_M359");
        }
    }

    function first10() {
        $sql = "SELECT * FROM forms where form_id <11;";
        $f10 = $this -> db -> conn_id -> prepare($sql);
        $f10 -> execute();

        if ($f10) {
            return $f10 -> fetchall();
        }
    }

    function elev9() {
        $sql = "SELECT * FROM forms where form_id < 20 AND form_id > 10;";
        $elev9 = $this -> db -> conn_id -> prepare($sql);
        $elev9 -> execute();

        if ($elev9) {
            return $elev9 -> fetchall();
        }
    }

    function twenty_5() {
        $sql = "SELECT * FROM forms where form_id < 26 AND form_id > 19;";
        $twenty5 = $this -> db -> conn_id -> prepare($sql);
        $twenty5 -> execute();

        if ($twenty5) {
            return $twenty5 -> fetchall();
        }
    }

    function twen8thir7() {
        $sql = "SELECT * FROM forms where form_id < 38 AND form_id > 27;";
        $twen87 = $this -> db -> conn_id -> prepare($sql);
        $twen87 -> execute();

        if ($twen87) {
            return $twen87 -> fetchall();
        }
    }

    function checklists() {
        $sql = "SELECT * FROM forms where forms LIKE '%- Checklist';";
        $checklists = $this -> db -> conn_id -> prepare($sql);
        $checklists -> execute();

        if ($checklists) {
            return $checklists -> fetchall();
        }
    }

    function getemail($session, $counselor) {
        $sql = "SELECT student.email FROM student
			    INNER JOIN session
				ON session.anum = student.anum
			    INNER JOIN support
				ON support.session_id = session.session_id
			    WHERE support.session_id = :session AND support.counselor = :counselor";
        $emails = $this -> db -> conn_id -> prepare($sql);
        $emails -> bindParam(':session', $session);
        $emails -> bindParam(':counselor', $counselor);
        $emails -> execute();

        if ($emails) {
            if ($emails -> rowCount() == 1) {
                $row = $emails -> fetch();

                return $this -> encrypt -> decode($row['email']);
            }
        }
    }

    function updateemail($session, $counselor) {
        $sql = "UPDATE support SET emailed = '1' WHERE session_id = :session AND counselor = :counselor";
        $update = $this -> db -> conn_id -> prepare($sql);
        $update -> bindParam(':session', $session);
        $update -> bindParam(':counselor', $counselor);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function getform($form_id) {
        $sql = "SELECT formname FROM forms WHERE form_id = :form_id AND forms NOT LIKE '%Checklist';";
        $forms = $this -> db -> conn_id -> prepare($sql);
        $forms -> bindParam(':form_id', $form_id);
        $forms -> execute();

        if ($forms) {
            if ($forms -> rowCount() == 1) {
                $row = $forms -> fetch();

                return $row['formname'];
            }
        }
    }

    function getcheck($form_id) {
        $sql = "SELECT forms FROM forms WHERE form_id = :form_id AND forms LIKE '%Checklist';";
        $forms = $this -> db -> conn_id -> prepare($sql);
        $forms -> bindParam(':form_id', $form_id);
        $forms -> execute();

        if ($forms) {
            if ($forms -> rowCount() == 1) {
                $row = $forms -> fetch();

                return $row['forms'];
            }
        }
    }

    function get_reasons() {
        $sql = "SELECT * FROM reasons;";
        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            return $query -> fetchall();
        }
    }

    function update_anum($curr_anum, $anum) {
        $sql = "UPDATE student SET anum = :anum WHERE anum = :curr_anum";
        $update = $this -> db -> conn_id -> prepare($sql);
        $update -> bindParam(':anum', $anum);
        $update -> bindParam(':curr_anum', $curr_anum);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function check_anum($anum) {
        $sql = "SELECT anum FROM student WHERE anum = :anum;";
        $select = $this -> db -> conn_id -> prepare($sql);
        $select -> bindParam(':anum', $anum);
        $select -> execute();

        if ($select) {
            if ($select -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function deletestudent($curr_anum) {
        $sql = "DELETE FROM student WHERE anum = :anum";
        $delete = $this -> db -> conn_id -> prepare($sql);
        $delete -> bindParam(':anum', $curr_anum);
        $delete -> execute();

        if ($delete) {
            if ($delete -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function update_sess_anum($curr_anum, $anum) {
        $sql = "UPDATE session SET anum = :anum WHERE anum = :curr_anum";
        $update = $this -> db -> conn_id -> prepare($sql);
        $update -> bindParam(':anum', $anum);
        $update -> bindParam(':curr_anum', $curr_anum);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() > 0) {
                return TRUE;
            }
        }
    }

    function update_aidyear($session, $aidyear) {
        $sql = "UPDATE session SET aidyear = :aidyear WHERE session_id = :session";
        $update = $this -> db -> conn_id -> prepare($sql);
        $update -> bindParam(':aidyear', $aidyear);
        $update -> bindParam(':session', $session);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function update_why($session, $why) {
        $sql = "UPDATE session SET why = :why WHERE session_id = :session";
        $update = $this -> db -> conn_id -> prepare($sql);
        $update -> bindParam(':why', $why);
        $update -> bindParam(':session', $session);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function update_first($curr_anum, $anum, $first) {
        $sql = "UPDATE student SET first = :first WHERE anum = :anum";
        $update = $this -> db -> conn_id -> prepare($sql);

        if ($anum !== "") {
            $update -> bindParam(':anum', $anum);
        } else {
            $update -> bindParam(':anum', $curr_anum);
        }
        $update -> bindParam(':first', $first);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function update_last($curr_name, $anum, $last) {
        $sql = "UPDATE student SET last = :last WHERE anum = :anum";
        $update = $this -> db -> conn_id -> prepare($sql);

        if ($anum !== "") {
            $update -> bindParam(':anum', $anum);
        } else {
            $update -> bindParam(':anum', $curr_anum);
        }
        $update -> bindParam(':last', $last);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

    function update_email($curr_name, $anum, $email) {
        $sql = "UPDATE student SET email = :email WHERE anum = :anum";
        $update = $this -> db -> conn_id -> prepare($sql);

        if ($anum !== "") {
            $update -> bindParam(':anum', $anum);
        } else {
            $update -> bindParam(':anum', $curr_anum);
        }
        $update -> bindParam(':email', $email);
        $update -> execute();

        if ($update) {
            if ($update -> rowCount() == 1) {
                return TRUE;
            }
        }
    }

}
