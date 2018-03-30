<link rel="stylesheet" href="https://bootswatch.com/3/sandstone/bootstrap.css">
<link rel="stylesheet" href="style.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script src="script.js"></script>

<?php

require_once '../vendor/autoload.php';
require_once 'my_sudoku.php';
?>
<input type="hidden" id="hidden_sudoku" value="<? echo json_encode($sudoku); ?>">
<div class="container">
	<div class="page-header">
		<h1>Play me</h1>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div id="game">
				<table>
				</table>
			</div>
		</div>
		<div class="col-xs-8">
			<div class="form-group">
				<button class="btn btn-primary btn-lg" id="btn-gaped">Show Gaped</button>
			</div>

			<div class="form-group">
				<button class="btn btn-info btn-lg" id="btn-full">Show Full</button>
			</div>
			<div class="form-group">
				<button class="btn btn-warning btn-lg" id="btn-clear" disabled>Clear</button>
			</div>
			<div class="form-group">
				<div id="time"></div>
			</div>
		</div>
	</div>
</div>
