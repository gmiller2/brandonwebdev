<?php get_header(); ?>


	<div class="resort-head-info">

		<h1 class="entry-title" style="margin-bottom: 0.6em;">Vacations in
		<?php
			$term =	$wp_query->queried_object;
			echo $term->name;
		?>
		</h1>


		<?php
		  $temp = $wp_query;
		  $wp_query = null;
		  $wp_query = new WP_Query();
		  $wp_query->query('showposts=10&post_type=vacations&'.$term->taxonomy.'='.$term->slug.'&paged='.$paged);

		  while ($wp_query->have_posts()) : $wp_query->the_post();
		?>

		<div class="arc-header-container">

		<h2 class="h2-hotel-heading-arc" style="margin-top: 0;"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

		<p class="star-rating" style="font-size: 1.2em; margin-top: -0.5em; color: #00739a;"><?php $terms_as_text = get_the_term_list( $post->ID, 'company', 'From ', ', ', '' ) ; echo strip_tags($terms_as_text); ?></p>



		<p class="star-rating" style="margin-top: -2.5em;">

				<?php $ratingval = get_post_meta( $post->ID,'rating',true );

					if ($ratingval == "Option 1") {
						?>
						<!-- 3 apples -->
						Rating: <img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="3 Apples"><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="">
						<?php

					} elseif ($ratingval == "Option 2") {
						?>
						<!-- 4 apples -->
						Rating: <img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="4 Apples"><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="">
						<?php

					} elseif ($ratingval == "Option 10") {
						?>
						<!-- 4 apples (Golden) -->
						Rating: <img src="http://traveljunctioninc.com/images/appleicon_g.png" alt="4 Golden Apples"><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt="">
						<?php

					} elseif ($ratingval == "Option 3") {
						?>
						<!-- 5 apples -->
						Rating: <img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="5 Apples"><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="">
						<?php

					} elseif ($ratingval == "Option 9") {
						?>
						<!-- 6 apples (Golden) -->
						Rating: <img src="http://traveljunctioninc.com/images/appleicon_g.png" alt="5 Golden Apples"><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt="">
						<?php

					} elseif ($ratingval == "Option 8") {
						?>
						<!-- 6 apples -->
						Rating: <img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="6 Apples"><img src="http://traveljunctioninc.com/images/appleicon_r.png"><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_r.png" alt="">
						<?php

					} elseif ($ratingval == "Option 4") {
						?>
						<!-- 6 apples (Golden) -->
						Rating: <img src="http://traveljunctioninc.com/images/appleicon_g.png" alt="6 Golden Apples"><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt=""><img src="http://traveljunctioninc.com/images/appleicon_g.png" alt="">
						<?php

					} elseif ($ratingval == "Option 5") {
						?>
						<!-- 3 stars -->
						Rating: 3 Stars
						<?php

					} elseif ($ratingval == "Option 6") {
						?>
						<!-- 4 stars -->
						Rating: 4 Stars
						<?php

					} elseif ($ratingval == "Option 7") {
						?>
						<!-- 5 stars -->
						Rating: 5 Stars
						<?php

					} elseif ($ratingval == "Option 11") {
						?>
						<!-- Collette tour -->
						<!-- Nothing for right now. -->

						<?php

					} else {
						// do nothing
					}
				?>
			</p>

		</div><!--end arc-header-container-->


		<article id="content" style="width: 45%;">

		</article>

		<div class="tax-image-on-right">

			<a href="<?php the_permalink() ?>" rel="bookmark" title="View More Information About <?php the_title_attribute(); ?>"><?php if (class_exists('MultiPostThumbnails')
							&& MultiPostThumbnails::has_post_thumbnail('vacations', 'resortthumbs2')) : MultiPostThumbnails::the_post_thumbnail('vacations', 'resortthumbs2', NULL, 'resortthumbs-img'); endif; ?></a>

			<div class="booknow" style="font-size: 1.2em; margin-top: -0.4em; width: 100%;">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="View More Information About <?php the_title_attribute(); ?>">View More Information</a>
			</div>

		</div><!--end tax-image-on-right (picture) -->



		<article id="content" style="width: 45%;">
			<?php the_excerpt(); ?>
		</article>


		<div style="clear: both;"></div>

		<div class="dividerline" style="margin-top: 3.5em; width: 100%;"></div>

		<?php endwhile; ?>

		<div class="page-those-vacations">
			<span style="float: left;"><?php previous_posts_link('&laquo; Previous Page') ?></span>
			<span style="float: right;"><?php next_posts_link('Next Page &raquo;') ?></span>
		</div><!--end page-those-vacations-->

		<?php
		  $wp_query = null;
		  $wp_query = $temp;  // Reset
		?>

	</div><!--end resort-head-info-->



	<div style="clear: both;"></div>

	<?php get_footer(); ?>
