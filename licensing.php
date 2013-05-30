<?
include('header-start.php');
?>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span4">
				<h2 id="ImprintHead"><?echo $licensing_datalicensing; ?></h2>
				<?echo $licensing_datalicensingtext; ?>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span4">
				<h2 id="ImprintHead"><?echo $licensing_allowed; ?></h2>
				<?echo $licensing_allowedtext; ?>
			</div>
		</div>
	</div>
	
		<div class="container leftband">
		<div class="row-fluid">
			<div class="span4">
				<h2 id="ImprintHead"><?echo $licensing_aslongas; ?></h2>
				<?echo $licensing_aslongastext; ?>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>