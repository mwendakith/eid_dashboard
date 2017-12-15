<?php $siteKey = '6LfymQsUAAAAAG7YlfJ12gGnmFNRUZJ6JSkPEFiT';
$lang = 'en';?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
			    <strong>Login</strong>
			</div>
			<div class="panel-body" id="contact_us">
				<center>
					<div id="error_div">
						<?php 
							if(isset($errors)){
								echo $errors;
							}

						?>
					</div>
				</center>
			    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url();?>survey/logger">					

					<div class="form-group">
						<label for="name" class="col-sm-2 control-label" style="color: black;">Username:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="username" placeholder="Username" required>
						</div>
					</div>

					<div class="form-group">
						<label for="name" class="col-sm-2 control-label" style="color: black;">Password:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" placeholder="Password" required>
						</div>
					</div>


					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary" style="color:white; background-color:#1BA39C;">
						</div>
						<div class="col-sm-6" id="loading"></div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$().ready(function(){
	    $('.dt-picker').datepicker( {
	        dateFormat: 'yy-mm-dd'
	    });

	    $(".survey-select").select2();
    
	});
</script>