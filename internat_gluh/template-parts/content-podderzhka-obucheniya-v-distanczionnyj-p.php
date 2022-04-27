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
	<?php the_title('<h2 class="page_title title">', '</h2>'); ?>

	<?php the_content(); ?>
	<section id="app_form">
		<h3>Задать вопрос по организации дистанционных уроков</h3>
		
		<p> Заполняя форму, вы даете согласие на обработку персональных данных.</p>
		<p>Пожалуйста, укажите Ваши контактные данные:</p>
		<p>* - обязательные поля для заполнения</p>

		<form action="<? site_url() ?>/wp-admin/admin-ajax.php?action=distance_education" class="distance_education">
			<div class="loader" id="loader-4">
				<div class="loader_wrap">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
			<div class="application_wrap">
				<div class="specialists_fields">
					<div class="fields_group">
						<input type="text" class="input" name="class" id="class" required>
						<label for="class">Класс ребенока*</label>
					</div>
					<div class="fields_group">
						<input type="text" class="input" name="fio" id="fio" required>
						<label for="fio">ФИО*</label>
					</div>
					<div class="fields_group">
						<input type="text" class="input" name="email" id="email" required>
						<label for="email">Е-почта*</label>
					</div>
					<div class="fields_group">
						<input type="text" class="input" name="phone" id="phone">
						<label for="phone">Телефон</label>
					</div>
					<div class="fields_group">
						<textarea id="text" name="text" id="" cols="30" rows="5" required>Уважаемая Администрация ГБОУ "Комплексный реабилитационно-образовательный центр для детей с нарушениями слуха и зрения" г. Владикавказ. Сообщаю, что у меня и моего ребенка – обучающегося _ класса «_», возник вопрос по организации дистанционных уроков следующего плана: _______. Прошу предоставить разъяснения по вышеизложенному вопросу.</textarea>
						<label for="text">Обращение*</label>
					</div>
					<input type="text" name="captcha" id="captcha">
					<div class="privacy-policy">
						<input type="checkbox" name="privacypolicy" id="privacy-policy" required checked disabled>
						Нажимая на кнопку "Отправить", я принимаю условия <a href="/polzovatelskoe-soglashenie/" target="_blank" rel="noopener noreferrer">пользовательского соглашения</a><br>
					</div>
					
				</div>
				<button class="btn" type="submit">отправить</button>
			</div>
		</form>
	</section>
</div>