<div class="embed-container">
  <?php $iframe = get_sub_field('tat_bifeo');
    preg_match('/src="(.+?)"/', $iframe, $matches);
    $src = $matches[1];
    $params = array(
    'controls'       => 1,
    'hd'             => 1,
    'autohide'       => 0,
    'autoplay'       => 0,
    'showinfo'       => 0,
    'rel'            => 0,
    'loop'           => 0,
    'modestbranding' => 1,
    'wmode'          => 'transparent',
    'playsinline'    => 1,
  );
  $new_src = add_query_arg($params, $src);
  $iframe = str_replace($src, $new_src, $iframe);
  $attributes = 'frameborder="0" autoplay="false" uk-video';
  $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
  echo $iframe; ?>
</div>

<style>
.embed-container {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
  max-width: 100%;
}
.embed-container iframe,
.embed-container object,
.embed-container embed {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
