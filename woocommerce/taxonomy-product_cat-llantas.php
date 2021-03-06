<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );

function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {

	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		$html = "<div class='quantity amely_qty illantas_qty'><span class='minus'>-</span>
					<label class='screen-reader-text' >Cantidad</label>
					<input class='input-text qty text' step='1' name='quantity' value='2' title='Cantidad' size='4' pattern='[0-9]*' inputmode='numeric' aria-labelledby='' type='number'>
				<span class='plus'>+</span></div>";
		$html .= "<a href='" . esc_url( $product->add_to_cart_url() ) . "'";
		$html .= " class = 'button product_type_simple add_to_cart_button ajax_add_to_cart' ";
		$html .= " data-quantity='2'";
		$html .= " data-product_id='" . $product->get_id() . "'";
		$html .= " data-product_name='". $product->get_title() ."'";
		$html .= " rel='nofollow'";
		$html .= ">";
		$html .= "Agregar";//esc_html( $product->add_to_cart_text() );
		$html .= "</a>";
	}
	return $html;
}


get_header( 'shop' );

// Sidebar config
$page_wrap_class = $content_class = '';
$sidebar_config  = amely_get_option( 'shop_sidebar_config' );
$full_width_shop = amely_get_option( 'full_width_shop' );
$column_switcher = amely_get_option( 'column_switcher' );
$breadcrumbs_on  = amely_get_option( 'breadcrumbs' );
$shop_filters    = amely_get_option( 'shop_filters' );

if ( $sidebar_config == 'left' ) {
	$page_wrap_class = 'has-sidebar-left row';
	$content_class   = ( $full_width_shop ) ? 'col-xs-12 col-md-8 col-lg-10' : 'col-xs-12 col-md-8 col-lg-9';
} elseif ( $sidebar_config == 'right' ) {
	$page_wrap_class = 'has-sidebar-right row';
	$content_class   = ( $full_width_shop ) ? 'col-xs-12 col-md-8 col-lg-10' : 'col-xs-12 col-md-8 col-lg-9';
} else {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}

//$sidebar = Amely_Helper::get_active_sidebar( true );
$sidebar = false;

if ( ! $sidebar ) {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}

?>

<div class="illantas container wide<?php echo $full_width_shop ? ' wide' : ''; ?>">
	<div class="inner-page-wrap <?php echo esc_attr( $page_wrap_class ); ?>">
		<div id="main" class="site-content <?php echo esc_attr( $content_class ); ?>" role="main">


		<aside id="sidebar-search" class="widgets-illantas llantas sidebar">

			<h2 class="widget-title "> 
				Compara y compra la mejor llanta de coche
			</h2>			
			
			<div class="row">

				<div class="widget-area col1 col-xs-12 col-md-4">
					<?php dynamic_sidebar( 'idzonallantas1' ); ?>
				</div>
				
				<div class="widget-area col2 col-xs-12 col-md-4">
					<?php dynamic_sidebar( 'idzonallantas2' ); ?>
				</div>

				<div class="widget-area col3 col-xs-12 col-md-4">
					<?php dynamic_sidebar( 'idzonallantas3' ); ?>
				</div>
			</div>

		</aside>


			<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 * @hooked WC_Structured_Data::generate_website_data() - 30
			 */
			do_action( 'woocommerce_before_main_content' );
			?>

			<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );

			if ( have_posts() ) : ?>

				<div class="shop-loop-head row">
					<div class="shop-display col-xl-7 col-lg-6">
						<?php woocommerce_result_count(); ?>
					</div>
					<div class="shop-filter col-xl-5 col-lg-6">

						<?php

						if ( ! $shop_filters ) :
							woocommerce_catalog_ordering();
						endif;

						if ( $column_switcher ) :

							$columns = apply_filters( 'amely_shop_products_columns',
								array(
									'xs' => 1,
									'sm' => 2,
									'md' => 3,
									'lg' => 3,
									'xl' => get_option( 'woocommerce_catalog_columns', 5 ),
								) );

							?>
							<div class="col-switcher"
							     data-cols="<?php echo esc_attr( json_encode( $columns ) ); ?>"><?php esc_html_e( 'See:',
									'amely' ); ?>
								<a href="#" data-col="2">2</a>
								<a href="#" data-col="3">3</a>
								<a href="#" data-col="4">4</a>
								<a href="#" data-col="5">5</a>
								<a href="#" data-col="6">6</a>
							</div><!-- .col-switcher -->
						<?php endif; ?>

						<?php if ( $shop_filters ) : ?>
							<div class="amely-filter-buttons">
								<a href="#" class="open-filters"><?php _e( 'Filters', 'amely' ); ?></a>
							</div><!-- .amely-filter-buttons -->
						<?php endif; ?>
					</div>
				</div><!--.shop-loop-head -->

				<?php if ( $shop_filters ) : ?>
					<div class="filters-area">
						<div class="filters-inner-area row">
							<?php dynamic_sidebar( 'filters-area' ); ?>
						</div><!-- .filters-inner-area -->
					</div><!--.filters-area-->

					<div
						class="active-filters"><?php the_widget( 'WC_Widget_Layered_Nav_Filters' ); ?></div><!--.active-filters-->
				<?php endif; ?>

				<?php

				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {


					// Table format header

					?>
					<div class='product product-loop new post-106 type-product status-publish has-post-thumbnail product_cat-llantas'>
						<div class="wrap-first-columns"></div>
						<div class="attributes attr-header">
							<div class="attr-et attr"> <strong>Características</strong></div>
						</div>
						<div class="wrap-last-columns"></div>
					</div>
					<div class='product product-loop new post-106 type-product status-publish has-post-thumbnail product_cat-llantas'>
						<div class="wrap-first-columns"></div>
						<div class="attributes attr-header">
							<div class="attr-et attr"> <strong>ANCH.</strong></div>
							<div class="attr-et attr"> <strong>DIAM.</strong></div>
							<div class="attr-anclaje attr"> <strong>ANC.</strong></div>
							<div class="attr-et attr"> <strong>ET.</strong></div>
						</div>
						<div class="wrap-last-columns"></div>
					</div>

					<?php

					while ( have_posts() ) {
						the_post();

						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content', 'table-product' );

					}

				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
				?>

			<?php else: ?>

				<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
				?>

			<?php endif; ?>

			<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
			?>
		</div>
		<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */

		?>

		<?php
		//do_action( 'woocommerce_sidebar' );
		?>
	</div>
</div>

<?php get_footer( 'shop' ); ?>
