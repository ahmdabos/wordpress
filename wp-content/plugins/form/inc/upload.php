<?php
require(dirname(__FILE__) . '/../../../../wp-load.php');
$allowed_mime_type = array(
    'image/png',
    'image/jpg',
    'image/jpeg',
    'image/gif',
    /*'text/plain',
    'application/vnd.ms-powerpoint',
    'application/pdf',
    'text/plain',*/
);
$allowed_size = 2097152;

/*function custom_upload_dir($arr)
{
    $arr['path'] = $arr['basedir'] . '/files';
    $arr['url'] = $arr['baseurl'] . '/files';
    $arr['subdir'] = '/files';
    return $arr;
}
add_filter('upload_dir', 'custom_upload_dir');*/

$wordpress_upload_dir = wp_upload_dir();
$i = 1;

$attachment = $_FILES['attachment'];
$new_file_path = $wordpress_upload_dir['path'] . '/' . $attachment['name'];

$new_file_mime = mime_content_type($attachment['tmp_name']);

if (empty($attachment))
    die('File is not selected.');

if ($attachment['error'])
    die($attachment['error']);

if ($attachment['size'] > wp_max_upload_size() || $attachment['size'] > $allowed_size)
    die('It is too large than expected.');

if (!in_array($new_file_mime, get_allowed_mime_types()) || !in_array($new_file_mime, $allowed_mime_type))
    die('WordPress doesn\'t allow this type of uploads.');

while (file_exists($new_file_path)) {
    $i++;
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $attachment['name'];
}

if (move_uploaded_file($attachment['tmp_name'], $new_file_path)) {


    $upload_id = wp_insert_attachment(array(
        'guid' => $new_file_path,
        'post_mime_type' => $new_file_mime,
        'post_title' => preg_replace('/\.[^.]+$/', '', $attachment['name']),
        'post_content' => '',
        'post_status' => 'inherit'
    ), $new_file_path);

    // wp_generate_attachment_metadata() won't work if you do not include this file
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Generate and save the attachment metas into the database
    wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));
    // Show the uploaded file in browser
    //echo $wordpress_upload_dir['url'] . '/' . basename($new_file_path);die;

}
/*remove_filter('upload_dir', 'custom_upload_dir');*/
