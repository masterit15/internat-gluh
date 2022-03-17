// это были новости на главной странице
<section class="section news">
      <h3 class="section_title">Новости</h3>
      <div class="news_home">
        <?
        $reviews = new WP_Query(
          array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 6,
          )
        );
        if ($reviews->have_posts()) {
          while ($reviews->have_posts()) {
            $reviews->the_post(); 
            
            ?>
            <div class="news_home_item">
              <? if (get_the_post_thumbnail_url($post->ID, 'large')) { ?>
                <div class="news_home_item_madia" style="background-image: url(<?= get_the_post_thumbnail_url($post->ID, 'large') ?>);"></div>
              <? } else { ?>
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                  <title />
                  <g data-name="Layer 2" id="Layer_2">
                    <path d="M29,8H26V5a1,1,0,0,0-1-1H3A1,1,0,0,0,2,5V23a1,1,0,0,0,1,1H6v3a1,1,0,0,0,1,1H29a1,1,0,0,0,1-1V9A1,1,0,0,0,29,8ZM4,22V6H24V8H7A1,1,0,0,0,6,9V22Zm8-10a2,2,0,1,1-2,2A2,2,0,0,1,12,12ZM25.89,23.46A1,1,0,0,1,25,24H11a1,1,0,0,1-.89-.55,1,1,0,0,1,.09-1.05l3-4a1,1,0,0,1,1.25-.29l1.35.67,3.49-3.49a1,1,0,0,1,.79-.29,1,1,0,0,1,.73.42l5,7A1,1,0,0,1,25.89,23.46Z" />
                  </g>
                </svg>
              <? } ?>

              <div class="news_home_item_content">
                <a class="news_home_item_title" href="<?= get_permalink() ?>"><? the_title() ?></a>
                <div class="news_home_item_desc"><? the_excerpt() ?></div>
                <span class="news_home_item_date"><?= date("d.m.Y в H:m", strtotime($reviews->post->post_date)) ?></span>
              </div>
            </div>
        <? }
        } else {
          echo 'Ничего не найдено';
        }
        wp_reset_postdata(); ?>
      </div>
    </section>