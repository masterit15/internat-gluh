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
    <?
    $reviews = new WP_Query(
      array(
        'post_type' => 'slider',
        'post_status' => 'publish',
        'posts_per_page' => 5,
        'orderby'          => 'date',
        'order'            => 'ASC',
      )
    );
    if ($reviews->have_posts()) {
      while ($reviews->have_posts()) {
        global $post;
        $reviews->the_post();
    ?>
        <div class="slider_item">
          <div class="slider_item_media" style="background-image: url(<?= get_the_post_thumbnail_url($post->ID, 'large') ?>);"></div>
          <!-- <h2 class="slider_item_title"><?//= $post->post_title ?></h2> -->
        </div>
    <? }
    }
    wp_reset_postdata(); ?>
  </div>
</section>

<div class="row">
  <? get_sidebar(); ?>
  <main id="main">
  <section class="section important_actions">
  <?
  wp_nav_menu(
    array(
      'theme_location'   => 'menu-home-items',
      'menu_id'          => '',
      'menu_class'       => 'important_actions_list',
      'container'       => false,
      'link_before' => '<h4 class="important_actions_list_item_title">',
      'link_after' => '</h4>'
    )
  );
  ?>
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
    <section class="section about_us">
      <h3 class="section_title">О нас</h3>
      <p class="section_desc">ГБОУ "Комплексный реабилитационно-образовательный центр для детей с нарушениями слуха и зрения" г. Владикавказ РСО-Алания</p>
      <?the_content()?>
    </section>
    <section class="section useful_link">
      <h3 class="section_title">Полезные ресурсы</h3>
      <ul class="useful_link_list">
        <?
        $reviews = new WP_Query(
          array(
            'post_type' => 'useful_link',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby'          => 'date',
            'order'            => 'ASC',
          )
        );
        if ($reviews->have_posts()) {
          while ($reviews->have_posts()) {
            global $post;
            $reviews->the_post();
            $custom = get_post_custom($post->ID);
            $link    = $custom["useful_link"][0];
        ?>
            <li class="useful_link_list_item" title="<?= $post->post_title ?>" aria-label="<?= $post->post_title ?>">
              <a href="<?=$link?>" target="_blank" rel="noopener noreferrer">
                <div class="useful_link_list_item_content">
                  <?if(!get_the_post_thumbnail_url($post->ID, 'large')){?>
                    <div class="useful_link_list_item_svg">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      >
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                        <polyline points="15 3 21 3 21 9" />
                        <line x1="10" y1="14" x2="21" y2="3" />
                      </svg>
                    </div>
                  <?}else{?>
                    <img src="<?= get_the_post_thumbnail_url($post->ID, 'large') ?>" alt="" class="useful_link_list_item_media">
                  <?}?>
                  <div class="useful_link_list_item_title"><?= $post->post_title ?></div>
                </div>
                <span class="useful_link_list_item_lnk"><?=$link?></span>
              </a>
            </li>
        <? }
        }
        wp_reset_postdata(); ?>
      </ul>
    </section>
    <p style="text-align: center;">
<strong>Обновление официального сайта образовательной организации не менее 4-х раз в месяц.</strong></p>

<p style="text-align: center;"><strong>Последнее обновление: <b>
  <script language="javascript" type="text/javascript">
var d = new Date();

var day=new Array("Воскресенье","Понедельник","Вторник",
"Среда","Четверг","Пятница","Суббота");

var month=new Array("января","февраля","марта","апреля","мая","июня",
"июля","августа","сентября","октября","ноября","декабря");

document.write(day[d.getDay()]+" " +d.getDate()+ " " + month[d.getMonth()]
+ " " + d.getFullYear() + " г.");
</script></b> </strong></p>
  </main>
</div>