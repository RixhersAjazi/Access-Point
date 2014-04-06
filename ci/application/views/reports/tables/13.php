<div id="que">

<h3>Total Phone Calls</h3>
<?php echo anchor('staff_controller/reports', 'Return'); ?>
<table id='datatables' class='display'>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Student ID</th>
                        <th>Reason</th>
                        <th>Aid Year</th>
                        <th>Phone Line</th>
                        <th>Staff Comments</th>
                        <th>Session Status</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                    foreach($phone as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['signintime'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo anchor('studenthistory_controller/history/' . urlencode($row['anum']) . '', htmlspecialchars($row['anum'], ENT_QUOTES, 'UTF-8'), 'title="Find Student" target="_blank"') ?></td>
                            <td><?php echo htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['aidyear'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo str_replace('Student on line ', '', htmlspecialchars($row['studentcomments'], ENT_QUOTES, 'UTF-8'))?></td>
                            <td><?php echo htmlspecialchars($row['counselorcomments'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['state'], ENT_QUOTES, 'UTF-8'); ?></td>
                       </tr>
<?php
}
?>

                    </tbody>
            </table>




</div>