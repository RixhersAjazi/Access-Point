<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_model extends CI_Model {

    function studenttotalwait() {
        try {
            $sql = "SELECT
		    DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
						session.session_id,
						session.anum,
						student.first,
						student.last,
						reasons.reason,
						(TIMEDIFF(t.fin, session.signintime)) AS time
					FROM session
						INNER JOIN student
							ON student.anum = session.anum
						INNER JOIN reasons
							ON reasons.reason_id = session.why
						LEFT JOIN (SELECT support.session_id, MAX(support.finishtime) AS fin FROM support GROUP BY support.session_id) AS t
							ON t.session_id = session.session_id
					WHERE session.status = 3;";
            $studenttotalwait = $this -> db -> conn_id -> prepare($sql);
            $studenttotalwait -> execute();

            if ($studenttotalwait) {
                if ($studenttotalwait -> rowCount() > 0) {
                    return $studenttotalwait -> fetchall();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: A_M38");
        }
    }

    function counselorperformance() {
        try {
            $sql = "SELECT
		DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
						session.session_id,
						session.anum,
						student.first,
						student.last,
						users.fname,
						reasons.reason,
						(TIMEDIFF(support.starttime, session.signintime)) as start,
						(TIMEDIFF(support.finishtime, support.starttime)) AS 'Time With Counselor',
						(TIMEDIFF(support.finishtime, session.signintime)) AS total
					FROM session
						INNER JOIN student
							ON student.anum = session.anum
						INNER JOIN reasons
							ON reasons.reason_id = session.why
						LEFT JOIN support
    						ON session.session_id = support.session_id
						INNER JOIN users
    						ON users.username = support.counselor
					WHERE session.status = 3
					ORDER BY session.session_id asc;";
            $counselorperformance = $this -> db -> conn_id -> prepare($sql);
            $counselorperformance -> execute();

            if ($counselorperformance) {
                if ($counselorperformance -> rowCount() > 0) {
                    return $counselorperformance -> fetchall();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: A_M80");
        }
    }

    function avgperformance() {
        try {
            $sql = "SELECT
						users.fname as counselor,
						count(session.anum) as students,
						SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(starttime, signintime)))) AS 'AVG Wait Time',
						SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(finishtime, starttime)))) AS 'AVG Session Length'
					FROM session
						LEFT JOIN support
							ON support.session_id = session.session_id
						LEFT JOIN users
							ON users.username = support.counselor
					WHERE session.status = 3
					GROUP BY fname;";
            $avgperformance = $this -> db -> conn_id -> prepare($sql);
            $avgperformance -> execute();

            if ($avgperformance) {
                if ($avgperformance -> rowCount() > 0) {
                    return $avgperformance -> fetchall();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: A_M113");
        }
    }

    function reasons() {
        try {
            $sql = "SELECT
						reasons.reason AS Reason,
	   					COUNT(session.why) AS Count,
	   					SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(t.fin, session.signintime)))) AS Time
					FROM session
	   					INNER JOIN reasons
							ON reasons.reason_id = session.why
	   					LEFT JOIN (SELECT support.session_id, MAX(support.finishtime) AS fin FROM support GROUP BY support.session_id) AS t
							ON t.session_id = session.session_id
					WHERE session.status = 3
					GROUP BY session.why
					ORDER BY session.signintime DESC;";
            $reasons = $this -> db -> conn_id -> prepare($sql);
            $reasons -> execute();

            if ($reasons) {
                if ($reasons -> rowCount() > 0) {
                    return $reasons -> fetchall();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: A_M146");
        }
    }

    function aidyears() {
        try {
            $sql = "SELECT
					   COUNT(why) 'Visits',
 	                   aidyear 'Aid Year',
 	                   SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(t.fin, session.signintime)))) AS Time,
 	                   DAYOFMONTH(MIN(signintime)) 'FIRST DAY',
 	                   MONTHNAME(MIN(signintime)) MONTH,
 	                   YEAR(MIN(signintime)) YEAR
 	                FROM session
 	                INNER JOIN student
 	                         ON student.anum = session.anum
 	                LEFT JOIN (SELECT support.session_id, MAX(support.finishtime) AS fin FROM support GROUP BY support.session_id) AS t
                            ON t.session_id = session.session_id
 	                WHERE session.status = 3
 	                GROUP BY aidyear;";
            $aidyears = $this -> db -> conn_id -> prepare($sql);
            $aidyears -> execute();

            if ($aidyears) {
                if ($aidyears -> rowCount() > 0) {
                    return $aidyears -> fetchall();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: A_M176");
        }
    }

    function aidperday() {
        try {
            $sql = "SELECT
			DATE_FORMAT(session.signintime, '%b %d, %Y') Date,
			COUNT(session.session_id) 'Total',
			sum(case when aidyear = '12-13' then 1 else 0 end) '12-13',
			sum(case when aidyear = '13-14' then 1 else 0 end) '13-14',
			sum(case when aidyear = '14-15' then 1 else 0 end) '14-15'
		    FROM session
		    Where status = '3'
		    GROUP by Date;
";
            $aidperday = $this -> db -> conn_id -> prepare($sql);
            $aidperday -> execute();

            if ($aidperday) {
                if ($aidperday -> rowCount() > 0) {
                    return $aidperday -> fetchall();
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: A_M205");
        }
    }

    function perhour() {
        $sql = "SELECT
		    DATE_FORMAT(signintime, '%c/%d/%y') Date,
		    count(session_id) as Total,
		    SUM(CASE WHEN HOUR(signintime) = 08 THEN 1 ELSE 0 END) '8AM-9AM',
		    SUM(CASE WHEN HOUR(signintime) = 09 THEN 1 ELSE 0 END) '9AM-10AM',
		    SUM(CASE WHEN HOUR(signintime) = 10 THEN 1 ELSE 0 END) '10AM-11AM',
		    SUM(CASE WHEN HOUR(signintime) = 11 THEN 1 ELSE 0 END) '11AM-12PM',
		    SUM(CASE WHEN HOUR(signintime) = 12 THEN 1 ELSE 0 END) '12PM-1PM',
		    SUM(CASE WHEN HOUR(signintime) = 13 THEN 1 ELSE 0 END) '1PM-2PM',
		    SUM(CASE WHEN HOUR(signintime) = 14 THEN 1 ELSE 0 END) '2PM-3PM',
		    SUM(CASE WHEN HOUR(signintime) = 15 THEN 1 ELSE 0 END) '3PM-4PM',
		    SUM(CASE WHEN HOUR(signintime) = 16 THEN 1 ELSE 0 END) '4PM-5PM',
		    SUM(CASE WHEN HOUR(signintime) = 17 THEN 1 ELSE 0 END) '5PM-6PM',
		    SUM(CASE WHEN HOUR(signintime) = 18 THEN 1 ELSE 0 END) '6PM-7PM',
		    SUM(CASE WHEN HOUR(signintime) = 19 THEN 1 ELSE 0 END) '7PM-8PM'
		FROM session
		WHERE session.status = '3'
		GROUP by Date";
        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            if ($query -> rowCount() > 0) {
                return $query -> fetchall();
            }
        }
    }

    function perweekday() {
        $sql = "SELECT
		    DATE_FORMAT(signintime, '%W %Y') Date,
		    count(session_id) as Total,
		    SUM(CASE WHEN HOUR(signintime) = 08 THEN 1 ELSE 0 END) '8AM-9AM',
		    SUM(CASE WHEN HOUR(signintime) = 09 THEN 1 ELSE 0 END) '9AM-10AM',
		    SUM(CASE WHEN HOUR(signintime) = 10 THEN 1 ELSE 0 END) '10AM-11AM',
		    SUM(CASE WHEN HOUR(signintime) = 11 THEN 1 ELSE 0 END) '11AM-12PM',
		    SUM(CASE WHEN HOUR(signintime) = 12 THEN 1 ELSE 0 END) '12PM-1PM',
		    SUM(CASE WHEN HOUR(signintime) = 13 THEN 1 ELSE 0 END) '1PM-2PM',
		    SUM(CASE WHEN HOUR(signintime) = 14 THEN 1 ELSE 0 END) '2PM-3PM',
		    SUM(CASE WHEN HOUR(signintime) = 15 THEN 1 ELSE 0 END) '3PM-4PM',
		    SUM(CASE WHEN HOUR(signintime) = 16 THEN 1 ELSE 0 END) '4PM-5PM',
		    SUM(CASE WHEN HOUR(signintime) = 17 THEN 1 ELSE 0 END) '5PM-6PM',
		    SUM(CASE WHEN HOUR(signintime) = 18 THEN 1 ELSE 0 END) '6PM-7PM',
		    SUM(CASE WHEN HOUR(signintime) = 19 THEN 1 ELSE 0 END) '7PM-8PM'
		FROM session
		WHERE session.status = '3'
		GROUP by Date;";

        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            if ($query -> rowCount() > 0) {
                return $query -> fetchall();
            }
        }
    }

    function students() {
        $sql = "SELECT
		    student.anum,
		    student.first,
		    student.last,
		    COUNT(session.anum) as Total,
		    DATE_FORMAT(MIN(session.signintime), '%b %d, %Y - %l%p') as 'First',
		    DATE_FORMAT(MAX(session.signintime), '%b %d, %Y - %l%p') as 'Last'
		FROM student
		    INNER JOIN session
			ON session.anum = student.anum
		GROUP BY student.anum
		ORDER BY Total desc;";
        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            if ($query -> rowCount() > 0) {
                return $query -> fetchall();
            }
        }
    }

    function studentemails() {
        $sql = "SELECT
            student.anum,
            student.first,
            student.last,
            student.email,
            DATE_FORMAT(MIN(session.signintime), '%b %d, %Y - %l%p') as 'First',
            DATE_FORMAT(MAX(session.signintime), '%b %d, %Y - %l%p') as 'Last',
            DATE_FORMAT(session.signintime, '%b %d, %Y') Date
        FROM student
            INNER JOIN session
            ON session.anum = student.anum
        WHERE student.email != 'NULL'
        GROUP BY student.anum
        ORDER BY Date asc;";

        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            if ($query -> rowCount() > 0) {
                return $query -> fetchall();
            }
        }
    }

    function dynamic($date1, $date2, $and, $or, $count) {
        $sql = "SELECT
		    student.anum,
		    student.first,
		    student.last,
		    student.email,
		    session.aidyear,
		    reasons.reason,
		    COUNT(session.anum) as Total,
		    DATE_FORMAT(MIN(session.signintime), '%b %d, %Y - %l:%i %p') as 'First',
		    DATE_FORMAT(MAX(session.signintime), '%b %d, %Y - %l:%i %p') as 'Last'
		FROM student
		    INNER JOIN session
			ON session.anum = student.anum
		    INNER JOIN session_status
			ON session_status.status = session.status
		    INNER JOIN reasons
            ON reason_id = session.why";

        $placeholder = array();
        $where = "";
        $name = array();

        if ($date1 !== "") {
            if (substr($date1, 0, 1) === '4') {
                $where .= " AND DATE_FORMAT(session.signintime, '%m/%e/%Y') BETWEEN :date1 AND :date2";
            } elseif (substr($date1, 0, 1) === '3') {
                $where .= " AND DATE_FORMAT(session.signintime, '%m/%e') BETWEEN :date1 AND :date2";
            } elseif (substr($date1, 0, 1) === '2') {
                $where .= " AND DATE_FORMAT(session.signintime, '%m/%Y') BETWEEN :date1 AND :date2";
            } else {
                $where .= " AND DATE_FORMAT(session.signintime, '%Y') BETWEEN :date1 AND :date2";
            }
            $placeholder[':date1'] = substr_replace($date1, '', 0, 1);
            $placeholder[':date2'] = substr_replace($date2, '', 0, 1);
        }

        if ($and) {
            foreach ($and as $key => $value) {
                if ($key === 'why_and') {
                    foreach ($value as $why) {

                    }
                }
            }
        }

        if ($or) {

        }

        if ($count !== "") {
            if (preg_match("(>=|<=|>|<|=|0-9)", $count)) {
                $where .= " GROUP BY session.anum HAVING COUNT(session.anum) $count";
            }
        } else {
            $where .= " GROUP BY session.anum";
        }

        $finSQL = $sql . ' WHERE 1 ' . $where;
        $dynamic = $this -> db -> conn_id -> prepare($finSQL);
        $dynamic -> execute($placeholder);
        var_dump($dynamic);
        var_dump($placeholder);

        if ($dynamic) {
            return $dynamic -> fetchall();
        }
    }

    function deepdown($vals) {
        $sql = "SELECT
            student.anum,
            student.first,
            student.last,
            student.email,
            session.aidyear,
            reasons.reason,
            COUNT(session.anum) as Total,
            DATE_FORMAT(MIN(session.signintime), '%b %d, %Y - %l:%i %p') as 'First',
            DATE_FORMAT(MAX(session.signintime), '%b %d, %Y - %l:%i %p') as 'Last'
        FROM student
            INNER JOIN session
            ON session.anum = student.anum
            INNER JOIN session_status
            ON session_status.status = session.status
            INNER JOIN reasons
            ON reason_id = session.why
        WHERE 1 ";

        if ($vals !== "") {
            if (array_key_exists(":aidyear", $vals)) {
                $sql .= " AND aidyear = :aidyear ";
            }
            if (array_key_exists(":reason", $vals)) {
                $sql .= " AND reason = :reason ";
            }
            if (array_key_exists(":status", $vals)) {
                $sql .= "AND session_status.state = :status";
            }
        }

        $finsql = $sql . ' GROUP BY student.anum ';
        $query = $this -> db -> conn_id -> prepare($finsql);
        $query -> execute($vals);
        if ($query) {
            return $query -> fetchall();
        }
    }

    function session_status() {
        $sql = "SELECT 
                    COUNT(anum) count, 
                    session_status.state state 
                FROM session 
                INNER JOIN session_status 
                    ON session_status.status = session.status
                WHERE session.status NOT IN (0,1,2)
                GROUP BY state
                ORDER BY count desc;";
        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            return $query -> fetchall();
        }
    }

    function phone_calls() {
        $sql = "SELECT 
                    DATE_FORMAT(session.signintime, '%b %d, %Y - %l:%i %p') as signintime, 
                    anum, 
                    reason, 
                    aidyear, 
                    studentcomments, 
                    counselorcomments,
                    state 
                FROM session 
                    INNER JOIN reasons 
                        ON reasons.reason_id = session.why 
                    LEFT JOIN support 
                        ON support.session_id = session.session_id 
                    INNER JOIN session_status 
                        ON session_status.status = session.status 
                WHERE studentcomments LIKE '%Student on line %' AND session.status NOT IN (0,1,2) 
                GROUP BY session.session_id;";
        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            return $query -> fetchall();
        }
    }

    function hourly_phones() {
        $sql = "SELECT
            DATE_FORMAT(signintime, '%c/%d/%y') Date,
            count(anum) as Total,
            SUM(CASE WHEN HOUR(signintime) = 08 THEN 1 ELSE 0 END) '8AM-9AM',
            SUM(CASE WHEN HOUR(signintime) = 09 THEN 1 ELSE 0 END) '9AM-10AM',
            SUM(CASE WHEN HOUR(signintime) = 10 THEN 1 ELSE 0 END) '10AM-11AM',
            SUM(CASE WHEN HOUR(signintime) = 11 THEN 1 ELSE 0 END) '11AM-12PM',
            SUM(CASE WHEN HOUR(signintime) = 12 THEN 1 ELSE 0 END) '12PM-1PM',
            SUM(CASE WHEN HOUR(signintime) = 13 THEN 1 ELSE 0 END) '1PM-2PM',
            SUM(CASE WHEN HOUR(signintime) = 14 THEN 1 ELSE 0 END) '2PM-3PM',
            SUM(CASE WHEN HOUR(signintime) = 15 THEN 1 ELSE 0 END) '3PM-4PM',
            SUM(CASE WHEN HOUR(signintime) = 16 THEN 1 ELSE 0 END) '4PM-5PM',
            SUM(CASE WHEN HOUR(signintime) = 17 THEN 1 ELSE 0 END) '5PM-6PM',
            SUM(CASE WHEN HOUR(signintime) = 18 THEN 1 ELSE 0 END) '6PM-7PM',
            SUM(CASE WHEN HOUR(signintime) = 19 THEN 1 ELSE 0 END) '7PM-8PM'
        FROM session
        WHERE session.status NOT IN (0,1,2) AND studentcomments LIKE '%Student on line %'
        GROUP by Date;";

        $query = $this -> db -> conn_id -> prepare($sql);
        $query -> execute();

        if ($query) {
            if ($query -> rowCount() > 0) {
                return $query -> fetchall();
            }
        }
    }

}
