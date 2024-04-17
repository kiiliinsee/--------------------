( function( api ) {

	// Extends our custom "beauty-studio" section.
	api.sectionConstructor['beauty-studio'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );