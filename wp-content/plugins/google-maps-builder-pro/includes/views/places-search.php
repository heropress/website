<?php
/**
 *  googlemapsbuilder.dev - places-search.php
 *
 * @description:
 * @copyright  : http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      : 1.0.0
 * @created    : 8/1/2015
 */ ?>
<div id="places-search" class="places-search-wrap">
	<input id="pac-input" class="controls" type="text"
	       placeholder="<?php _e( 'Enter a location', $this->plugin_slug ); ?>">

	<div id="type-selector" class="controls">
		<input type="radio" name="type" id="changetype-all" checked="checked">
		<label for="changetype-all"><?php _e( 'All', $this->plugin_slug ); ?></label>

		<input type="radio" name="type" id="changetype-establishment">
		<label for="changetype-establishment"><?php _e( 'Establishments', $this->plugin_slug ); ?></label>

		<input type="radio" name="type" id="changetype-address">
		<label for="changetype-address"><?php _e( 'Addresses', $this->plugin_slug ); ?></label>

		<input type="radio" name="type" id="changetype-geocode">
		<label for="changetype-geocode"><?php _e( 'Geocodes', $this->plugin_slug ); ?></label>
	</div>
</div>
