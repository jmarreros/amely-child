<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Enqueue child scripts
 */
add_action( 'wp_enqueue_scripts', 'amely_child_enqueue_scripts' );
if ( ! function_exists( 'amely_child_enqueue_scripts' ) ) {

	function amely_child_enqueue_scripts() {
		wp_enqueue_style( 'amely-main-style', trailingslashit( get_template_directory_uri() ) . '/style.css' );
		wp_enqueue_style( 'amely-child-style', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css' );
		wp_enqueue_script( 'amely-child-script',
			trailingslashit( get_stylesheet_directory_uri() ) . 'script.js',
			array( 'jquery' ),
			null,
			true );
	}

}


// Mostrar características adicionales de producto
add_action( 'woocommerce_shop_loop_item_title_amely', "ACF_product_content", 18 );
add_action( 'woocommerce_single_product_summary', "ACF_product_content", 18 );

function ACF_product_content(){
  if (function_exists('the_field')){
    echo "<p class='acf cf_dcp'>" . get_field('dcp') . "</p>";
    echo "<p class='acf cf_dimensiones'>" . get_field('dimensiones') . "</p>";
    echo "<p class='acf cf_color'>" . get_field('color') . "</p>";
  }
}

// Agregar nuevas zonas por categoría

function dcms_zona_llantas() {
	register_sidebar( array(
		'name'          => 'Zona Widget Llantas',
		'id'            => 'idzonallantas',
		'description'   => 'Widgets para la categoría Llantas',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dcms_zona_llantas' );

function dcms_zona_neumaticos() {
	register_sidebar( array(
		'name'          => 'Zona Widget Neumáticos',
		'id'            => 'idzonaneumaticos',
		'description'   => 'Widgets para la categoría Neumaticos',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dcms_zona_neumaticos' );








