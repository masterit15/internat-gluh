<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
<div class="content" id="post-<?php the_ID(); ?>">
	<?php the_title( '<h2 class="page_title title">', '</h2>' ); ?>

	<?php the_content();?>
	<section id="app+form">
		<h3 style="text-align: center;">Запись на консультацию</h3>
		<p> Заполняя форму, вы даете согласие на обработку персональных данных.</p>
		<p>* - обязательные поля для заполнения</p>
	
	<form action="<?site_url ()?>/wp-admin/admin-ajax.php?action=application" class="application">
	<div class="loader" id="loader-4">
		<span></span>
		<span></span>
		<span></span>
	</div>
		<div class="application_wrap">
		<!-- <span class="close"><i class="fa fa-times"></i></span> -->
		<div class="heda">
		<div class="specialists_filter">
			<?
			$terms = get_terms( 'specialists-cat' );
			if( $terms && ! is_wp_error($terms) ){
				echo '<select id="specialists_cat" name="specialists_cat" title="Категории специалистов" data-action="'.site_url ().'/wp-admin/admin-ajax.php?action=specialistsSelect">';
				echo '<option value="#">Категории специалистов</option>';
				foreach( $terms as $term ){
					echo '<option value="'.$term->term_id.'">'. $term->name .'</option>';
				}
				echo '</select>';
			}
			$reviews = new WP_Query(
				array(
						'post_type' => 'specialists',
						'post_status' => 'publish',
						'posts_per_page' => -1,
				)
		);
		if ($reviews->have_posts()) {
			echo '<select id="specialists" name="specialists" title="Список специалистов" data-action="'.site_url ().'/wp-admin/admin-ajax.php?action=specialistShedule">';
				echo '<option value="#">Список специалистов</option>';  
				while ($reviews->have_posts()) {
					global $post;
						$reviews->the_post();
						echo '<option value="'.$post->ID.'">'. $post->post_title .'</option>';
				}
			echo '</select>';
		}
			?>
			</div>
			<select name="service_type" id="service_type">
				<option value="#">Вид оказания услуг</option>
				<option value="#">очная</option>
				<option value="#">дистанционная</option>
			</select>
		
		</div>
		<div class="specialists_fields">
		<div class="fields_group">
			<input type="text" class="input" name="fio" id="fio" required>
			<label for="fio">ФИО*</label>
		</div>
		<div class="fields_group">
			<input type="text" class="input" name="age" id="age" required>
			<label for="fio">Возраст ребенка*</label>
		</div>
		<div class="fields_group">
			<input type="text" class="input" name="phone" id="phone">
			<label for="phone">Телефон</label>
		</div>
		<div class="fields_group">
			<input type="text" class="input" name="email" id="email">
			<label for="email">Е-почта</label>
		</div>
		<div class="fields_group">
			<textarea id="text" name="text" id="" cols="30" rows="5"></textarea>
			<label for="text">Предполагаемая тема обращения</label>
		</div>
		<input type="text" name="captcha" id="captcha">
		<div class="privacy-policy">
			<input type="checkbox" name="privacypolicy" id="privacy-policy" required checked disabled>
			Нажимая на кнопку "Отправить", я принимаю условия <a href="/polzovatelskoe-soglashenie/" target="_blank" rel="noopener noreferrer">пользовательского соглашения</a><br>
		</div>
		<button class="btn" type="submit">отправить</button>
		</div>
		</div>
	</form>
	</section>
</div>
