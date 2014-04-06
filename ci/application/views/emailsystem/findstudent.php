<?php echo validation_errors('<p class="error">'); ?>
<?php echo $error ?>
<p class="error">
    <?php echo $this->session->flashdata('emailview'); ?>
</p>

<?php
$anum = 'placeholder="A Number" autocomplete="off"';
$first = 'placeholder="First Name" autocomplete="off"';
$last = 'placeholder="Last Name" autocomplete="off"';
$subject = 'placeholder="Email Subject" autocomplete="off"';
?>

<div id="emaillinks">
    <?php echo anchor('email_controller/emailview', 'Find Student', 'id="currentemail"'); ?>
    <?php echo anchor('email_controller/directemail', 'Direct Email'); ?>
</div>

<div id="emails">
    <div id = "emailinfo">
	<?php
	echo form_open_multipart('email_controller/sendemail');
	echo form_input('anum', set_value('anum'), $anum);
	echo form_input('fname', set_value('fname'), $first);
	echo form_input('lname', set_value('lname'), $last);
	?>
    </div>
    <div id="subject">
	<?php
	echo form_input('subject', set_value('subject'), $subject);
	?>
    </div>
    <div id="message">
	<textarea name="message" rows="3" cols="60" placeholder="Email Message (Optional)"><?php echo set_value('message') ?></textarea>
    </div>
    <div id="attachment">
	<input type="file" name="files[]" multiple />
    </div>
    <div id="sendemail">
	<?php
	echo form_submit('submit', 'Send Email');
	echo anchor('staff_controller/index', 'Return');
	echo form_close();
	?>
    </div>
</div>
<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
