	<?php if (!empty($remarketing_code)) echo $remarketing_code; ?> 
	<?php if (isset($ecommerce_status) && $ecommerce_status && !empty($ga4_datalayer)) { ?>
	<script>
	window.dataLayer = window.dataLayer || [];
	dataLayer.push({ ecommerce: null });
	dataLayer.push(<?php echo json_encode($ga4_datalayer); ?>); 
	</script> 
	<?php } ?>
	<?php if (isset($ga4_product) && $ga4_product) { ?>
	<script>
	if (typeof sendGa4Details !== 'undefined') {
		sendGa4Details(<?php echo json_encode($ga4_product); ?>, false);
	} 
	</script>
	<?php } ?>
	<?php if (isset($ga4_json) && $ga4_json) { ?>
	<script>
	window.ecommerce_ga4_products = window.ecommerce_ga4_products || {};
	ecommerce_ga4_product_data = <?php echo json_encode($ga4_json); ?>;
	if (typeof sendGa4Impressions !== 'undefined') {
		sendGa4Impressions(ecommerce_ga4_product_data, <?php echo (isset($view_search_results) && $view_search_results) ? 'true' : 'false'; ?>, false);
	}
	ecommerce_ga4_products = $.extend(ecommerce_ga4_products, ecommerce_ga4_product_data);
	  </script>
	<?php } ?>