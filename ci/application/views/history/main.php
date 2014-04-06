<?php
echo validation_errors('<p class="error">');

$anum = 'placeholder="A Number" autocomplete="off"';
$first = 'placeholder="First Name" autocomplete="off"';
$last = 'placeholder="Last Name" autocomplete="off"';
$options = array('' => 'Report (Only for A-Number)', 'all' => 'All Sessions', 'fin' => 'Finished Sessions', 'left' => 'Left Sessions', 'term' => 'Terminated Sessions', 'aba' => 'Abandoned Sessions', 'form' => 'All Forms Given');
?>
<div id="findperson">
    <br>
    <strong>Note: Using First or Last name field will select all students with matching characters</strong>
    <br>
    <div id="findstudent">
	<?php
	echo form_open('studenthistory_controller/findstudent', 'target="_blank"');
	echo form_input('anum', set_value('anum'), $anum);
	echo form_input('fname', set_value('fname'), $first);
	?>
	<?php echo form_input('lname', set_value('lname'), $last);
	?>
    </div>
    <div id="choosetable">
<?php echo form_dropdown('choosetable', $options, ''); ?>
    </div>
    <div id="findnow1">
	<?php
	echo anchor('staff_controller/index', 'Return');
	echo form_submit('submit', 'Find Student')
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
