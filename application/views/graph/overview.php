<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/31/2016
 * Time: 10:13 AM
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title><?php if (!empty($title)) echo $title; else "AfyaData Manager"; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="<?= base_url() ?>assets/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="<?= base_url() ?>assets/bootstrap/css/navbar-fixed-top.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
			        aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Project name</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Contact</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header">Nav header</li>
						<li><a href="#">Separated link</a></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../navbar/">Default</a></li>
				<li class=""><a href="./" class="dropdown-toggle" data-toggle="dropdown" role="button"
				                aria-haspopup="true"
				                aria-expanded="false"><?php echo ucfirst($this->session->userdata("username")) ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">My Profile</a></li>
						<li><a href="#">Change password</a></li>
						<li><a href="#">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>


<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a>

					<ul>
						<?php foreach ($xforms as $form) { ?>
							<li>
								<?php echo anchor("graph/overview/" . $form->id, $form->title); ?>
							</li>
						<?php } ?>
					</ul>

				</li>
			</ul>
			<!--			<ul class="nav nav-sidebar">-->
			<!--				<li><a href="">Nav item</a></li>-->
			<!--				<li><a href="">Nav item again</a></li>-->
			<!--				<li><a href="">One more nav</a></li>-->
			<!--				<li><a href="">Another nav item</a></li>-->
			<!--				<li><a href="">More navigation</a></li>-->
			<!--			</ul>-->

		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header" id="xform-title"><?php echo $form_details->title ?></h1>
			<div class="" style="margin-bottom: 10px;">
				<?php echo form_open("graph/overview/" . $form_details->id, 'class="form-inline" role="form"'); ?>
				<?php
				$options = array("" => "Select column to plot");
				foreach ($table_fields as $key => $value) {
					$options[$value] = ucfirst(str_replace("_", " ", $value));
				}
				?>

				<div class="form-group">
					<label for="Axis Column"></label>
					<?php echo form_dropdown("axis", $options, $table_fields[mt_rand(1, (count($table_fields) - 1))], 'class="form-control"'); ?>
				</div>
				<div class="form-group">
					<label for="Group by"></label>
					<?php $options[""] = "Select column to Group by";
					echo form_dropdown("group_by", $options, $table_fields[mt_rand(1, (count($table_fields) - 1))], 'class="form-control"'); ?>
				</div>

				<div class="form-group">
					<label for="Operation"></label>
					<?php echo form_dropdown("function", array("COUNT" => "Count all", "SUM" => "Find summation"), "COUNT", 'class="form-control"'); ?>
				</div>

				<!-- Todo Uncomment and implement date
				<div class="form-group">
					<div class="input-group date startdate" data-link-field="dtp_input1">
						<input type="text" size="10" id="startdate" name="startdate" placeholder="Start date"
						       value="" readonly class="form-control">
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group date enddate" data-link-field="dtp_input1">
						<input type="text" size="10" id="startdate" name="startdate" placeholder="End date"
						       value="" readonly class="form-control">
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
				-->


				<div class="form-group">
					<div class="input-group">
						<?php echo form_submit("submit", "Submit", 'class="btn btn-primary"'); ?>
					</div>
				</div>
				<?php echo form_close(); ?>

				<?php echo validation_errors(); ?>
			</div>

			<div id="graph-content">
				<!--TODO Insert graph code here -->

				<?php if (empty($categories)) {
					$message = "<p class='text-center'>Select <strong>columns</strong> you want to plot against a group column and function you want to use, to see a chart here</p>";
					echo display_message($message, "info");
				}
				?>

			</div>

			<div class="">
				<!--				<pre>-->
				<!--					--><?php //print_r($table_fields_data); ?>
				<!--				</pre>-->
				<!--<pre>
					<?php /*print_r($results); */ ?>
				</pre>-->
			</div>
		</div>
	</div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=base_url()?>assets/bootstrap/js/vendor/jquery.min.js"><\/script>')</script>
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url() ?>assets/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?= base_url() ?>assets/public/js/highcharts.js"></script>
</body>
</html>

<script type="text/javascript">

	$(function () {

		Highcharts.setOptions({
			lang: {
				thousandsSep: ','
			}
		});

		$('#graph-content').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: '<?php echo $series['name']; ?>'
				},
				xAxis: {
					categories: <?php echo $categories; ?>
				},
				yAxis: {
					title: {
						text: '<?php echo !empty($chart_title) ? $chart_title : "Count"?>'
					}
				},
				series: [{
					name: '<?php echo $series['name']; ?>',
					data: <?php echo str_replace('"', "", json_encode($series['data']));?>
				}],
				credits: {
					enabled: false
				}
			}
		);
	})
	;

	$(document).ready(function () {
		//working fine
		// Ajax calls here.
	});
</script>
