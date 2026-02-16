
jQuery(document).ready(function($) {
	
	$('#calc_shipping_country').change(function() {
		var val = $(this).val();
		if (val === 'IS' || val === 'CH' || val === 'NO') {
			$('.nicht-eu-shipping-hinweis').css('display', 'block');
		} else {
			$('.nicht-eu-shipping-hinweis').css('display', 'none');
		}
	});
	
	$('select#billing_country').change(function() {
		var val = $(this).val();
		if (val === 'IS' || val === 'CH' || val === 'NO') {
			$('#billing_country_field label').html('Land <abbr class="required" title="erforderlich">*</abbr><div style="font-weight:400;" class="nicht-eu-shipping-hinweis"><small>Bei Lieferung in L&auml;nder au&szlig;erhalb der EU k&ouml;nnen zus&auml;tzlich zum Kaufpreis l&auml;nderspezifische Einfuhrabgaben und Z&ouml;lle anfallen, die der K&auml;ufer zu tragen hat.</small></div>');
		} else {
			$('#billing_country_field label').html('Land <abbr class="required" title="erforderlich">*</abbr>');
		}
	});
	
	var single_product_massangaben_link = 0;
	var single_product_waschempfehlung_link = 0;
	
	$('.single-product-massangaben-link').click(function() {
		if (single_product_massangaben_link === 0) {
			$('.single-product-massangaben').slideDown(250);
			single_product_massangaben_link = 1;
		} else {
			$('.single-product-massangaben').slideUp(250);
			single_product_massangaben_link = 0;
		}
	});
	
	$('.single-product-waschempfehlung-link').click(function() {
		if (single_product_waschempfehlung_link === 0) {
			$('.single-product-waschempfehlung').slideDown(250);
			single_product_waschempfehlung_link = 1;
		} else {
			$('.single-product-waschempfehlung').slideUp(250);
			single_product_waschempfehlung_link = 0;
		}
	});
	
	$('div.single-product-price').append('<div class="subprice">(Preis inkl. MwSt. zzgl. <a target="_blank" href="/lieferzeit-versandkosten/">Versandkosten</a>)</div>');
	
	$('.home-hovertext').hover(function() {
		$(this).children('.hovertext').show();
	}, function() {
		$('.hovertext').hide();
	});
});