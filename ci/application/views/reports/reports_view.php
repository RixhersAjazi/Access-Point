<div id="queries">
    <br />
    <center><strong>Report Generator</strong></center>

    <br />
    <?php echo form_open('reports_controller/generate'); ?>

    <div id="performance">
	<fieldset><legend>Performance Reports</legend>
	    <label class="reports"><input type="radio" name="reports" value="1" <?php echo set_radio('reports', '1'); ?>>Student Total Wait</input></class>
		<label class="reports"><input type="radio" name="reports" value="2" <?php echo set_radio('reports', '2'); ?>>Counselor Performance Per Session</input></class>
		    <label class="reports"><input type="radio" name="reports" value="3" <?php echo set_radio('reports', '3'); ?>>Average Counselor Performance</input></class>
			<label class="reports"><input type="radio" name="reports" value="9" <?php echo set_radio('reports', '9'); ?>>Total Students</input>


			    </fieldset>
			    </div>
			    <br />
			    <div id="admin">
				<fieldset><legend>Administrative Reports</legend>
				    <label class="reports"><input type="radio" name="reports" value="4" <?php echo set_radio('reports', '4'); ?>>Reasons For Visit</input></class>
					<label class="reports"><input type="radio" name="reports" value="5" <?php echo set_radio('reports', '5'); ?>>Overview of Totals</input></class>
					    <label class="reports"><input type="radio" name="reports" value="6" <?php echo set_radio('reports', '6'); ?>>Summary Of Students Per Day</input></label>
					    <label class="reports"><input type="radio" name="reports" value="7" <?php echo set_radio('reports', '7'); ?>>Summary Students Per Hour</input></label>
					    <label class="reports"><input type="radio" name="reports" value="8" <?php echo set_radio('reports', '8'); ?>>Summary Students Per Week Day</input></label>
					    <label class="reports"><input type="radio" name="reports" value="10" <?php echo set_radio('reports', '10'); ?>>Student Emails</input></label>
					    <label class="reports"><input type="radio" name="reports" value="12" <?php echo set_radio('reports', '12'); ?>>Status Overviews</input></label>
					     <label class="reports"><input type="radio" name="reports" value="13" <?php echo set_radio('reports', '13'); ?>>Total Phone Calls</input></label>
					     <label class="reports"><input type="radio" name="reports" value="14" <?php echo set_radio('reports', '14'); ?>>Hourly Phone Calls</input></label>
			    </fieldset>
					    </div>
					    <br />
					    <?php
					    echo form_submit('generate', 'Generate Report');
					    echo anchor('staff_controller/index', 'Return');
					    echo anchor('reports_controller/dynamic', 'Dynamic Reporting')
					    ?>

					    </div>
					    <div id="report_footer">
						<p>
						    Special thanks to  <strong>Suny Orange Applied Technology Department</strong> and <strong>SunyOrange Financial Aid Office </strong>
						    <br>
						    <strong>Application Created By Rixhers Ajazi. <?php echo anchor('email_controller/email_rix', 'Send Me An Email', 'target="_blank"') ?></strong>
						</p>
					    </div>
