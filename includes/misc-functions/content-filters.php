<?php 
/**
 * This file contains the function which hooks to a brick's content output
 *
 * @since 1.0.0
 *
 * @package    MP Stacks EddCart
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * This function hooks to the brick output. If it is supposed to be a 'eddcart', then it will output the eddcart
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_eddcart($default_content_output, $mp_stacks_content_type, $brick_id){
	
	//If this stack content type is not set to be eddcart	
	if ($mp_stacks_content_type != 'eddcart'){
		return $default_content_output;
	}

	ob_start();
	
	$display = 'style="display:none;"';
  	$cart_quantity = edd_get_cart_quantity();
	
	echo '<div class="mp-stacks-eddcart-container">';
		echo '<div class="mp-stacks-eddcart-btn-container">';
			echo '<a class="mp-stacks-eddcart-cart-btn" target="_parent" href="' . edd_get_checkout_uri() . '">';
				echo '<i class="mp-stacks-eddcart-shopping-cart-icon fa-shopping-cart"></i>';
				echo '<span class="edd-cart-quantity">' . $cart_quantity . '</span>';
			echo '</a>';
		echo '</div>';
	
		do_action('edd_before_cart');
	
		?>
	
		<ul class="edd-cart">
		<!--dynamic-cached-content-->
		<?php
			$cart_items = edd_get_cart_contents();
			if($cart_items) :
				foreach( $cart_items as $key => $item ) :
					echo edd_get_cart_item_template( $key, $item, false );
				endforeach;
				?>
				<li class="cart_item edd_subtotal"><?php echo __( 'Subtotal:', 'edd' ). " <span class='subtotal'>" . edd_currency_filter( edd_format_amount( edd_get_cart_subtotal() ) ); ?></span></li>
				<li class="cart_item edd_checkout"><a class="button mp-stacks-eddcart-checkout-btn" target="_parent" href="<?php echo edd_get_checkout_uri(); ?>"><?php _e( 'Checkout', 'edd' ); ?></a></li>
				<?php
	
			else :
				edd_get_template_part( 'widget', 'cart-empty' );
			endif;
		?>
		<!--/dynamic-cached-content-->
		</ul>
		<?php
	
		do_action( 'edd_after_cart' );
	
	echo '</div>';
	
	return ob_get_clean();
	
}
add_filter('mp_stacks_brick_content_output', 'mp_stacks_brick_content_output_eddcart', 10, 3);

/**
 * This function hooks to the brick css output to style the eddcart
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_css_eddcart( $css_output, $brick_id ){
	
	//First Media Type
	$mp_stacks_first_content_type = get_post_meta($brick_id, 'brick_first_content_type', true);
	
	//Second Media Type
	$mp_stacks_second_content_type = get_post_meta($brick_id, 'brick_second_content_type', true);
	
	if ( $mp_stacks_first_content_type != 'eddcart' && $mp_stacks_second_content_type != 'eddcart' ){
		return $css_output;	
	}
	
	//Get icon specs
	$eddcart_icon_color = get_post_meta( $brick_id, 'eddcart_icon_color', true );
	
	//Get carts font size
	$eddcart_font_size = get_post_meta( $brick_id, 'eddcart_font_size', true );
	$eddcart_font_color = get_post_meta( $brick_id, 'eddcart_font_color', true );
	
	//Get border specs
	$eddcart_show_borders = get_post_meta( $brick_id, 'eddcart_show_borders', true );
	$eddcart_show_borders = !empty( $eddcart_show_borders ) ? 'border-bottom: 1px solid;' : NULL;
	$eddcart_border_color = get_post_meta( $brick_id, 'eddcart_border_color', true );
	$eddcart_border_color = !empty( $eddcart_border_color ) ? 'border-color: ' . $eddcart_border_color : NULL;
	
	//Get checkout button specs
	$eddcart_checkout_btn_color = get_post_meta( $brick_id, 'eddcart_checkout_btn_color', true );
	$eddcart_checkout_btn_text_color = get_post_meta( $brick_id, 'eddcart_checkout_btn_text_color', true );
	$eddcart_checkout_btn_mouseover_color = get_post_meta( $brick_id, 'eddcart_checkout_btn_mouseover_color', true );
	$eddcart_checkout_btn_mouseover_text_color = get_post_meta( $brick_id, 'eddcart_checkout_btn_mouseover_text_color', true );
	
	//Get Features Output
	$css_eddcart_output = '
		#mp-brick-' . $brick_id . ' .mp-stacks-eddcart-shopping-cart-icon{ 
			color: ' . $eddcart_icon_color . ';
		}
		#mp-brick-' . $brick_id . ' .mp-stacks-eddcart-container .edd-cart{ 
			font-size: ' . $eddcart_font_size . 'px;
			color: ' . $eddcart_font_color . ';
		}
		#mp-brick-' . $brick_id . ' .mp-stacks-eddcart-container .edd-cart .edd-cart-item, 
		#mp-brick-' . $brick_id . ' .mp-stacks-eddcart-container .edd_subtotal, 
		#mp-brick-' . $brick_id . ' .mp-stacks-eddcart-container .cart_item.empty
		{ 
			' . $eddcart_show_borders . '
			' . $eddcart_border_color . '
		}
		#mp-brick-' . $brick_id . ' .mp-stacks-eddcart-checkout-btn{
			background-color: ' . $eddcart_checkout_btn_color . ';
			color: ' . $eddcart_checkout_btn_text_color . ';
		}
		#mp-brick-' . $brick_id . ' .mp-stacks-eddcart-checkout-btn:hover{
			background-color: ' . $eddcart_checkout_btn_mouseover_color . ';
			color: ' . $eddcart_checkout_btn_mouseover_text_color . ';
		}
		#mp-brick-' . $brick_id . ' .edd-remove-from-cart{
			color: ' . $eddcart_checkout_btn_color . ';
		}
		#mp-brick-' . $brick_id . ' .edd-remove-from-cart:hover{
			color: ' . $eddcart_checkout_btn_mouseover_color . ';
		}';
	
	return $css_eddcart_output . $css_output;
}
add_filter('mp_brick_additional_css', 'mp_stacks_brick_content_output_css_eddcart', 10, 3);