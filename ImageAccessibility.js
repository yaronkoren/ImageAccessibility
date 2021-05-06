( function ( $, mw ) {

	$('img[data-long-desc-url]').each( function() {
		var longDescURL = $(this).attr('data-long-desc-url');
		var longDescLink = '<p class="imageLongDescription"><a href="' + longDescURL + '">' +
			mw.msg( 'imageaccessibility-viewdesc' ) + '</a></p>';
		$(longDescLink).insertAfter($(this).parent());
	});
	$('img[data-create-long-desc-url]').each( function() {
		var longDescURL = $(this).attr('data-create-long-desc-url');
		var longDescLink = '<p><a href="' + longDescURL + '" class="new">' +
			mw.msg( 'imageaccessibility-createdesc' ) + '</a></p>';
		$(longDescLink).insertAfter($(this).parent());
	});
	$('img[data-view-long-desc-url]').each( function() {
		var longDescURL = $(this).attr('data-view-long-desc-url');
		var longDescLink = '<p><a href="' + longDescURL + '">' +
			mw.msg( 'imageaccessibility-viewdescinternal' ) + '</a></p>';
		$(longDescLink).insertAfter($(this).parent());
	});

}( jQuery, mediaWiki ) );
