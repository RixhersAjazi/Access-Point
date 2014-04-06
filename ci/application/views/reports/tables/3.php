<div id="que">

<h3>Average Student Wait Time To See Counselor</h3>
<?php echo anchor('staff_controller/reports', 'Return'); ?>
<table id='datatables' class='display'>
                <thead>
                    <tr>
                    	<th>Counselor Name</th>
						<th>Students Seen</th>
                        <th>Average Time For Counselor</th>
                        <th>Average Time With Counselor</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                    foreach($avgperformance as $row) {
                        ?>
                        <tr>
			    <td><?php echo htmlspecialchars($row['counselor'], ENT_QUOTES, 'UTF-8'); ?></td>
			    <td><?php echo htmlspecialchars($row['students'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['AVG Wait Time'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['AVG Session Length'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
<?php
}
?>

                    </tbody>
            </table>




</div>