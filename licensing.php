<?
include('header-start.php');
?>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="ImprintHead"><?echo $licensing_datalicensing; ?></h2>
				<p style="text-align: justify; margin-right: 1%">
				<?echo $licensing_datalicensingtext; ?>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="ImprintHead"><?echo $licensing_allowed; ?></h2>
				<p style="text-align: justify; margin-right: 1%">
				<?echo $licensing_allowedtext; ?>
				</p>
			</div>
		</div>
	</div>
	
	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="ImprintHead"><?echo $licensing_aslongas; ?></h2>
				<p style="text-align: justify; margin-right: 1%">
				<?echo $licensing_aslongastext; ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>