<?php
/**
 * Template Name: Products Shop
 */
get_header();


$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
	'menu_order' => __( 'Default sorting', 'woocommerce' ),
	'popularity' => __( 'Sort by popularity', 'woocommerce' ),
	'rating'     => __( 'Sort by average rating', 'woocommerce' ),
	'date'       => __( 'Sort by newness', 'woocommerce' ),
	'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
	'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
) );

$default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
$orderby         = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

if ( wc_get_loop_prop( 'is_search' ) ) {
	$catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );

	unset( $catalog_orderby_options['menu_order'] );
}

if ( ! $show_default_orderby ) {
	unset( $catalog_orderby_options['menu_order'] );
}

if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
	unset( $catalog_orderby_options['rating'] );
}

if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
	$orderby = current( array_keys( $catalog_orderby_options ) );
}
?>
<div class="container" style="margin-bottom: 16px;">
	<?php
	wc_get_template( 'loop/orderby.php', array(
		'catalog_orderby_options' => $catalog_orderby_options,
		'orderby'                 => $orderby,
		'show_default_orderby'    => $show_default_orderby,
	) );
	?>
</div>
<?php

$order_by = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : '';

if ( 'price' === $order_by ) {
    $meta_key = '_regular_price';
    $order = 'ASC';
}
if ( 'price-desc' === $order_by ) {
	$meta_key = '_regular_price';
	$order = 'DESC';
}
if ( 'rating' === $order_by ) {
	$meta_key = '_wc_average_rating';
	$order = 'DESC';
}
if ( 'popularity' === $order_by ) {
	$meta_key = '_wc_review_count';
	$order = 'DESC';
}

$args = array(
	'post_type' => 'product',
	'meta_key' => $meta_key,
	'orderby' => 'meta_value',
	'order' => $order,
//	'tax_query' => array(
//		array(
//			'taxonomy' => 'product_cat',
//			'field'    => 'slug',
//			'terms'    => 'women',
//		),
//	)
);

$result = new WP_Query( $args );


?>
<div class="container">
	<div class="row">
		<?php
		if ( $result->have_posts() ) {
			while ( $result->have_posts() ) : $result->the_post();
			$default_img = '<img src="' . site_url() . '/wp-content/uploads/2018/06/noimg.jpeg' . '"/>';
			$img = ( get_the_post_thumbnail() ) ? get_the_post_thumbnail() : $default_img;
			$id = get_the_ID();
			?>
			<div class="col-md-4">
				<div><a href="<?php the_permalink(); ?>"><?php echo $img; ?></a></div>
				<h4 class="text-center"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
				<div><?php echo do_shortcode( '[add_to_cart id="' . $id . '"]' )?></div>
			</div>
		<?php
			endwhile;
		}
		?>
	</div>
</div>


<?php get_footer(); ?>
