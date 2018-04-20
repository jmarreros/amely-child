<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$classes = array(
	'product',
	'product-loop',
);

// Add 'new' class
$timestamp = strtotime( get_the_time( 'Y-m-d', $post->ID ) );
$newdays   = apply_filters( 'amely_shop_new_days', amely_get_option( 'shop_new_days' ) );

// Agregado jmarreros
$is_new = false;
if ( $newdays ){
	$is_new    =  ( time() - $timestamp )  < ( 60 * 60 * 24 * $newdays );
}
// -----------------

if ( $is_new ) {
	$classes[] = 'new';
}

// $classes[] = Amely_Helper::get_grid_item_class( apply_filters( 'amely_shop_products_columns',
// 	array(
// 		'xs' => 1,
// 		'sm' => 2,
// 		'md' => 3,
// 		'lg' => 4,
// 		'xl' => intval( get_option( 'woocommerce_catalog_columns', 5 ) ),
// 	) ) );

// $other_classes = apply_filters( 'amely_shop_products_classes', '' );
// $classes[]     = $other_classes;

$buttons_class   = array(
	'product-buttons product-buttons--' . apply_filters( 'amely_product_buttons_scheme',
		amely_get_option( 'product_buttons_scheme' ) ),
);
$buttons_class[] = wp_is_mobile() ? 'mobile' : '';

?>


<div <?php post_class( $classes ); ?>>
	
	<div class="wrap-first-columns">
		<div class="labels">
			<?php woocommerce_show_product_loop_sale_flash(); ?>
		</div>

		<div class="product-thumb">
			<?php
				Amely_Woo::wishlist_button();
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
			<div class="<?php echo implode( ' ', $buttons_class ); ?>">
				<?php
					Amely_Woo::quick_view_button();
				?>
			</div>
		</div>

		<div class="product-name">
			<?php 
				echo "<a href='" . $product->get_permalink() . "' >";
				echo "<span>" . $product->get_name() . "</span>"; 
				echo "</a>";
			?>

			<div class="manufacturer">
				Algún fabricante
				<?php echo $product->get_attribute( 'pa_fabricante' );  ?>
			</div>

			<div class="finish">
				Algún acabado
				<?php echo $product->get_attribute( 'pa_acabado' );  ?>
			</div>

			<?php 
				$pa_diametro = $product->get_attribute( 'pa_diametro' );
				$pa_anclaje = $product->get_attribute( 'pa_anclaje' );
				$pa_et = $product->get_attribute( 'pa_et' );
			?>
			
			<div class="responsive-attr">
				<div class="attr-et attr">
					<?php echo "Diámetro: " . $pa_diametro; ?>
				</div>
				<div class="attr-anclaje attr"> 
					<?php echo "Anclaje:" .  $pa_anclaje;  ?>
				</div>
				<div class="attr-et attr">
					<?php echo  "ET:" . $pa_et; ?>
				</div>				
			</div>

		</div><!-- product name -->

	</div>

	<div class="attributes">
		<div class="attr-et attr">
			<?php echo $pa_diametro; ?>
		</div>
		<div class="attr-anclaje attr"> 
			<?php echo $pa_anclaje;  ?>
		</div>
		<div class="attr-et attr">
			<?php echo  $pa_et; ?>
		</div>
	</div>

	<div class="wrap-last-columns">
		<div class="wrap-price">
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</div>

		<div class="add_cart">
			<?php woocommerce_template_loop_add_to_cart(); ?>
		</div>
	</div>
</div>

