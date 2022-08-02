<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */


// add_action('woocommerce_after_single_product_summary','fn__',10,1);
function fn__(){
	global $product;
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
			}
		</style>
	<?php }

}