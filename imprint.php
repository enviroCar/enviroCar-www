<?php
/*
* This file is part of enviroCar.
* 
* enviroCar is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* enviroCar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with enviroCar.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once('./assets/includes/authentification.php');
$logged_in = false; 
if(!is_logged_in()){
        $logged_in = false; 
        include('header-start.php');
}else{
        $logged_in = true;
        include('header.php');
}
?> 

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span12">
				<h2 id="ImprintHead"><?php echo $imprint_imprint;?></h2>
				<p style="margin-right: 1%">
					52&deg; North Initiative for Geospatial Open Source Software GmbH<br/>
					Martin-Luther-King-Weg 24<br/>
					48155 Münster, Germany<br/>
					<br/>
					<?php echo $imprint_phone;?> +49 (0)251.396371-0<br/>
					<?php echo $imprint_fax;?> +49 (0)251.396371-11<br/>
					<?php echo $imprint_email;?><a href="mailto:info@52north.org">info@52north.org</a><br/>
					<a href="http://52north.org">http://52north.org</a><br/>
					<br/>
					<?php echo $imprint_directors;?> Dr. Albert Remke, Dr. Andreas Wytzisk<br/>
					<br/>
					USt.-ID-Nr. DE253303206<br/>
					<br/>
					<?php echo $imprint_registry;?> Amtsgericht Münster HRB 10849<br/>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span12">
				<h2 id="ContentHead"><?php echo $imprint_content;?></h2>
				<p style="text-align: justify; margin-right: 1%">
					<?php echo $imprint_contenttext;?>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span12">
				<h2 id="CopyrightHead"><?php echo $imprint_copyright;?></h2>
				<p style="text-align: justify; margin-right: 1%">
					<?php echo $imprint_copyrighttext;?>
				</p>
			</div>
		</div>
	</div>

<?php 
include('footer.php');