<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>javascript/js/updateajax.js" type="text/javascript"></script>
	<script type="text/javascript">
	    $(document).ready(function()
	    {
		var table1 = $('#waiting').dataTable(
			{
			    "sPaginationType": "full_numbers",
			    "bJQueryUI": true,
			    "sAjaxDataProp": "waiting",
			    "sAjaxSource": '<?php echo base_url();?>studentonlyaccess_controller/studentonlyqueue',
			    "bDeferRender": true,
			    "bSort": false,
			    "bAutoWidth": false,
			    "iDisplayLength": 500,
			    "aoColumns":
				    [
					{"mdata": "first"},
					{"mdata": "last"},
					{"mdata": "SECOND",
					    "sWidth": "1%"
					}
				    ]
			});
		setInterval(function() {
		    table1.fnReloadAjax(null, null, true);
		}, 1000);
	    });
	</script>

	<style type="text/css">
	    @import "<?php echo base_url(); ?>javascript/css/demo_table_jui.css";
	    @import "<?php echo base_url(); ?>javascript/themes/smoothness/jquery-ui-1.8.4.custom.css";
	</style>

	<style type="text/css">
	    * {
		font-family: arial;
	    }
	    .display a
	    {
		text-decoration: none;
		padding: 2px;
	    }
	    .display td {
		text-align: center;
	    }
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<title>Access Point Student Queue</title>
    </head>
    <body>
	<h3>Student Queue</h3>
	<table id='waiting' class='display'>
	    <thead>
		<tr>
		    <th>First Name</th>
		    <th>Last Name</th>
		    <th>Time Waiting</th>
		</tr>
	    </thead>
	    <tbody>

	    </tbody>
	</table>
    </body>
</html>
