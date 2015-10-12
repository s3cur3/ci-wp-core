<?php

/*
  Plugin Name: Featured Image Attribution, by Conversion Insights
  Plugin URI: http://conversioninsights.net/free-software/
  Version: 1.0
  Author: Conversion Insights, Inc.
  Author URI: http://conversioninsights.net/
  Description: Easily attribute Featured Images that require Creative Commons attribution. Just call the <code>featuredImgAttribution()</code> function immediately after the place in your theme where you display the image.
  Text Domain: featured-image-attribution
  Domain Path: /languages
  License: CC0 (Public domain)
 */

add_action( 'admin_init', 'fia_add_attribution_box' );
function fia_add_attribution_box() {
    $screens = array( 'post', 'page' );
    foreach ($screens as $screen) {
        add_meta_box(
            'attribution_box',
            'Featured Image Attribution',
            'fia_show_attribution_box',
            $screen, 'side', 'low'
        );
    }
}


add_action('admin_menu', 'fia_create_menu');
function fia_create_menu() {
    // Enqueue backend assets
    if( is_admin() ) {
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'angular',
            get_template_directory_uri() . '/assets/js/admin/angular.min.js',
            array('jquery'),
            '1.0.6',
            false
        );
    }
}


function fia_show_attribution_box( $page ) {
    // Retrieve current settings
    $prefaceText =  get_post_meta( $page->ID, 'preface_text', true );
    $attributionText =  get_post_meta( $page->ID, 'attribution_text', true );
    $attributionHREF =  get_post_meta( $page->ID, 'attribution_href', true );

    $licenseText =  get_post_meta( $page->ID, 'license_text', true );
    $licenseHREF =  get_post_meta( $page->ID, 'license_href', true );
    ?>
    <style>
        #attribution-box input {
            width: 100%;
        }
        #attribution-box h4 {
            margin-bottom: 0;
        }
    </style>
    <script>
        /**
         * The controller for the Featured Image Attribution tool's admin panel
         */
        function FIAAdminController($scope) {
            $scope.prefaceText = "<?php echo $prefaceText; ?>";
            $scope.attributionText = "<?php echo $attributionText; ?>";
            $scope.attributionHREF = "<?php echo $attributionHREF; ?>";
            $scope.licenseText = "<?php echo $licenseText; ?>";
            $scope.licenseHREF = "<?php echo $licenseHREF; ?>";
        }


        var app = angular.module('FIAAdmin', []);
    </script>
    <div id="attribution-box" ng-controller="FIAAdminController" ng-app="FIAAdmin">
        <h4><label for="prefaceText">Prefacing text for attribution:</label></h4>
        <div><input type="text" name="preface_text" value="<?php echo $prefaceText; ?>" placeholder="E.g., Image credit:" id="prefaceText" ng-model="prefaceText"></div>

        <h4><label for="attributionText">Attribution for Featured Image:</label></h4>
        <div><input type="text" name="attribution_text" value="<?php echo $attributionText; ?>" placeholder="E.g., John Doe" id="attributionText" ng-model="attributionText"></div>

        <h4><label for="attributionHREF">URL for attribution:</label></h4>
        <div><input type="url" name="attribution_href" value="<?php echo $attributionHREF; ?>" placeholder="E.g., http://john-doe-photos.com" id="attributionHREF" ng-model="attributionHREF"></div>

        <h4><label for="licenseText">License name:</label></h4>
        <div><input type="text" name="license_text" value="<?php echo $licenseText; ?>" placeholder="E.g., CC-BY-SA 3.0" id="licenseText" ng-model="licenseText"></div>

        <h4><label for="licenseHREF">URL for license:</label></h4>
        <div><input type="url" name="license_href" value="<?php echo $licenseHREF; ?>" placeholder="E.g., http://creativecommons.org/licenses/by-sa/3.0/" id="licenseHREF" ng-model="licenseHREF"></div>

        <div ng-show="prefaceText.length + attributionText.length + licenseText.length > 0">
            <h4>Preview:</h4>
            <p class="featured-img-caption">{{prefaceText}} <a href="{{$attributionHREF}}" title="Image attribution" target="_blank">{{attributionText}}</a> <span ng-show="licenseText.length > 0">[<a href="{{licenseHREF}}" title="{{licenseText}}" target="_blank">{{licenseText}}</a>]</span></p>
        </div>
    </div>
<?php
}


function fia_handle_attribution_data( $pageID, $page ) {
    $keys = array( 'preface_text', 'attribution_text', 'attribution_href', 'license_text', 'license_href' );

    foreach( $keys as $key ) {
        if ( isset( $_POST[$key] ) && $_POST[$key] != '' ) {
            update_post_meta( $pageID, $key, $_POST[$key] );
        } else if( get_post_meta( $page->ID, $key, true ) != '' ) { // post info *used to be* shown
            update_post_meta( $pageID, $key, '' );
        }
    }
}
add_action( 'save_post', 'fia_handle_attribution_data', 10, 2 );



function fia_featured_img_attribution() {
    $prefaceText =  get_post_meta( get_the_ID(), 'preface_text', true );
    $attributionText =  get_post_meta( get_the_ID(), 'attribution_text', true );
    $attributionHREF =  get_post_meta( get_the_ID(), 'attribution_href', true );

    $licenseText =  get_post_meta( get_the_ID(), 'license_text', true );
    $licenseHREF =  get_post_meta( get_the_ID(), 'license_href', true );

    $openHREF = "";
    $closeHREF = "";
    if( $attributionHREF && $attributionText ) {
        $openHREF = "<a href=\"$attributionHREF\" title=\"Image attribution\" target=\"_blank\">";
        $closeHREF = "</a>";
    }

    $licenseHTML = "";
    if( $licenseText ) {
        $licenseHTML = " [";
        if( $licenseHREF ) {
            $licenseHTML .= "<a href=\"$licenseHREF\" title=\"$licenseText\" target=\"_blank\">$licenseText</a>]";
        } else {
            $licenseHTML .= $licenseText . "]";
        }
    }

    if( $prefaceText || $attributionText ) {
?>
        <!-- Featured Image Attribution -->
        <p class="featured-img-caption"><?php echo $prefaceText, " ", $openHREF, $attributionText, $closeHREF, ". ", $licenseHTML; ?></p>
<?php
    }
}