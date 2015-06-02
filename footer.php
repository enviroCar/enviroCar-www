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
?>
<!-- FOOTER -->  
	<footer>
        <div class="footer">
    		<div class="container">
                <div class="row">
                    <div class="span12" style="text-align: center; line-height: 100%;">
                        <?
                            if($lang == 'en'){ echo '<img src="./assets/img/blank_flag.png" onClick="changeLanguage(\'de\')" class="flag flag-de" alt="German">';
                            }else{
                              echo '<img src="./assets/img/blank_flag.png" onClick="changeLanguage(\'en\')" class="flag flag-gb" alt="English">';
                            }
                          ?> &middot;
                        2013 - 2015 <?echo $envirocar; ?> &middot; <a href="imprint.php"><? echo $footer_imprint; ?></a> &middot; <a href="terms.php"><? echo $footer_terms; ?></a>
                    </div>
                </div>
    		</div>
        </div>
	</footer>
	
	<!-- Javascripts -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="./assets/js/bootstrap-plugins-concat.min.js"></script>
  </body>
</html>
