
jQuery(document).ready(function() {  
	
	jQuery( '#calc_shipping_country' ).change(function() {
		var val = jQuery( this ).val();
		if(val == 'IS' || val == 'CH' || val == 'NO' ) {
			jQuery( '.nicht-eu-shipping-hinweis' ).css( 'display', 'block' );
		}
		else {
			jQuery( '.nicht-eu-shipping-hinweis' ).css( 'display', 'none' );
		}
	});
	
	jQuery( 'select#billing_country').change(function() {
		var val = jQuery( this ).val();
		if(val == 'IS' || val == 'CH' || val == 'NO' ) {
			jQuery( '#billing_country_field label' ).html( 'Land <abbr class="required" title="erforderlich">*</abbr><div style="font-weight:400;" class="nicht-eu-shipping-hinweis"><small>Bei Lieferung in L&auml;nder au&szlig;erhalb der EU k&ouml;nnen zus&auml;tzlich zum Kaufpreis l&auml;nderspezifische Einfuhrabgaben und Z&ouml;lle anfallen, die der K&auml;ufer zu tragen hat.</small></div>' );
		}
		else {
			jQuery( '#billing_country_field label' ).html( 'Land <abbr class="required" title="erforderlich">*</abbr>' );
		}
	});
	
	var single_product_massangaben_link=0;
	var single_product_waschempfehlung_link=0;
	
	jQuery( ".single-product-massangaben-link" ).click(function(){
		
		if(single_product_massangaben_link==0) {
			jQuery( ".single-product-massangaben" ).slideDown(250);
			single_product_massangaben_link=1;
		}
		else {
			jQuery( ".single-product-massangaben" ).slideUp(250);
			single_product_massangaben_link=0;
		}
	});
	
	jQuery( ".single-product-waschempfehlung-link" ).click(function(){
		if(single_product_waschempfehlung_link==0) {
			jQuery( ".single-product-waschempfehlung" ).slideDown(250);
			single_product_waschempfehlung_link=1;
		}
		else {
			jQuery( ".single-product-waschempfehlung" ).slideUp(250);
			single_product_waschempfehlung_link=0;
		}
	});
	
	
	jQuery( "div.single-product-price" ).append( '<div class="subprice">(Preis inkl. MwSt. zzgl. <a target="_blank" href="/lieferzeit-versandkosten/">Versandkosten</a>)</div>');
	
	jQuery( ".home-hovertext" ).hover(function(){
		jQuery( this ).children( ".hovertext" ).show();
	},
	function(){
		jQuery( ".hovertext").hide();
	});
});