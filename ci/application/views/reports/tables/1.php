<div id="que">

    <h3>Total Time In Office For Students</h3>
    <?php echo anchor('staff_controller/reports', 'Return'); ?>
    <table id='datatables' class='display'>
	<thead>
	    <tr>
		<th>Date</th>
		<th>A Number</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Reason For Visit</th>
		<th>Total Time</th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    foreach ($totalwait as $row) {
		?>
    	    <tr>
    		<td><?php echo htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo anchor('studenthistory_controller/history/' . urlencode($row['anum']) . '', htmlspecialchars($row['anum'], ENT_QUOTES, 'UTF-8'), 'title="Find Student" target="_blank"') ?></td>
    		<td><?php echo htmlspecialchars($row['first'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($row['last'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8'); ?></td>
    	    </tr>
		<?php
	    }
	    ?>

	</tbody>
    </table>




</div>