<?php

 if(!defined('BASEPATH')) exit('No direct script access allowed');

 class MY_Form_validation extends CI_Form_validation
 {

	 public function is_valid_student_id($str)
	 {
		 if(strlen($str) > 9)
		 {
			 $this -> set_message('is_valid_student_id', 'A-Number can not be over 9 characters');
			 return FALSE;
		 }
		 elseif(strlen($str) < 9)
		 {
			 $this -> set_message('is_valid_student_id', 'A-Number can not be under 9 characters');
			 return FALSE;
		 }
		 elseif((($str[0]) !== 'a') && (($str[0]) !== 'A'))
		 {
			 $this -> set_message('is_valid_student_id', 'A-Number must begin with the letter "A"');
			 return FALSE;
		 }
		 elseif(ctype_alpha($str[0]))
		 {
			 if(is_numeric(substr($str, 1, strlen($str) - 1)))
			 {
				 return TRUE;
			 }
			 else
			 {
				 $this -> set_message('is_valid_student_id', 'A-Number must have 8 digits 0 - 9');
				 return FALSE;
			 }
		 }
		 else
		 {
			 $this -> set_message('is_valid_student_id', 'A-Number must begin with the letter "A"');
			 return FALSE;
		 }

	 }

 }
