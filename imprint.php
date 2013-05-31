<?
include('header-start.php');
?>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="ImprintHead"><? echo $imprint_imprint;?></h2>
				52&deg; North Initiative for Geospatial Open Source Software GmbH<br/>
				Martin-Luther-King-Weg 24<br/>
				48155 Münster, Germany<br/>
				<br/>
				<? echo $imprint_phone;?> +49 (0)251.396371-0<br/>
				<? echo $imprint_fax;?> +49 (0)251.396371-11<br/>
				<? echo $imprint_email;?> info@52north.org<br/>
				http://52north.org<br/>
				<br/>
				<? echo $imprint_directors;?> Dr. Albert Remke, Dr. Andreas Wytzisk<br/>
				<br/>
				USt.-ID-Nr. DE253303206<br/>
				<br/>
				<? echo $imprint_registry;?> Amtsgericht Münster HRB 10849<br/>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="ContentHead"><? echo $imprint_content;?></h2>
				<? echo $imprint_contenttext;?>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="CopyrightHead"><? echo $imprint_copyright;?></h2>
				<? echo $imprint_copyrighttext;?>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>