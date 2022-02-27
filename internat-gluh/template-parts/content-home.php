<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
<section class="hero">
  <div class="slider owl-carousel owl-theme">
    <div class="slider_item">
      <div class="slider_item_media" style="background-image: url(<?= TURI ?>/images/dist/pexels-1.jpg);"></div>
      <h2 class="slider_item_title">Далеко-далеко за словесными горами, в стране гласных и согласных живут рыбные тексты. Все послушавшись своего они языкового, до по всей меня имени щеке рот жизни живет несколько предложения взобравшись, решила курсивных коварных знаках!</h2>
    </div>
    <div class="slider_item">
      <div class="slider_item_media" style="background-image: url(<?= TURI ?>/images/dist/pexels-2.jpg);"></div>
      <h2 class="slider_item_title">Далеко-далеко за словесными горами, в стране гласных и согласных живут рыбные тексты. Все послушавшись своего они языкового, до по всей меня имени щеке рот жизни живет несколько предложения взобравшись, решила курсивных коварных знаках!</h2>
    </div>
    <div class="slider_item">
      <div class="slider_item_media" style="background-image: url(<?= TURI ?>/images/dist/pexels-3.jpg);"></div>
      <h2 class="slider_item_title">Далеко-далеко за словесными горами, в стране гласных и согласных живут рыбные тексты. Все послушавшись своего они языкового, до по всей меня имени щеке рот жизни живет несколько предложения взобравшись, решила курсивных коварных знаках!</h2>
    </div>
  </div>
</section>
<script src="https://pos.gosuslugi.ru/bin/script.min.js"></script>
<div id='js-show-iframe-wrapper'>
  <div class='pos-banner-fluid bf-18'>
    <div class='bf-18__decor'>
      <div class='bf-18__logo-wrap'>
        <img class='bf-18__logo' src='https://pos.gosuslugi.ru/bin/banner-fluid/gosuslugi-logo-blue.svg' alt='Госуслуги' />
        <div class='bf-18__slogan'>Решаем вместе</div>
      </div>
    </div>
    <div class='bf-18__content'>
      <div class='bf-18__text'>
        Есть предложения по организации учебного процесса или знаете, как сделать школу лучше?
      </div>
      <div class='bf-18__bottom-wrap'>
        <div class='bf-18__btn-wrap'>
          <!-- pos-banner-btn_2 не удалять; другие классы не добавлять -->
          <button class='pos-banner-btn_2' type='button'>Написать о проблеме
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  (function() {
    "use strict";

    function ownKeys(e, t) {
      var n = Object.keys(e);
      if (Object.getOwnPropertySymbols) {
        var o = Object.getOwnPropertySymbols(e);
        if (t) o = o.filter(function(t) {
          return Object.getOwnPropertyDescriptor(e, t).enumerable
        });
        n.push.apply(n, o)
      }
      return n
    }

    function _objectSpread(e) {
      for (var t = 1; t < arguments.length; t++) {
        var n = null != arguments[t] ? arguments[t] : {};
        if (t % 2) ownKeys(Object(n), true).forEach(function(t) {
          _defineProperty(e, t, n[t])
        });
        else if (Object.getOwnPropertyDescriptors) Object.defineProperties(e, Object.getOwnPropertyDescriptors(n));
        else ownKeys(Object(n)).forEach(function(t) {
          Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t))
        })
      }
      return e
    }

    function _defineProperty(e, t, n) {
      if (t in e) Object.defineProperty(e, t, {
        value: n,
        enumerable: true,
        configurable: true,
        writable: true
      });
      else e[t] = n;
      return e
    }
    var POS_PREFIX_18 = "--pos-banner-fluid-18__",
      posOptionsInitialBanner18 = {
        background: "#50b3ff",
        "grid-template-columns": "100%",
        "grid-template-rows": "262px auto",
        "max-width": "100%",
        "text-font-size": "20px",
        "text-margin": "0 0 24px 0",
        "button-wrap-max-width": "100%",
        "bg-url": "url('https://pos.gosuslugi.ru/bin/banner-fluid/18/banner-fluid-bg-18-2.svg')",
        "bg-url-position": "right bottom",
        "content-padding": "26px 24px 24px",
        "content-grid-row": "0",
        "logo-wrap-padding": "16px 12px 12px",
        "logo-width": "65px",
        "logo-wrap-top": "0",
        "logo-wrap-left": "0",
        "slogan-font-size": "12px"
      },
      setStyles = function(e, t) {
        var n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : POS_PREFIX_18;
        Object.keys(e).forEach(function(o) {
          t.style.setProperty(n + o, e[o])
        })
      },
      removeStyles = function(e, t) {
        var n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : POS_PREFIX_18;
        Object.keys(e).forEach(function(e) {
          t.style.removeProperty(n + e)
        })
      };

    function changePosBannerOnResize() {
      var e = document.documentElement,
        t = _objectSpread({}, posOptionsInitialBanner18),
        n = document.getElementById("js-show-iframe-wrapper"),
        o = n ? n.offsetWidth : document.body.offsetWidth;
      if (o > 340) t["button-wrap-max-width"] = "209px";
      if (o > 482) t["content-padding"] = "24px", t["text-font-size"] = "24px";
      if (o > 568) t["grid-template-columns"] = "1fr 292px", t["grid-template-rows"] = "100%", t["content-grid-row"] = "1", t["content-padding"] = "32px 24px", t["bg-url-position"] = "calc(100% + 35px) bottom";
      if (o > 610) t["bg-url-position"] = "calc(100% + 12px) bottom";
      if (o > 726) t["bg-url-position"] = "right bottom";
      if (o > 783) t["grid-template-columns"] = "1fr 390px";
      if (o > 820) t["grid-template-columns"] = "1fr 420px", t["bg-url-position"] = "right bottom";
      if (o > 1098) t["bg-url"] = "url('https://pos.gosuslugi.ru/bin/banner-fluid/18/banner-fluid-bg-18-3.svg')", t["bg-url-position"] = "calc(100% + 55px) bottom", t["grid-template-columns"] = "1fr 557px", t["text-font-size"] = "32px", t["content-padding"] = "32px 32px 32px 50px", t["logo-width"] = "78px", t["slogan-font-size"] = "15px", t["logo-wrap-padding"] = "20px 16px 16px";
      if (o > 1422) t["max-width"] = "1422px", t["grid-template-columns"] = "1fr 720px", t["content-padding"] = "32px 48px 32px 160px", t.background = "linear-gradient(90deg, #50b3ff 50%, #f8efec 50%)";
      setStyles(t, e)
    }
    changePosBannerOnResize(), window.addEventListener("resize", changePosBannerOnResize), window.onunload = function() {
      var e = document.documentElement,
        t = _objectSpread({}, posOptionsInitialBanner18);
      window.removeEventListener("resize", changePosBannerOnResize), removeStyles(t, e)
    };
  })()
</script>
<script>
  Widget("https://pos.gosuslugi.ru/form", <?= $widgetId ?>)
</script>
<section class="section important_actions">
  <?
  $ul = '<ul id="%1$s" class="%2$s">%3$s
          <li class="menu-item">
            <a href="#">Контакты</a>
            <ul class="sub-menu">
              <li><a href="/">'.get_theme_mod('address').'</a></li>
              <li><a data-phone="'.get_theme_mod('phones').'" href="tel:'.get_theme_mod('phones').'"> '.get_theme_mod('phones').'</a></li>
              <li><a href="mailto:'.get_theme_mod('email').'">'.get_theme_mod('email').'</a></li>
              <li><a href="#">'.get_theme_mod('operating_mode').'</a></li>

              
            </ul>
          </li>
        </ul>';
    wp_nav_menu(
      array(
        'theme_location' 	=> 'menu-home-items',
        'menu_id'        	=> '',
        'menu_class' 			=> 'important_actions_list',
        'container' 			=> false,
        'link_before' => '<h4 class="important_actions_list_item_title">',
        'link_after' => '</h4>'
        // 'items_wrap' => $ul
      )
    );
    ?>
</section>
<div class="row">
  <? get_sidebar(); ?>
  <main id="main">
    <section class="section news">
      <h3 class="section_title">Новости</h3>
      <div class="news_home">
        <div class="news_home_item">
          <div class="news_home_item_madia" style="background-image: url(<?= TURI ?>/images/dist/pexels-1.jpg);"></div>
          <div class="news_home_item_content">
            <a class="news_home_item_title" href="">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты.</a>
            <div class="news_home_item_desc">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты. Большого вопроса которой несколько алфавит назад заглавных толку возвращайся, то, букв заголовок не там она всеми языкового, семантика он пунктуация.</div>
            <span class="news_home_item_date">12.02.2022 в 13:45</span>
          </div>
        </div>
        <div class="news_home_item">
          <div class="news_home_item_madia" style="background-image: url(<?= TURI ?>/images/dist/pexels-3.jpg);"></div>
          <div class="news_home_item_content">
            <a class="news_home_item_title" href="">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты.</a>
            <div class="news_home_item_desc">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты. Большого вопроса которой несколько алфавит назад заглавных толку возвращайся, то, букв заголовок не там она всеми языкового, семантика он пунктуация.</div>
            <span class="news_home_item_date">12.02.2022 в 13:45</span>
          </div>
        </div>
        <div class="news_home_item">
          <div class="news_home_item_madia" style="background-image: url(<?= TURI ?>/images/dist/pexels-2.jpg);"></div>
          <div class="news_home_item_content">
            <a class="news_home_item_title" href="">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты.</a>
            <div class="news_home_item_desc">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты. Большого вопроса которой несколько алфавит назад заглавных толку возвращайся, то, букв заголовок не там она всеми языкового, семантика он пунктуация.</div>
            <span class="news_home_item_date">12.02.2022 в 13:45</span>
          </div>
        </div>
        <div class="news_home_item">
          <div class="news_home_item_madia" style="background-image: url(<?= TURI ?>/images/dist/pexels-1.jpg);"></div>
          <div class="news_home_item_content">
            <a class="news_home_item_title" href="">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты.</a>
            <div class="news_home_item_desc">Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты. Большого вопроса которой несколько алфавит назад заглавных толку возвращайся, то, букв заголовок не там она всеми языкового, семантика он пунктуация.</div>
            <span class="news_home_item_date">12.02.2022 в 13:45</span>
          </div>
        </div>
      </div>
    </section>
    <section class="section about_us">
      <h3 class="section_title">О нас</h3>
      <p class="section_desc">ГБОУ "Комплексный реабилитационно-образовательный центр для детей с нарушениями слуха и зрения" г. Владикавказ РСО-Алания</p>
      <div class="about_us_post">
        <div class="about_us_post_media" style="background-image: url(<?= TURI ?>/images/dist/pexels-1.jpg);"></div>
        <p> Мы с тобою живем в необычном мире,
          Мы судьбою помечены знаком одним
          Этот знак для иных, словно тяжкая гиря,
          А другие стоят, не согнувшись под ним. </p>

        <p> И живут, как и все, полнокровно и смело,
          Не сдаваясь ни в чем, промолчав о беде.
          В их умелых руках также спорится дело,
          И черпаются силы в любви и труде. </p>

        <p>Ты равняйся по ним! Ничего не пропало.
          Сколько дел на земле! Присмотрись не спеша.
          Что бывало лишь сказка – реальностью стала.
          И в реальности жизнь все равно хороша! </p>
      </div>


      <div class="about_us_post">
        <div class="about_us_post_media" style="background-image: url(<?= TURI ?>/images/dist/pexels-3.jpg);"></div>
        <p>На планете все мы люди.
          Так давайте с вами будем
          Относиться чуть добрее
          К тем, кто в чем-то нас слабее.</p>

        <p>Главное – внутри, учтите,
          И на внешность не смотрите.
          Всем нам хочется влюбиться,
          И работать, и учиться.</p>

        <p>Пусть же тот, кто не такой,
          Счастья сыщет, как любой.</p>
      </div>

    </section>
    <section class="section useful_link">
      <h3 class="section_title">Полезные ресурсы</h3>
      <ul class="useful_link_list">
        <li class="useful_link_list_item" title="Официальный сайт Министерства образования и науки РФ" aria-label="Официальный сайт Министерства образования и науки РФ">
          <a href="#" target="_blank" rel="noopener noreferrer">
            <div class="useful_link_list_item_title"></div>
            <img src="http://internat-gluh.ucoz.ru/12345/sajt_minobr.jpg" alt="" class="useful_link_list_item_media">
          </a>
        </li>
        <li class="useful_link_list_item" title="Официальный сайт Министерства образования и науки РФ" aria-label="Официальный сайт Министерства образования и науки РФ">
          <a href="#" target="_blank" rel="noopener noreferrer">
            <div class="useful_link_list_item_title"></div>
            <img src="http://internat-gluh.ucoz.ru/12345/sajt_minobr_rso-a.jpg" alt="" class="useful_link_list_item_media">
          </a>
        </li>
        <li class="useful_link_list_item" title="Официальный сайт Министерства образования и науки РФ" aria-label="Официальный сайт Министерства образования и науки РФ">
          <a href="#" target="_blank" rel="noopener noreferrer">
            <div class="useful_link_list_item_title"></div>
            <img src="http://internat-gluh.ucoz.ru/12345/sajt_minobr.jpg" alt="" class="useful_link_list_item_media">
          </a>
        </li>
        <li class="useful_link_list_item" title="Официальный сайт Министерства образования и науки РФ" aria-label="Официальный сайт Министерства образования и науки РФ">
          <a href="#" target="_blank" rel="noopener noreferrer">
            <div class="useful_link_list_item_title"></div>
            <img src="http://internat-gluh.ucoz.ru/12345/sajt_minobr.jpg" alt="" class="useful_link_list_item_media">
          </a>
        </li>
        <li class="useful_link_list_item" title="Официальный сайт Министерства образования и науки РФ" aria-label="Официальный сайт Министерства образования и науки РФ">
          <a href="#" target="_blank" rel="noopener noreferrer">
            <div class="useful_link_list_item_title"></div>
            <img src="http://internat-gluh.ucoz.ru/12345/sajt_minobr.jpg" alt="" class="useful_link_list_item_media">
          </a>
        </li>
      </ul>
    </section>
  </main>
</div>