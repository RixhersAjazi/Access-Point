<div id="que">
    <h3>Report Run On <?php echo date("F j, Y, g:i a") ?></h3>
    <?php echo anchor('reports_controller/dynamic', 'Return'); ?>
    <table id='datatables' class='display'>
	<thead>
	    <tr>
		<th>A Number</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Emails</th>
		<th>Reason</th>
		<th>Aid Year</th>
		<th>Total Visits</th>
		<th>First Visit</th>
		<th>Latest Visit</th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    foreach ($dynamic as $row) {
		?>
    	    <tr>
    		<td><?php echo anchor('studenthistory_controller/history/' . urlencode($row['anum']) . '', htmlspecialchars($row['anum'], ENT_QUOTES, 'UTF-8'), 'title="Find Student" target="_blank"') ?></td>
    		<td><?php echo htmlspecialchars($row['first'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($row['last'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($this->encrypt->decode($row['email']), ENT_QUOTES, 'UTF-8') ?></td>
    		<td><?php echo htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($row['aidyear'], ENT_QUOTES, 'UTF-8') ?></td>
    		<td><?php echo htmlspecialchars($row['Total'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($row['First'], ENT_QUOTES, 'UTF-8'); ?></td>
    		<td><?php echo htmlspecialchars($row['Last'], ENT_QUOTES, 'UTF-8'); ?></td>
    	    </tr>
		<?php
	    }
	    ?>
	</tbody>
    </table>
</div>