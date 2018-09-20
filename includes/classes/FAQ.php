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


class FAQ {
	public function register() {
		add_action( 'init', [ $this, 'register_cpt' ], 11 );
		add_action( 'init', [ $this, 'register_taxonomy' ], 11 );
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
}
