<div id="que">

<h3>Student Visits</h3>
<?php echo anchor('staff_controller/reports', 'Return'); ?>
<table id='datatables' class='display'>
                <thead>
                    <tr>

                        <th>Reason For Visit</th>
                     	<th>Number of sessions</th>
                     	<th>Average Student Visit Time</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                    foreach($reasons as $row) {
                        ?>
                        <tr>
			    <td><?php echo anchor('reports_controller/deepdown/' . urlencode($row['Reason']) . '', htmlspecialchars($row['Reason'], ENT_QUOTES, 'UTF-8', 'title="Review Students" target="_blank"')); ?></td>
                            <td><?php echo htmlspecialchars($row['Count'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['Time'], ENT_QUOTES, 'UTF-8'); ?></td>
                       </tr>
<?php
}
?>

                    </tbody>
            </table>




</div>