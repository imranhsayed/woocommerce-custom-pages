<?php
/*
 * Template Name: Product Categories
 */
get_header();
?>
<?php //echo do_shortcode( '[product_categories]' );?>
<?php

$args = array(
	'taxonomy'          => 'product_cat',
	'hide_empty'        => false,
    );
$result = get_terms( $args );
?>

<div class="container">
	<div class="row">
		<?php
		foreach ( $result as $cat ) {
			if ( 'Uncategorized' !== $cat->name ) {
			$term_link = get_term_link( $cat, 'product_cat' );
			$cat_thumb_id =	get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$shop_catalog_img_arr = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
			$cat_img = $shop_catalog_img_arr[0];
				?>
			<div class="col-md-4">
				<div>
					<a href="<?php echo $term_link; ?>"><img src="<?php echo $cat_img; ?>" alt=""></a>
				</div>
				<div>
					<a href="<?php echo $term_link; ?>">
						<?php echo $cat->name; ?><span>( <?php echo $cat->count;?> )</span>
					</a>
				</div>
			</div>
		<?php
			}
		}
		?>
	</div>
</div>


<?php get_footer(); ?>
