<?php
/*
Plugin Name: Display All Image File Path
Plugin URI: http://plugins.justingivens.com/?pid=Display-All-Image-File-Path
Description: The plugin loops through all available image sizes and display it out to the users on the Edit Media screen and when you upload new content only.
Version: 1.1
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

add_filter('attachment_fields_to_edit' , 'display_all_image_sizes_function' , 10 , 2);
function display_all_image_sizes_function( $form_fields , $post ) {
	if( ( stristr( $_SERVER['SCRIPT_NAME'] , '/wp-admin/media.php' ) !== FALSE ) || ( stristr( $_SERVER['SCRIPT_NAME'] , '/wp-admin/async-upload.php' ) ) ) {
		$listArray = get_intermediate_image_sizes();
		$x = 2;
		foreach ($listArray as $imageSize) {
			$image_attributes = wp_get_attachment_image_src( $post->ID , $imageSize );
			if( !empty( $image_attributes[0] ) ) {
				$form_fields["image_url$x"] = array(
					'label'      => __("Additional File $x"),
					'input'      => 'html',
					'html'       => "<input type='text' class='text urlfield' readonly='readonly' name='attachments[$post->ID][url$x]' value='$image_attributes[0]' /><br />",
					'value'      => $image_attributes[0],
					'helps'      => __("Location of the image path for $imageSize. Dimensions: $image_attributes[1] x $image_attributes[2]")
				);
				$x++;
			}
		}
	}
	return $form_fields;
}
?>