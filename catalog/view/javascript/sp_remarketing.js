function remarketingAddToCart(json) {
	console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'add_to_cart_sent');
	heading = $('h1').text();
	if (typeof heading == 'undefined' || heading == '') {
		heading = 'other';
	}

	if (json['remarketing']) {

		if (json['remarketing']['ecommerce_status'] !== null) {
			window.dataLayer = window.dataLayer || [];
			dataLayer.push({ ecommerce: null });
			dataLayer.push(json['remarketing']['ga4_datalayer']);  
		}
		
		if (json['remarketing']['ecommerce_ga4_status'] != null) {
			if (typeof gtag != 'undefined') {
				json['remarketing']['ecommerce_ga4_event']['items'][0]['item_list_name'] = heading;
				gtag('event', 'add_to_cart', json['remarketing']['ecommerce_ga4_event']);
			}
		}
	}
}	  

function remarketingRemoveFromCart(json) {
	console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'remove_from_cart_sent');
	heading = $('h1').text();
	
	if (typeof heading == 'undefined' || heading == '') {
		heading = 'other';
	}

	if (json['remarketing']) {
		if (json['remarketing']['ecommerce_status'] != null) {
			window.dataLayer = window.dataLayer || [];
			dataLayer.push({ ecommerce: null });
			dataLayer.push(json['remarketing']['ga4_datalayer']);   
		}
		
		if (json['remarketing']['ecommerce_ga4_status'] != null) {
			if (typeof gtag != 'undefined') {
				json['remarketing']['ecommerce_ga4_event']['items'][0]['item_list_name'] = heading;
				gtag('event', 'remove_from_cart', json['remarketing']['ecommerce_ga4_event']);
			}
		}
	}
}	

function remarketingRemoveFromSimpleCart(cart_product_id, quantity) {
	if (cart_product_id && quantity) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/removeProduct',
		data: {'product_id' : cart_product_id, 'quantity': quantity},
			dataType: 'json',
            success: function(json) { 
				remarketingRemoveFromCart(json);
			}
		});
	}
}

function sendGa4Click(data) {
	console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'ga4_click_sent');
	heading = $('h1').text();
	currency = $('.currency_ecommerce_code').val();
	
	if (data) {
		if (typeof gtag != 'undefined') {
			gtag('event', 'select_item', {
				'send_to': $('.ecommerce_ga4_identifier').val(),
				'currency': currency,
				'items': [data]
			});
		}
	}
}	 

function sendGa4Impressions(data, search = false, measurement = false) {
	console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'ga4_impressions_sent');
	currency = $('.currency_ecommerce_code').val();
	heading = $('h1').text();
	
	if (typeof heading == 'undefined' || heading == '') {
		heading = 'other';
	}
	
	if (data && measurement == false) {
		if (typeof gtag != 'undefined') {
			if (!search) {
				event_name = 'view_item_list';
			} else {
				event_name = 'view_search_results';
			}

			gtag('event', event_name, {
				'send_to': $('.ecommerce_ga4_identifier').val(),
				'currency': currency,
				'items': data 
			});
		}
	}
}	 

function sendGa4Details(data, measurement = false) {
	if (data && measurement == false) {
		if (typeof gtag != 'undefined') {
			gtag('event', 'view_item', data);
		}
		console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'details_ga4_sent');
	}	
}	 

function sendGa4Cart(data) { 
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendGa4Cart',
		data: {cart : data},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'ecommerce_ga4_cart_sent');
			}
		});
	}
}	 

function sendWishList(json) {
	console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'wishlist_sent');
	
	heading = $('h1').text();
	
	if (typeof heading == 'undefined' || heading == '') {
		heading = 'other';
	}
	
	if (json['remarketing']['ecommerce_ga4_status'] != null) {
		if (typeof gtag != 'undefined') {
			json['remarketing']['ecommerce_ga4_event']['items'][0]['item_list_name'] = heading;
			gtag('event', 'add_to_wishlist', json['remarketing']['ecommerce_ga4_event']);
		}
	}
	
	if (json['remarketing']['ecommerce_status'] !== null) {
		window.dataLayer = window.dataLayer || [];
		dataLayer.push({ ecommerce: null });
		dataLayer.push(json['remarketing']['ga4_datalayer']);  
	} 
}

function remarketingQuickOrder(json) {
	console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'quick_order_sent');
	
	if (json['remarketing']) {
		
		if (json['remarketing']['ecommerce_status'] != null) {
			window.dataLayer = window.dataLayer || [];
			dataLayer.push({ ecommerce: null });
			dataLayer.push(json['remarketing']['ga4_datalayer']);
		}

		if (json['remarketing']['ecommerce_ga4_status'] != null) {
			if (typeof gtag != 'undefined') {
				gtag('event', 'purchase', json['remarketing']['ga4_event']);	
			}			
		}
	}
}
	
function decodePostParams(str) {
    return (str || document.location.search).replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = n[1],this}.bind({}))[0];
}

$(document).ready(function() {
	console.log ('%c%s', 'color: green; font: 1.2rem/1 Tahoma;', 'sp ecommerce tracker start');

	$.each($("[onclick*='cart.add'], [onclick*='get_revpopup_cart'], [onclick*='addToCart'], [onclick*='get_oct_popup_add_to_cart']"), function() {
		product_id = $(this).attr('onclick').match(/[0-9]+/);
		$(this).addClass('remarketing_cart_button').attr('data-product_id', product_id);
	});
	
	$(document).ajaxSuccess(function(event, xhr, settings) {
		if (settings.url.indexOf('checkout/cart/add') != -1 || settings.url.indexOf('extension/module/technics/technicscart/fastadd2cart') != -1 || settings.url.indexOf('checkout/cart/add&oct_dirrect_add=1') != -1 || settings.url.indexOf('madeshop/cart/add') != -1 || settings.url.indexOf('extension/module/frametheme/ft_cart/add') != -1 || settings.url.indexOf('extension/basel/basel_features/add_to_cart') != -1) {
			if (typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof remarketingAddToCart == 'function') {
					remarketingAddToCart(xhr.responseJSON);
				}
			}
		}
		
		if (settings.url.indexOf('checkout/cart/remove') != -1) {
			if (typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof remarketingRemoveFromCart == 'function') {
					remarketingRemoveFromCart(xhr.responseJSON);
				}
			}
		}
		
		if (settings.url.indexOf('account/wishlist/add') != -1) {
			if (typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof sendWishList == 'function') {
					sendWishList(xhr.responseJSON);
				}
			} 
		}
		
		if (settings.url.indexOf('extension/module/luxshop_newfastordercart') != -1 || settings.url.indexOf('extension/module/luxshop_newfastorder') != -1 || settings.url.indexOf('index.php?route=extension/module/cyber_newfastordercart') != -1 || settings.url.indexOf('extension/module/cyber_newfastorder') != -1 || settings.url.indexOf('extension/module/chameleon_newfastorder/addFastOrder') != -1 || settings.url.indexOf('extension/module/newfastorder') != -1 || settings.url.indexOf('extension/module/newfastordercart') != -1 || settings.url.indexOf('extension/module/uni_quick_order/add') != -1) {
			if (settings.type == 'POST' && typeof xhr.responseJSON['success'] !== 'undefined' && typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof remarketingQuickOrder == 'function') {
					remarketingQuickOrder(xhr.responseJSON);
				}
			}
		} 
		
		if (settings.url.indexOf('checkout/simplecheckout&group=0') != -1) {
			simple_data = decodePostParams(decodeURI(settings.data));

			if (simple_data.remove !== 'undefined' && simple_data.remove !== '') {
				quantity_key = 'quantity[' + simple_data.remove + ']';
				quantity = simple_data[quantity_key]; 
				
				if (typeof cart_products[simple_data.remove] !== 'undefined') {
					cart_product_id = cart_products[simple_data.remove]['product_id'];
					if (typeof remarketingRemoveFromSimpleCart == 'function') {
						remarketingRemoveFromSimpleCart(cart_product_id, quantity);
					}
				}
			}
		}
		
		if (settings.url.indexOf('checkout/simplecheckout/prevent_delete') != -1) {
			if (typeof gtag != 'undefined' && typeof ga4_payment_data != 'undefined') {
				gtag('event', 'add_payment_info', ga4_payment_data);
			}
		}
	});
});