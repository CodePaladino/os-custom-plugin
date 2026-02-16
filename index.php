<?php
/*
Plugin Name: OS-Custom
Description: Custom WooCommerce plugin for product categories with color and mood attributes
Version: 0.2
Author: Oliver Schönmehl
Author URI:  
License: GPL v2 or later
Requires PHP: 8.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue frontend scripts and styles
 */
function os_enqueue_frontend_assets() {
	wp_enqueue_style( 'os-custom-style', plugin_dir_url( __FILE__ ) . 'style.css', array(), '0.2' );
	wp_enqueue_script( 'os-custom-effects', plugin_dir_url( __FILE__ ) . 'effects.js', array( 'jquery' ), '0.2', true );
}
add_action( 'wp_enqueue_scripts', 'os_enqueue_frontend_assets' );

/**
 * Enqueue admin scripts for media upload
 */
function os_enqueue_admin_assets() {
	wp_enqueue_media();
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( 'os-custom-upload', plugin_dir_url( __FILE__ ) . 'imageupload.js', array( 'jquery', 'media-upload', 'thickbox' ), '0.2', true );
}
add_action( 'admin_enqueue_scripts', 'os_enqueue_admin_assets' ); 

/**
 * Enqueue color picker for admin
 */
function os_enqueue_color_picker( $hook_suffix ) {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'os-custom-colorpicker', plugins_url( 'colorpicker.js', __FILE__ ), array( 'wp-color-picker' ), '0.2', true );
}
add_action( 'admin_enqueue_scripts', 'os_enqueue_color_picker' );

/**
 * Shortcode to display color categories
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function bs_shortcode_farbkategorien( $atts ) {
	$atts = shortcode_atts( array(
		'cat'    => '',
		'subcat' => '',
	), $atts, 'farbkategorien' );

	$cat = sanitize_text_field( $atts['cat'] );
	$subcat = sanitize_text_field( $atts['subcat'] );
	
	if ( $subcat === '' ) {
	
		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( array( 
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' );
				
				// Check if term_parent exists and has a slug
				if ( $term_parent && isset( $term_parent->slug ) && $term_parent->slug === $cat ) {
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if ( $color !== '' && $typ === 'Farbe' ) {
						$url = esc_url( '/produktkategorie/' . $term_parent->slug . '/' . $term->slug . '/' );
						$html .= '<a href="' . $url . '">';
						$html .= '<div class="product-color-cat">';
						$html .= '<img src="' . esc_url( $color ) . '" alt="' . esc_attr( $term->name ) . '" />';
						$html .= '</div>';
						$html .= '</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
	else {

		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( array( 
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' );
				
				// Check if term_parent exists and has a slug
				if ( $term_parent && isset( $term_parent->slug ) && $term_parent->slug === $subcat ) {
				
					$term_parent2 = get_term_by( 'id', $term_parent->parent, 'product_cat' );
					
					// Check if term_parent2 exists
					if ( ! $term_parent2 ) {
						continue;
					}
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if ( $color !== '' && $typ === 'Farbe' ) {
						$url = esc_url( '/produktkategorie/' . $term_parent2->slug . '/' . $term_parent->slug . '/' . $term->slug . '/' );
						$html .= '<a href="' . $url . '">';
						$html .= '<div class="product-color-cat">';
						$html .= '<img src="' . esc_url( $color ) . '" alt="' . esc_attr( $term->name ) . '" />';
						$html .= '</div>';
						$html .= '</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
}
add_shortcode( 'farbkategorien', 'bs_shortcode_farbkategorien' );

/**
 * Shortcode to display mood/atmosphere categories
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function bs_shortcode_stimmungskategorien( $atts ) {
	$atts = shortcode_atts( array(
		'cat'    => '',
		'subcat' => '',
	), $atts, 'stimmungskategorien' );

	$cat = sanitize_text_field( $atts['cat'] );
	$subcat = sanitize_text_field( $atts['subcat'] );
	
	if ( $subcat === '' ) {
	
		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( array( 
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' );
				
				// Check if term_parent exists and has a slug
				if ( $term_parent && isset( $term_parent->slug ) && $term_parent->slug === $cat ) {
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if ( $color !== '' && $typ === 'Stimmung' ) {
						$url = esc_url( '/produktkategorie/' . $term_parent->slug . '/' . $term->slug . '/' );
						$html .= '<a href="' . $url . '">';
						$html .= '<div class="product-atmosphere-cat">';
						$html .= '<img src="' . esc_url( $color ) . '" alt="' . esc_attr( $term->name ) . '" />';
						$html .= '</div>';
						$html .= '</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
	else {

		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( array( 
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' );
				
				// Check if term_parent exists and has a slug
				if ( $term_parent && isset( $term_parent->slug ) && $term_parent->slug === $subcat ) {
				
					$term_parent2 = get_term_by( 'id', $term_parent->parent, 'product_cat' );
					
					// Check if term_parent2 exists
					if ( ! $term_parent2 ) {
						continue;
					}
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if ( $color !== '' && $typ === 'Stimmung' ) {
						$url = esc_url( '/produktkategorie/' . $term_parent2->slug . '/' . $term_parent->slug . '/' . $term->slug . '/' );
						$html .= '<a href="' . $url . '">';
						$html .= '<div class="product-atmosphere-cat">';
						$html .= '<img src="' . esc_url( $color ) . '" alt="' . esc_attr( $term->name ) . '" />';
						$html .= '</div>';
						$html .= '</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
}
add_shortcode( 'stimmungskategorien', 'bs_shortcode_stimmungskategorien' );

/**
 * Add custom fields to product category creation form
 */
function os_add_product_category_fields() {
	?>
	<div class="form-field">
		<label for="term_meta_color_img">Farb-Grafik</label>
		<input id="term_meta_color_img" type="text" size="36" name="term_meta[color_img]" value="" />
		<input id="upload_image_button" type="button" value="Grafik ausw&auml;hlen" />
	</div>
	<div class="form-field">
		<label>Ist Farbe oder Stimmung?</label>
		<fieldset>
			<input type="radio" id="typ_farbe_farbe" name="term_meta[typ_farbe]" value="Farbe" checked="checked" />
			<label for="typ_farbe_farbe">Farbe</label><br />
			<input type="radio" id="typ_farbe_stimmung" name="term_meta[typ_farbe]" value="Stimmung" />
			<label for="typ_farbe_stimmung">Stimmung</label>
		</fieldset>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'os_add_product_category_fields');

function add_product_cat_columns($columns) {
    $columns['color_img'] = 'Farb-Grafik';
    return $columns;
}
add_filter('manage_edit-product_cat_columns' , 'add_product_cat_columns');
	
/**
 * Display custom column content for product categories
 * 
 * @param string $content Column content
 * @param string $column_name Column name
 * @param int $id Term ID
 * @return string Column content
 */
function content_product_cat_columns( $content, $column_name, $id ) {
	if ( $column_name === 'color_img' ) {
		$term_meta = get_option( "product_cat_$id" );
		if ( isset( $term_meta['color_img'] ) && $term_meta['color_img'] !== '' ) {
			$img_url = esc_url( $term_meta['color_img'] );
			$content = '<img style="width:40px;height:40px;" src="' . $img_url . '" alt="' . esc_attr__( 'Category Image', 'os-custom' ) . '" />';
		}
	}
	return $content;
}
add_action( 'manage_product_cat_custom_column', 'content_product_cat_columns', 10, 3);

/**
 * Edit custom fields for product category
 * 
 * @param object $term Term object
 */
function os_edit_product_category_fields( $term ) {
	// Put the term ID into a variable
	$t_id = $term->term_id;
 
	// Retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "product_cat_$t_id" ); ?>

	<tr class="form-field term-name-wrap">
		<th scope="row"><label for="term_meta_color_img">Farb-Grafik</label></th>
		<td>
		<?php
		if ( isset( $term_meta['color_img'] ) && $term_meta['color_img'] !== '' ) {
			$img_url = esc_url( $term_meta['color_img'] );
			echo '<img style="width:40px;height:40px;" src="' . $img_url . '" alt="' . esc_attr__( 'Current Image', 'os-custom' ) . '" />';
		}
		?>
		<input id="term_meta_color_img" type="text" size="36" name="term_meta[color_img]" value="<?php echo isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : ''; ?>" />
		<input id="upload_image_button" type="button" value="Grafik ausw&auml;hlen" />
		</td>
	</tr>
	<tr class="form-field form-required term-name-wrap">
		<th scope="row"><label for="typ_farbe">Ist Farbe oder Stimmung?</label></th>
		<td>
		<fieldset>
		<input type="radio" id="typ_farbe_farbe" name="term_meta[typ_farbe]" value="Farbe" <?php 
		$typ_farbe = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : '';
		if ( $typ_farbe === '' || $typ_farbe === 'Farbe' ) { 
			echo 'checked="checked"'; 
		} 
		?> />
		<label for="typ_farbe_farbe">Farbe</label><br />
		<input type="radio" id="typ_farbe_stimmung" name="term_meta[typ_farbe]" value="Stimmung" <?php 
		if ( $typ_farbe === 'Stimmung' ) { 
			echo 'checked="checked"'; 
		} 
		?> />
		<label for="typ_farbe_stimmung">Stimmung</label>
		</fieldset>
		</td>
	</tr>

<?php
}
add_action( 'product_cat_edit_form_fields', 'os_edit_product_category_fields', 10, 1 );

/**
 * Save custom meta for product category taxonomy
 * 
 * @param int $term_id Term ID
 */
function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) && is_array( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "product_cat_$t_id" );
		if ( ! is_array( $term_meta ) ) {
			$term_meta = array();
		}
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset( $_POST['term_meta'][ $key ] ) ) {
				$term_meta[ $key ] = sanitize_text_field( wp_unslash( $_POST['term_meta'][ $key ] ) );
			}
		}
		// Save the option array
		update_option( "product_cat_$t_id", $term_meta );
	}
}  
add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_product_cat', 'save_taxonomy_custom_meta', 10, 2 );

/**
 * Display custom fields on single product page
 */
function wdm_add_custom_fields() {
	global $product;
	
	// Check if product object exists
	if ( ! $product ) {
		return;
	}
	
	$product_id = $product->get_id();
	
	?><div class="single-product-materialangabe" itemprop="materialangabe"><?php
	echo wp_kses_post( nl2br( get_post_meta( $product_id, 'woocommerce_materialangabe', true ) ) );
	?></div><?php
	
	?><div class="single-product-massangaben-link"><div class="inner-left">Ma&szlig;angaben</div><div class="inner-right">+</div><div style="clear:both"></div></div>
	<div class="single-product-massangaben" itemprop="massangaben"><?php
	echo wp_kses_post( nl2br( get_post_meta( $product_id, 'woocommerce_massangaben', true ) ) );
	?></div><?php
	
	?><div class="single-product-waschempfehlung-link"><div class="inner-left">Waschempfehlung</div><div class="inner-right">+</div><div style="clear:both"></div></div>
	<div class="single-product-waschempfehlung" itemprop="waschempfehlung"><?php
	echo wp_kses_post( nl2br( get_post_meta( $product_id, 'woocommerce_waschempfehlung', true ) ) );
	?></div><?php
}
add_action( 'woocommerce_single_product_summary', 'wdm_add_custom_fields', 21 );

//Zus�tzliche Felder im Produkt
add_action( 'woocommerce_product_options_pricing', 'wc_add_product_field' ); 
function wc_add_product_field() {

    woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_materialangabe', 'class' => '', 'label' => 'Materialangabe' ) );
	woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_massangaben', 'class' => '', 'label' => 'Ma&szlig;angaben' ) );
	woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_waschempfehlung', 'class' => '', 'label' => 'Waschempfehlung' ) );
	woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_besondere_merkmale', 'class' => '', 'label' => 'Besondere Merkmale' ) );
}

//speichere zus�tzliche Felder im Produkt
add_action( 'save_post', 'wc_save_product_field' );
/**
 * Save custom product fields
 * 
 * @param int $product_id Product ID
 */
function wc_save_product_field( $product_id ) {
	// If this is an autosave do nothing, we only save when update button is clicked
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Define fields to save
	$fields = array(
		'woocommerce_materialangabe',
		'woocommerce_massangaben',
		'woocommerce_waschempfehlung',
		'woocommerce_besondere_merkmale',
	);

	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $product_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
		} else {
			delete_post_meta( $product_id, $field );
		}
	}
}


//F�ge zus�tzliche Checkboxen auf der Kasse-Seite ein
add_action( 'woocommerce_review_order_before_submit', 'custom_woocommerce_add_terms' );
/**
 * Add custom terms checkboxes to checkout
 */
function custom_woocommerce_add_terms() {
	?>
	<p class="form-row terms">
		<input type="checkbox" class="input-checkbox" name="terms1" value="1" <?php checked( isset( $_POST['terms1'] ), true ); ?> id="terms1" />
		<label for="terms1" class="checkbox">Ich habe die <a href="<?php echo esc_url( '/datenschutz/' ); ?>" target="_blank">Datenschutzerkl&auml;rung</a> gelesen und akzeptiert.</label>
	</p>
	<p class="form-row terms">
		<input type="checkbox" class="input-checkbox" name="terms2" value="1" <?php checked( isset( $_POST['terms2'] ), true ); ?> id="terms2" />
		<label for="terms2" class="checkbox">Ich habe das <a href="<?php echo esc_url( '/widerrufsrecht/' ); ?>" target="_blank">Widerrufsrecht</a> zur Kenntnis genommen.</label>
	</p>
	<p class="form-row terms">
		<input type="checkbox" class="input-checkbox" name="terms3" value="1" <?php checked( isset( $_POST['terms3'] ), true ); ?> id="terms3" />
		<label for="terms3" class="checkbox">Ich habe die <a href="<?php echo esc_url( '/agb/' ); ?>" target="_blank">Allgemeinen Gesch&auml;ftsbedingungen (AGB)</a> und die <a href="<?php echo esc_url( '/lieferzeit-versandkosten/' ); ?>" target="_blank">Hinweise zu Lieferzeit &amp; Versandkosten</a> gelesen und akzeptiert.</label>
	</p>
	<?php
}


add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');
/**
 * Validate custom checkout fields
 */
function my_custom_checkout_field_process() {
	if ( empty( $_POST['terms1'] ) ) {
		wc_add_notice( 'Du musst die <strong>Datenschutzerkl&auml;rung</strong> lesen und akzeptieren.', 'error' );
	}
	if ( empty( $_POST['terms2'] ) ) {
		wc_add_notice( 'Du musst das <strong>Widerrufsrecht</strong> zur Kenntnis nehmen.', 'error' );
	}
	if ( empty( $_POST['terms3'] ) ) {
		wc_add_notice( 'Du musst die <strong>Allgemeinen Gesch&auml;ftsbedingungen (AGB)</strong> und <strong>Hinweise zu Lieferzeit & Versandkosten</strong> lesen und akzeptieren', 'error' );
	}
}

/**
 * Count mood/atmosphere articles in a category
 * 
 * @param string $cat Parent category slug
 * @param string $subcat Sub-category slug
 * @return int Number of mood articles
 */
function bs_anzahl_stimmungsartikel( $cat, $subcat ) {
	$anzahl = 0;
	
	$terms = get_terms( array( 
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	
		foreach ( $terms as $term ) {
			$term_id = $term->term_id;
			$term_parent = get_term_by( 'id', $term->parent, 'product_cat' );

			if ( $term_parent && isset( $term_parent->slug ) && $term_parent->slug === $subcat ) {
				$term_meta = get_option( "product_cat_$term_id" );
				$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
				$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
				
				if ( $color !== '' && $typ === 'Stimmung' ) {
					$anzahl++;
				}
			}
		}
	}
	return $anzahl;
}

/**
 * Count color articles in a category
 * 
 * @param string $cat Parent category slug
 * @param string $subcat Sub-category slug
 * @return int Number of color articles
 */
function bs_anzahl_farbartikel( $cat, $subcat ) {
	$anzahl = 0;
	
	$terms = get_terms( array( 
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	
		foreach ( $terms as $term ) {
			$term_id = $term->term_id;
			$term_parent = get_term_by( 'id', $term->parent, 'product_cat' );

			if ( $term_parent && isset( $term_parent->slug ) && $term_parent->slug === $subcat ) {
				$term_meta = get_option( "product_cat_$term_id" );
				$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
				$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
				
				if ( $color !== '' && $typ === 'Farbe' ) {
					$anzahl++;
				}
			}
		}
	}
	return $anzahl;
}

/**
 * Add color and atmosphere categories to product category pages
 */
function os_add_color_and_atmophere_to_product_categories() {
	$q_object = get_queried_object();
	if ( ! isset( $q_object->taxonomy ) ) {
		return;
	}
	
	$taxonomy = $q_object->taxonomy;
	
	if ( $taxonomy === 'product_cat' ) {
		$parent = $q_object->parent;
		
		$category = get_term_by( 'id', $parent, $taxonomy );
		$sub_category = get_term_by( 'id', get_queried_object_id(), $taxonomy );
		
		// Check if category and sub_category exist
		if ( ! $category || ! $sub_category ) {
			return;
		}
		
		$content = '';
		
		// Farben
		if ( bs_anzahl_farbartikel( $category->slug, $sub_category->slug ) > 0 ) {
			$content = '[vc_row][vc_column width="1/1"][vc_column_text]';
			$content .= '<h4 style="text-align: center;">Was ist Deine Lieblingsfarbe?</h4>';
			$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
			$content .= '[farbkategorien cat="' . esc_attr( $category->slug ) . '" subcat="' . esc_attr( $sub_category->slug ) . '"]';
			$content .= '[/vc_column_text][/vc_column][/vc_row]';
		} else { // Wenn die unterste Ebene erreicht ist
			$term_id = $sub_category->term_id;
			$term_meta = get_option( "product_cat_$term_id" );
			$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
			$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
			
			if ( $color !== '' && $typ === 'Farbe' ) {
				$content .= '[vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '<h4 style="text-align: center;">Auf welche Farbe hast du noch Lust?</h4>';
				$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '[farbkategorien cat="' . esc_attr( $category->slug ) . '"]';
				$content .= '[/vc_column_text][/vc_column][/vc_row]';
			}
		}
		
		// Stimmungen - nur Anzeigen wenn mindestens 1 Stimmungsartikel vorhanden ist
		if ( bs_anzahl_stimmungsartikel( $category->slug, $sub_category->slug ) > 0 ) {
			$content .= '[vc_row][vc_column width="1/1"][vc_column_text]';
			$content .= '<h4 style="text-align: center;">Nichts passendes gefunden? Schau doch einfach mal hier.</h4>';
			$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
			$content .= '[stimmungskategorien cat="' . esc_attr( $category->slug ) . '" subcat="' . esc_attr( $sub_category->slug ) . '"]';
			$content .= '[/vc_column_text][/vc_column][/vc_row]';
		} else { // Wenn die unterste Ebene erreicht ist
			$term_id = $sub_category->term_id;
			$term_meta = get_option( "product_cat_$term_id" );
			$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
			$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
			
			if ( $color !== '' && $typ === 'Stimmung' ) {
				$content .= '[vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '<h4 style="text-align: center;">Nichts passendes gefunden? Schau doch einfach mal hier.</h4>';
				$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '[stimmungskategorien cat="' . esc_attr( $category->slug ) . '"]';
				$content .= '[/vc_column_text][/vc_column][/vc_row]';
			}
		}
		
		echo do_shortcode( $content );
	}
}
add_action( 'woocommerce_after_shop_loop2', 'os_add_color_and_atmophere_to_product_categories' );


/**
 * Add other categories to product category pages
 */
function os_add_other_categories() {
	$q_object = get_queried_object();
	if ( ! isset( $q_object->taxonomy ) ) {
		return;
	}
	
	$taxonomy = $q_object->taxonomy;
	
	if ( $taxonomy === 'product_cat' ) {
		$parent = $q_object->parent;
		
		$category = get_term_by( 'id', $parent, $taxonomy );
		$sub_category = get_term_by( 'id', get_queried_object_id(), $taxonomy );
		
		// Check if category and sub_category exist
		if ( ! $category || ! $sub_category ) {
			return;
		}
		
		$cat = $category->slug;
		$subcat = $sub_category->slug;
		$terms = get_terms( array( 
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' );
				
				if ( $term_parent && isset( $term_parent->slug ) && $term_parent->slug === $category->slug ) {
					$term_meta = get_option( "product_cat_$term_id" );
					$color = isset( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = isset( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if ( $color === '' ) {
						$url = esc_url( '/produktkategorie/' . $category->slug . '/' . $term->slug . '/' );
						echo '<a href="' . $url . '">' . esc_html( $term->name ) . '</a><br />';
						
						// Hole Unterkategorien
						$u_terms = get_terms( array( 
							'taxonomy'   => 'product_cat',
							'hide_empty' => false,
						) );
						if ( ! empty( $u_terms ) && ! is_wp_error( $u_terms ) ) {
						
							foreach ( $u_terms as $u_term ) {
								$u_term_id = $u_term->term_id;
								$u_term_parent = get_term_by( 'id', $u_term->parent, 'product_cat' );
								
								if ( $u_term_parent && isset( $u_term_parent->slug ) && $u_term_parent->slug === $term->slug ) {
									$u_term_meta = get_option( "product_cat_$u_term_id" );
									$u_color = isset( $u_term_meta['color_img'] ) ? esc_attr( $u_term_meta['color_img'] ) : '';
									$u_typ = isset( $u_term_meta['typ_farbe'] ) ? esc_attr( $u_term_meta['typ_farbe'] ) : 'Farbe';
									
									if ( $u_color === '' ) {
										$u_url = esc_url( '/produktkategorie/' . $category->slug . '/' . $term->slug . '/' . $u_term->slug . '/' );
										echo '<a style="margin-left:15px;font-size:0.9em;" href="' . $u_url . '">' . esc_html( $u_term->name ) . '</a><br />';
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
add_action( 'woocommerce_after_shop_loop3', 'os_add_other_categories' );

