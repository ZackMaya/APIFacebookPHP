<?php
 
function fb_fan_count( $fb_page ){
    $data = json_decode(file_get_contents('http://graph.facebook.com/' . $fb_page));
    echo $data->likes;
}
 
fb_fan_count('enespanol');
 
?>