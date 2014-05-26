<?php 
/**
 * MP Stacks + EddCart Enqueue Scripts
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks + EddCart
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 

function mp_stacks_eddcart_enqueue_scripts(){ 
	
	//Enqueue Font Awesome CSS
	wp_enqueue_style( 'fontawesome', plugins_url( '/fonts/font-awesome-4.0.3/css/font-awesome.css', dirname( __FILE__ ) ) );
	
	//EDD Cart css
	wp_enqueue_style( 'mp_stacks_eddcart_js', plugins_url('css/mpstacks-eddcart.css', dirname(__FILE__)));	
	
	//EDD Cart JS
	wp_enqueue_script( 'mp_stacks_eddcart_js', plugins_url('js/mpstacks-eddcart.js', dirname(__FILE__)), array('jquery'), false, true );	
	
}
add_filter( 'wp_enqueue_scripts', 'mp_stacks_eddcart_enqueue_scripts' );
