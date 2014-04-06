<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/install.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			if ($("#add").is(":checked")) {
				$(".forms").show("fast");
			} else {
				$(".forms").css("display", "none");
			}

			if ($("#datatables tr > td:contains(9999)").length !== 0) {
				if ($(".noinfo").is(":checked")) {
					$("#additional_couns").hide("fast");
					$(".hungup").hide("fast");
					$(".action").hide("fast");
					$(".upd").prop('checked', false);
					$("#updateDIV").hide("fast");
					$("#noInfoComs").show("fast");
					$("#onlyother").prop("checked", false);
                    $("#add").prop("checked", false);
                    $(".form").hide("fast");
                    $(".form1").hide("fast");
				} else {
					$("#additional_couns").show("fast");
					$(".action").show("fast");
					$(".upd").prop('checked', true);
					$(".hungup").show("fast");
					$("#updateDIV").show("fast");
					$("#noInfoComs").hide("fast");
				}
				if ($(".hungup").is(":checked")) {
					$(".upd").prop('checked', false);
					$(".upd").css("display", "none");
					$("#phone").prop('checked', false);
					$("#additional_couns").css("display", "none");
					$(".action").css("display", "none");
					$("#onlyother").prop("checked", false);
                    $("#add").prop("checked", false);
                    $(".form").hide("fast");
                    $(".form1").hide("fast");
				} else {
					$(".upd").prop('checked', true);
					$("#phone").prop('checked', true);
					$(".upd").css("display", "none");
					$("#additional_couns").show("fast");
					$(".action").show("fast");
				}
			} else {
				$(".noinfo").css("display", "none");
				$("#noInfoComs").css("display", "none");
				$(".hungup").css("display", "none");
			}

			if ($("#onlyother").is(":checked")) {
				$("#counselorcomments").show("fast");
				$("#officecomments").css("display", "none");
				$("#emailcomments").css("display", "none");
			} else {
				$("#counselorcomments").css("display", "none");
			}

			if ($("#add").is(":checked") && $("#addother").is(":checked")) {
				$("#emailcomments").show("fast");
			} else {
				$("#emailcomments").css("display", "none");
			}

			if ($("#add").is(":checked") && $("#officenotes").is(":checked")) {
				$("#officecomments").show("fast");
			} else {
				$("#officecomments").css("display", "none");
			}

			if ($(".upd").is(":checked")) {
				$("#updateDIV").show("fast");
			} else {
				$("#updateDIV").css("display", "none");
			}

			$(".action").click(function() {
				if ($("#add").is(":checked")) {
					$(".forms").show("fast");
				} else {
					$(".forms").hide("fast");
				}
				if ($("#onlyother").is(":checked")) {
					$("#counselorcomments").show("fast");
					$("#officecomments").hide("fast");
					$("#emailcomments").hide("fast");
				} else {
					$("#counselorcomments").hide("fast");
				}
			});

			$(".form").click(function() {
				if ($("#addother").is(":checked")) {
					$("#emailcomments").show("fast");
				} else {
					$("#emailcomments").hide("fast");
				}

				if ($("#officenotes").is(":checked")) {
					$("#officecomments").show("fast");
				} else {
					$("#officecomments").hide("fast");
				}
			});

			$(".hungup").click(function() {
				if ($(".hungup").is(":checked")) {
					$(".upd").prop('checked', false);
					$("#updateDIV").hide("fast");
					$("#phone").prop('checked', false);
					$("#additional_couns").hide("fast");
					$(".action").prop(":checked", false);
					$(".action").hide("fast");
					$(".noinfo").hide("fast");
					$("#noInfoComs").css("display", "none");
					$("#onlyother").prop("checked", false);
					$("#add").prop("checked", false);
					$(".form").hide("fast");
					$(".form1").hide("fast");
				} else {
					$(".upd").prop('checked', true);
					$("#updateDIV").show("fast");
					$("#phone").prop('checked', true);
					$("#additional_couns").show("fast");
					$(".action").show("fast");
					$(".noinfo").show("fast");
				}
			});

			$(".noinfo").click(function() {
				if ($(".noinfo").is(":checked")) {
					$("#additional_couns").hide("fast");
					$(".hungup").hide("fast");
					$(".action").hide("fast");
					$(".upd").prop('checked', false);
					$("#updateDIV").hide("fast");
					$("#noInfoComs").show("fast");
					$("#onlyother").prop("checked", false);
                    $("#add").prop("checked", false);
                    $(".form").hide("fast");
                    $(".form1").hide("fast");
				} else {
					$("#additional_couns").show("fast");
					$(".action").show("fast");
					$(".upd").prop('checked', true);
					$(".hungup").show("fast");
					$("#updateDIV").show("fast");
					$("#noInfoComs").hide("fast");
				}
			});

			$(".upd").click(function() {
				if ($(".upd").is(":checked")) {
					$("#updateDIV").show("fast");
				} else {
					$("#updateDIV").hide("fast");
				}
			});
		});
	</script>
	<style type="text/css">
	   @import "<?php echo base_url(); ?>javascript/css/demo_table_jui.css";
	   @import "<?php echo base_url(); ?>javascript/themes/smoothness/jquery-ui-1.8.4.custom.css";
	</style>
	<style type="text/css">
		* {
			font-family: arial;
		}
		a {
			text-decoration: none;
		}
		textarea::-webkit-input-placeholder {
			color: #ff0000;
			font-weight: bolder;
		}

		input::-webkit-input-placeholder {
			color: #ff0000;
			font-weight: bolder;
		}
		.form {
			display: inline-block;
			width: 200px;
			margin-left: 10px;
			padding: 1px;
			color: #000000;
		}
		#updateDIV {
			display: inline-block;
			margin-left: 150px;
		}

		#updateDIV input {
			padding: 5px;
		}

		.form1 {
			margin-top: 10px;
			display: inline-block;
			width: 250px;
			margin-left: 235px;
		}

		#form1 {
			display: block;
			width: 245px;
		}

		#form {
			display: block;
			width: 90px;
		}

		#actions {
			display: inline-block;
			width: 220px;
		}

		.action {
			display: block;
		}

	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<title>Access Point Student Queue</title>
    </head>
    <body>
	<font color="#ff0000">
	    <?php echo validation_errors('<p class="error">'); ?>
	</font>
	<?php echo $error ?>
	<table id='datatables' class='display'>
	    <thead>
		<tr>
		    <th>Session ID</th>
		    <th>A Number</th>
		    <th>First Name</th>
		    <th>Last Name</th>
		    <th>Reason for visit</th>
		    <th>Comments</th>
		    <th>Staff Comments</th>
		    <th>Aid Year</th>
		    <th>Staff Member</th>
		</tr>
	    </thead>
	    <tbody>
		<?php 
		  foreach ($counsview as $row) {
		    ?>
		    <tr>
    		    <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo anchor('studenthistory_controller/history/' . urlencode($row['anum']) . '', htmlspecialchars($row['anum'], ENT_QUOTES, 'UTF-8'), 'title="Find Student" target="_blank"') ?></td>
    		    <td><?php echo htmlspecialchars($row['first'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['last'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['studentcomments'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['counselorcomments'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['aidyear'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['fname'], ENT_QUOTES, 'UTF-8') ?></td>

			<?php
            }
		    ?>
	    </tbody>
	</table>
	
	<?php echo form_open('studentqueue_controller/input/' . urlencode($row['id']) . '/' . urlencode($row['anum']) . ''); ?>
	<div id="actions">
	    <label><input type="checkbox" id="phone" name="phone" value ="yes" style="display:none;"/></label>
        <label class ="clas3"><input type="checkbox" name="no_info" value="yes" class="noinfo" <?php echo set_checkbox('no_info', 'yes'); ?>/><font color="#ff0000" size="2" class="noinfo"><strong>No Information Provided</strong></font></label>
        <br>
	    <label class ="class2"><input type="checkbox" name="hung" value="yes" class="hungup" <?php echo set_checkbox('hung', 'yes'); ?>/><font color="#ff0000" size="2" class="hungup"><strong>Student Hung Up</strong></font></label>
	    <label class ="class1"><input type="checkbox" name="update" value="yes" class="upd" <?php echo set_checkbox('update', 'yes'); ?>/><font color="#ff0000" size="2" class="upd"><strong>Update Student Info</strong></font></label>
	    <label class ="action"><input type="radio" name="action" value="Additional" id="add" <?php echo set_radio('action', 'Additional'); ?>/><font color="#ff0000" size="2"><strong>Additional Info Requested</strong></font></label>
	    <label class ="action"><input type="radio" name="action" value="Complete Ready For Packaging" <?php echo set_radio('action', 'Complete Ready For Packaging'); ?>/><font color="#ff0000" size="2"><strong>Complete Ready For Packaging</strong></font></label>
	    <label class ="action"><input type="radio" name="action" value="Deferment Given"  <?php echo set_radio('action', 'Deferment Given'); ?>/><font color="#ff0000" size="2"><strong>Deferment Given</strong></font></label>
	    <label class ="action"><input type="radio" name="action" value="Packaged" <?php echo set_radio('action', 'Packaged'); ?>/><font color="#ff0000" size="2"><strong>Packaged</strong></font></label>
	    <label class ="action"><input type="radio" name="action" value="Other" id="onlyother" <?php echo set_radio('action', 'Other'); ?>/><font color="#ff0000" size="2"><strong>Other</strong></font></label>
	</div>
	<div class="form">
	    <fieldset class="forms"><legend>Info Requested</legend>

		<?php foreach ($first10 as $form) {
		    ?>
    		<label id="form"><input type="checkbox" name="form[]" value="<?php echo $form['form_id'] ?>" <?php echo set_checkbox('form', $form['form_id']) ?>><?php echo $form['forms'] ?></label>
		    <?php
            }
		?>

	    </fieldset>
	</div>
	<div class="form">
	    <fieldset class="forms"><legend>Info Requested</legend>
		<?php foreach ($elevennine as $form) {
		    ?>
    		<label id="form"><input type="checkbox" name="form[]" value="<?php echo $form['form_id'] ?>" <?php echo set_checkbox('form', $form['form_id']) ?>><?php echo $form['forms'] ?></label>
		    <?php
            }
		?>
		<br>
	    </fieldset>
	</div>
	<div class="form">
	    <fieldset class="forms"><legend>Info Requested</legend>
		<?php foreach ($twenty5 as $form) {
		    ?>
    		<label id="form"><input type="checkbox" name="form[]" value="<?php echo $form['form_id'] ?>" <?php echo set_checkbox('form', $form['form_id']) ?>><?php echo $form['forms'] ?></label>
		    <?php
            }
		?>

		<label id="form"><input type="checkbox" name="form[]" value="26" <?php echo set_checkbox('form', '26') ?>>T4A</label>
		<label id="form"><input type="checkbox" name="form[]" value="27" <?php echo set_checkbox('form', '27') ?>>SAA</label>
		<label id="form"><input type="checkbox" name="addother" value="addotherinfo" id="addother" <?php echo set_checkbox('addother', 'addotherinfo') ?>>Other</label>
		<label id="form"><input type="checkbox" name="office" value="notes" id="officenotes" <?php echo set_checkbox('office', 'notes') ?>>Office</label>
	    </fieldset>
	</div>
	<div class="form">
	    <fieldset class="forms"><legend>Info Requested</legend>
		<?php foreach ($twen87 as $form) {
		    ?>
    		<label id="form"><input type="checkbox" name="form[]" value="<?php echo $form['form_id'] ?>" <?php echo set_checkbox('form', $form['form_id']) ?>><?php echo $form['forms'] ?></label>
		    <?php
            }
		?>
	    </fieldset>
	</div>
	<div class="form1">
	    <fieldset class="forms"><legend>Checklists Given</legend>
		<?php foreach ($checklists as $form) { ?>
    		<label id="form1"><input type="checkbox" name="form[]" value="<?php echo $form['form_id'] ?>" <?php echo set_checkbox('form', $form['form_id']) ?>><?php echo $form['forms'] ?></label>
		<?php } ?>
	    </fieldset>
	</div>
	<br />
	<textarea name="emailcomments" rows="5" cols="40" id="emailcomments" placeholder="Email Comments"><?php echo set_value('counselorcomments') ?></textarea>
	<br />
	<textarea name="counselorcomments" rows="5" cols="40" id="counselorcomments" placeholder="Counselor Comments"><?php echo set_value('counselorcomments') ?></textarea>
	<br />
	<textarea name="officecomments" rows="5" cols="40" id="officecomments" placeholder="Office Comments"><?php echo set_value('officecomments') ?></textarea>
	<br />
	<textarea name="noinfo_comms" rows="5" cols="40" id="noInfoComs" placeholder="Why was no information provided?"><?php echo set_value('noinfo_comms') ?></textarea>
	<br />
	<?php echo form_submit('finish', 'Finish Session'); ?>
	<br />
	<?php echo form_submit('additional', 'Needs Additional Counseling', 'id="additional_couns"'); ?>
	<br />
	<?php echo anchor('studentqueue_controller/index', 'Return To Queue'); ?>
<br>
<div id="updateDIV">
    <?php
    $anum = 'placeholder="A-Number" autocomplete="off"';
    $fname = 'placeholder="First Name" autocomplete="off"';
    $lname = 'placeholder="Last Name" autocomplete="off"';
    $email = 'placeholder="Email (Optional)" autocomplete="off"';

    echo form_input('anum', set_value('anum'), $anum);
    echo form_input('fname', set_value('fname'), $fname);
    echo form_input('lname', set_value('lname'), $lname);
    echo form_input('email', set_value('email'), $email);
    ?>
    <select name="aidyear">
        <option value="" <?php echo set_select('aidyear', "", TRUE) ?> >Choose Aid-Year</option>
        <option value="12-13" <?php echo set_select('aidyear', '12-13'); ?> >12-13</option>
        <option value="13-14" <?php echo set_select('aidyear', '13-14'); ?> >13-14</option>
        <option value="14-15" <?php echo set_select('aidyear', '14-15'); ?> >14-15</option>
    </select>
    <select name="reasons">
            <option value="">Choose Reason</option>
        <?php foreach ($reasons as $r) { ?>
            <option value="<?php echo $r['reason_id'] ?>"<?php echo set_select('reasons', $r['reason_id'])?>><?php echo $r['reason'] ?></option>
        <?php } ?>    
    </select>
    <?php
    echo form_close();
    ?>
    </div>
    </body>
</html>
