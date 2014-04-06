<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/ZeroClipboard.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/TableTools.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/reports.js" type="text/javascript"></script>

	<style type="text/css">
	    @import "<?php echo base_url(); ?>javascript/css/demo_table_jui.css";
	    @import "<?php echo base_url(); ?>javascript/themes/smoothness/jquery-ui-1.8.4.custom.css";
	    @import "<?php echo base_url(); ?>javascript/css/TableTools_JUI.css";
	    @import "<?php echo base_url(); ?>javascript/css/TableTools.css";
	</style>
	<style type="text/css">
	    * {
		font-family: arial;
	    }
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<title>Access Point Student Queue</title>
    </head>
    <body>
	<h4>List of students matching <?php echo $first; echo $last; ?></h4>
	<table id='datatables' class='display'>
	    <thead>
		<tr>
		    <th>A Number</th>
		    <th>First Name</th>
		    <th>Last Name</th>
		    <th>Email Address</th>
		</tr>
	    </thead>
	    <tbody>
		<?php
		foreach ($history as $row) {
		    ?>
    		<tr>
		    <td><?php echo anchor('studenthistory_controller/history/' . urlencode($row['anum']) . '', htmlspecialchars($row['anum'], ENT_QUOTES, 'UTF-8'), 'title="Find Student"') ?></td>
    		    <td><?php echo htmlspecialchars($row['first'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['last'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($this->encrypt->decode($row['email']), ENT_QUOTES, 'UTF-8') ?></td>
    		</tr>

		    <?php
		}
		?>
	    </tbody>
	</table>
    </div>
</body>
</html>