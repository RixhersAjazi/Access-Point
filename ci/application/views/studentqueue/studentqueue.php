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
			    "iDisplayLength": 10,
			    "aLengthMenu": [5, 10],
			    "sAjaxDataProp": "waiting",
			    "sAjaxSource": '<?php echo base_url();?>studentqueue_controller/ajaxcall',
			    "bDeferRender": true,
			    "bAutoWidth": false,
			    "aoColumns":
				    [
					{"mdata": "id",
					    "sWidth": "7%",
					    "mRender": function(data, full)
					    {
						var div = '<div id="waitinglinks">';
						var url = '<a href="<?php echo base_url();?>studentqueue_controller/start/' + data + '" title="Start Session">' + '<img src="<?php echo base_url();?>images/greencheck.gif"' + '</a>';
						var url1 = '<a href="<?php echo base_url();?>studentqueue_controller/stop/' + data + '" title="End Session">' + '<img src="<?php echo base_url();?>images/orangeMinus.png"' + '</a>';
						var url2 = '<a href="<?php echo base_url();?>studentqueue_controller/abandon/' + data + '" title="Abandon Session">' + '<img src="<?php echo base_url();?>images/redX.png"' + '</a>';
						var end = '</div>';

						return div + url + url1 + url2 + end;
					    }
					},
					{
					    "mdata": "anum",
					    "sWidth": "1%",
					    "mRender": function(data, full)
					    {
						return '<a href="<?php echo base_url();?>studenthistory_controller/history/' + data + '" target="_blank">' + data + '</a>';
					    }
					},
					{"mdata": "first"},
					{"mdata": "last"},
					{"mdata": "SECOND",
					    "sWidth": "1%"
					},
					{"mdata": "reason"},
					{"mdata": "studentcomments"},
					{"mdata": "aidyear",
					    "sWidth": "1%"
					},
					{"mdata": "counselorcomments"}
				    ]
			});
		setInterval(function() {
		    table1.fnReloadAjax(null, null, true);
		}, 1000);
	    });
	</script>
	<script type="text/javascript">
	    $(document).ready(function()
	    {
		var table2 = $('#beingseen').dataTable(
			{
			    "sPaginationType": "full_numbers",
			    "bJQueryUI": true,
			    "iDisplayLength": 10,
			    "aLengthMenu": [5, 10],
			    "sAjaxDataProp": "beingseen",
			    "sAjaxSource": '<?php echo base_url();?>studentqueue_controller/ajaxcall',
			    "bDeferRender": true,
			    "bAutoWidth": false,
			    "aoColumns":
				    [
					{"mdata": "id",
					    "sWidth": "1%",
					    "mRender": function(data, full)
					    {
						var div = '<div id="beingseenlinks">';
						var url = '<a href="<?php echo base_url();?>studentqueue_controller/cont/' + data + '" title="Continue Session">' + '<img src="<?php echo base_url();?>images/greencheck.gif"' + '</a>';
						var url1 = '<a href="<?php echo base_url();?>studentqueue_controller/terminate/' + data + '" title="Terminate Session">' + '<img src="<?php echo base_url();?>images/blue_minus.gif"' + '</a>';
						var end = '</div>';

						return div + url + url1 + end;
					    }
					},
					{"mdata": "anum",
					    "sWidth": "1%"
					},
					{"mdata": "first"},
					{"mdata": "last"},
					{"mdata": "signintime",
					    "sWidth": "14%"
					},
					{"mdata": "fname",
					    "sWidth": "1%"
					},
					{"mdata": "starttime",
					    "sWidth": "14%"
					},
					{
					    "mdata": "TIME",
					    "swidth": "10%"
					}
				    ]
			});
		setInterval(function() {
		    table2.fnReloadAjax(null, null, true);
		}, 15000);
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

	<?php echo anchor('staff_controller/index', 'Return'); ?>
	<p class='error'>
	    <font color="#ff0000">
		<?php echo $this->session->flashdata('reports'); ?>
	    </font>
	</p>

	<h3>Students Waiting</h3>
	<table id='waiting' class='display'>
	    <thead>
		<tr>
		    <th>Actions</th>
		    <th>A Number</th>
		    <th>First Name</th>
		    <th>Last Name</th>
		    <th>Time Waiting</th>
		    <th>Reason for visit</th>
		    <th>Comments</th>
		    <th>Aid Year</th>
		    <th>Staff Comments</th>
		</tr>
	    </thead>
	    <tbody>

	    </tbody>
	</table>

	<h3>Students Being Seen</h3>
	<table id='beingseen' class='display'>
	    <thead>
		<tr>
		    <th>Actions</th>
		    <th>A Number</th>
		    <th>First Name</th>
		    <th>Last Name</th>
		    <th>Sign In Time</th>
		    <th>Staff Member</th>
		    <th>Start Time</th>
		    <th>Total Wait</th>
		</tr>
	    </thead>
	    <tbody>

	    </tbody>
	</table>
    </body>
</html>
