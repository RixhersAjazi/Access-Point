<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<title>Access Point</title>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/mainstyle.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/secondarystyles.css" type="text/css"/>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var why = $('input[name=why]:checked').val();
			var why1 = $('input[name=why1]:checked').val();

			if ($("#current").is(":checked")) {
				$("#anum").css("display", "none");
			} else {
				$("#anum").show("fast");
			}

			if ($(".phone").is(":checked")) {
				$("#phoneline").show("fast");
			} else {
				$("#phoneline").css("display", "none");
			}

			if ($("#push_through").is(":checked")) {
				$(".hide").css("display", "none");
				$("#aidset").css("display", "none");
				$(".reason").css("display", "none");
				$("#phoneline").show("fast");
				$(".phone").css("display", "none");
			} else {
				$(".hide").show("fast");
				$("#aidset").show("fast");
				$(".reason").show("fast");
				$("#phoneline").css("display", "none");
				$(".phone").show("fast");
			}

			$("#push_through").click(function() {
				if ($("#push_through").is(":checked")) {
					$(".hide").hide("fast");
					$("#aidset").hide("fast");
					$(".reason").hide("fast");
					$("#phoneline").show("fast");
					$(".phone").hide("fast");
				} else {
					$(".hide").show("fast");
					$("#aidset").show("fast");
					$(".reason").show("fast");
					$("#phoneline").hide("fast");
					$(".phone").show("fast");
				}
			});

			$(".phone").click(function() {
				if ($(".phone").is(":checked")) {
					$("#phoneline").show("fast");
				} else {
					$("#phoneline").hide("fast");
				}
			});
			if (why !== '12') {
				$("#extrareason").css("display", "none");
			}
			if ((why1 !== '20') && (why !== 12)) {
				$("#comments").css("display", "none");
			} else {
				$("#comments").show("fast");
			}
			if ((why1 !== '14') && (why !== 12)) {
				$("#appointment").css("display", "none");
			}
			$("#current").click(function() {
				if ($("#current").is(":checked")) {
					$("#anum").hide("fast");
				} else {
					$("#anum").show("fast");
				}
			});
			$(".why").click(function() {
				var why = $('input[name=why]:checked').val();
				var why1 = $('input[name=why1]:checked').val();
				if (why > 11) {
					$("#extrareason").show("fast");
				} else {
					$("#extrareason").hide("fast");
				}
				if ((why1 === '20') && (why === '12')) {
					$("#comments").show("fast");
				} else {
					$("#comments").hide("fast");
				}
				if ((why1 === '14') && (why === '12')) {
					$("#appointment").show("fast");
				} else {
					$("#appointment").hide("fast");
				}
			});
		});
	</script>
    </head>
    <body>
	<div id="wrapper">
	    <div id="header"><img src="<?php echo base_url(); ?>images/masterheader.jpg"></div>

	    <?php echo validation_errors('<p class="error">'); ?>
	    <p class='error'>
		<?php echo $this -> session -> flashdata('studenterror'); ?>
	    </p>
	    <br />
	    <div id="personalinfo">
		<fieldset><legend>Personal Information</legend>
		    <?php
            $anum = 'placeholder="Student A-Number" autocomplete="off" id="anum" class = "hide"';
            $fname = 'placeholder="First Name" autocomplete="off" class = "hide"';
            $lname = 'placeholder="Last Name" autocomplete="off" class = "hide"';
            $email = 'placeholder="Email" autocomplete="off" id="email" class = "hide"';
            $options = array('' => 'Choose Phone Line', '4190/97' => '4190/97', '4191' => '4191', '4192' => '4192', '4193' => '4193', '4196' => '4196', '4210' => '4210', '4121' => '4121', '4656' => '4656');

            echo form_open('studentlogin_controller/validstudent');
		    ?>

		    <font class="phone" color="#ff0000" size="2">Check Box If You Do Not Have An A-Number</font><input type="checkbox" name="student" value="yes" id="current" class = "hide" <?php echo set_checkbox('student', 'yes'); ?>/>
		    <br>
		    <font color="#ff0000" size="2">Put on hold</font><input type="checkbox" name="push" value="yes" id="push_through" <?php echo set_checkbox('push', 'yes'); ?>/>
		    <?php
            echo form_input('anum', set_value('anum'), $anum);
            echo form_input('fname', set_value('fname'), $fname);
            echo form_input('lname', set_value('lname'), $lname);
            echo form_input('email', set_value('email'), $email);
		    ?>
		    <font class="phone" color="#ff0000" size="2">If student is on the phone check box</font><input type="checkbox" name="phone" value="yes" class="phone" <?php echo set_checkbox('phone', 'yes'); ?>/>
		    <br>
		    <select name="phoneline" id="phoneline">
			<?php foreach ($options as $key => $value) { ?>
    			<option value="<?php echo $key ?>" <?php echo set_select('phoneline', $value); ?>><?php echo $value ?></option>
			<?php } ?>
		    </select>
		</fieldset>
	    </div>
	    <div id="aidset">
		<fieldset><legend>What Aid Year Are You Inquiring About?</legend>
		    <label class="aidyear"><input type="radio" name="aidyear" value="12-13" <?php echo set_radio('aidyear', '12-13'); ?>>12-13</label>
		    <label class="aidyear"><input type="radio" name="aidyear" value="13-14" <?php echo set_radio('aidyear', '13-14'); ?>>13-14</label>
		    <label class="aidyear"><input type="radio" name="aidyear" value="14-15" <?php echo set_radio('aidyear', '14-15'); ?>>14-15</label>
		</fieldset>
	    </div>
	    <div class="reason">
		<fieldset class="reason"><legend>Choose Reason For Visit</legend>

		    <?php foreach ($reasons as $r) {
			?>

    		    <label class="why"><input type="radio" name="why" value="<?php echo $r['reason_id'] ?>" <?php echo set_radio('why', $r['reason_id']) ?>><?php echo $r['reason'] ?></label>
			<?php
            }
		    ?>
		    <label class="why"><input type="radio" name="why" value="12" <?php echo set_radio('why', '12') ?>>Additional Reasons</label>
		</fieldset>
	    </div>
	    <div id="extrareason">
		<fieldset class="extrareason"><legend>Other Reasons</legend>
		    <?php foreach ($reasons1 as $r) { ?>

    		    <label class="why"><input type="radio" name="why1" value="<?php echo $r['reason_id'] ?>" <?php echo set_radio('why1', $r['reason_id']) ?>><?php echo $r['reason'] ?></label>

		    <?php } ?>
		</fieldset>
	    </div>
	    <div id="comments">
		<fieldset><legend>Comments</legend>
		    <textarea name="comments" rows="5" cols="24" placeholder="Only For Other!"><?php echo set_value('comments') ?></textarea>
		</fieldset>
	    </div>
	    <div id="appointment">
		<fieldset><legend>Only For<font color="#ff0000"><strong> Appointments</strong></font></legend>
		    <?php
            $options1 = array('' => 'Hour', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12');

            $options2 = array('' => 'Minute', '00' => '00', '15' => '15', '30' => '30', '45' => '45');
		    ?>
		    <select name="counselor">
			<option value="">Choose Counselor</option>
			<?php foreach ($staff as $s) { ?>
    			<option value="<?php echo $s['fname'] ?>" <?php echo set_select('counselor', $s['fname']) ?>><?php echo '' . $s['fname'] . ' ' . $s['lname'] . '' ?></option>
			<?php } ?>
		    </select>
		    <?php
            echo form_dropdown('hour', $options1);
            echo form_dropdown('min', $options2);
		    ?>
		</fieldset>
	    </div>
	    <div id="sendinfo"><?php echo form_submit('submit', 'Next'); ?></div>
	    <div id="signin_footer">
		<p>
		    Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
		    <br>
		    <strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
		</p>
	    </div>
	</div>
    </body>
</html>