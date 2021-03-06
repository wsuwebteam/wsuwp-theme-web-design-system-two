<?php namespace WSUWP\Theme\WDS;

class Block_WSUWP_Post_Hero extends Block {

	protected static $block_name    = 'wsuwp/post-hero';
	protected static $default_attrs = array(
		'className'    => '',
        'hide'         => false,
		'style'        => 'default',
		'imageId'      => '',
		'imageSrc'     => '',
		'imageAlt'     => '',
		'imageCaption' => '',
		'imageRatio'   => '16-9',
	);


	public static function render( $attrs, $content = '' ) {

		if ( ! static::is_set( $attrs, 'hide' ) ) {

			self::set_image_attrs( $attrs );

			ob_start();

			if ( ! empty( $attrs['imageSrc'] ) ) {

				switch ( $attrs['style'] ) {
	
					case 'figure':
						include __DIR__ . '/templates/figure.php';
						break;
	
					default:	
						include __DIR__ . '/templates/default.php';
						break;
				}
			}

			return ob_get_clean();

		} else {

			return '';
		}

	}


	protected static function set_image_attrs( &$attrs ) {

		

		if ( empty( $attrs['imageSrc'] ) && has_post_thumbnail() ) {

			$attrs['imageId']      = get_post_thumbnail_id();

			$image_array = wp_get_attachment_image_src( $attrs['imageId'], 'full' );

			$attrs['imageSrc']     = $image_array[0];
			$attrs['imageSrcset']  = wp_get_attachment_image_srcset( $attrs['imageId'], 'full' );
			$attrs['imageSizes']   = wp_get_attachment_image_sizes( $$attrs['imageId'], 'full' );
			$attrs['imageAlt']     = get_post_meta( $attrs['imageId'], '_wp_attachment_image_alt', true);
			$attrs['imageCaption'] = wp_get_attachment_caption( $attrs['imageId'] );

		}

	}


}