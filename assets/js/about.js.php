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
<script type="text/javascript">
(function ($) {

	$(function(){

		// fix sub nav on scroll
		var $win = $(window),
				$nav = $('.subnav'),
				navHeight = $('.navbar').first().height(),
				navTop = $('.subnav').length && $('.subnav').offset().top - navHeight,
				isFixed = 0;

		processScroll();

		$win.on('scroll', processScroll);

		function processScroll() {
			var i, scrollTop = $win.scrollTop();
			if (scrollTop >= navTop && !isFixed) {
				isFixed = 1;
				$nav.addClass('subnav-fixed');
			} else if (scrollTop <= navTop && isFixed) {
				isFixed = 0;
				$nav.removeClass('subnav-fixed');
			}
		}

	});

})(window.jQuery);
</script>