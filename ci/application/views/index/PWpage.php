<div id="login_form">
    <h3>Change Password</h3>
    <p class='error'>
	<?php echo $this->session->flashdata('PWchange'); ?>
    </p>
    <?php
    $user = 'placeholder="Username" autocomplete="off"';
    $pass = 'placeholder="Current Password", autocomplete="off"';
    $newpass = 'placeholder="New Password (Atleast 7 Characters)", autocomplete="off"';
    $newpass1 = 'placeholder="Confirm Password", autocomplete="off"';
    $code = 'placeholder="Secret Code", autocomplete="off"';
    $passs = 'placeholder="Current Password", autocomplete="off"';

    echo validation_errors('<p class="error">');
    echo form_open('login_controller/changePW');
    echo form_input('username', set_value('username'), $user);
    echo form_password('currentpass', '', $passs);
    echo form_password('password', '', $newpass);
    echo form_password('passconf', '', $newpass1);
    echo form_password('code', '', $code);
    echo form_submit('submit', 'Change Password');
    echo anchor('login_controller/index', 'Return');
    ?>
</div>
<div id="footer">
    <p>
	Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
	<br>
	<strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
    </p>
</div>
