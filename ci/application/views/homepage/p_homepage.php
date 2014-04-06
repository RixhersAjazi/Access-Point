<div id="president">
    <?php
    echo anchor('staff_controller/reports', 'Reporting Tools');
    echo anchor('staff_controller/graphs', 'Charts / Graphs');
    echo anchor('email_controller/emailview', 'Email System');
    echo anchor('login_controller/logout', 'Log Out');
    ?>
</div>
<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
