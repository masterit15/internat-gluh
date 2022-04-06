<form class="search_form" id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <span class="close"><i class="fa fa-times"></i></span>
    <div class="search_field_group">
      <i class="fa fa-search"></i>
      <input type="text" class="search_field" name="s" placeholder="Поиск" value="<?php echo get_search_query(); ?>">
      <button class="search_btn" type="submit">Поиск</button>
    </div>
</form>
<div class="search_result"></div>