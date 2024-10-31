<?php
/*
Plugin Name: PushaStats
Version: 0.5
Plugin URI: http://viewport.se/pusha-plugin-till-wordpress/
Description: PuhaStas visar dina Pushade l&auml;nkar p&aring; panelen.
Mer info pŒ <a href="http://viewport.se/pusha-plugin-till-wordpress/">viewport.se</a>!
Author: Filip Stefansson
Author URI: http://viewport.se
*/

/*  Copyright 2009  Filip Stefansson  (email : filip.stefansson@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/	


	function pushastats() {
get_pusha();
};

if (isset($_POST['pusha'])) {
update_option('pusha_inlagg', $_POST['antal']);
}

$antal = get_option('pusha_inlagg');

if(empty($antal)) {
update_option('pusha_inlagg', 5);
}



function get_pusha() {
 query_posts('showposts='.get_option('pusha_inlagg').'&post_status=publish'); 
 while (have_posts()) : the_post(); 


  
echo  '
 <div style="width: 60px; height: 60px; float: left;" >
 <script type="text/javascript">
var pusha_url="';
the_permalink();
echo '"
var pusha_bakgrund="#FFFFFF";
var pusha_titel="'; 
the_title(); 
echo '"
var pusha_beskrivning="'.$content.'";
var pusha_nyttfonster=true;
</script>
<script src="http://www.pusha.se/knapp/pusha.js" type="text/javascript"></script>
 </div>
 
 <div style="width: 100%; height: 70px">
 <span style="font-size: 20px;"><a href="';
  the_permalink();
  echo '">';
   the_title() ;
   echo '</a></span>
<p style="margin: 3px 0 0 0">
';		

		$content = get_the_content(); 
		$content = strip_tags($content); 
		$content = substr($content, 0, -3);
		$content = substr($content, 0, 150);
		echo $content . '...';
echo '
</p>

 </div>

 ';

endwhile;

echo '
 <div>
 <form name="pusha" method="post" action="">
 <h5>Hur m&aring;nga inl&auml;gg vill du visa?</h5>
 <p><input type="text" value="'.$antal.'" name="antal" />
 <input type="submit" value="OK" name="pusha" class="button"/>
 </p>
 </form>
 </div>
';

};	





		
			// LŠgger till Widgeten
			function pushastats_dashboard_setup() {
				wp_add_dashboard_widget( 'pushastats', __( 'PushaStats' ), 'pushastats' );
				}


					// Integrerar den nya Widgeten
					add_action('wp_dashboard_setup', 'pushastats_dashboard_setup');


