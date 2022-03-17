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
	<li class="mobile_nav_item add" aria-label="отправить заявку"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></li>
	<li class="mobile_nav_item specversion bt_widget-vi-on" aria-label="версия для слабовидящих">
		<i class="fa fa-eye" aria-hidden="true"></i>
		<!-- <i class="fa fa-low-vision" aria-hidden="true"></i> -->
	</li>
	<li class="mobile_nav_item search" aria-label="поиск по сайту"><i class="fa fa-search" aria-hidden="true"></i></li>
</ul>
	<form action="" class="application">
		<span class="close"><i class="fa fa-times"></i></span>
		<div class="fields_group">
			<input type="text" class="input" name="fio" id="fio" required>
			<label for="fio">ФИО</label>
		</div>
		<div class="fields_group">
			<input type="text" class="input" name="phone" id="phone" required>
			<label for="phone">Телефон</label>
		</div>
		<div class="fields_group">
			<input type="text" class="input" name="email" id="email" required>
			<label for="email">Е-почта</label>
		</div>
		<div class="fields_group">
			<textarea id="text" name="text" id="" cols="30" rows="5" required></textarea>
			<label for="text">Текст</label>
		</div>
		<button class="btn" type="submit">отправить</button>
	</form>
</body>

</html>