<?
include('header-start.php');
?>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="ImprintHead"><? echo $imprint_imprint;?></h2>
				<p style="margin-right: 1%">>
					52&deg; North Initiative for Geospatial Open Source Software GmbH<br/>
					Martin-Luther-King-Weg 24<br/>
					48155 Münster, Germany<br/>
					<br/>
					<? echo $imprint_phone;?> +49 (0)251.396371-0<br/>
					<? echo $imprint_fax;?> +49 (0)251.396371-11<br/>
					<? echo $imprint_email;?><a href="mailto:info@52north.org">info@52north.org</a><br/>
					<a href="http://52north.org">http://52north.org</a><br/>
					<br/>
					<? echo $imprint_directors;?> Dr. Albert Remke, Dr. Andreas Wytzisk<br/>
					<br/>
					USt.-ID-Nr. DE253303206<br/>
					<br/>
					<? echo $imprint_registry;?> Amtsgericht Münster HRB 10849<br/>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="ContentHead"><? echo $imprint_content;?></h2>
				<p style="text-align: justify; margin-right: 1%">
					<? echo $imprint_contenttext;?>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span">
				<h2 id="CopyrightHead"><? echo $imprint_copyright;?></h2>
				<p style="text-align: justify; margin-right: 1%">
					<? echo $imprint_copyrighttext;?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>