<div id="terminate_form">
    <?php echo validation_errors('<p class="error">'); ?>
    <br>
    <h3>Terminate Session</h3>
    <div id="termination">
	<fieldset><legend>Name</legend>
	    <?php
	    $fname = 'placeholder="Counselor First Name" autocomplete="off"';
	    $lname = 'placeholder="Counselor Last Name" autocomplete="off"';

	    echo form_open('studentqueue_controller/terminate/' . urlencode($this->uri->segment(3)) . '');
	    echo form_input('fname', set_value('fname'), $fname);
	    echo form_input('lname', set_value('lname'), $lname);
	    ?>
	</fieldset>
	<fieldset><legend>Reason For Termination</legend>
	    <textarea name="terminationcomments" rows="5" cols="38" placeholder="Comments"><?php echo set_value('terminationcomments') ?></textarea>
	    <?php echo form_submit('submit', 'Send');
	    echo anchor('studentqueue_controller/index', 'Return');
	    ?>
	</fieldset>
    </div>
</div>
<div id="report_footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
