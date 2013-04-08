<?php
/*
Plugin Name: Display All Image File Path
Plugin URI: http://plugins.justingivens.com/?pid=Display-All-Image-File-Path
Description: The plugin loops through all available image sizes and display it out to the users on the Edit Media screen and when you upload new content only.
Version: 2.0
Author: Justin D. Givens
Author URI: http://plugins.justingivens.com/?aid=Display-All-Image-File-Path
Copyright 2011 Justin D. Givens

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function iiab_add_custom_box_image_path() {
    add_meta_box( 
        'iiab_display_image_paths',
        __( 'Display All Image File Path', 'iiab' ),
        'iiab_inner_custom_box_image_paths',
        'attachment',
        'normal',
        'low'
    );
}
add_action( 'add_meta_boxes', 'iiab_add_custom_box_image_path' );

function iiab_inner_custom_box_image_paths( $post ) {
	$listArray = get_intermediate_image_sizes();
	$x = 2;
	foreach ($listArray as $imageSize) {
		$image_attributes = wp_get_attachment_image_src( $post->ID , $imageSize );
		if( !empty( $image_attributes[0] ) ) {
			echo __( "Additional File $x" , 'iiab' ) . "<input type='text' style=\"width:100%;\" onclick=\"this.select()\" readonly='readonly' name='attachments[$post->ID][url$x]' value='$image_attributes[0]' /><br />" . __( 'Location of the image path for <strong>' .$imageSize . '</strong>. Dimensions: ' . $image_attributes[1] . ' x ' . $image_attributes[2] , 'iiab' ) . '<br /><br />';
			$x++;
		}
	}
	if( $x == 2 ) {
		_e( 'This attachment does not have any additional file paths.' , 'iiab' );
	}
}
?>