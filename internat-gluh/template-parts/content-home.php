<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
<span class="elips-small-light"></span>
<span class="elips-small-red"></span>
<section class="hero">
  <div class="offer">
    <div class="offer_wrap">
      <h2 class="offer_title title">Не отказывай себе в качестве!</h2>
      <p class="offer_text">Наша компания предоставляет стабильное и качественное интернет подключение  посредством оптоволоконных технологий. Каждый может подобрать подходящий ему безлимитный тарифный план, а также насладиться ночным ускорением.</p>
      <button class="offer_btn" data-action="<?php echo site_url ()?>/wp-admin/admin-ajax.php?action=form">Подключиться</button>
    </div>
  </div>
  <video width="674" height="674" class="video" loop="loop" autoplay="" muted="">
    <source src="#" type="video/mp4" />
    <source src="#" type="video/ogv" />
    <source src="<?=TURI;?>/video/STelecomComposed_final_alpha.webm" type="video/webm" />
  </video>
  <span class="down_text">
    <svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 16.672l5.364-5.364 1.414 1.414L12 20.5l-7.778-7.778 1.414-1.414L11 16.672V4.5h2v12.172z" fill="#241D19" fill-opacity=".8"/></svg>
    наши тарифы
  </span>
</section>
<section class="rates">
  <h2 class="section_title title">Выберите подходящий тарифный план</h2>
  <ul class="rates_list">
		<?
			$reviews = new WP_Query(
			array(
			'post_type' => 'rates',
			'post_status' => 'publish',
			'posts_per_page' => 5,
			'orderby'          => 'date',
      'order'            => 'ASC',
			'page'=> 1
			// 'category_name' => 'news'
			));
			
			if ($reviews->have_posts()) {
				$speed = 9;
				while ($reviews->have_posts()) {$reviews->the_post();
				
				$custom = get_post_custom($reviews->ID);
			// PR($custom);
		?>
			<li class="rates_list_item <?if($custom['rates_popular'][0] == 'y'){?>popular<?}?>" data-speed="<?=$speed?>">
      <h3 class="rates_list_item_title"><?the_title()?></h3>
      <div class="rates_list_item_speedometer">
        <svg width="84" height="67" version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          viewBox="0 0 90 75" style="enable-background:new 0 0 90 75;" xml:space="preserve">
        <style type="text/css">
          .st0{fill:#00C9AF;}
          .st1{fill:#FFD777;}
          .st2{fill:#FF8244;}
          .st3{fill:#FFBA4A;}
          .st4{fill:#FD4848;}
          .st5{fill:#FFFFFF;filter:url(#Adobe_OpacityMaskFilter);}
          .st6{mask:url(#path-9-inside-1_0_1_2_);fill:#241D19;}
          .st7{fill:none;stroke:#241D19;stroke-width:3;}
          .st8{fill:#FFFFFF;filter:url(#Adobe_OpacityMaskFilter_1_);}
          .st9{mask:url(#path-12-inside-2_0_1_2_);fill:#858585;stroke:#241D19;stroke-width:6;}
          .st10{fill:#241D19;}
          .st11{fill:#FFFFFF;filter:url(#Adobe_OpacityMaskFilter_2_);}
          .st12{mask:url(#path-18-inside-3_0_1_2_);fill:#8AE7D3;stroke:#241D19;stroke-width:4;}
        </style>
        <path class="st0" d="M14.7,40.5H6.2c-1.5,13.5,2,18,3,23.5c0.8,4.5,10.5,4,9.5-1C17.2,55.3,14.4,45,14.7,40.5z"/>
        <path class="st1" d="M26.9,21.3l-6.2-5.8C10.4,24.2,9.3,31.3,6.2,36c-2.5,3.8,5.8,6.8,8.5,2.5C18.9,31.8,23.6,24.3,26.9,21.3z"/>
        <path class="st2" d="M61.4,21.3l6.2-5.8C78,24.2,79.1,31.3,82.1,36c2.5,3.8-5.8,6.8-8.5,2.5C69.5,31.8,64.8,24.3,61.4,21.3z"/>
        <path class="st3" d="M61.2,20.2l8-5.7c-29-13-39.2-3.2-44.7-1.8c-4.4,1.1-0.4,9,4.6,7.6C36.8,18.1,40.2,13.5,61.2,20.2z"/>
        <path class="st4" d="M74.3,42h8.5c1.5,13.5-2,18-3,23.5c-0.8,4.5-10.5,4-9.5-1C71.9,56.8,74.6,46.5,74.3,42z"/>
        <defs>
          <filter id="Adobe_OpacityMaskFilter" filterUnits="userSpaceOnUse" x="1.2" y="3" width="87" height="69">
            <feColorMatrix  type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1 0"/>
          </filter>
        </defs>
        <mask maskUnits="userSpaceOnUse" x="1.2" y="3" width="87" height="69" id="path-9-inside-1_0_1_2_">
          <path class="st5" d="M15.5,69c-2.8,0-5.4-1.3-6.7-3.8c-2.9-5.6-4.6-12-4.6-18.7C4.2,24.1,22.4,6,44.7,6c22.4,0,40.5,18.1,40.5,40.5
            c0,6.7-1.7,13.1-4.6,18.7C79.4,67.7,76.8,69,74,69c-3.8,0-6-5.5-4.2-8.9c2.2-4,3.4-8.7,3.4-13.6C73.2,30.8,60.5,18,44.7,18
            C29,18,16.2,30.8,16.2,46.5c0,4.9,1.2,9.5,3.4,13.6C21.5,63.5,19.3,69,15.5,69z"/>
        </mask>
        <path class="st6" d="M5.7,42h9.5v-3H5.7V42z M19.2,16.1l7.5,7l2-2.2l-7.5-7L19.2,16.1z M62.3,23.1l7-6.5l-2-2.2l-7,6.5L62.3,23.1z
          M73.7,42h10v-3h-10V42z M69.8,60.1l2.6,1.4L69.8,60.1z M19.7,60.1L17,61.5L19.7,60.1z M80.7,65.2L78,63.8L80.7,65.2z M8.8,65.2
          l2.7-1.4L8.8,65.2z M1.2,46.5c0,7.2,1.8,14.1,4.9,20.1l5.3-2.8c-2.7-5.2-4.2-11.1-4.2-17.3H1.2z M44.7,3C20.7,3,1.2,22.5,1.2,46.5h6
          C7.2,25.8,24,9,44.7,9V3z M88.2,46.5C88.2,22.5,68.8,3,44.7,3v6c20.7,0,37.5,16.8,37.5,37.5H88.2z M83.3,66.6
          c3.1-6,4.9-12.9,4.9-20.1h-6c0,6.3-1.5,12.1-4.2,17.3L83.3,66.6z M72.4,61.5c2.4-4.5,3.8-9.6,3.8-15h-6c0,4.4-1.1,8.5-3.1,12.2
          L72.4,61.5z M76.2,46.5C76.2,29.1,62.1,15,44.7,15v6c14.1,0,25.5,11.4,25.5,25.5H76.2z M44.7,15c-17.4,0-31.5,14.1-31.5,31.5h6
          C19.2,32.4,30.7,21,44.7,21V15z M13.2,46.5c0,5.4,1.4,10.6,3.8,15l5.3-2.9c-2-3.6-3.1-7.7-3.1-12.2H13.2z M74,66
          c-0.3,0-1-0.2-1.5-1.4c-0.5-1.2-0.5-2.4-0.1-3.1l-5.3-2.9c-1.5,2.7-1.2,5.9-0.1,8.4c1.1,2.4,3.4,5,7,5V66z M17,61.5
          c0.4,0.7,0.4,1.9-0.1,3.1c-0.5,1.2-1.2,1.4-1.5,1.4v6c3.5,0,5.9-2.5,7-5c1.1-2.5,1.3-5.7-0.1-8.4L17,61.5z M78,63.8
          c-0.7,1.3-2.2,2.2-4,2.2v6c3.7,0,7.4-1.8,9.3-5.4L78,63.8z M6.1,66.6C8,70.2,11.8,72,15.5,72v-6c-1.8,0-3.3-0.9-4-2.2L6.1,66.6z"/>
        <circle class="st7" cx="44.2" cy="46" r="7.5"/>
        <defs>
          <filter id="Adobe_OpacityMaskFilter_1_" filterUnits="userSpaceOnUse" x="8.8" y="38.8" width="42.5" height="22.1">
            <feColorMatrix  type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1 0"/>
          </filter>
        </defs>
        <mask maskUnits="userSpaceOnUse" x="8.8" y="38.8" width="42.5" height="22.1" id="path-12-inside-2_0_1_2_">
          <path class="st8" d="M13,57.8c-1.2,0.2-1.7-1.4-0.6-1.9l29-13.7c2.6-1.3,5.8,0.1,6.7,2.9c0.9,2.8-0.8,5.7-3.6,6.3L13,57.8z"/>
        </mask>
        <path class="st9 speed_arrow" d="M13,57.8c-1.2,0.2-1.7-1.4-0.6-1.9l29-13.7c2.6-1.3,5.8,0.1,6.7,2.9c0.9,2.8-0.8,5.7-3.6,6.3L13,57.8z"/>
        <circle class="st10" cx="20.7" cy="49.5" r="1.5"/>
        <circle class="st10" cx="23.7" cy="32.5" r="1.5"/>
        <circle class="st10" cx="44.7" cy="20.5" r="1.5"/>
        <circle class="st10" cx="64.7" cy="32.5" r="1.5"/>
        <circle class="st10" cx="68.7" cy="49.5" r="1.5"/>
        <defs>
          <filter id="Adobe_OpacityMaskFilter_2_" filterUnits="userSpaceOnUse" x="33.2" y="65" width="23" height="10">
            <feColorMatrix  type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1 0"/>
          </filter>
        </defs>
        <mask maskUnits="userSpaceOnUse" x="33.2" y="65" width="23" height="10" id="path-18-inside-3_0_1_2_">
          <path class="st11" d="M36.2,67h17c0.6,0,1,0.4,1,1v4c0,0.6-0.4,1-1,1h-17c-0.6,0-1-0.4-1-1v-4C35.2,67.4,35.7,67,36.2,67z"/>
        </mask>
        <path class="st12" d="M36.2,67h17c0.6,0,1,0.4,1,1v4c0,0.6-0.4,1-1,1h-17c-0.6,0-1-0.4-1-1v-4C35.2,67.4,35.7,67,36.2,67z"/>
        </svg>
      </div>
      <ul class="rates_list_item_speed">
        <li><span>Скорость</span> <strong><?=$custom['rates_speed'][0]?> Мбит/сек</strong></li>
        <li class="boost"><span>Ускорение<sup>1</sup></span> <strong><?=$custom['rates_boost'][0]?> Мбит/сек</strong></li>
      </ul>
      <div class="rates_list_item_price">
        <span class="rates_list_item_price_rub">₽</span>
        <div class="rates_list_item_price_text"><?=$custom['rates_price'][0]?></div>
        <div class="rates_list_item_price_month">месяц</div>
      </div>
      <button class="rates_list_item_btn" data-rate="<?the_ID()?>" data-action="<?php echo site_url ()?>/wp-admin/admin-ajax.php?action=form">Подключить</button>
      <div class="rates_list_item_price_down">
        <div class="rates_list_item_price_down_item">
          <img src="<?=TURI?>/images/dist/home.svg" alt="">
          <div class="rates_list_item_price">
            <span class="rates_list_item_price_rub">₽</span>
            <div class="rates_list_item_price_text"><?=$custom['rates_price_house'][0]?></div>
          </div>
        </div>
        <div class="rates_list_item_price_down_item">
          <img src="<?=TURI?>/images/dist/homes.svg" alt="">
          <div class="rates_list_item_price">
            <span class="rates_list_item_price_rub">₽</span>
            <div class="rates_list_item_price_text"><?=$custom['rates_price_apartment'][0]?></div>
          </div>
        </div>
      </div>
    </li>
		<?
		$speed += 50;
		}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
  </ul>
  <span class="down_text"><sup>1</sup> - Ускорение работает с 01:00 до 08:00</span>
</section>
<section class="advantages">
  <h2 class="section_title title">Наши преимущества</h2>
  <ul class="advantages_list">
    <li class="advantages_list_item">
      <img src="<?=TURI?>/images/dist/shit.png" alt="" class="advantages_list_item_icon">
      <h3 class="advantages_list_item_title">Надежность</h3>
      <p class="advantages_list_item_desc">Разнообразный и богатый опыт сложившаяся структура организации обеспечивает широкому кругу (специалистов) участие в формировании дальнейших направлений развития. </p>
    </li>
    <li class="advantages_list_item">
      <img src="<?=TURI?>/images/dist/speed.png" alt="" class="advantages_list_item_icon">
      <h3 class="advantages_list_item_title">Скорость</h3>
      <p class="advantages_list_item_desc">Разнообразный и богатый опыт сложившаяся структура организации обеспечивает широкому кругу (специалистов) участие в формировании дальнейших направлений развития. </p>
    </li>
    <li class="advantages_list_item">
      <img src="<?=TURI?>/images/dist/price.png" alt="" class="advantages_list_item_icon">
      <h3 class="advantages_list_item_title">Конкурентные цены</h3>
      <p class="advantages_list_item_desc">Разнообразный и богатый опыт сложившаяся структура организации обеспечивает широкому кругу (специалистов) участие в формировании дальнейших направлений развития. </p>
    </li>
  </ul>
</section>