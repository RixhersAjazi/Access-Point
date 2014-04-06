<h3>Users</h3><?php echo anchor('admin_controller/index', 'Return');?>       
            <table id='beingseen' class='display'>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>First</th>
                        <th>Last</th>
                        <th>Register Date</th>
                        <th>Activation Status</th>
                        <th>Account Role</th>
                    </tr>
                </thead>
                <tbody>
					<?php foreach ($users as $row) { ?>
					<?php 
						$options = array("" => "", 'activate' => 'Activate Account', 'deactivate' => 'Deactivate Account'); 
						$optionroles = array("" => "", 'student' => 'Student Rights', 'staff' => 'Staff Rights', 'admin' => 'Admin Rights', 'vp' => 'Presidential Rights', 'sv' => 'StudentView');
					?>
					<tr>
						<td><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo htmlspecialchars($row['fname'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo htmlspecialchars($row['lname'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo htmlspecialchars($row['reg_data'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo 'Current Status: ' .  htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?>
							<?php echo form_open('admin_controller/activated/' .urlencode($row['username']). '/' .urlencode($row['fname']). '' ); ?>
							<?php echo form_dropdown('options', $options, ""); ?>
							<?php echo form_submit('submit', 'Submit'); ?>
							<?php echo form_close(); ?>
						</td>
						<td>
							<?php echo 'Current Role: ' . htmlspecialchars($row['Role'], ENT_QUOTES, 'UTF-8');  
							echo form_open('admin_controller/activated/' .urlencode($row['username']). '/' .urlencode($row['fname']). '' ); 
							echo form_dropdown('options', $optionroles, ""); 
							echo form_submit('submit', 'Submit');
							echo form_close(); ?>
						</td>
					</tr>
					<?php } ?>
                </tbody>
            </table>
