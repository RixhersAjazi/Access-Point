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

	    table {
		text-align: center;
	    }

	    #historylinks {
		margin-left: 450px;
		margin-bottom: 6px;
	    }

	    #historylinks a {
		text-decoration: none;
		border: none;
		margin-right: 1px;
		padding: 6px;
		text-decoration: none;
		font-size: 12px;
		-webkit-border-radius: 4px;
		background: #f25914;
		color: #ffffff;
	    }

	    #historylinks a:hover {
		background: #ff6a2a;
		cursor: pointer;
		border: solid 1px;
		border-color: #34658D
	    }

	    a#currenthistory {
		background: #34658D;
	    }
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<title>Access Point Student Queue</title>
    </head>
    <body>
	<h4>Forms Given To <?php echo $this->uri->segment(3); ?></h4>
	<div id="historylinks">
	    <?php echo anchor('studenthistory_controller/history/' . $this->uri->segment(3) . '', 'All'); ?>
	    <?php echo anchor('studenthistory_controller/fin_history/' . $this->uri->segment(3) . '', 'Finished'); ?>
	    <?php echo anchor('studenthistory_controller/left_history/' . $this->uri->segment(3) . '', 'Left'); ?>
	    <?php echo anchor('studenthistory_controller/term_history/' . $this->uri->segment(3) . '', 'Terminated'); ?>
	    <?php echo anchor('studenthistory_controller/aba_history/' . $this->uri->segment(3) . '', 'Abandoned'); ?>
	    <?php echo anchor('studenthistory_controller/forms_history/' . $this->uri->segment(3) . '', 'Forms', 'id="currenthistory"'); ?>
	</div>
	<table id='datatables' class='display'>
	    <thead>
		<tr>
		    <th>Date</th>
		    <th>A Number</th>
		    <th>First Name</th>
		    <th>Last Name</th>
		    <th>Staff Member</th>
		    <th>Forms</th>
		</tr>
	    </thead>
	    <tbody>
		<?php
		foreach ($history as $row) {
		    ?>
    		<tr>
    		    <td><?php echo htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['anum'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['first'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['last'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['fname'], ENT_QUOTES, 'UTF-8') ?></td>
    		    <td><?php echo htmlspecialchars($row['forms'], ENT_QUOTES, 'UTF-8') ?></td>
    		</tr>
		    <?php
		}
		?>
	    </tbody>
	</table>
    </body>
</html>