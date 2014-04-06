<div id="que">
<h3>Student Visits</h3>
<?php
    echo anchor('staff_controller/reports', 'Return');
?>

<table id='datatables' class='display'>
                <thead>
                    <tr>
                        <th>Date</th>
                     	<th>Total Students</th>
                     	<th>12-13</th>
                    	<th>13-14</th>
			            <th>14-15</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                    foreach($aidperday as $row) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['Total'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['12-13'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['13-14'], ENT_QUOTES, 'UTF-8'); ?></td>
			                <td><?php echo htmlspecialchars($row['14-15'], ENT_QUOTES, 'UTF-8'); ?></td>
                       </tr>
<?php
}
?>

                    </tbody>
            </table>




</div>