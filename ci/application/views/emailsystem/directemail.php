<?php echo validation_errors('<p class="error">'); ?>
<?php echo $error ?>
<p class="error">
    <?php echo $this->session->flashdata('emailview'); ?>
</p>

<?php
$email = 'placeholder="Email" autocomplete="off"';
$subject = 'placeholder="Email Subject" autocomplete="off"';
?>

<div id="emaillinks">
    <?php echo anchor('email_controller/emailview', 'Find Student'); ?>
    <?php echo anchor('email_controller/directemail', 'Direct Email', 'id="currentemail"'); ?>
</div>

<div id="emails">
    <div id = "out_email">
	<?php
	echo form_open_multipart('email_controller/outside_email');
	echo form_input('out_email', set_value('out_email'), $email);
	?>
    </div>
    <div id="subject">
	<?php
	echo form_input('out_subject', set_value('out_subject'), $subject);
	?>
    </div>
    <div id="message">
	<textarea name="out_message" rows="3" cols="60" placeholder="Email Message (Optional)"><?php echo set_value('out_message') ?></textarea>
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
