<?php
/*
Plugin Name: OS-Custom
Description: 
Version: 0.1
Author: Oliver Sch&ouml;nmehl
Author URI:  
License:  
*/


wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');
wp_register_script('my-upload', plugin_dir_url( __FILE__ ).'imageupload.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');


wp_enqueue_style('bs_style', plugin_dir_url( __FILE__ ) . 'style.css','1.0');

function bs_plugin_add_javascript()
{ 
	echo '<script type="text/javascript" src="'.plugin_dir_url( __FILE__ ).'effects.js"></script>';
} 
add_action('wp_footer', 'bs_plugin_add_javascript', 1000); 

add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'my-script-handle', plugins_url('colorpicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

function bs_shortcode_farbkategorien( $atts ) {

	$cat = $atts['cat'];
	$subcat = $atts['subcat'];
	
	if($subcat == '') {
	
		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( 'product_cat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' ); 
				
				if($term_parent->slug == $cat) {
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if($color != '' && $typ == 'Farbe') {
						$html .= '<a href="/produktkategorie/'.$term_parent->slug.'/'.$term->slug.'/';
						$html .= '">
						<div class="product-color-cat">
						<img src="';
						$html .= esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
						$html .= '" />
						</div>
						</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
	else {

		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( 'product_cat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' ); 
				
				if($term_parent->slug == $subcat) {
				
					$term_parent2 = get_term_by( 'id', $term_parent->parent, 'product_cat' ); 
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if($color != '' && $typ == 'Farbe') {
						$html .= '<a href="/produktkategorie/'.$term_parent2->slug.'/'.$term_parent->slug.'/'.$term->slug.'/';
						$html .= '">
						<div class="product-color-cat">
						<img src="';
						$html .= esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
						$html .= '" />
						</div>
						</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
}
add_shortcode( 'farbkategorien', 'bs_shortcode_farbkategorien' );

function bs_shortcode_stimmungskategorien( $atts ) {

	$cat = $atts['cat'];
	$subcat = $atts['subcat'];
	
	if($subcat == '') {
	
		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( 'product_cat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' ); 
				
				if($term_parent->slug == $cat) {
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if($color != '' && $typ == 'Stimmung') {
						$html .= '<a href="/produktkategorie/'.$term_parent->slug.'/'.$term->slug.'/">
						<div class="product-atmosphere-cat">
						<img src="';
						$html .= esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
						$html .= '" />
						</div>
						</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
	else {

		$html = '<div class="product-color-cat-container">';
		$terms = get_terms( 'product_cat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
				$term_parent = get_term_by( 'id', $term->parent, 'product_cat' ); 
				
				if($term_parent->slug == $subcat) {
				
					$term_parent2 = get_term_by( 'id', $term_parent->parent, 'product_cat' ); 
				
					$term_meta = get_option( "product_cat_$term_id" );
					$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
					$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
					
					if($color != '' && $typ == 'Stimmung') {
						$html .= '<a href="/produktkategorie/'.$term_parent2->slug.'/'.$term_parent->slug.'/'.$term->slug.'/">
						<div class="product-atmosphere-cat">
						<img src="';
						$html .= esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
						$html .= '" />
						</div>
						</a>';
					}
				}
			}
		}
		$html .= '<div style="clear:both;"></div></div>';
		return $html;
	}
}
add_shortcode( 'stimmungskategorien', 'bs_shortcode_stimmungskategorien' );

function os_add_product_category_fields() {
	?>
	<div class="form-field">
	<label>Farb-Grafik</label>
	<!--<input id="colorpicker" name="term_meta[color]" id="term_meta[color]" />-->
	<input id="upload_image" type="text" size="36" name="term_meta[color_img]" value="" />
	<input id="upload_image_button" type="button" value="Grafik ausw&auml;hlen" />
	</div>
	<div class="form-field">
	<label>Ist Farbe oder Stimmung?</label>
	<fieldset>
	<input type="radio" name="term_meta[typ_farbe]" value="Farbe" checked="checked" /> Farbe<br />
	<input type="radio" name="term_meta[typ_farbe]" value="Stimmung" /> Stimmung
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
	
function content_product_cat_columns( $column, $column_name, $id ) {
	
	if($column_name == 'color_img') {
		$term_meta = get_option( "product_cat_$id" );
		if($term_meta['color_img'] != '') {
			echo '<img style="width:40px;height:40px;" src="';
			echo esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
			echo '" />';
		}
	}
}
add_action( 'manage_product_cat_custom_column', 'content_product_cat_columns', 10, 3);

function os_edit_product_category_fields($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "product_cat_$t_id" ); ?>

	<!-- <tr class="form-field form-required term-name-wrap"> -->
	<tr class="form-field term-name-wrap">
		<th scope="row"><label for="name">Farb-Grafik</label></th>
		<td>
		<?php
		if($term_meta['color_img'] != '') {
			echo '<img style="width:40px;height:40px;" src="';
			echo esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
			echo '" />';
		}
		?>
		<input id="upload_image" type="text" size="36" name="term_meta[color_img]" value="<?php echo esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : ''; ?>" />
		<input id="upload_image_button" type="button" value="Grafik ausw&auml;hlen" />
		</td>
	</tr>
	<tr class="form-field form-required term-name-wrap">
		<th scope="row"><label for="name">Ist Farbe oder Stimmung?</label></th>
		<td>
		<fieldset>
		<input type="radio" name="term_meta[typ_farbe]" value="Farbe" <?php 
		if(esc_attr( $term_meta['typ_farbe']) == ''
		|| esc_attr( $term_meta['typ_farbe']) == 'Farbe') { echo 'checked="checked" '; } 
		?>/> Farbe<br />
		<input type="radio" name="term_meta[typ_farbe]" value="Stimmung" <?php 
		if(esc_attr( $term_meta['typ_farbe']) == 'Stimmung') { echo 'checked="checked" '; } 
		?>/> Stimmung
		</fieldset>
		</td>
	</tr>


<?php
}
add_action( 'product_cat_edit_form_fields', 'os_edit_product_category_fields', 10, 1 );

function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "product_cat_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "product_cat_$t_id", $term_meta );
	}
}  
add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_product_cat', 'save_taxonomy_custom_meta', 10, 2 );

function wdm_add_custom_fields()
{
	global $product;

	?><div class="single-product-materialangabe" itemprop="materialangabe"><?php
	echo nl2br(get_post_meta( $product->id, 'woocommerce_materialangabe', true ));
	?></div><?php
	
	?><div class="single-product-massangaben-link"><div class="inner-left">Ma&szlig;angaben</div><div class="inner-right">+</div><div style="clear:both"></div></div>
	<div class="single-product-massangaben" itemprop="massangaben"><?php
	echo nl2br(get_post_meta( $product->id, 'woocommerce_massangaben', true ));
	?></div><?php
	
	?><div class="single-product-waschempfehlung-link"><div class="inner-left">Waschempfehlung</div><div class="inner-right">+</div><div style="clear:both"></div></div>
	<div class="single-product-waschempfehlung" itemprop="waschempfehlung"><?php
	echo nl2br(get_post_meta( $product->id, 'woocommerce_waschempfehlung', true ));
	?></div><?php
}
add_action( 'woocommerce_single_product_summary', 'wdm_add_custom_fields', 21 );

//Zusätzliche Felder im Produkt
add_action( 'woocommerce_product_options_pricing', 'wc_add_product_field' ); 
function wc_add_product_field() {

    woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_materialangabe', 'class' => '', 'label' => 'Materialangabe' ) );
	woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_massangaben', 'class' => '', 'label' => 'Ma&szlig;angaben' ) );
	woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_waschempfehlung', 'class' => '', 'label' => 'Waschempfehlung' ) );
	woocommerce_wp_textarea_input( array( 'id' => 'woocommerce_besondere_merkmale', 'class' => '', 'label' => 'Besondere Merkmale' ) );
}

//speichere zusätzliche Felder im Produkt
add_action( 'save_post', 'wc_save_product_field' );
function wc_save_product_field( $product_id ) {

    // If this is a auto save do nothing, we only save when update button is clicked
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ return; }
	
	if ( isset( $_POST['woocommerce_materialangabe'] ) ) {
		update_post_meta( $product_id, 'woocommerce_materialangabe', $_POST['woocommerce_materialangabe'] );
	} else {
		delete_post_meta( $product_id, 'woocommerce_materialangabe' );
	}
	
	if ( isset( $_POST['woocommerce_massangaben'] ) ) {
		update_post_meta( $product_id, 'woocommerce_massangaben', $_POST['woocommerce_massangaben'] );
	} else {
		delete_post_meta( $product_id, 'woocommerce_massangaben' );
	}
	
	if ( isset( $_POST['woocommerce_waschempfehlung'] ) ) {
		update_post_meta( $product_id, 'woocommerce_waschempfehlung', $_POST['woocommerce_waschempfehlung'] );
	} else {
		delete_post_meta( $product_id, 'woocommerce_waschempfehlung' );
	}
	
	if ( isset( $_POST['woocommerce_besondere_merkmale'] ) ) {
		update_post_meta( $product_id, 'woocommerce_besondere_merkmale', $_POST['woocommerce_besondere_merkmale'] );
	} else {
		delete_post_meta( $product_id, 'woocommerce_besondere_merkmale' );
	}
}


//Füge zusätzliche Checkboxen auf der Kasse-Seite ein
add_action( 'woocommerce_review_order_before_submit', 'custom_woocommerce_add_terms' );
function custom_woocommerce_add_terms(  ) {
    global $woocommerce;
 
	?>
	<p class="form-row terms">
		<input type="checkbox" class="input-checkbox" name="terms1" value="1" <?php checked( isset( $_POST['terms1'] ), 1, true ); ?> id="terms1" />
		<label for="terms" class="checkbox">Ich habe die <a href="/datenschutz/" target="_blank">Datenschutzerkl&auml;rung</a> gelesen und akzeptiert.</label>
	</p>
	<p class="form-row terms">
		<input type="checkbox" class="input-checkbox" name="terms2" value="1" <?php checked( apply_filters( 'woocommerce_terms2_is_checked_default', isset( $_POST['terms2'] ) ), true ); ?> id="terms2" />
		<label for="terms" class="checkbox">Ich habe das <a href="/widerrufsrecht/" target="_blank">Widerrufsrecht</a> zur Kenntnis genommen.</label>
	</p>
    <p class="form-row terms">
		<input type="checkbox" class="input-checkbox" name="terms3" value="1" <?php checked( apply_filters( 'woocommerce_terms3_is_checked_default', isset( $_POST['terms3'] ) ), true ); ?> id="terms3" />
		<label for="terms" class="checkbox">Ich habe die <a href="/agb/" target="_blank">Allgemeinen Gesch&auml;ftsbedingungen (AGB)</a> und die <a href="/lieferzeit-versandkosten/" target="_blank">Hinweise zu Lieferzeit & Versandkosten</a> gelesen und akzeptiert.</label>
	</p>
	<?php
}


add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');
function my_custom_checkout_field_process() {

    if ( ! $_POST['terms1'] ) {
        wc_add_notice( 'Du musst die <strong>Datenschutzerkl&auml;rung</strong> lesen und akzeptieren.' , 'error' );
	}
	if ( ! $_POST['terms2'] ) {
        wc_add_notice( 'Du musst das <strong>Widerrufsrecht</strong> zur Kenntnis nehmen.' , 'error' );
	}
	if ( ! $_POST['terms3'] ) {
        wc_add_notice( 'Du musst die <strong>Allgemeinen Gesch&auml;ftsbedingungen (AGB)</strong> und <strong>Hinweise zu Lieferzeit & Versandkosten</strong> lesen und akzeptieren' , 'error' );
	}
}

function bs_anzahl_stimmungsartikel( $cat, $subcat ) {
	
	$anzahl=0;
	
	$terms = get_terms( 'product_cat' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	
		foreach ( $terms as $term ) {
			$term_id = $term->term_id;
			$term_parent = get_term_by( 'id', $term->parent, 'product_cat' ); 

			if($term_parent->slug == $subcat) {
				
				$term_meta = get_option( "product_cat_$term_id" );
				$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
				$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
				
				if($color != '' && $typ == 'Stimmung') {
					$anzahl++;
				}
			}
		}
	}
	return $anzahl;
}

function bs_anzahl_farbartikel( $cat, $subcat ) {
	
	$anzahl=0;
	
	$terms = get_terms( 'product_cat' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	
		foreach ( $terms as $term ) {
			$term_id = $term->term_id;
			$term_parent = get_term_by( 'id', $term->parent, 'product_cat' ); 

			if($term_parent->slug == $subcat) {
				
				$term_meta = get_option( "product_cat_$term_id" );
				$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
				$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
				
				if($color != '' && $typ == 'Farbe') {
					$anzahl++;
				}
			}
		}
	}
	return $anzahl;
}

function os_add_color_and_atmophere_to_product_categories(  ) {

	$q_object = get_queried_object();
	if( isset($q_object->taxonomy) ){
		$taxonomy = $q_object->taxonomy;
		
		if($taxonomy == 'product_cat') {
			
			$parent = $q_object->parent;
			
			$category = get_term_by('id', $parent, $taxonomy);
			$sub_category = get_term_by('id', get_queried_object_id(), $taxonomy);
			
			//Farben
			if(bs_anzahl_farbartikel($category->slug,$sub_category->slug)>0) {
				$content = '[vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '<h4 style="text-align: center;">Was ist Deine Lieblingsfarbe?</h4>';
				$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '[farbkategorien cat="'.$category->slug.'" subcat="'.$sub_category->slug.'"]';
				$content .= '[/vc_column_text][/vc_column][/vc_row]';
			}
			else { //wenn die unterste Ebene erreicht ist
				$term_id = $sub_category->term_id;
				$term_meta = get_option( "product_cat_$term_id" );
				$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
				$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
				
				if($color != '' && $typ == 'Farbe') {
					$content .= '[vc_row][vc_column width="1/1"][vc_column_text]';
					$content .= '<h4 style="text-align: center;">Auf welche Farbe hast du noch Lust?</h4>';
					$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
					$content .= '[farbkategorien cat="'.$category->slug.'"]';
					$content .= '[/vc_column_text][/vc_column][/vc_row]';
				}
			}
			
			//Stimmungen - nur Anzeigen wenn mindestens 1 Stimmungsartikel vorhanden ist
			if(bs_anzahl_stimmungsartikel($category->slug,$sub_category->slug)>0) {
				$content .= '[vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '<h4 style="text-align: center;">Nichts passendes gefunden? Schau doch einfach mal hier.</h4>';
				$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
				$content .= '[stimmungskategorien cat="'.$category->slug.'" subcat="'.$sub_category->slug.'"]';
				$content .= '[/vc_column_text][/vc_column][/vc_row]';
			}
			else { //wenn die unterste Ebene erreicht ist
				$term_id = $sub_category->term_id;
				$term_meta = get_option( "product_cat_$term_id" );
				$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
				$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
				
				if($color != '' && $typ == 'Stimmung') {
					$content .= '[vc_row][vc_column width="1/1"][vc_column_text]';
					$content .= '<h4 style="text-align: center;">Nichts passendes gefunden? Schau doch einfach mal hier.</h4>';
					$content .= '[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/1"][vc_column_text]';
					$content .= '[stimmungskategorien cat="'.$category->slug.'"]';
					$content .= '[/vc_column_text][/vc_column][/vc_row]';
				}
			}
			
			echo do_shortcode( $content );
		}
	}
}
add_action( 'woocommerce_after_shop_loop2', 'os_add_color_and_atmophere_to_product_categories' );


function os_add_other_categories(  ) {

	$q_object = get_queried_object();
	if( isset($q_object->taxonomy) ){
		$taxonomy = $q_object->taxonomy;
		
		if($taxonomy == 'product_cat') {
			
			$parent = $q_object->parent;
			
			$category = get_term_by('id', $parent, $taxonomy);
			$sub_category = get_term_by('id', get_queried_object_id(), $taxonomy);
			
			$cat = $category->slug;
			$subcat = $sub_category->slug;
			$terms = get_terms( 'product_cat' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			
				foreach ( $terms as $term ) {
					$term_id = $term->term_id;
					$term_parent = get_term_by( 'id', $term->parent, 'product_cat' ); 
					
					if($term_parent->slug==$category->slug /*&& $term->slug!=$sub_category->slug*/) {
						
						$term_meta = get_option( "product_cat_$term_id" );
						$color = esc_attr( $term_meta['color_img'] ) ? esc_attr( $term_meta['color_img'] ) : '';
						$typ = esc_attr( $term_meta['typ_farbe'] ) ? esc_attr( $term_meta['typ_farbe'] ) : 'Farbe';
						
						if($color == '') {
							echo '<a href="/produktkategorie/'.$category->slug.'/'.$term->slug.'/">'.$term->name.'</a><br />';
							
							//hole Unterkategorien
							$u_terms = get_terms( 'product_cat' );
							if ( ! empty( $u_terms ) && ! is_wp_error( $u_terms ) ){
							
								foreach ( $u_terms as $u_term ) {
									$u_term_id = $u_term->term_id;
									$u_term_parent = get_term_by( 'id', $u_term->parent, 'product_cat' ); 
									
									if($u_term_parent->slug==$term->slug) {
										
										$u_term_meta = get_option( "product_cat_$u_term_id" );
										$color = esc_attr( $u_term_meta['color_img'] ) ? esc_attr( $u_term_meta['color_img'] ) : '';
										$typ = esc_attr( $u_term_meta['typ_farbe'] ) ? esc_attr( $u_term_meta['typ_farbe'] ) : 'Farbe';
										
										if($color == '') {
											echo '<a style="margin-left:15px;font-size:0.9em;" href="/produktkategorie/'.$category->slug.'/'.$term->slug.'/'.$u_term->slug.'/">'.$u_term->name.'</a><br />';
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
}
add_action( 'woocommerce_after_shop_loop3', 'os_add_other_categories' );

