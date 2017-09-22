<?php get_header(); ?>


<script src="http://d2g9qbzl5h49rh.cloudfront.net/static/feedback2.js?3.2.6370" type="text/javascript">
	var JFL_51385572807159 = new JotformFeedback({
	formId:'51385572807159',
	base:'http://jotform.us/',
	windowTitle:'Request a Quote Form',
	background:'#299FFD',
	fontColor:'#FFFFFF',
	type:1,
	height:500,
	width:550,
	openOnLoad:false
	});
</script>


		<div class="resort-head-info">

			<!-- allows custom metabox values to display -->
			<?php global $post; $custom = get_post_custom($post->ID); ?>

			<h1 class="h1-vpage"><?php single_post_title(); ?></h1>

			<h2 class="h2-hotel-heading"><?php $terms_as_text = get_the_term_list( $post->ID, 'company', 'From ', ', ', '' ) ; echo strip_tags($terms_as_text); ?></h2>

			<p class="star-rating">

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

		</div><!--end resort-head-info-->


		<div class="widthofimg" style="margin: 0 auto;">
			<!-- large resort image -->
			<? if ( has_post_thumbnail( ) ) the_post_thumbnail('resortmain' ); ?>
		</div>


		<div class="resort-head-info">

			<!-- Get the appropriate booking link, based on the company -->
			<?php $companybook = get_the_term_list( $post->ID, 'company', '', ', ', '' );
				$companybookwotags = strip_tags($companybook);

				if ($companybookwotags == "Apple Vacations") {

					$bookinghref  = 'http://www.book.applevacations.com/search.do?command=handleAppleVacationPackageSearch&departureDay=&departureMonth=&departureYear=2013&numberOfAdults=2&returnDay=&returnMonth=&returnYear=2013&searchType=applePackage&Antigua=&selectedGateway=&agentId=39756301';

				} elseif ($companybookwotags == "Sandals Resorts") {

					$bookinghref  = 'https://obe.sandals.com/index.cfm?event=ehOBE.dspHome&OBE_PARTNER_CODE=CB&OBE_PARTNER_REF=102194&BRAND=sandals&EVENT=ehOBE.dspHome&REINITUSER=1&REFERRAL=102194&A=1';
				} else {
					// have it go to the default booking page
					$bookinghref  = 'http://www.traveljunctioninc.com/book';
				}
			?>


			<?php $bookonlinebtnval = get_post_meta( $post->ID,'bookonlinebtn',true );

					if ($bookonlinebtnval == "Yes") {
						?>
						<!-- Yes, INCLUDE BOOK BUTTON -->
						<!--<div class="booknow-vpage">
							<a target="_blank" href="<?php echo $bookinghref; ?>">Book Now</a>
						</div>-->
						<div class="booknow-vpage">
							<a class="lightbox-51385572807159" style="cursor:pointer;">Get a Quote</a>
						</div>

						<?php

					} elseif ($bookonlinebtnval == "No") {
						?>
						<!-- Can't be booked online, don't show button -->
						<div class="booknow-vpage">
							<a class="lightbox-51385572807159" style="cursor:pointer;">Get a Quote</a>
						</div>

					<?php

					} else {
						// show the button (to be safe)

						?>

						<!-- Contact form in modal window-->
						<div class="booknow-vpage">
							<a class="lightbox-51385572807159" style="cursor:pointer;">Get a Quote</a>
						</div>

						<?php

					}
				?>


			<h2 style="text-transform: uppercase;"><?php echo $amenities = $custom["important_point"][0]; ?></h2>


			<article id="content">
				<!-- the loop and short description -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<p><?php the_content(); ?></p>
			</article>

			<div style="clear: both;"></div>

			<h2>Includes</h2>


			<?php
				if ( get_post_meta($post->ID, 'amenities', true) ) :
					// Get amenities from database as a string
					$amenities = get_post_meta( $post->ID, "amenities", true );
					// Break the string up by using the line breaks <br>
					$amenities = explode( "\n", $amenities );
					// Open the ul tag
					echo '<ul class="includes-section">';
					// Loop through each bullet point (now an array due to explode() function)
					foreach( $amenities as $amenity ) {
						// Add the li tags around each item
						echo '<li>' . $amenity . '</li>';
					}
					// Once the loop finishes, close the ul tag
					echo '</ul>';
				endif;
			?>


			<h2>Photos</h2>

			<ol class="resort-photo-gallery">

				<li><?php if (class_exists('MultiPostThumbnails')
					&& MultiPostThumbnails::has_post_thumbnail('vacations', 'resortthumbs')) : MultiPostThumbnails::the_post_thumbnail('vacations', 'resortthumbs', NULL, 'resortthumbs-img'); endif; ?></li>

				<li class="center-gallery-img"><?php if (class_exists('MultiPostThumbnails')
					&& MultiPostThumbnails::has_post_thumbnail('vacations', 'resortthumbs2')) : MultiPostThumbnails::the_post_thumbnail('vacations', 'resortthumbs2', NULL, 'resortthumbs-img'); endif; ?></li>

				<li><?php if (class_exists('MultiPostThumbnails')
					&& MultiPostThumbnails::has_post_thumbnail('vacations', 'resortthumbs3')) : MultiPostThumbnails::the_post_thumbnail('vacations', 'resortthumbs3', NULL, 'resortthumbs-img'); endif; ?></li>

			</ol>


				<?php $bookonlinebtnval = get_post_meta( $post->ID,'bookonlinebtn',true );

					if ($bookonlinebtnval == "Yes") {
						?>
						<!-- Yes, INCLUDE BOOK BUTTON -->

						<div class="book-now-box">
							<div class="booknow" style="margin: 0 auto;">
								<!--<a target="_blank" href="<?php echo $bookinghref; ?>">Book Now</a>-->
								<a class="lightbox-51385572807159" style="cursor:pointer;">Get a Quote</a>

							</div><!--end booknow-->
							<p class="call-us-w-questions">Or call us at <a class="no-color" href="tel:+18003665715">1-800-366-5715</a> with questions</p>
						</div><!--end book-now-box-->

						<?php

					} elseif ($bookonlinebtnval == "No") {
						?>
						<!-- Can't be booked online, show "contact us for info" instead -->


						<div class="book-now-box">
							<div class="booknow" style="margin: 0 auto;">
								<!--<a target="_blank" href="<?php echo $bookinghref; ?>">Book Now</a>-->
								<a class="lightbox-51385572807159" style="cursor:pointer;">Get a Quote</a>

							</div><!--end booknow-->
							<p class="call-us-w-questions">Or call us at <a class="no-color" href="tel:+18003665715">1-800-366-5715</a> with questions</p>
						</div><!--end book-now-box-->

					<?php

					} else {
						// show the button (to be safe)
						?>

						<div class="book-now-box">
							<div class="booknow" style="margin: 0 auto;">
							<!--	<a target="_blank" href="<?php echo $bookinghref; ?>">Book Now</a>-->
									<a class="lightbox-51385572807159" style="cursor:pointer;">Get a Quote</a>
							</div><!--end booknow-->
							<p class="call-us-w-questions">Or call us at <a class="no-color" href="tel:+18003665715">1-800-366-5715</a> with questions</p>
						</div><!--end book-now-box-->

						<?php
					}
				?>

		</div><!--end resort-head-info-->


		<!--end single-->


	<?php endwhile; endif; ?>


<?php get_footer(); ?>
