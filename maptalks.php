<?php
/*
Plugin Name: MapTalks Plugin
Plugin URI: http://www.eurotrip.it/maptalks-plugin/
Description: Inserisce nei vostri articoli le vostre mappe di MapTalks.
Version: 0.1
License: GPL
Author: Giuseppe Trisciuoglio
Author URI: http://www.eurotrip.it
*/

function maptalks_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'comments'		=> 'on', 
		'background'	=> '#FFFFFF',
		'test_color'			=> '#000000',
		'anchor_color'			=> '#3B5998',
		'top_background'	=> '#F1F5F5',
		'top_text_color'	=> '#3B5998',
		'border_color'		=> '#DBECEC',
		'separators_color'		=> '#E3E3E3',
		'type'				=> 'map',
		'width'				=> '550',
		'height'				=> '450',
		'id'					=> '',
		'comment_background'	=> '#DBE8E8',
		'blurred_text_color'	=> '#808080',
		'photos_box'			=> 'on',
		'linked_resource'		=> 'on',
		'comments_brief'		=> 'on'
	), $atts));	
	
	$maptalks_api_key = get_option('maptalks_api_key');
	
	$maptalks_shortcode .= '<script type="text/javascript">maptalks_motif={"background":"'.$background.'",';
	$maptalks_shortcode .= '"top_background":"'.$top_background.'",';
	$maptalks_shortcode .= '"top_text_color":"'.$top_text_color.'",';
	$maptalks_shortcode .= '"text_color":"'.$text_color.'",';
	$maptalks_shortcode .= '"anchor_color":"'.$anchor_color.'",';
	$maptalks_shortcode .= '"border_color":"'.$border_color.'",';
	$maptalks_shortcode .= '"separators_color":"'.$separators_color.'"';
	if ($type == 'post'){
		$maptalks_shortcode .= ',"comment_background":"'.$comment_background.'",';
		$maptalks_shortcode .= '"blurred_text_color":"'.$blurred_text_color.'"};';
	}else{
		$maptalks_shortcode .= '};';
	}
	$maptalks_shortcode .= 'maptalks_widget={"api":{"apiKey":"'.$maptalks_api_key.'",';
	$maptalks_shortcode .= '"type":"'.$type.'","version":"0.1",';
	$maptalks_shortcode .= '"id":"'.$id.'","features":{"comments":"'.$comments.'"';
	if ($type == 'post'){
		$maptalks_shortcode .= ',"photos_box":"'.$photos_box.'",';
		$maptalks_shortcode .= '"linked_resource":"'.$linked_resource.'",';
		$maptalks_shortcode .= '"comments_brief":"'.$comments_brief.'"}},';
	}else{
		$maptalks_shortcode .= '}},';
	}
	$maptalks_shortcode .= '"iframe":{"width":"'.$width.'","height":"'.$height.'"}};</script>'; 
	$maptalks_shortcode .= '<script type="text/javascript" src="http://www.maptalks.net/js/api/widget.js"></script>';
	
	return $maptalks_shortcode;
}
add_shortcode('maptalks', 'maptalks_shortcode');

add_action('admin_menu', 'add_maptalks_plugin_option_page');

function add_maptalks_plugin_option_page() {
	add_options_page('MapTalks', 'MapTalks', 6, __FILE__, 'maptalks_options_page');
}

function maptalks_options_page() { 
	global $maptalks_api_key; 
	$maptalks_api_key = get_option('maptalks_api_key'); ?>
	<h2>Impostazioni MapTalks</h2>
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" id="userid_label">API Key MapTalks</th>
				<td>
				<input name="maptalks_api_key" type="text" id="maptalks_api_key" value="<?php echo $maptalks_api_key; ?>" size="50" />
				<input type="hidden" name="page_options" value="maptalks_api_key" />
				<input type="hidden" name="action" value="update" />	
				<span>Non conosci la tua API Key clicca <a href="http://www.maptalks.net/app/profile/developer" target="_blank" >qui</a>.</span></td>
			</tr>
		</table>
		<div class="submit">
			<input type="submit" value="<?php _e('Salva') ?>" class="button-primary" />
		</div>
		</form>
		
		<h2>Come usare il plugin</h2>
		<p>Usa lo shortcode <code>[maptalks]</code> per inserire la tua mappa nei tuoi post.</p>
		
		<p>Puoi inserire le mappe inserendo un codice simile a questo <code>[maptalks id="1234"]</code> dove 1234 &egrave; l'ID della tua mappa. <span>Clicca <a target="_blank" href="http://www.maptalks.net/app/info/developer">qui</a> per scoprire come sapere il tuo id.</span>
		<br /><br />
		Puoi utilizzare ulteriori paramentri per customizzare la tua mappa scritti <a target="_blank" href="http://www.eurotrip.it/maptalks-plugin/">qui</a>.</p>
		
		<p>MapTalks Plugin &egrave; sviluppato da <a target="_blank" href="http://www.eurotrip.it">Giuseppe Trisciuoglio</a>.
	</div>
<?php } ?>