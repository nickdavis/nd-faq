<?php
/**
 * FAQ
 *
 * @package     NickDavis\FAQ
 * @since       0.1.0
 * @author      Nick Davis
 * @link        http://nickdavis.co
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\FAQ;

use WP_Query;

class FAQ {
	public function register() {
		add_action( 'init', [ $this, 'register_cpt' ], 11 );
		add_action( 'init', [ $this, 'register_taxonomy' ], 11 );

		add_shortcode( 'faq', array( $this, 'register_shortcode' ) );
	}

	public function render( $category = '' ) {
		$query = $this->get( $category );

		ob_start();

		include ND_FAQ_PATH . 'templates/faqs.php';

		$faqs = ob_get_contents();

		ob_end_clean();

		wp_reset_postdata();

		return $faqs;
	}

	public function get( $category = '' ) {
		$posts = [];

		$args = [
			'posts_per_page' => 500,
			'post_type'      => 'nd-faq',
		];

		if ( ! empty( $category ) ) {
			$args['faq-category'] = $category;
		}

		return new WP_Query( $args );
	}

	public function register_cpt() {
		register_extended_post_type( 'nd-faq',
			[
				'publicly_queryable' => false,
				'supports'           => [
					'title',
					'editor'
				],
				'menu_icon'          => 'dashicons-format-status',
			],
			[
				// Overrides the base names used for labels.
				'singular' => 'FAQ',
				'plural'   => 'FAQs',
				'slug'     => 'faq',
			]
		);
	}

	public function register_taxonomy() {
		register_extended_taxonomy(
			'faq-category',
			'nd-faq',
			[],
			[
				// Overrides the base names used for labels.
				'singular' => 'FAQ Category',
				'plural'   => 'FAQ Categories',
				'slug'     => 'faq-category',
			]
		);
	}

	public function register_shortcode( $attributes ) {
		$category = isset( $attributes['category'] )
			? $attributes['category']
			: '';

		return $this->render( $category );
	}
}
