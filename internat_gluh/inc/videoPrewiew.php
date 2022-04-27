<?
add_action('wp_ajax_getVideoPreview', 'getVideoPreview'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_getVideoPreview', 'getVideoPreview');
header('Content-Type: application/json; charset=utf-8');
function getVideoPreview(){
  $videoID = $_POST['vid'];
  $res = array('success'=> false,'defaultPreview'=>get_template_directory_uri() . '/images/dist/rutubePreview.jpg');
  if(mb_strlen($videoID,'UTF-8') > 25){
    $json = file_get_contents('http://rutube.ru/api/video/'.$videoID.'?format=json');
    $videoInfo = json_decode($json, true);
    if($videoInfo){
      $res['success'] = true;
      $res['title'] = $videoInfo['title'];
      $res['preview'] = $videoInfo['thumbnail_url'];
    }
  }else{
    $json = file_get_contents('https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' .$videoID. '&format=json');
    $videoInfo = json_decode($json, true);
    if($videoInfo){
      $res['success'] = true;
      $res['title'] = $videoInfo['title'];
      $res['preview'] = $videoInfo['thumbnail_url'];
    }
  }
  echo json_encode($res);
  die();
}