<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>
	<?php 
	$product_id = $product->get_id();
	$specification = get_field('_product_specification',$product_id);
	if($specification){ ?>
		<div class="product-specification">
			<div class="details">
				<?php foreach ($specification as $value) { ?>
					<div class="rows">
						<div class="cols">
							<div class="img"><img src="<?php echo $value['icon']; ?>"></div>
							<div class="content">
								<h4 class="title"><?php echo $value['title']; ?></h4>
								<p class="desc"><?php echo $value['description']; ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<style type="text/css">
			.product-specification{
				background: #4ea8d959;
    			padding: 20px;
    			display: inline-block;
			}
			.product-specification .details{
				display: grid;
			    grid-template-columns: 1fr 1fr;
			    align-items: start;
			    column-gap: 20px;
			    row-gap: 20px;
			}
			.cols {
			    display: flex;
			    align-items: flex-start;
			}
			.product-specification .cols .img{
				width: 15%;
			}
			.product-specification .cols .content{
				width: 80%;
				margin-left: 20px;
			}
		</style>
	<?php } 
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
