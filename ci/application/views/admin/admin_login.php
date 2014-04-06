<div id="login_form">
    <h3>Admin Login</h3>
    <?php
    $user = 'placeholder="Usernmame" autocomplete="off"';
    $pass = 'placeholder="Password", autocomplete="off"';

    echo validation_errors('<p class="error">');
    echo form_open('staff_controller/valid_admin');
    echo form_input('username', set_value('username'), $user);
    echo form_password('password', '', $pass);
    echo form_submit('submit', 'Login');
    echo anchor('staff_controller/index', 'Return');
    ?>
</div>
<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
