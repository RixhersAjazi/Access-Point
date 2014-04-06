<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<title>Access Point</title>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/mainstyle.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/secondarystyles.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>javascript/themes/smoothness/jquery-ui-1.8.4.custom.css"/>
	<style type="text/css">
	    .no-close .ui-dialog-titlebar-close {
		display: none;
	    }
	</style>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/jquery-ui-1.10.2.custom.js" type="text/javascript"></script>
	<script type="text/javascript">
	    $(document).ready(function() {
		var Form = $("#signinform");
		$(function() {
		    $("#dialog-confirm").dialog({
			resizable: false,
			autoOpen: false,
			dialogClass: "no-close",
			draggable: false,
			height: 320,
			width: 500,
			modal: true,
			buttons: {
			    'Cancel': function() {
				$(this).dialog("close");
				Form.data("confirmProgress", false);
			    },
			    'Submit Information': function() {
				Form.submit();
				Form.data("confirmProgress", false);
			    }
			}
		    });
		});
		Form.submit(function() {
		    if (!$(this).data("confirmProgress")) {
			$(this).data("confirmProgress", true);
			$('#dialog-confirm').dialog('open');
			return false;
		    } else {
			return true;
		    }

		});
	    });
	    $(document).on('click', "#Cancel", function(e)
	    {
		e.preventDefault();
		var href = '<?php echo base_url(); ?>studentlogin_controller/studentlogin';
		$("#dialog-noconfirm").dialog({
		    resizable: false,
		    dialogClass: "no-close",
		    draggable: false,
		    height: 320,
		    width: 500,
		    modal: true,
		    buttons: {
			"Cancel": function() {
			    $(this).dialog("close");
			},
			"Go Back": function() {
			    window.location.href = href;
			},
		    }
		});
	    });
	</script>
    </head>
    <body>
	<div id="wrapper">
	    <p class='error'>
		<?php echo $this->session->flashdata('signin_info'); ?>
	    </p>
	    <div id="signin_info">
		<ul>
		    <h3>
			<li>Photo ID is <strong><FONT color="#ff0000">MANDATORY</FONT></strong></li>
			<br />
			<li>All documents must be copies</li>
			<br />
			<li>All copies must be signed</li>
			<br />
			<li>Please Have A Number On All Documents</li>
			<br>
			<li>Your SUNY Orange email is the official means of communication</li>
		    </h3>
		    <h2><FONT COLOR="#ff0000">Important:</FONT></h2>
		</ul>
	    </div>
	    <?php echo form_open('studentlogin_controller/agree', 'id="signinform"') ?>
	    <input type="checkbox" id="agree" name="options" value="agree"<?php echo form_checkbox('options', 'agree') ?>I have read and understood the above <br /> <font color="#ff0000" size="2">(Please click on the box if you agree to meet all requirements)<br />(If not please do not submit, click "Cancel" and follow the prompt)</font></input>
	    <br />
	    <br />
	    <br />
	    <?php
	    echo anchor('studentlogin_controller/studentlogin', 'Cancel', 'id="Cancel"');
	    echo form_submit('Submit', 'Submit Information');
	    echo form_close();
	    ?>

	    <div id="dialog-confirm" title="Please Confirm" style="display: none;">
		<ul>
		    <li>By clicking <FONT COLOR="red">"Submit Information"</FONT> counselors will be notified that you are here - please take a seat</li>
		    <br>
		    <li>If You click <FONT COLOR="red">"Cancel"</FONT> you will not be inserted into the <FONT COLOR="red">Student Queue</FONT></li>
		</ul>
	    </div>
	    <div id="dialog-noconfirm" title="Please Confirm" style="display: none;">
		<ul>
		    <li>By clicking <FONT COLOR="red">"Go Back"</FONT> your information will be removed from the current session</li>
		    <br>
		    <li>If You click <FONT COLOR="red">"Cancel"</FONT> your information will still be active and you will stay on the current page</li>
		</ul>
	    </div>
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
