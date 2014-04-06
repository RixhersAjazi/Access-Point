<?php echo validation_errors('<p class="error">'); ?>
<?php echo $error ?>
<p class="error">
    <?php echo $this->session->flashdata('emailview'); ?>
</p>

<?php
$email = 'placeholder="Your Email" autocomplete="off"';
$fname = 'placeholder="First Name" autocomplete="off"';
$lname = 'placeholder="Last Name" autocomplete="off"';
$subject = 'placeholder="Subject" autocomplete="off"';
$company = 'placeholder="Company Name" autocomplete="off"';
?>

<div id="email_form">
    <?php
    echo form_open_multipart('email_controller/send');
    echo form_input('your_email', set_value('your_email'), $email);
    echo form_input('your_fname', set_value('your_fname'), $fname);
    echo form_input('your_lname', set_value('your_lname'), $lname);
    echo form_input('out_subject', set_value('out_subject'), $subject);
    echo form_input('company', set_value('company'), $company);
    ?>

    <textarea name="out_message" rows="3" cols="40" placeholder="Message"><?php echo set_value('out_message') ?></textarea>

    <br><br>

    <?php if ((isset($_SERVER['HTTP_REFERER'])) && ($_SERVER['HTTP_REFERER'] !== current_url())) { ?>
        <input name="redirect" type="hidden" value="<?php echo $_SERVER['HTTP_REFERER'] ?>"/>
	<?php
	echo anchor($_SERVER['HTTP_REFERER'], 'Return');
    }
    echo form_submit('submit', 'Send Email');
    echo form_reset('reset', 'Reset Fields');
    echo form_close();
    ?>
	<p><FONT size="2">I will reply to your email <strong>within</strong> 24 hours <br>
	    - Rixhers
	    </FONT></p>
</div>


<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
