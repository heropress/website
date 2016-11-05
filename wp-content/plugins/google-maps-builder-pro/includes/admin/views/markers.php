<?php
/**
 *  Markers
 *
 * @description: Appears in modal
 * @since      :
 * @created    : 4/29/14
 */
?>

<div class="white-popup marker-icon-modal mfp-hide">
	<div class="inner-modal-wrap">
		<div class="inner-modal-container">
			<div class="inner-modal">
				<button type="button" class="gmb-modal-close">&times;</button>
				<div class="marker-description-wrap clear">

					<h3><?php _e( 'Customize Map Marker', $this->plugin_slug ); ?></h3>

					<p><?php _e( 'Customize your Google Maps markers by choosing from the options below. Integrations are made possible from the leading maps icons libraries. Plus, you can upload your own!', $this->plugin_slug ); ?></p>
				</div>

				<div class="marker-row clear">

					<h3><?php _e( 'Step 1: Select a Marker Type', $this->plugin_slug ); ?></h3>

					<div class="marker-item" data-marker="MAP_PIN" data-toggle="map-svg-icons">
						<div class="marker-svg marker-preview">
							<svg version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 100 165" enable-background="new 0 0 100 165" xml:space="preserve"><path fill="#428BCA" d="M50,0C22.382,0,0,21.966,0,49.054C0,76.151,50,165,50,165s50-88.849,50-115.946C100,21.966,77.605,0,50,0z"></path>
				</svg>
						</div>
						<div class="marker-description"><?php _e( 'Map Pin', $this->plugin_slug ); ?></div>
					</div>
					<div class="marker-item" data-marker="SQUARE_PIN" data-toggle="map-svg-icons">
						<div class="marker-svg marker-preview">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 100 120" enable-background="new 0 0 100 120" xml:space="preserve"><polygon fill="#428BCA" points="100,0 0,0 0,100 36.768,100 50.199,119.876 63.63,100 100,100 "></polygon></svg>
						</div>
						<div class="marker-description"><?php _e( 'Square Pin', $this->plugin_slug ); ?></div>
					</div>
					<div class="marker-item" data-marker="default" data-toggle="default-icons-row">
						<div class="marker-default marker-preview">
							<img src="<?php echo apply_filters( 'gmb_default_marker', GMB_PLUGIN_URL . 'assets/img/spotlight-poi.png' ); ?>" class="default-marker" />
						</div>
						<div class="marker-description"><?php _e( 'Default Icons', $this->plugin_slug ); ?></div>
					</div>
					<div class="marker-item" data-marker="mapicons" data-toggle="map-icons-row">
						<div class="marker-map-icons marker-preview">
							<img src="<?php echo GMB_PLUGIN_URL . 'assets/img/logo-mapicons.png'; ?>" class="default-marker" />
						</div>
						<div class="marker-description"><?php _e( 'Map Icons', $this->plugin_slug ); ?></div>
					</div>
					<div class="marker-item" data-marker="mapicons" data-toggle="templatic-icons-row">
						<div class="marker-map-icons marker-preview">
							<img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-icon.png'; ?>" class="templatic-marker" />
						</div>
						<div class="marker-description"><?php _e( 'Templatic Icons', $this->plugin_slug ); ?></div>
					</div>
					<div class="marker-item" data-marker="upload" data-toggle="marker-upload">
						<div class="marker-upload marker-preview">
							<span class="dashicons dashicons-upload"></span>
						</div>
						<div class="marker-description"><?php _e( 'Upload Marker', $this->plugin_slug ); ?></div>
					</div>

				</div>

				<div class="marker-icon-row map-svg-icons clear">

					<div class="marker-icon-color-wrap clear">
						<div class="marker-color-picker-wrap">
							<input type="text" name="color" id="color" value="#428BCA" class="color-picker marker-color" />
						</div>
						<p class="color-desc"><?php _e( 'Customize the marker color?', $this->plugin_slug ); ?></p>
					</div>

					<h3><?php _e( 'Step 2: Select a Marker Icon', $this->plugin_slug ); ?></h3>

					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-art-gallery"></span>
							art-gallery
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-campground"></span>
							campground
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-bank"></span>
							bank
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-hair-care"></span>
							hair-care
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-gym"></span>
							gym
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-point-of-interest"></span>
							point-of-interest
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-post-box"></span>
							post-box
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-post-office"></span>
							post-office
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-university"></span>
							university
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-beauty-salon"></span>
							beauty-salon
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-atm"></span>
							atm
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-rv-park"></span>
							rv-park
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-school"></span>
							school
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-library"></span>
							library
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-spa"></span>
							spa
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-route"></span>
							route
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-postal-code"></span>
							postal-code
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-stadium"></span>
							stadium
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-postal-code-prefix"></span>
							postal-code-prefix
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-museum"></span>
							museum
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-finance"></span>
							finance
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-natural-feature"></span>
							natural-feature
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-funeral-home"></span>
							funeral-home
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-cemetery"></span>
							cemetery
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-park"></span>
							park
						</div>
					</div>
					<div class="icon">
						<div class="icon-inner">
							<span class="map-icon-lodging"></span>
							lodging
						</div>
					</div>


					<div class="marker-label-color-wrap clear">
						<div class="marker-color-picker-wrap">
							<input type="text" name="color" id="color" class="color-picker label-color" value="#444444" />
						</div>
						<p class="color-desc"><?php _e( 'Customize the icon color?', $this->plugin_slug ); ?></p>
					</div>


				</div>
				<!--/.marker-icon-row -->

				<div class="marker-icon-row default-icons-row gmb-hidden clear">

					<h3><?php _e( 'Step 2: Select a Marker Icon', $this->plugin_slug ); ?></h3>

					<ul class="map-icons-list">
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/blue_MarkerZ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/brown_MarkerZ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/darkgreen_MarkerZ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/green_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/orange_MarkerZ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/paleblue_MarkerZ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/pink_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/purple_MarkerZ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/red_MarkerZ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow-blank.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow-dot.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerA.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerB.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerC.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerD.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerE.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerF.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerG.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerH.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerI.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerJ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerK.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerL.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerM.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerN.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerO.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerP.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerQ.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerR.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerS.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerT.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerU.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerV.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerW.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerX.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerY.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/default-icons/yellow_MarkerZ.png' ?>" alt=""></a>
						</li>
					</ul>
				</div>
				<!--/.map-icons-row-->
				<div class="marker-icon-row map-icons-row gmb-hidden clear">

					<h3><?php _e( 'Step 2: Select a Marker Icon', $this->plugin_slug ); ?></h3>

					<ul class="map-icons-list">
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/accessdenied.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/airport.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/anniversary.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/apartment-3.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/audio.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bank_euro.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bar.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bar_coktail.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bicycle_shop.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bigcity.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_black.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_black.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_blue.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_green.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_grey.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_pink.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_red.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_turquoise.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_white.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/blank_yellow.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bread.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bus.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/busstop.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/bustour.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/camping-2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/car.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/casino.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/caution.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/cctv.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/cinema.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/cloudy.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/coffee.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/comment-map-icon.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/communitycentre.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/condominium.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/construction.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/conveniencestore.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/conversation-map-icon.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/cycling.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/dancinghall.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/daycare.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/direction_down.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/direction_left.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/direction_right.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/direction_up.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/direction_upthenleft.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/direction_upthenright.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/disability.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/downloadicon.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/drinkingwater.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/entrance.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/factory.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/farm-2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/fastfood.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/female.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/ferry.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/fillingstation.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/finish.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/fire.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/firstaid.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/flag-export.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/flowers.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/forest2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/gifts.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/grocery.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/group.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/harbor.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/home.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/hospital-2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/hospital-building.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/hostel_0star.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/hotel_0star.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/house.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/information.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/kids.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/lake.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_00.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_01.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_02.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_03.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_04.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_05.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_06.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_07.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_08.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_09.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/number_10.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_a.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_b.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_c.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_d.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_e.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_f.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_g.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_h.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_i.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_j.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_k.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_l.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_m.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_n.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_o.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_p.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_q.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_r.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_s.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_t.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_u.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_v.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_w.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_x.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_y.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/letter_z.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/lodging_0star.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/loveinterest.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/male.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/mall.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/medicine.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/motel-2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/motorcycle.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/mountains.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/movierental.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/music_classical.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/music_live.png' ?>" alt=""></a>
						</li>

						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/parking.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/parkinggarage.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/party.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/photo.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/pin-export.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/pinother.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/pizzaria.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/planecrash.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/police2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/postal.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/quadrifoglio.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/radiation.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/recycle.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/regroup.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/repair.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/restaurant.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/revolt.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/sandwich.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/school.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/shooting2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/shootingrange.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/sight-2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/smiley_happy.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/smiley_neutral.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/smiley_sad.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/snowy.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/sportutilityvehicle.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/star.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/stop.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/strike.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/sunny.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/supermarket.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/swimming2.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/symbol_excla.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/symbol_inter.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/taxiway.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/telephone.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/text.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/theater.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/toilets.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/toilets_disability.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/tools.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/train.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/truck3.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/tweet.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/university.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/video.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/villa.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/wifi.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/winebar.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/workoffice.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/zoo.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/maps-icons-collection/zoom.png' ?>" alt=""></a>
						</li>
					</ul>
				</div>
				<!--/.map-icons-row-->

				<div class="marker-icon-row templatic-icons-row gmb-hidden clear">
					<h3><?php _e( 'Step 2: Select a Marker Icon', $this->plugin_slug ); ?></h3>

					<ul class="map-icons-list">
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/accountancy.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/arts-crafts.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/astrology.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/automotive.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/bars.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/birds.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/books-media.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/breakfast-n-brunch.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/business.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/cake-shop.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/clothings.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/clubs.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/coffee-n-tea.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/commercial-places.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/community.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/computers.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/concerts.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/cookbooks.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/dance-clubs.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/default.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/dental.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/doctors.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/education.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/electronics.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/employment.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/engineering.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/entertainment.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/event.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/exhibitions.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/fashion.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/festivals.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/accountancy.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/financial-services.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/food.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/furniture-stores.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/games.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/gifts-flowers.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/government.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/halloween.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/health-medical.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/home-services.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/hotels.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/industries.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/internet.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/jewelry.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/jobs.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/karaoke.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/law.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/lawn-garden.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/libraries.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/local-services.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/lounges.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/magazines.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/manufacturing.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/marker-new1_12.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/mass-media.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/massage-therapy.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/matrimonial.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/medical.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/meetups.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/miscellaneous-for-sale.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/mobile-phones.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/movies.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/museums.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/musical.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/musical-instruments.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/nightlife.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/parks.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/parties.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/pets.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/photography.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/pizza.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/places.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/play-schools.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/playgrounds.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/pool-halls.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/printing-graphic-arts.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/professional.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/real-estate.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/religious-organizations.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/residential-places.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/restaurants.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/retail-stores.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/saloon.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/schools.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/science.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/shopping.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/sporting-goods.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/telemarketing.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/tickets.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/tiffin-services.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/tires-accessories.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/tools-hardware.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/tours.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/toys-store.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/transport.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/travel.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/tutors.png' ?>" alt=""></a>
						</li>
						<li>
							<a href="#" class="maps-icon"><img src="<?php echo GMB_PLUGIN_URL . 'assets/img/templatic-map-icons/vacant-land.png' ?>" alt=""></a>
						</li>
					</ul>

				</div>
				<div class="marker-icon-row marker-upload clear">
					<h3><?php _e( 'Step 2: Upload or Select a Marker Icon', $this->plugin_slug ); ?></h3>

					<div class="gmb-marker-image-wrap clear">
						<div class="gmb-image-preview"></div>
						<input class="gmb-upload-button button" onclick="gmb_upload_marker.uploader(); return false;" type="button" value="Upload or Select a Marker Image">
					</div>


				</div>

				<div class="save-marker-icon clear gmb-hidden">
					<p class="save-text"><?php _e( 'Marker is ready to be set.', $this->plugin_slug ); ?></p>
					<button class="button button-primary button-large save-marker-button" data-marker="" data-marker-color="#428BCA" data-label="" data-label-color="#FFFFFF" data-marker-index="">Set Marker</button>
				</div>

			</div>
		</div>
	</div>
</div>
