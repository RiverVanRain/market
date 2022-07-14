define(['elgg', 'jquery', 'elgg/lightbox', 'elgg/i18n'], function (elgg, $, lightbox, i18n) {
	$(document).ready(function(){
		$('#plaintext-description').keyup(function () {
			var $textarea = $(this);
			var limit = $textarea.data('limit');
			var remaining = limit - $textarea.val().length;
			var $form = $textarea.closest('form')
			var $counter = $form.find('[data-counter]').eq(0);
			$counter.find('[data-counter-indicator]').text(remaining);
			if (remaining < 0) {
					$counter.addClass('market-counter-overflow');
					$form.find('[type="submit"]').prop('disabled', true).addClass('elgg-state-disabled');
				} else {
					$counter.removeClass('market-counter-overflow');
					$form.find('[type="submit"]').prop('disabled', false).removeClass('elgg-state-disabled');
				}
		});

		$('#market-type').change(function() {
			var value = $(this).val();
			$('#market-price').prop('readonly', false);	
			if (value == 'free') {
				$('#market-price').val('0');
				$('#market-price').prop('readonly', true);
			} else if (value == 'swap') {
				$('#market-price').val('');
				$('#market-price').prop('readonly', true);
			}
		});
		
		var options = {
			photo: true,
		};
		
		lightbox.bind('.elgg-lightbox-photo, a[rel="market-gallery"]', options, false);
	});
});