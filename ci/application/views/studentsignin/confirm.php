<?php echo validation_errors('<p class="error">'); ?>
<?php echo $error ?>

<h1><font color="#ff0000">Please Read :</font></h1>

<li><p>The <font color="#ff0000">information</font> you have previously entered does not match our records.</p></li>
<li><p>For the students security and privacy this automated message has been triggered to aid in assuring that student rights are upheld!</p></li>
<li><p>Please review the following information to make sure you are the student!</p></li>
<li><p>Is your A-Number <font color="#ff0000"><strong><?php echo $info[0]['anum'] ?></strong></font>? If it is then is your name <font color="ff0000"><strong><?php echo $info[0]['first'] ?></strong></font> <font color="ff0000"><strong><?php echo $info[0]['last'] ?></strong></font>?</p></li>
<li><p>If you answered yes to both then you may proceed to the student agreement page which will give you further instructions!</p></li>
<li><p>If you <font color="#ff0000">DID NOT </font>answer yes to both please click the "Cancel" button and notify front desk personnel</p></li>

<div id="confirm_a">
    <?php echo anchor('studentlogin_controller/studentlogin', 'Cancel') ?>
    <?php echo anchor('studentlogin_controller/signin_info', 'Continue'); ?>
</div>




<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>