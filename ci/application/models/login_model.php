<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    function activated($username) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username AND status = 'Activated'";
            $activated = $this -> db -> conn_id -> prepare($sql);
            $activated -> bindParam(':username', $username);
            $activated -> execute();

            if ($activated) {
                if ($activated -> rowCount() == 1) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: L_M25");
        }
    }

    function checkPW($username, $pass) {
        try {
            $sql = "SELECT * from users WHERE username = :username";
            $checkPW = $this -> db -> conn_id -> prepare($sql);
            $checkPW -> bindParam(':username', $username);
            $checkPW -> execute();

            if ($checkPW) {
                if ($checkPW -> rowCount() == 1) {
                    $row = $checkPW -> fetch();
                    $dbpass = $this -> encrypt -> decode($row['password']);

                    if ($dbpass === $pass) {
                        return TRUE;
                    }
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: L_M54");
        }
    }

    function checkcode($username, $code) {
        try {
            $sql = "SELECT * from users WHERE username = :username AND secretcode = :code";
            $checkcode = $this -> db -> conn_id -> prepare($sql);
            $checkcode -> bindParam(':username', $username);
            $checkcode -> bindParam(':code', $code);
            $checkcode -> execute();

            if ($checkcode) {
                if ($checkcode -> rowCount() == 1) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: L_M78");
        }
    }

    function changePW($username, $password) {
        try {
            $bcrypt = new Bcrypt(17);
            $hash = $bcrypt -> hash($password);

            $sql = "UPDATE users SET password = :pass WHERE username = :username";
            $updatePW = $this -> db -> conn_id -> prepare($sql);
            $updatePW -> bindParam(':pass', $hash);
            $updatePW -> bindParam(':username', $username);
            $updatePW -> execute();

            if ($updatePW) {
                if ($updatePW -> rowCount() == 1) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: L_M105");
        }
    }

    function validate_login($username, $pass) {
        try {
            $bcrypt = new Bcrypt(17);

            $sql = "SELECT * FROM users WHERE username = :username";
            $loginQ = $this -> db -> conn_id -> prepare($sql);
            $loginQ -> bindParam(':username', $username);
            $loginQ -> execute();

            if ($loginQ) {
                if ($loginQ -> rowCount() == 1) {
                    $row = $loginQ -> fetch();
                    $hash = $row['password'];

                    if ($bcrypt -> verify($pass, $hash)) {
                        return TRUE;
                    }
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: L_M136");
        }
    }

    function removecode($username) {
        try {
            $sql = "UPDATE users SET secretcode = '' WHERE username = :username";
            $remove = $this -> db -> conn_id -> prepare($sql);
            $remove -> bindParam(':username', $username);
            $remove -> execute();

            if ($remove) {
                if ($remove -> rowCount() == 1) {
                    return TRUE;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occured, Contact System Admin - Err: L_M159");
        }
    }

    function admin_email() {
        try {
            $sql = "SELECT * from users WHERE status = 'Activated' AND role = '3' AND username != 'coderrix';";
            $admin_email = $this -> db -> conn_id -> prepare($sql);
            $admin_email -> execute();
            $emails = array();

            if ($admin_email) {
                if ($admin_email -> rowCount() > 0) {
                    foreach ($admin_email->fetchall() as $row) {
                        $emails[] = $this -> encrypt -> decode($row['email']);
                    }
                    return $emails;
                }
            }
        } catch (PDOException $e) {
            error_log($e -> getMessage());
            die("An Error Occurred, Contact System Admin - Err: L_M");
        }
    }

}
