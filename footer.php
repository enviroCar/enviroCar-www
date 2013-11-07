<!-- FOOTER -->  
	<footer>
        <div class="footer">
    		<div class="container-fluid">
                <div class="row">
                    <div class="span12">
                        <?
                            if($lang == 'en'){ echo '<img src="" onClick="changeLanguage(\'de\')" class="flag flag-de" alt="German">';
                            }else{
                              echo '<img src="" onClick="changeLanguage(\'en\')" class="flag flag-gb" alt="English">';
                            }
                          ?> &middot;
                        2013 <?echo $envirocar; ?> &middot; <a href="imprint.php"><? echo $footer_imprint; ?></a> &middot; <a href="terms.php"><? echo $footer_terms; ?></a>
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
