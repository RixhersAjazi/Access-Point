<div id="create_form">
    <?php echo validation_errors('<p class="error">'); ?>
    <h3>Create Account</h3>
    <fieldset><legend>Login Credentials</legend>
	<?php
	$fname = 'placeholder="First Name" autocomplete="off"';
	$lname = 'placeholder="Last Name" autocomplete="off"';
	$email = 'placeholder="Email Address" autocomplete="off"';
	$user = 'placeholder="User Name" autocomplete="off"';

	echo form_open('admin_controller/create');
	echo form_input('fname', set_value('fname'), $fname);
	echo form_input('lname', set_value('lname'), $lname);
	echo form_input('email', set_value('email'), $email);
	echo form_input('username', set_value('username'), $user);
	echo form_submit('submit', 'Create Account');
	echo anchor('admin_controller/index', 'Return');
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
