<div id="adminhome">
    <?php
    echo anchor('admin_controller/create_view', 'Create Account');
    echo anchor('admin_controller/activate', 'Accounts');
    echo anchor('admin_controller/updatestudent', 'Update Student');
    echo anchor('staff_controller/adminlogout', 'Log Out');
    ?>
</div>
<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
