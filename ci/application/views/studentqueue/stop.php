<div id="stop_form">
    <?php echo validation_errors('<p class="error">'); ?>
    <br>
    <h3>End Session</h3>
    <div id="sessionend">
	<fieldset><legend>Reasons</legend>
	    <?php
	    $options = array("" => "", 'Not Here' => 'Student Not Here', 'Left For Class' => 'Student Left For class',);
	    echo form_open('studentqueue_controller/stop/' . urlencode($this->uri->segment(3)) . '');
	    echo form_dropdown('reason', $options, "");
	    ?>
	</fieldset>
	<fieldset><legend><input type="checkbox" name="reason" value="Other" <?php echo set_checkbox('reason', 'Other'); ?>>Other</input></legend>
	    <textarea name="stopcomments" rows="3" cols="38" placeholder="Only For Other!"><?php echo set_value('stopcomments') ?></textarea>
	    <br />
	    <?php
	    echo form_submit('submit', 'Send');
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
