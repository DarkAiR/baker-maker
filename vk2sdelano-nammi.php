<?php

function checkDuplicates($dirs)
{
    $images = [];
    foreach ($dirs as $d) {
        foreach (glob($d."/*.jpg") as $filename) {
            preg_match('/.*\/(.*?\.jpg)$/imxus', $filename, $m);
            $filename = $m[1];
            if (isset($images[$filename])) {
                echo 'FOUND : '.$filename.PHP_EOL;
            }
            $images[$filename] = 1;
        }
    }
}




$dirs = [];
foreach (glob("vkposts/*",GLOB_ONLYDIR) as $filename) {
    $dirs[] = $filename;
}

// Копируем картинки в общую директорию
$imgPathGallery = './vkimages/gallery';
$imgPathNews = './vkimages/news';
$imgPathNewsOrig = './vkimages/news_original';
if (!is_dir($imgPathGallery))       mkdir($imgPathGallery, 0755, true);
if (!is_dir($imgPathNews))          mkdir($imgPathNews, 0755, true);
if (!is_dir($imgPathNewsOrig))      mkdir($imgPathNewsOrig, 0755, true);

$file = fopen('./vkposts/posts.sql', 'w');
foreach ($dirs as $d) {
    $textImgArr = [];
    $firstImg = [];
    foreach (glob($d."/*.jpg") as $filePath) {
        preg_match('/.*\/(.*?\.jpg)$/imxus', $filePath, $m);
        $filename = $m[1];

        $imgSrc = @imagecreatefromjpeg($filePath);
        if (!$imgSrc) {
            echo 'Empty image <'.$filePath.'>'.PHP_EOL;
            continue;
        }
        imagedestroy($imgSrc);

        $textImgArr[] = $filename;
        if (empty($firstImg))
            $firstImg = [$filePath, $filename];

        $res = copy($filePath, $imgPathGallery.'/'.$filename);
        if (!$res) {
            echo 'Cannot copy from <'.$filePath.'> to <'.$imgPathGallery.'/'.$filename.'>'.PHP_EOL;
            die;
        }
    }

    // Создаем маленькую картинку
    $smallImage = 'noimage.jpg';
    if (!empty($firstImg)) {
        // Fetch the image size and mime type
        list($imgW, $imgH, $imgType) = getimagesize($firstImg[0]);
        $imgDstW = 242;
        $imgDstH = floor($imgH * 242 / $imgW);
        
        $imgSrc = imagecreatefromjpeg($firstImg[0]);
        $imgDst = imagecreatetruecolor($imgDstW, $imgDstH);

        imagecopyresampled($imgDst, $imgSrc, 0, 0, 0, 0, $imgDstW, $imgDstH, $imgW, $imgH);

        imagejpeg($imgDst, $imgPathNews.'/'.$firstImg[1]);
        copy($firstImg[0], $imgPathNewsOrig.'/'.$firstImg[1]);

        imagedestroy($imgSrc);        
        imagedestroy($imgDst);

        $smallImage = $firstImg[1];
    }

    $post = file_get_contents($d.'/post.txt');
    $post = explode(PHP_EOL, $post);
    
    $date = $post[0];
    $text = $post[2];

    // Заменяем восклицательные знаки и прочее
    $text = str_replace('&#33;', '!', $text);

    // Подменяем ссылки
    $text = preg_replace_callback('/<a[^>]+href="(.*?)".*?>(.*?)<\/a>/imxus', function($m) {
        if (substr($m[1], 0, 1) != '/')
            return '<a href="'.$m[1].'" target="_blank">'.$m[2].'</a>';
        return '<a href="http://vk.com'.$m[1].'" target="_blank">'.$m[2].'</a>';
    }, $text);

    // Подменяем картинки
    $text = preg_replace_callback('/(<img[^>]+src=")(.*?)(".*?>)/imxus', function($m) {
        if (substr($m[2], 0, 1) != '/')
            return $m[0];
        return $m[1].'http://vk.com'.$m[2].$m[3];
    }, $text);

    // Собираем текст картинок
    $textImg = '';
    foreach ($textImgArr as $img) {
        preg_match('/.*_(\d+)_(\d+)\.jpg$/imxus', $img, $m);
        $textImg .= '<p><img alt="" src="/store/u/images/'.$img.'" style="height:'.$m[2].'px; width:'.$m[1].'px" /></p>';
    }

    $createTime = strtotime($date);
    
    $title = strip_tags(str_replace('<br>', ' ', $text));
    $title = (strlen($title) < 32) ? $title : substr($title, 0, 31).'...';
    $title = str_replace('&quot;', '"', $title);
    $title = addslashes($title);

    $shortDesc = strip_tags(str_replace('<br>', PHP_EOL, $text));
    $shortDesc = (strlen($shortDesc) < 255) ? $shortDesc : substr($shortDesc, 0, 254).'...';
    $shortDesc = str_replace('&quot;', '"', $shortDesc);
    $shortDesc = addslashes($shortDesc);

    $desc = '<p>'.$text.'</p>'.$textImg;
    $desc = addslashes($desc);

    $sql = "insert into `News` (`createTime`, `title`, `shortDesc`, `desc`, `image`, `docs`, `onMain`, `visible`) VALUES ($createTime, \"$title\", \"$shortDesc\", \"$desc\", \"$smallImage\", '[]', 0, 0);".PHP_EOL;
    //$sql = iconv('utf-8', 'windows-1251', $sql);
    fwrite($file, $sql);
}
fclose($file);
