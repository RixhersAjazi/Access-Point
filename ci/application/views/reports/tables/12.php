<div id="que">

<h3>Student Status Averages</h3>
<?php echo anchor('staff_controller/reports', 'Return'); ?>
<table id='datatables' class='display'>
                <thead>
                    <tr>
                        <th>Status Description</th>
                        <th>Totals</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                    foreach($status as $row) {
                        ?>
                        <tr>
                <td><?php echo anchor('reports_controller/deepdown/status-' . urlencode($row['state']) . '', htmlspecialchars($row['state'], ENT_QUOTES, 'UTF-8', 'title="Review Students" target="_blank"')); ?></td>
                <td><?php echo htmlspecialchars($row['count'], ENT_QUOTES, 'UTF-8'); ?></td>
                 </tr>
<?php
}
?>

                    </tbody>
            </table>




</div>