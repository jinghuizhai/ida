<?php
function imagecropper($source_path,$target_width,$target_height=null)
{
    $source_info   = getimagesize($source_path);
    $source_width  = $source_info[0];
    $source_height = $source_info[1];
    $source_mime   = $source_info['mime'];
    $source_ratio  = $source_height / $source_width;

    if(empty($target_height)){
        $target_height = $source_height/($source_width/$target_width);
    }
    $target_ratio  = $target_height / $target_width;

    // 源图过高
    if ($source_ratio > $target_ratio)
    {
        $cropped_width  = $source_width;
        $cropped_height = $source_width * $target_ratio;
        $source_x = 0;
        $source_y = ($source_height - $cropped_height) / 2;
    }
    // 源图过宽
    elseif ($source_ratio < $target_ratio)
    {
        $cropped_width  = $source_height / $target_ratio;
        $cropped_height = $source_height;
        $source_x = ($source_width - $cropped_width) / 2;
        $source_y = 0;
    }
    // 源图适中
    else
    {
        $cropped_width  = $source_width;
        $cropped_height = $source_height;
        $source_x = 0;
        $source_y = 0;
    }

    switch ($source_mime)
    {
        case 'image/gif':
            $source_image = imagecreatefromgif($source_path);
            break;

        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($source_path);
            break;

        case 'image/png':
            $source_image = imagecreatefrompng($source_path);
            break;

        default:
            return false;
            break;
    }

    $target_image  = imagecreatetruecolor($target_width, $target_height);
    $cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

    // 裁剪
    imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height); 
    // 缩放
    imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);

    // header('Content-Type: image/jpeg');
    $filename = basename($source_path);
    $dotpos = strrpos($filename,'.');
    $target_name = substr($filename,0,$dotpos).$target_width."x".$target_width.substr($filename, $dotpos);
    return imagejpeg($target_image,$target_name,100);
    // imagedestroy($source_image);
    // imagedestroy($target_image);
    // imagedestroy($cropped_image);
}
// echo imagecropper('12.jpg',60);
?>