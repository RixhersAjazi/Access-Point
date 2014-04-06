<?php echo validation_errors('<p class="error">'); ?>
<?php echo $success ?>
<p class="error">
    <?php echo $this->session->flashdata('emailview'); ?>
</p>

<?php
$anum = 'placeholder="A Number" autocomplete="off" id="updateanum"';
$first = 'placeholder="First Name" autocomplete="off"';
$last = 'placeholder="Last Name" autocomplete="off" ';
$email = 'placeholder="Email" autocomplete="off" id="updateemail"';
?>

<div id="updatestu">
    <div id = "findupdate">
	<?php
	echo form_open('admin_controller/updatenow');
	echo form_input('anum', set_value('anum'), $anum);
	echo form_input('fname', set_value('fname'), $first);
	echo form_input('lname', set_value('lname'), $last);
	echo form_input('email', set_value('email'), $email);
	?>
    </div>

    <div id="updatewarn">
	<h1>Please Note:</h1>
	<p>If the student does not have an A-Number in the database then you can not update student. <font color="#ff0000">However</font>, if the previous is true,  can insert the student in the database manually</p>
    </div>
    <div id="findnow">
	<?php
	echo anchor('admin_controller/index', 'Return');
	echo form_submit('submit', 'Submit');
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
