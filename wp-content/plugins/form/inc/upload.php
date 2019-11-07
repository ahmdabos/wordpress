<?php
function custom_upload_dir($arr)
{
    $arr['path'] = $arr['basedir'] . '/files';
    $arr['url'] = $arr['baseurl'] . '/files';
    $arr['subdir'] = '/files';
    return $arr;
}

add_filter('upload_dir', 'custom_upload_dir');
if ($_FILES['fileToUpload']['name']) {
    if ($_FILES['fileToUpload']['size'] <= 50000000) {
        $filename = sanitize_text_field($_FILES["fileToUpload"]["name"]);
        $my_custom_filename = time() . $filename;
        wp_upload_bits($my_custom_filename, null, '$content');
    }
}
remove_filter('upload_dir', 'custom_upload_dir');