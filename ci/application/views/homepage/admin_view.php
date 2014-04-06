<div id="adminhomepage">
    <?php
    echo anchor('studentlogin_controller/studentlogin', 'Sign In Page', 'target="_blank"');
    echo anchor('studentqueue_controller/index', 'Student Queue');
    echo anchor('staff_controller/reports', 'Reports');
    echo anchor('email_controller/emailview', 'Email System');
    echo anchor('studenthistory_controller/index', 'Student History');
    echo anchor('staff_controller/admin_login', 'Admin Panel');
    ?>
</div>
<div id="logout">
    <?php echo anchor('login_controller/logout', 'Log Out'); ?>
</div>
<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
