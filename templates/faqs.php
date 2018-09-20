<div class="faq_block">
	<div class="contain mid">

		<?php if ( ! empty( esc_html( $title ) ) ) : ?>
			<h3><?= esc_html( $title ); ?></h3>
		<?php endif; ?>

		<?php if ( $query->have_posts() ) : ?>
			<div class="faq_list">
				<?php while ( $query->have_posts() ) :$query->the_post(); ?>

					<div class="faq">
						<div class="question">
							<h5><?php the_title(); ?></h5>
							<span class="plus_minus"></span>
						</div>
						<div class="answer_contain">
							<div class="answer">
								<?php the_content(); ?>
							</div>
						</div>
					</div>

				<?php endwhile; ?>
			</div>
		<?php endif; ?>

	</div>
</div>
