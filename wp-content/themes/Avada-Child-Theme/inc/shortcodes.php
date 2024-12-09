<?php

/* Shortcodes */

/* Shortcode to get Posts by Category Default*/

if ( ! function_exists('post_listing_by_category') ) {
	
	function post_listing_by_category($atts = array()) {
		$attsArray = shortcode_atts(
			array(
				'categories' => '',
				'limit' => -1,
			), $atts);
		
		
		$args = array(
			'post_type'         =>  'post',
			'post_status'       =>  'publish',
			'posts_per_page' 	=>   $attsArray['limit'],
			'order' => 'ASC'
		);
		
		if ( ! empty( $attsArray['categories'] ) ) 
		{
			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'category',
					'field'  => 'id',
					'terms'  => explode( ',', $attsArray['categories'] ),
					'operator' => 'IN',
				)
			);
		}
		
		$allPosts = new WP_Query( $args );
		ob_start();
		if ( $allPosts->have_posts() ) : ?>
			<div class="table-1">
			<table class="posts-listing default-posts-listing">
				<thead>
					<tr>
						<th>Date</th>
						<th>Image</th>
						<th>Title</th>
					</tr>
				</thead>
				<?php while ( $allPosts->have_posts() ) : $allPosts->the_post(); ?>
					<?php 
						$author =  get_field('author', get_the_ID());
						$external_post = get_field('external_post', get_the_ID());
						$post_url = "";
						if($external_post){
							$external_url = get_field('external_url', get_the_ID());
							$post_url = $external_url;
						}
						else{
							$post_url = get_the_permalink();
						}
					?>
					<tr>
						<td><strong><?php echo the_date('M Y'); ?></strong></td>
						<td><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?> ><?php the_post_thumbnail();?></a></td>
						<td><h4><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?>><?php the_title();?></a></h4></td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
		<?php 
		wp_reset_postdata();
		endif;
		$the_content = ob_get_clean();
        return $the_content;
	}
	
	add_shortcode( 'post_listing_by_default_category', 'post_listing_by_category' );
}

/* Shortcode to get Posts by Category With Author*/

if ( ! function_exists('post_listing_by_category_author') ) {
	
	function post_listing_by_category_author($atts = array()) {
		$attsArray = shortcode_atts(
			array(
				'categories' => '',
				'limit' => -1,
			), $atts);
		
		
		$args = array(
			'post_type'         =>  'post',
			'post_status'       =>  'publish',
			'posts_per_page' 	=>   $attsArray['limit'],
			
		);
		
		if ( ! empty( $attsArray['categories'] ) ) 
		{
			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'category',
					'field'  => 'id',
					'terms'  => explode( ',', $attsArray['categories'] ),
					'operator' => 'IN',
				)
			);
		}
		
		$allPosts = new WP_Query( $args );
		ob_start();
		if ( $allPosts->have_posts() ) : ?>
			<div class="table-1">
			<table class="posts-listing default-posts-listing">
				<thead>
					<tr>
						<th>Date</th>
						<th>Image</th>
						<th>Title</th>
						<th>Author</th>
					</tr>
				</thead>
				<?php while ( $allPosts->have_posts() ) : $allPosts->the_post(); ?>
					<?php 
						$author =  get_field('author', get_the_ID());
						$external_post = get_field('external_post', get_the_ID());
						$post_url = "";
						if($external_post){
							$external_url = get_field('external_url', get_the_ID());
							$post_url = $external_url;
						}
						else{
							$post_url = get_the_permalink();
						}
					?>
					<tr>
						<td><strong><?php echo the_date('M Y'); ?></strong></td>
						<td><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?> ><?php the_post_thumbnail();?></a></td>
						<td><h4><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?>><?php the_title();?></a></h4></td>
						<td><?php echo $author; ?></td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
		<?php 
		wp_reset_postdata();
		endif;
		$the_content = ob_get_clean();
        return $the_content;
	}
	
	add_shortcode( 'post_listing_by_category_with_author', 'post_listing_by_category_author' );
}

/* Shortcode to get Posts by Category Conventions*/

if ( ! function_exists('post_listing_by_category_conventions') ) {
	
	function post_listing_by_category_conventions($atts = array()) {
		$attsArray = shortcode_atts(
			array(
				'categories' => '',
				'limit' => -1,
			), $atts);
		
		
		$args = array(
			'post_type'         =>  'post',
			'post_status'       =>  'publish',
			'posts_per_page' 	=>   $attsArray['limit'],
			
		);
		
		if ( ! empty( $attsArray['categories'] ) ) 
		{
			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'category',
					'field'  => 'id',
					'terms'  => explode( ',', $attsArray['categories'] ),
					'operator' => 'IN',
				)
			);
		}
		
		$allPosts = new WP_Query( $args );
		ob_start();
		if ( $allPosts->have_posts() ) : ?>
			<div class="table-1">
			<table class="posts-listing default-posts-listing">
				<thead>
					<tr>
						<th>Year</th>
						<th>Title</th>
					</tr>
				</thead>
				<?php while ( $allPosts->have_posts() ) : $allPosts->the_post(); ?>
					<?php 
						$author =  get_field('author', get_the_ID());
						$external_post = get_field('external_post', get_the_ID());
						$post_url = "";
						if($external_post){
							$external_url = get_field('external_url', get_the_ID());
							$post_url = $external_url;
						}
						else{
							$post_url = get_the_permalink();
						}
					?>
					<tr>
						<td><strong><?php echo the_date('Y'); ?></strong></td>
						<td><h4><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?>><?php the_title();?></a></h4></td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
		<?php 
		wp_reset_postdata();
		endif;
		$the_content = ob_get_clean();
        return $the_content;
	}
	
	add_shortcode( 'post_listing_by_category_conventions', 'post_listing_by_category_conventions' );
}

/* Shortcode to get Posts by Category Id */

if ( ! function_exists('post_listing_by_category_id') ) {
	
	function post_listing_by_category_id($atts = array()) {
		$attsArray = shortcode_atts(
			array(
				'categories' => '',
				'limit' => -1,
			), $atts);
		
		
		$args = array(
			'post_type'         =>  'post',
			'post_status'       =>  'publish',
			'posts_per_page' 	=>   $attsArray['limit'],
			'order' => 'ASC'
		);
		
		if ( ! empty( $attsArray['categories'] ) ) 
		{
			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'category',
					'field'  => 'id',
					'terms'  => explode( ',', $attsArray['categories'] ),
					'operator' => 'IN',
				)
			);
		}
		
		$allPosts = new WP_Query( $args );
		ob_start();
		if ( $allPosts->have_posts() ) : ?>
			<div class="table-1">
			<table class="posts-listing">
				<thead>
					<tr>
						<th>Logo/Link</th>
						<th>Link to Chapter Page<br> Chapter contact</th>
						<th>Geographic Area</th>
						<th>Chapter<br> Newsletter</th>
					</tr>
				</thead>
				<?php while ( $allPosts->have_posts() ) : $allPosts->the_post(); ?>
					<?php 
						$contact_link =  get_field('contact_link', get_the_ID());
						$geographic_area =  get_field('geographic_area', get_the_ID());
						$social_icon_link = get_field('social_icon_link', get_the_ID());
						$external_post = get_field('external_post', get_the_ID());
						$post_url = "";
						if($external_post){
							$external_url = get_field('external_url', get_the_ID());
							$post_url = $external_url;
						}
						else{
							$post_url = get_the_permalink();
						}
					?>
					<tr>
						<td><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?> ><?php the_post_thumbnail();?></a></td>
						<td>
							<h4><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?>><?php the_title();?></a></h4>
							<?php if($contact_link) : 
								$link_url = $contact_link['url'];
    							$link_title = $contact_link['title'];
    							$link_target = $contact_link['target'] ? $contact_link['target'] : '_self';
    						?>
							<div class="contact-link"><strong>Contact:</strong> <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
							<?php endif;?>
						</td>
						<td>
							<p><?php echo $geographic_area; ?></p>
							<?php if($social_icon_link) : ?>
								<a href="<?php echo $social_icon_link; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none"><path d="M28.9143 14.4352C28.9143 6.65592 22.608 0.349609 14.8287 0.349609C7.04948 0.349609 0.743164 6.65592 0.743164 14.4352C0.743164 21.4656 5.89402 27.2929 12.6279 28.3496V18.5068H9.05144V14.4352H12.6279V11.3319C12.6279 7.80175 14.7308 5.85178 17.9482 5.85178C19.4888 5.85178 21.1012 6.12689 21.1012 6.12689V9.59326H19.3251C17.5754 9.59326 17.0296 10.6791 17.0296 11.7941V14.4352H20.9361L20.3116 18.5068H17.0296V28.3496C23.7634 27.2929 28.9143 21.4656 28.9143 14.4352Z" fill="#17375e"></path></svg></a>
							<?php endif; ?>
						</td>
						<td>
							
						<?php if( have_rows('newsletters_listing') ): ?>
							<ul class="newsletters_listing">
							<?php while( have_rows('newsletters_listing') ): the_row(); 
								$newsletters_name = get_sub_field('newsletters_name');
								if($newsletters_name) : 
									$link_url = $newsletters_name['url'];
									$link_title = $newsletters_name['title'];
									$link_target = $newsletters_name['target'] ? $newsletters_name['target'] : '_self';
								?>
								<li><a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></li>
								<?php endif;
								?>
							<?php endwhile; ?>
							</ul>
						<?php endif; ?>

						</td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
		<?php 
		wp_reset_postdata();
		endif;
		$the_content = ob_get_clean();
        return $the_content;
	}
	
	add_shortcode( 'post_listing_by_category', 'post_listing_by_category_id' );
}

/* Shortcode to get Posts by Category Id */

if ( ! function_exists('get_post_listing_by_category_id_no_image') ) {
	
	function get_post_listing_by_category_id_no_image($atts = array()) {
		$attsArray = shortcode_atts(
			array(
				'categories' => '',
				'limit' => -1,
			), $atts);
		
		
		$args = array(
			'post_type'         =>  'post',
			'post_status'       =>  'publish',
			'posts_per_page' 	=>   $attsArray['limit'],
			'order' => 'ASC'
		);
		
		if ( ! empty( $attsArray['categories'] ) ) 
		{
			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'category',
					'field'  => 'id',
					'terms'  => explode( ',', $attsArray['categories'] ),
					'operator' => 'IN',
				)
			);
		}
		
		$allPosts = new WP_Query( $args );
		ob_start();
		if ( $allPosts->have_posts() ) : ?>
			<div class="table-1">
			<table class="posts-listing">
				<thead>
					<tr>
						<th>Link to Chapter Page<br> Chapter contact</th>
						<th>Geographic Area</th>
						<th>Chapter<br> Newsletter</th>
					</tr>
				</thead>
				<?php while ( $allPosts->have_posts() ) : $allPosts->the_post(); ?>
					<?php 
						$contact_link =  get_field('contact_link', get_the_ID());
						$geographic_area =  get_field('geographic_area', get_the_ID());
						$social_icon_link = get_field('social_icon_link', get_the_ID());
						$external_post = get_field('external_post', get_the_ID());
						$post_url = "";
						if($external_post){
							$external_url = get_field('external_url', get_the_ID());
							$post_url = $external_url;
						}
						else{
							$post_url = get_the_permalink();
						}
					?>
					<tr>
						<td>
							<h4><a href="<?php echo $post_url; ?>" <?php echo ($external_post && $external_url) ? 'target="_blank"' : ''; ?>><?php the_title();?></a></h4>
							<?php if($contact_link) : 
								$link_url = $contact_link['url'];
    							$link_title = $contact_link['title'];
    							$link_target = $contact_link['target'] ? $contact_link['target'] : '_self';
    						?>
							<div class="contact-link"><strong>Contact:</strong> <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
							<?php endif;?>
						</td>
						<td>
							<p><?php echo $geographic_area; ?></p>
							<?php if($social_icon_link) : ?>
								<a href="<?php echo $social_icon_link; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none"><path d="M28.9143 14.4352C28.9143 6.65592 22.608 0.349609 14.8287 0.349609C7.04948 0.349609 0.743164 6.65592 0.743164 14.4352C0.743164 21.4656 5.89402 27.2929 12.6279 28.3496V18.5068H9.05144V14.4352H12.6279V11.3319C12.6279 7.80175 14.7308 5.85178 17.9482 5.85178C19.4888 5.85178 21.1012 6.12689 21.1012 6.12689V9.59326H19.3251C17.5754 9.59326 17.0296 10.6791 17.0296 11.7941V14.4352H20.9361L20.3116 18.5068H17.0296V28.3496C23.7634 27.2929 28.9143 21.4656 28.9143 14.4352Z" fill="#17375e"></path></svg></a>
							<?php endif; ?>
						</td>
						<td>
							
						<?php if( have_rows('newsletters_listing') ): ?>
							<ul class="newsletters_listing">
							<?php while( have_rows('newsletters_listing') ): the_row(); 
								$newsletters_name = get_sub_field('newsletters_name');
								if($newsletters_name) : 
									$link_url = $newsletters_name['url'];
									$link_title = $newsletters_name['title'];
									$link_target = $newsletters_name['target'] ? $newsletters_name['target'] : '_self';
								?>
								<li><a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></li>
								<?php endif;
								?>
							<?php endwhile; ?>
							</ul>
						<?php endif; ?>

						</td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
		<?php 
		wp_reset_postdata();
		endif;
		$the_content = ob_get_clean();
        return $the_content;
	}
	
	add_shortcode( 'post_listing_by_category_no_image', 'get_post_listing_by_category_id_no_image' );
}

/* +++++++++++++++++++++++++++++ Registration Form Shortcodes ++++++++++++++++++++++++++++++++++++++++++   */

if ( ! function_exists('get_registration__form_2024') ) {
	function get_registration__form_2024() {
		wp_enqueue_script('custom-registraion-form-script', get_stylesheet_directory_uri() . '/js/custom-form.js', array('jquery'), null, true);
		 ob_start(); ?>
		<div class="registration-form-wrapper">
			<form class="registration-form registration-form-2024" name="conv" action="<?php echo site_url('/registrationformprocessor.php'); ?>" method="post">
			  <table style="border: 0px solid black; border-collapse: collapse;" width="100%">
				<tbody>
				  <tr>
					<th colspan="2" style="text-align: left;">LIST ATTENDEES</th>
					<th width="175px">First timer?</th>
					<th>Preferred names for badges</th>
				  </tr>
				  <tr>
					<td style="text-align: right;">Member Name</td>
					<td><input name="memberName" pattern="[A-Za-z .-]{4,}" required="" size="50" type="text"></td>
					<td style="text-align: center;">
					<select name="firstMember">
					<option value="no">no</option>
					<option value="yes">yes</option>
					</select>
					</td>
					<td><input name="memberBadge" pattern="[A-Za-z .-]{2,}" size="50" type="text"></td>
				  </tr>
				  <tr>
					<td style="text-align: right;">Spouse/Partner<br>
					</td>
					<td><input name="spouseName" pattern="[A-Za-z .-]{2,}" size="50" type="text"> </td>
					<td style="text-align: center;">
					<select name="firstSpouse">
					<option value="no">no</option>
					<option value="yes">yes</option>
					</select>
					</td>
					<td><input name="spouseBadge" pattern="[A-Za-z .-]{2,}" size="50" type="text"> </td>
				  </tr>
				  <tr>
					<td style="text-align: right;">Guest 1</td>
					<td><input name="guest1Name" pattern="[A-Za-z .-]{2,}" size="50" type="text"> </td>
					<td style="text-align: center;">
            <select name="firstGuest1">
            <option value="no">no</option>
            <option value="yes">yes</option>
            </select>
					</td>
					<td><input name="guest1Badge" pattern="[A-Za-z .-]{2,}" size="50" type="text"> </td>
				  </tr>
				  <tr>
					<td style="text-align: right;">Guest 2<br>
					</td>
					<td><input name="guest2Name" pattern="[A-Za-z .-]{2,}" size="50" type="text"> </td>
					<td style="text-align: center;">
            <select name="firstGuest2">
            <option value="no">no</option>
            <option value="yes">yes</option>
            </select>
					</td>
					<td><input name="guest2Badge" pattern="[A-Za-z .-]{2,}" size="50" type="text"> </td>
				  </tr>
				  <tr>
					  <td style="text-align: right; vertical-align: top;">Special needs?<br>
					</td>
					<td colspan="3"><textarea rows="2" cols="100" name="specialNeeds" placeholder="Please tell us of any special physical or dietary needs..."></textarea><br>
			&nbsp; </td>
				  </tr>
				  <tr>
					<td colspan="4" style="font-weight: bold; color: #0100fc;">MEMBER'S CONTACT INFORMATION</td>
				  </tr>
				  <tr>
					<td style="text-align: right; vertical-align: top;" rowspan="5">Mailing Address</td>
					<td rowspan="5" style="vertical-align: top;" class="address">
						<input name="addressLine1" size="50" placeholder="address line 1" type="text">
						<input name="addressLine2" size="50" placeholder="address line 2" type="text">
						<input name="addressLine3" size="50" placeholder="address line 3" type="text">
						<input name="addressLine4" size="50" placeholder="address line 4" type="text">
					</td>
					<td>SCI Nbr.</td>
					<td><input name="memberNbr" size="4" placeholder="nnnn" type="text"> </td>
				  </tr>
				  <tr>
					<td>Phone</td>
					<td><input name="memberPhone" size="20" type="text"> </td>
				  </tr>
				  <tr>
					<td>Cell</td>
					<td><input name="memberCell" size="20" type="text"> </td>
				  </tr>
				  <tr>
					<td>Email</td>
					<td><input name="memberEmail" size="50" placeholder="Your confirmation will be sent here" required="" type="email"></td>
				  </tr>
				  <tr>
					<td style="vertical-align: top;">Chapter</td>
					<td style="vertical-align: top;">
					<select name="chapterSelect" placeholder="Select">
					<option value="">select</option>
					<option value="ALTE GERMANEN">ALTE GERMANEN</option>
					<option value="ARIZONA STEIN COLLECTORS">ARIZONA STEIN COLLECTORS</option>
					<option value="BAYOU STEIN VEREIN">BAYOU STEIN VEREIN</option>
					<option value="BURGERMEISTERS">BURGERMEISTERS</option>
					<option value="CAROLINA STEINERS">CAROLINA STEINERS</option>
					<option value="DIE GOLDEN GATE ZECHER">DIE GOLDEN GATE ZECHER</option>
					<option value="DIE KRUGSAMMLER e. V.">DIE KRUGSAMMLER e. V.</option>
					<option value="DIE LUSTIGEN STEINJAEGER">DIE LUSTIGEN STEINJAEGER</option>
					<option value="DIE STUDENTEN PRINZ GRUPPE">DIE STUDENTEN PRINZ GRUPPE</option>
					<option value="DIXIE STEINERS">DIXIE STEINERS</option>
					<option value="ERSTE GRUPPE">ERSTE GRUPPE</option>
					<option value="GAMBRINUS STEIN CLUB">GAMBRINUS STEIN CLUB</option>
					<option value="LONE STAR CHAPTER">LONE STAR CHAPTER</option>
					<option value="MEISTER STEINERS">MEISTER STEINERS</option>
					<option value="MICHISTEINERS">MICHISTEINERS</option>
					<option value="NEW ENGLAND STEINERS">NEW ENGLAND STEINERS</option>
					<option value="PACIFIC STEIN SAMMLER">PACIFIC STEIN SAMMLER</option>
					<option value="PENNSYLVANIA KEYSTEINERS">PENNSYLVANIA KEYSTEINERS</option>
					<option value="PITTSBURGH STEIN SOCIETY">PITTSBURGH STEIN SOCIETY</option>
					<option value="ROCKY MOUNTAIN STEINERS">ROCKY MOUNTAIN STEINERS</option>
					<option value="SAINT LOUIS GATEWAY STEINERS">SAINT LOUIS GATEWAY STEINERS</option>
					<option value="SUN STEINERS">SUN STEINERS</option>
					<option value="THIRSTY KNIGHTS">THIRSTY KNIGHTS</option>
					<option value="THOROUGHBRED STEIN VEREIN">THOROUGHBRED STEIN VEREIN</option>
					<option value="UPPER MIDWEST STEINOLOGISTS">UPPER MIDWEST STEINOLOGISTS</option>
					<option value="UPPERSTEINERS OF N.Y. STATE">UPPERSTEINERS OF N.Y. STATE</option>
					</select>
					</td>
				  </tr>
				</tbody>
			  </table>
			  <table style="border: 0px solid black; border-collapse: collapse; width: 100%;">
				<tbody>
<!-- 				  <tr>
					<td colspan="4"><noscript><p>Your browser is not currently enabled for JavaScript, so we are unable to do the calculations in this form for you.</p></noscript></td>
				  </tr> -->
				  <tr style="border-top: 2px solid #0100fc;">
					<td colspan="4" style="font-weight: bold; color: #0100fc;">REGISTRATION FEES <span style="font-weight: normal; color: #000000;">include three "main tent" speakers, six roundtables, three breakfasts, dinner on Thursday and Saturday evenings, snacks and drinks in our own Hospitality Room, and of course, a custom-designed convention stein (one per single or couple). Your registration will be confirmed upon receipt of payment.&nbsp;&nbsp;<b>NOTE: Late registration fees will apply after May 31.</b></span>
					</td>
				  </tr>
				  <tr>
					<td>
					</td>
					<td style="text-align: center;">Amount</td>
					<td style="text-align: center;">Qty</td>
					<td style="text-align: center;">&nbsp;&nbsp;Amount&nbsp;&nbsp;</td>
				  </tr>
				  <tr>
					<td>Single - Includes one convention stein</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$&nbsp;<input name="priceSingle" size="4" tabindex="99" readonly="readonly" value="345" type="text"></td>
					<td style="text-align: center;">
					<select name="qtySingle" onchange="convCalculate()" placeholder="Select">
					<option value="0" selected="selected">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalSingle" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" onchange="convCalculate()" type="text"></td>
				  </tr>
				  <tr>
					<td>Couple - Includes one convention stein</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$ <input name="priceCouple" size="4" tabindex="99" readonly="readonly" value="625" type="text"></td>
					<td style="text-align: center;">
					<select name="qtyCouple" onchange="convCalculate()" placeholder="Select">
					<option value="0" selected="selected">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalCouple" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
				  <tr>
					<td colspan="4" style="font-weight: bold; color: #0100fc;">ADDITIONAL OPTIONS AND EVENTS</td>
				  </tr>
			<!-- +++++++++++++++++++++++++++  EVENT1 +++++++++++++++++++++++++++ -->
				  <tr>
					<td>Tuesday AM July 2 - Madison City Tour (9:30AM - noon) (56 people max!)</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$ <input name="priceEvent1" size="4" tabindex="99" readonly="readonly" value="45" type="text"><br>
					</td>
					<td style="text-align: center;">
					<select name="qtyEvent1" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalEvent1" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
				  <tr style="display: none;">
					<td>text for Event1<input name="textEvent1" size="50" value="Madison City Tour" readonly="readonly" type="text"><br>
					</td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ EVENT2 +++++++++++++++++++++++++++ -->
				  <tr>
					<td>Tuesday PM July 2 - Wollersheim Winery (12:30PM - 3:30PM) (56 people max!)</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$ <input name="priceEvent2" size="4" tabindex="99" readonly="readonly" value="45" type="text"> </td>
					<td style="text-align: center;">
					<select name="qtyEvent2" required="" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalEvent2" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
				  <tr style="display: none;">
					<td>text for Event2 <input name="textEvent2" size="50" value="Wollersheim Winery" readonly="readonly" type="text"><br>
					</td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ EVENT3 +++++++++++++++++++++++++++ -->
				  <tr style="DISPLAY:NONE;">
					<td>xxxxxxxx</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="priceEvent3" size="4" tabindex="99" readonly="readonly" value="0" type="text"> </td>
					<td style="text-align: center;">
					<select name="qtyEvent3" required="" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalEvent3" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
				  <tr style="display: none;">
					<td>text for Event3 <input name="textEvent3" size="50" value="not used" readonly="readonly" type="text"><br>
					</td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ EVENT4 +++++++++++++++++++++++++++ -->
				  <tr style="DISPLAY:NONE;">
					<td>xxxxxxxx</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="priceEvent4" size="4" tabindex="99" readonly="readonly" value="0" type="text"> </td>
					<td style="text-align: center;">
					<select name="qtyEvent4" required="" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalEvent4" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
				  <tr style="display: none;">
					<td>text for Event4 <input name="textEvent4" size="50" value="not used" readonly="readonly" type="text"><br>
					</td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ AUCTION +++++++++++++++++++++++++++ -->
				  <tr style="color: #0100fc; font-size: 1.2em; font-weight: bold;">
					<td>Wednesday, July 3 - Live stein auction conducted by Fox Auctions (open to the public)<br>
					</td>
					<td><br>
					</td>
					<td><br>
					</td>
					<td><br>
					</td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ Tea +++++++++++++++++++++++++++ -->
				  <tr>
					<td>Friday, July 5 - Afternoon Tea at the Sky Bar, Edgewater Hotel (limit of 50 attendees)<br>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$ <input name="priceTea" size="4" tabindex="99" readonly="readonly" value="60" type="text"> </td>
					<td style="text-align: center;">
					<select name="qtyTea" required="" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalTea" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
				  <tr style="display: none;">
					<td>text for Tea <input name="textTea" size="50" value="Afternoon Tea" readonly="readonly" type="text"><br>
					</td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ FULL TABLES +++++++++++++++++++++++++++ -->
				  <tr>
					<td>Stein sales room - Full table - registered attendees only<br>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$ <input name="priceFullTables" size="4" tabindex="99" readonly="readonly" value="30" type="text"><br>
					</td>
					<td style="text-align: center;">
					<select name="qtyFullTables" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalFullTables" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ HALF TABLES +++++++++++++++++++++++++++ -->
				  <tr>
					<td>Stein sales room - Half table - registered attendees only </td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$ <input name="priceHalfTables" size="4" tabindex="99" readonly="readonly" value="20" type="text"><br>
					</td>
					<td style="text-align: center;">
					<select name="qtyHalfTables" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalHalfTables" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
			<!-- +++++++++++++++++++++++++++ ADDITIONAL STEINS +++++++++++++++++++++++++++ -->
				  <tr style="border-bottom: 0px solid gray;">
					<td style="vertical-align: top;">Additional convention steins (subject to availability)<br>&nbsp;</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$ <input name="priceSteins" size="4" tabindex="99" readonly="readonly" value="55" type="text"></td>
					<td style="text-align: center; vertical-align: top;">
					<select name="qtySteins" onchange="convCalculate()" placeholder="Select">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					</select>
					</td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="totalSteins" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text"> </td>
				  </tr>
			<!-- +++++++++++++++++++++++++ COST SUMMARY +++++++++++++++++++++++++++++++++ -->
				  <tr>
            <td colspan="3" style="text-align: right;"><span style="font-weight: bold;">GRAND TOTAL</span></td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="grandTotal" size="6" tabindex="99" style="text-align: right;" onchange="convCalculate()" placeholder="0.00" readonly="readonly" type="text">&nbsp;&nbsp;</td>
				  </tr>
				  <tr>
            <td colspan="3" style="text-align: right;">The minimum required deposit is 50% of the total of all fees. <span style="font-weight: bold;">MINIMUM DEPOSIT</span></td>
					  <td style="text-align: center; display: flex; align-items:center; gap: 10px;">$<input name="minimumDeposit" size="6" tabindex="99" style="text-align: right;" placeholder="0.00" readonly="readonly" type="text">&nbsp;&nbsp;</td>
				  </tr>
				  <tr>
            <td colspan="3" style="text-align: right;"><span style="font-weight: bold; color: #0100fc;">IF YOU WANT TO PAY MORE THAN THE MINIMUM, ENTER AMOUNT HERE</span></td>
					<td style="text-align: center; display: flex; align-items:center; gap: 10px;"> $<input name="amountToPay" size="6" tabindex="99" style="text-align: right;" required="" onchange="checkAmountToPay()" type="text">&nbsp;&nbsp; </td>
				  </tr>
			<!-- +++++++++++++++++++++++++ OTHER CHOICES +++++++++++++++++++++++++++++++++ -->
				  <tr>
					  <td colspan="4" style="font-weight: bold; color: #0100fc;">OTHER CHOICES YOU NEED TO MAKE (and don't forget to click SUBMIT below when you are done)</td>
				  </tr>
				  <tr>
				    <td colspan="4" style="font-weight: bold;">THURSDAY evening (July 4) in the hotel - German Night - Indicate quantity for each entree choice</td>
          </tr>
          <tr>
            <td colspan="3">Please indicate how many of your party will attend, then enter the quantity for each entree</td>
            <td width="200px">
              <select name="qtyThursdayDinner" required="" placeholder="Select">
                <option value="">?</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="3">Sausage Sampler Plate</td>
            <td width="200px">
              <select name="qtyThursEntree1" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr>  
          <tr>
            <td colspan="3">Smoked Pork Chop</td>
            <td width="200px">
              <select name="qtyThursEntree2" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr> 
          <tr>
            <td colspan="3">Chicken Asiago</td>
            <td width="200px">
              <select name="qtyThursEntree3" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr> 
          <tr>
            <td colspan="3">Stuffed Portobello Mushroom (veg.)</td>
            <td width="200px">
              <select name="qtyThursEntree4" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr> 
				  <tr style="display: none;">
					  <td>text for ThursEntree1<input name="textThursEntree1" size="50" value="Sausage Sampler Plate" readonly="readonly" type="text"><br>
					</td>
				  </tr>
				  <tr style="display: none;">
					  <td>text for ThursEntree2<input name="textThursEntree2" size="50" value="Smoked Pork Chop" readonly="readonly" type="text"><br>
					</td>
				  </tr>
				  <tr style="display: none;">
					  <td>text for ThursEntree3<input name="textThursEntree3" size="50" value="xxxxxxxxx" readonly="readonly" type="text"><br>
					</td>
				  </tr>
				  <tr style="display: none;">
					  <td>text for ThursEntree4<input name="textThursEntree4" size="50" value="xxxxxxxxx" readonly="readonly" type="text"><br>
					</td>
				  </tr>
          <tr>
            <td colspan="4"><strong>SATURDAY evening dinner (July 6) in the hotel</strong></td>
          </tr>
          <tr>
            <td colspan="3">Please indicate how many of your party will attend. - Indicate quantity for each entree choice.</td>
            <td width="200px">
              <select name="qtySaturdayDinner" required="" placeholder="Select">
                <option value="">?</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="3">Herbed Chicken Breast</td>
            <td width="200px">
              <select name="qtySatEntree1" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="3">Pan Seared Salmon</td>
            <td width="200px">
              <select name="qtySatEntree2" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="3">Beef Short Ribs</td>
            <td width="200px">
              <select name="qtySatEntree3" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="3">Mushroom Ravioli (veg.)</td>
            <td width="200px">
              <select name="qtySatEntree4" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          </tr>
					<tr style="display: none;">
					  <td>text for SatEntree1<input name="textSatEntree1" size="50" value="Herbed Chicken Breast" readonly="readonly" type="text"></td>
				  </tr>
				  <tr style="display: none;">
					  <td>text for SatEntree2<input name="textSatEntree2" size="50" value="Pan Seared Salmon" readonly="readonly" type="text"></td>
				  </tr>
				  <tr style="display: none;">
					  <td>text for SatEntree3<input name="textSatEntree3" size="50" value="Beef Short Ribs" readonly="readonly" type="text"></td>
				  </tr>
				  <tr style="display: none;">
					  <td>text for SatEntree4<input name="textSatEntree4" size="50" value="Mushroom Ravioli (veg.)" readonly="readonly" type="text"></td>
				  </tr>
				  <tr style="display: none;">
					  <td colspan="4" style="font-weight: bold; color: #0100fc;">EARLY BIRDERS: Would you be interested in a group dinner on <b><u>Monday</u></b> evening if it can be arranged?</td>
          </tr>
          <tr style="display: none;">
            <td colspan="3">Please indicate how many of your party would attend.</td>
            <td width="200px">
              <select name="qtyMondayDinner" placeholder="Select">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
				  </tr>

			<!-- +++++++++++++++++++++++++ COST SUMMARY +++++++++++++++++++++++++++++++++ -->
				  <tr>
					  <td colspan="3" style="text-align: right;">Clicking <strong>SUBMIT</strong> will complete your registrations and take you to PayPal to make your payment (<strong>may take up to 10 seconds</strong>). <br>(If you are new to PayPal, <a href="https://stein-collectors.org/conv/About%20PayPal.html" target="_blank"><strong>click here</strong></a> for a quick overview.)</td>
					  <td><input value="SUBMIT" type="submit" class="btn-submit fusion-button-default-size button-default"></td>
				  </tr>
				  <tr>
					<td colspan="4" style="text-align: center;">SCI has negotiated a special rate of $139 for either a single or a double room at The Madison Concourse Hotel and Governor&apos;s Club, 1 West Dayton St., Madison, WI 53703. This rate is available until July 6th, or when the group block is sold out. To make your reservation call the hotel toll free at 1-800-356-8293 - say you are with the Stein Collectors International 2024 Annual Convention. Hotel parking is $15 per night.
					</td>
				  </tr>
				  <tr>
					<td colspan="4" style="text-align: center;"><span style="color: #0100fc; font-weight: bold;">QUESTIONS?</span> Contact <strong>David Bruha</strong> at <a href="mailto:dsbruha@Frontier.com"><strong>dsbruha@Frontier.com</strong></a> or <strong>715-277-3796</strong></td>
				  </tr>
				  <tr>
					<td colspan="4" style="text-align: center;"><em>Please send an email to <a href="mailto:webmaster@stein-collectors.org"><strong>webmaster@stein-collectors.org</strong></a> 			if you experience any problems using this page.</em></td>
				  </tr>
				</tbody>
			  </table>
			</form>
		</div>

	<?php
	return ob_get_clean();
	}
	add_shortcode( 'registration_form_2024', 'get_registration__form_2024' );
}
