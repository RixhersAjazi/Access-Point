<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
	    $(document).ready(function() {
		$("#and").click(function() {
		    $("#totalselect option:selected").appendTo("#select-and");
		});
		$("#or").click(function() {
		    $("#totalselect option:selected").appendTo("#select-or");
		});
		$("#removeand").click(function() {
		    $("#select-and option:selected")
			    .removeAttr("selected")
			    .appendTo("#totalselect");
		});
		$("#removeor").click(function() {
		    $("#select-or option:selected")
			    .removeAttr("selected")
			    .appendTo("#totalselect");
		});
	    });
	</script>
	<style type="text/css">
	    .selectnew {width: 230px; line-height: 1.5em; padding: 3px;}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/mainstyle.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/secondarystyles.css" type="text/css"/>
	<title>Access Point Mass Email</title>
    </head>
    <body>
	<?php echo validation_errors('<p class="error">'); ?>
	<?php echo $error ?>
	<p class="error">
	    <?php echo $this->session->flashdata('emailview'); ?>
	</p>
	<?php
	$options = array('' => 'Select Year', '2012' => '2012', '2013' => '2013', '2014' => '2014');
	$options1 = array(
	    '' => 'Select Month',
	    '01' => 'January',
	    '02' => 'Feburary',
	    '03' => 'March',
	    '04' => 'April',
	    '05' => 'May',
	    '06' => 'June',
	    '07' => 'July',
	    '08' => 'August',
	    '09' => 'September',
	    '10' => 'October',
	    '11' => 'November',
	    '12' => 'December');

	$options2 = array('' => 'Pick Day', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9',
	    '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18',
	    '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '27', '28' => '28',
	    '29' => '29', '30' => '30', '31' => '31');
	$options3 = array('12-13' => '12-13', '13-14' => '13-14', '14-15' => '14-15');

	$options5 = array('3' => 'Finished', '4' => 'Student Left', '5' => 'Terminated', '6' => 'Abandoned');
	$info = array('Additional' => 'Forms Given', 'Complete Ready For Packaging' => 'Ready For Packaging', 'Deferment Given' => 'Deferment', 'Packaged' => 'Packaged');
	$option6 = array('' => '', '=' => 'Equal To', '>' => 'Greater Than', '>=' => 'Greater Than Or Equal To', '<' => 'Less Than', '<=' => 'Less Than Or Equal To');
	$option7 = array('' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10');
	?>
	<div id="emaillinks">
	    <?php echo anchor('reports_controller/dynamic', 'Dynamic Reports', 'id="currentemail"'); ?>
	    <?php echo anchor('reports_controller/formsgiven', 'Forms Overview'); ?>
	</div>
	<div id="emails">
	    <?php echo form_open_multipart('reports_controller/dynamic_reporting', 'id="form"'); ?>

	    <div id="emaildate1">
		<fieldset><legend>Date One</legend>
		    <?php echo form_dropdown('year1', $options, '') ?>
		    <?php echo form_dropdown('month1', $options1, '') ?>
		    <?php echo form_dropdown('day1', $options2, ''); ?>
		</fieldset>
	    </div>
	    <p class ="error"><strong>Between</strong>
	    <div id="emaildate2">
		<fieldset><legend>Date Two</legend>
		    <?php echo form_dropdown('year2', $options, '') ?>
		    <?php echo form_dropdown('month2', $options1, '') ?>
		    <?php echo form_dropdown('day2', $options2, ''); ?>
		</fieldset>
	    </div>
	    <div id="mass_options">
		<a href="JavaScript:void(0);" id="and">And</a>
		<a href="JavaScript:void(0);" id="or">Or</a>
		<select name="totalselect" id="totalselect" multiple size="5">
		    <?php foreach ($options3 as $key => $value) { ?>
    		    <option value="aidyear_<?php echo $key ?>">Aid Year: <?php echo $value ?>
    		<?php } ?>
		    <option value="noemail">No Email</option>
		    <option value="yesemail">With Email</option>
		    <?php foreach ($reasons as $r) { ?>
    		    <option value="reason_<?php echo $r['reason_id'] ?>">Reason: <?php echo $r['reason'] ?></option>
		    <?php } ?>
		    <?php foreach ($options5 as $key => $value) { ?>
    		    <option value="status_<?php echo $key ?>">Session Status: <?php echo $value ?></option>
		    <?php } ?>
		    <?php foreach ($info as $key => $value) { ?>
    		    <option value="action_<?php echo $key ?>">Action: <?php echo $value ?></option>
		    <?php } ?>
		</select>
	    </div>

	    <select name="and[]" id="select-and" multiple size="5" class="selectnew">
	    </select>
	    <select name="or[]" id="select-or" multiple size="5" class="selectnew">
	    </select>
	    <br>
	    <br>
	    <a href="JavaScript:void(0);" id="removeand">Remove And</a>
	    <a href="JavaScript:void(0);" id="removeor">Remove Or</a>

	    <div id="count">
		<select name="operator">
		    <?php foreach ($option6 as $key => $value) { ?>
    		    <option value="<?php echo $key ?>"<?php echo set_select('operator', $key); ?>><?php echo $value ?></option>
		    <?php } ?>
		</select>
		<select name="count">
		    <?php foreach ($option7 as $key => $value) { ?>
    		    <option value="<?php echo $key ?>" <?php echo set_select('count', $key); ?>><?php echo $value ?></option>
		    <?php } ?>
		</select>
	    </div>


	    <div id="masssendemail">
		<?php
		echo form_submit('submit', 'Next', 'id="next"');
		echo anchor('staff_controller/reports', 'Return');
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
