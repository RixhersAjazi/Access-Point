<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<title>Access Point</title>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/mainstyle.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/secondarystyles.css" type="text/css"/>
    </head>
    <body>

	<div id="wrapper">
	    <p class='error'>
		<?php echo $this->session->flashdata('signin_info'); ?>
	    </p>
	    <div id="signin_info">
		<ul>
		    <h3>
			<li>You should be speaking with the student</li>
			<br />
			<li>Only <FONT COLOR="#ff0000">GENERAL</FONT> award information can be given out over the phone. No dollar amounts</li>
			<br />
			<li>Always encourage Banner - Self Service</li>
			<br />
		    </h3>
		</ul>
	    </div>
	    <?php echo form_open('studentlogin_controller/agree', 'id="signinform"') ?>
	    <br />
	    <br />
	    <br />
	    <?php
	    echo anchor('studentlogin_controller/studentlogin', 'Cancel', 'id="Cancel"');
	    echo form_submit('submit', 'Submit');
	    echo form_close();
	    ?>
	    <div id="footer">
		<p>
		    Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
		    <br>
		    <strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
		</p>
	    </div>
    </body>
</div>
</html>
