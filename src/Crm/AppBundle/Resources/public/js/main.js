var $collectionHolder;

jQuery(document).ready(function() {
	// Get the tbody that holds the collection of invoiceDetails
	$collectionHolder = $('tbody.invoiceDetails');

	// count the current form inputs we have (e.g. 2), use that as the new
	// index when inserting a new item (e.g. 2)
	$collectionHolder.data('index', $collectionHolder.find('tr').length);

	$(document.getElementById('newInvoiceDetail')).on('click', function(e) {
		// prevent the link from creating a "#" on the URL
		e.preventDefault();

		// add a new invoiceDetail form (see next code block)
		addInvoiceDetailForm($collectionHolder);
	});

	calculateTotalAmounts();

	$('.remove-invoiceDetail').on( 'click', removeInvoiceDetail);
	$('.triggerTotalAmounts').on( 'change', calculateTotalAmounts );
});

function addInvoiceDetailForm($collectionHolder) {
	// Get the data-prototype explained earlier
	var prototype = $collectionHolder.data('prototype');

	// get the new index
	var index = $collectionHolder.data('index');

	// Replace '__name__' in the prototype's HTML to
	// instead be a number based on how many items we have
	var newForm = prototype.replace(/__name__/g, index);

	// increase the index with one for the next item
	$collectionHolder.data('index', index + 1);

	$(document.getElementById('invoiceDetailsTable')).append(newForm);

	// handle the removal, just for this example
	$('.remove-invoiceDetail').on( 'click', removeInvoiceDetail);
	$('.triggerTotalAmounts').on( 'change', calculateTotalAmounts );
}

function removeInvoiceDetail() {
	$(this).parent().parent().remove();

	calculateTotalAmounts();

	return false;
}

function calculateTotalAmounts() {
	var taxableAmount	= 0.00,
		outlayAmount	= 0.00,
		vatAmount		= 0.00,
		taxAmount		= 0.00,
		totalAmount		= 0.00,
		vat				= parseInt( document.getElementById("Invoice_vat").value ),
		tax				= parseInt( document.getElementById("Invoice_tax").value ),
		type			= '',
		amount			= 0.00;

	$('tbody.invoiceDetails tr').each(function(){
		$this = $(this);

		type    = $this.find('.invoiceDetailType').val();
		amount	= normalizeAmount($this.find('.invoiceDetailAmount').val());
		$this.find('.invoiceDetailAmount').val(amount);

		if ('outlay' === type) {
			outlayAmount += amount;
		} else {
			taxableAmount += amount;
		}

		vatAmount	= ( taxableAmount * (vat / 100) );
		taxAmount	= ( -1 * ( taxableAmount * ( tax / 100 ) ) );
		totalAmount	= ( taxableAmount + vatAmount + taxAmount + outlayAmount );
	});

	document.getElementById('taxableAmount').innerHTML	= round(taxableAmount, 2);
	document.getElementById('vatAmount').innerHTML 		= round(vatAmount, 2);
	document.getElementById('taxAmount').innerHTML 		= round(taxAmount, 2);
	document.getElementById('outlayAmount').innerHTML	= round(outlayAmount, 2);
	document.getElementById('totalAmount').innerHTML 	= round(totalAmount, 2);
}

function normalizeAmount(amount) {
	amount = amount.replace(',','.');

	return parseFloat(amount);
}

function round(value, decimals) {
	return +( Math.round( value + 'e+' + decimals ) + 'e-'+decimals );
}