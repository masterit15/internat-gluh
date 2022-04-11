<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package internat_gluh
 */

?>

<footer id="footer">
	<div class="footer_list">
		<div class="footer_list_item">
			<h3>Телефоны доверия</h3>
			<ul class="contact_list">
				<li class="contact_list_item">
					<span>Всероссийский телефон доверия</span>
					<a href="tel:88002000122">8 800 2000 122</a>
				</li>
				<li class="contact_list_item">
					<span>Телефон доверия РСО-Алания</span>
					<a href="tel:529870">52 98 70</a>
				</li>
				<li class="contact_list_item">
					<a href="/privacy-policy/" target="_blank" rel="noopener noreferrer">Политика конфиденциальности</a>
				</li>
				
			</ul>
		</div>
		<div class="footer_list_item">
			<h3>Контактные данные</h3>
			<ul class="contact_list">
				<?
				$reviews = new WP_Query(
					array(
						'post_type' => 'contact_data',
						'post_status' => 'publish',
						'posts_per_page' => 10,
						// 'category_name' => 'news'
					)
				);

				if ($reviews->have_posts()) {
					while ($reviews->have_posts()) {
						$reviews->the_post();
						$custom = get_post_custom($reviews->ID);
				?>
						<li class="contact_list_item">
							<h4><? the_title() ?></h4>
							<span><?= $custom['contact_data_fio'][0] ?></span>
							<a href="email:<?= $custom['contact_data_email'][0] ?>"><?= $custom['contact_data_email'][0] ?></a>
							<?
							if (strpos($custom['contact_data_phone'][0], ',')) {
								$phones = explode(',', $custom['contact_data_phone'][0]);
								foreach ($phones as $phone) {
									echo '<a href="tel:' . $phone . '">' . $phone . '</a>';
								}
							} else {
								echo '<a href="tel:' . $custom['contact_data_phone'][0] . '">' . $custom['contact_data_phone'][0] . '</a>';
							}
							?>
						</li>
				<?
					}
				}
				wp_reset_postdata(); ?>
			</ul>
		</div>
	</div>
	<ul class="social">
		<?if(get_theme_mod('soc_vk')){?>
		<li>
			<a href="<?= get_theme_mod('soc_vk') ?>" target="_black"><img src="<?=TURI?>/images/dist/vk.svg" alt=""></a>
		</li>
		<?}?>
		<?if(get_theme_mod('soc_inst')){?>
		<li>
			<a href="<?= get_theme_mod('soc_inst') ?>" target="_black"><img src="<?=TURI?>/images/dist/im.svg" alt=""></a>
		</li>
		<?}?>
		<?if(get_theme_mod('soc_fac')){?>
		<li>
			<a href="<?= get_theme_mod('soc_fac') ?>" target="_black"><img src="<?=TURI?>/images/dist/fb.svg" alt=""></a>
		</li>
		<?}?>
		<?if(get_theme_mod('soc_ok')){?>
		<li>
			<a href="<?= get_theme_mod('soc_ok') ?>" target="_black"><img src="<?=TURI?>/images/dist/ok.svg" alt=""></a>
		</li>
		<?}?>
	</ul>
	<div class="copyright"><?= get_theme_mod('copyright') ?></div>
</footer><!-- #colophon -->

</div>
</div>
</div><!-- #page -->
<?php wp_footer(); ?>
<ul class="mobile_nav">
	<li class="mobile_nav_item add" aria-label="отправить заявку"><a href="/proekt-sovremennaya-shkola/#app_form"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></li>
	<li class="mobile_nav_item specversion bt_widget-vi-on" aria-label="версия для слабовидящих">
		<i class="fa fa-eye" aria-hidden="true"></i>
		<!-- <i class="fa fa-low-vision" aria-hidden="true"></i> -->
	</li>
	<li class="mobile_nav_item search" aria-label="поиск по сайту"><i class="fa fa-search" aria-hidden="true"></i></li>
</ul>
	
	<div class="search_popup">
		<?=get_search_form()?>
	</div>
	<div id="toTop" title="web studio 302">
      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
      <style type="text/css">
        .toTop-st0{fill:#F64400;}
        .toTop-st1{fill:#F5D200;}
        .toTop-st2{fill:#FFFFFF;stroke:#E5E5E5;stroke-miterlimit:10;}
        .toTop-st3{fill:#444444;stroke:#E5E5E5;stroke-miterlimit:10;}
      </style>
      <g id="fire">
        <path class="toTop-st0" d="M199.6,314.3c66.7,3.4,129-9,153.8-33.9c38.9-38.9,41.4-90.7,6.1-126c-35.3-35.3-87.2-32.8-126,6.1
          C208.6,185.4,196.2,247.8,199.6,314.3"/>
        <path class="toTop-st1" d="M296.3,167.7c-10.4,10.4-15.5,36.4-14.1,64.1c27.8,1.4,53.8-3.8,64.1-14.1c16.2-16.2,17.2-37.8,2.5-52.5
          C334.1,150.5,312.5,151.5,296.3,167.7z"/>
      </g>
      <g id="roket" focusable="false">
        <g>
          <path class="toTop-st2" d="M9.6,504.4 M59.1,159.8l-47.7,95.4C10,258.5,9.1,262,9,265.6c0,12.8,10.4,23.2,23.2,23.2h90.2
            c22.6-45.8,58.9-119.1,75.2-151.9c0.5-0.9,1-1.7,1.5-2.6h-98.5C84.8,134.3,66.2,145.7,59.1,159.8z M377.2,316.3
            c-32.8,16.4-106.3,52.8-151.9,75.4V482c0.2,12.7,10.5,22.9,23.1,23c3.5-0.1,7-1,10.3-2.4l95.3-47.7c14.1-7.1,25.6-25.6,25.6-41.4
            v-98c0.1,0,0.1-0.1,0.2-0.1v-0.5C378.9,315.3,378.1,315.8,377.2,316.3z"/>
          <path class="toTop-st2" d="M496.7,29.5c-1.4-6-6.1-10.7-12.1-12.1c-31.3-6.7-56.2-6.7-80.3-6.7c-86.1,0-151.3,39.2-205.2,123.4
            c-0.5,0.9-1,1.8-1.6,2.8C181.3,169.6,145,243,122.4,288.7h10.2c51.2,0,92.7,41.5,92.7,92.7c0,0,0,0,0,0v10.3
            c45.6-22.6,119.1-59,151.9-75.4c0.9-0.5,1.8-1,2.7-1.5c84.2-54.1,123.4-119.2,123.4-205C503.4,85.6,503.5,61,496.7,29.5z
            M364.3,196c-25.6,0-46.3-20.7-46.3-46.3s20.7-46.3,46.3-46.3c25.6,0,46.3,20.7,46.3,46.3C410.6,175.3,389.9,196,364.3,196z"/>
        </g>
        <circle class="toTop-st3" cx="364.3" cy="149.7" r="45.4"/>
      </g>
      </svg>
      <span class="stars">
        <span class="star star-1"></span>
        <span class="star star-2"></span>
        <span class="star star-3"></span>
        <span class="star star-4"></span>
      </span>
      </div>
</body>

</html>