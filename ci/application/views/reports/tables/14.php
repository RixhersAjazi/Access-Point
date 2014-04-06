<div id="que">
    <h3>Hourly Phone Calls</h3>
    <?php echo anchor('staff_controller/reports', 'Return'); ?>
    <table id='datatables' class='display'>
    <thead>
        <tr>
        <th>Date</th>
        <th>Total</th>
        <th>8AM-9AM</th>
        <th>9AM-10AM</th>
        <th>10AM-11AM</th>
        <th>11AM-12PM</th>
        <th>12PM-1PM</th>
        <th>1PM-2PM</th>
        <th>2PM-3PM</th>
        <th>3PM-4PM</th>
        <th>4PM-5PM</th>
        <th>5PM-6PM</th>
        <th>6PM-7PM</th>
        <th>7PM-8PM</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($hourlycalls as $row) {
        ?>
            <tr>
            <td><?php echo htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['Total'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['8AM-9AM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['9AM-10AM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['10AM-11AM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['11AM-12PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['12PM-1PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['1PM-2PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['2PM-3PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['3PM-4PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['4PM-5PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['5PM-6PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['6PM-7PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['7PM-8PM'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php
        }
        ?>

    </tbody>
    </table>




</div>