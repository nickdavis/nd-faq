<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 02/08/2018
 * Time: 19:56
 */

namespace NickDavis\FAQ;


class FAQ {
	public function register() {
		add_action( 'init', [ $this, 'register_cpt' ], 11 );
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
}
