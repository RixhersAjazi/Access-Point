<div id="que">

<h3>Student Wait Time To See Counselor</h3>
<?php echo anchor('staff_controller/reports', 'Return'); ?>
<table id='datatables' class='display'>
                <thead>
                    <tr>

                        <th>Date</th>
                      	<th>A Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Counselor Name</th>
                        <th>Reason For Visit</th>
                        <th>Wait For Counselor</th>
                        <th>Time With Counselor</th>
                        <th>Total Time</th>

                    </tr>
                </thead>
                <tbody>
                 <?php
                    foreach($performance as $row) {
                        ?>
                        <tr>
			    <td><?php echo htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo anchor('studenthistory_controller/history/' . urlencode($row['anum']) . '', htmlspecialchars($row['anum'], ENT_QUOTES, 'UTF-8'), 'title="Find Student" target="_blank"') ?></td>
                            <td><?php echo htmlspecialchars($row['first'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['last'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['fname'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8'); ?></td>
			    <td><?php echo htmlspecialchars($row['start'], ENT_QUOTES, 'UTF-8'); ?></td>
			    <td><?php echo htmlspecialchars($row['Time With Counselor'], ENT_QUOTES, 'UTF-8'); ?></td>
			    <td><?php echo htmlspecialchars($row['total'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
<?php
}
?>

                    </tbody>
            </table>




</div>