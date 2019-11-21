<?php
function custom_upload_dir($arr)
{
    $arr['path'] = $arr['basedir'] . '/files';
    $arr['url'] = $arr['baseurl'] . '/files';
    $arr['subdir'] = '/files';
    return $arr;
}

add_filter('upload_dir', 'custom_upload_dir');

if ($_FILES['attachment']['name']) {
    if ($_FILES['attachment']['size'] >= 1000) {
        $filename = sanitize_text_field($_FILES["attachment"]["name"]);
        $attachment = time() . $filename;
        wp_upload_bits($attachment, null, '$content');
    }
}
remove_filter('upload_dir', 'custom_upload_dir');