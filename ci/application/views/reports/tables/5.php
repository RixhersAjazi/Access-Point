<div id="que">

<h3>Student Aid Year Visits</h3>
<?php
    echo anchor('staff_controller/reports', 'Return');
    echo " ";
    echo anchor('reports_controller/deepdown/1', 'Monthly Total');
    echo " ";
    echo anchor('reports_controller/deepdown/2', 'Weekly Total');
?>

<table id='datatables' class='display'>
                <thead>
                    <tr>
                     	<th>Number of sessions</th>
                     	<th>Acedmic Year</th>
                     	<th>Total Time</th>
                        <th>First Day</th>
                        <th>Month Of Visit</th>
                        <th>Year Of Visit</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                    foreach($avgperformance as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Visits'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo anchor('reports_controller/deepdown/' . urlencode($row['Aid Year']) . '', htmlspecialchars($row['Aid Year'], ENT_QUOTES, 'UTF-8', 'title="Review Students" target="_blank"')); ?></td>
                            <td><?php echo htmlspecialchars($row['Time'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['FIRST DAY'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['MONTH'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['YEAR'], ENT_QUOTES, 'UTF-8'); ?></td>
                       </tr>
<?php
}
?>

                    </tbody>
            </table>




</div>
