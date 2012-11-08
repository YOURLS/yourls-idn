<?php
/*
Plugin Name: YOURLS IDN
Plugin URI: http://yourls.org/
Description: Compatibility with Internationalized Domain Names (IDN). Please read the plugin's readme.txt for configuration information
Version: 1.0
Author: Ozh
Author URI: http://ozh.org/

Thanks to contributors of the Issue #331 and to Bruno Kerouanton for their input and help
See http://code.google.com/p/yourls/issues/detail?id=331
*/

// Load & instantiate the IDN library
yourls_add_action( 'plugins_loaded', 'ozh_yidn_load' );
function ozh_yidn_load() {
	require_once ( dirname( __FILE__ ).'/IDNA2.php' );
	$idn = Net_IDNA2::getInstance();
	$idn->setParams( 'utf8', true );
	define( 'YOURLS_SITE_IDN', $idn->decode( YOURLS_SITE ) ); // eg http://héhé.net
}

// For the display
yourls_add_filter( 'table_add_row', 'ozh_yidn_ace2idn' );
yourls_add_filter( 'table_edit_row', 'ozh_yidn_ace2idn' );
yourls_add_filter( 'html_title', 'ozh_yidn_ace2idn' );
yourls_add_filter( 'html_link', 'ozh_yidn_ace2idn' );
yourls_add_filter( 'bookmarklet_jsonp', 'ozh_yidn_ace2idn' );
function ozh_yidn_ace2idn( $text ) {
	if( strpos( $text, YOURLS_SITE ) !== false ) {
		$text = str_replace( YOURLS_SITE, YOURLS_SITE_IDN, $text );
	}
	return $text;
}

// For the Share Box
yourls_add_filter( 'share_box_data', 'ozh_yidn_sharebox' );
function ozh_yidn_sharebox( $in ) {
	$in['share'] = ozh_yidn_ace2idn( $in['share'] );
	$in['shorturl'] = ozh_yidn_ace2idn( $in['shorturl'] );
	return $in;
}

// JS hack on the tools page to fix the Prefix n'Shorten explanation
yourls_add_action( 'html_footer', 'ozh_yidn_footerjs' );
function ozh_yidn_footerjs( $args ) {
	$context = $args[0];
	if( $context == 'tools' ) {
		$string = str_replace( 'http://', '', YOURLS_SITE );
		$idn = str_replace( 'http://', '', YOURLS_SITE_IDN );
		echo <<<JS
	<script>
	(function($) {
	    var omglol = $('div.sub_wrap').html().replace( '<span>$string/</span>', '<span>$idn/</span>');
		$('div.sub_wrap').html( omglol );
	})(jQuery);	
	</script>
JS;
	}
}
