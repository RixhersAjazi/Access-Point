<div id="request_form">
    <?php echo validation_errors('<p class="error">'); ?>
    <p class='error'><?php echo $this->session->flashdata('email'); ?></p>
    <br>
    <h3>Request Account</h3>
    <fieldset>
	<legend>
	    Personal Information
	</legend>
	<?php
	$fname = 'placeholder="First Name" autocomplete="off"';
	$lname = 'placeholder="Last Name" autocomplete="off"';
	$email = 'placeholder="Email Address" autocomplete="off"';

	echo form_open('login_controller/email_request');
	echo form_input('fname', set_value('fname'), $fname);
	echo form_input('lname', set_value('lname'), $lname);
	echo form_input('email', set_value('email'), $email);
	echo form_submit('submit', 'Request Account');
	echo anchor('login_controller/index', 'Return');
	?>
    </fieldset>
</div>
<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
