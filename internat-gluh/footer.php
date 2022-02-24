<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package internat-gluh
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
				));
				
				if ($reviews->have_posts()) {
					while ($reviews->have_posts()) {$reviews->the_post();
					$custom = get_post_custom($reviews->ID);
				?>
				<li class="contact_list_item">
					<h4><?the_title()?></h4>
					<span><?=$custom['contact_data_fio'][0]?></span>
					<a href="email:<?=$custom['contact_data_email'][0]?>"><?=$custom['contact_data_email'][0]?></a>
					<?
					if(strpos($custom['contact_data_phone'][0], ',')){
						$phones = explode(',', $custom['contact_data_phone'][0]);
						foreach($phones as $phone){
							echo '<a href="tel:'.$phone.'">'.$phone.'</a>';
						}
					}else{
						echo '<a href="tel:'.$custom['contact_data_phone'][0].'">'.$custom['contact_data_phone'][0].'</a>';
					}
					?>
				</li>
				<?
				}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
			</ul>
			</div>
		</div>

	</footer><!-- #colophon -->

	</div>
</div>
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
