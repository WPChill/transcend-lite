( function( api ) {

	// Extends our custom "transcend-pro-section" section.
	api.sectionConstructor['transcend-recomended-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );