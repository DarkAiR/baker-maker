<?php

$config = [
    'url' => 'https://vk.com/wall-46547927',
    'startOffset' => 0,
    'postsCount' => 500,
    'minDelay' => 1,
    'maxDelay' => 2,
];

function dateConvert($date)
{
    $y = date('Y');
    $r = preg_match('/(\d+)\s(\w+)\s(\d*)/imxus', $date, $m);
    if (!$r)
        return false;
    $day = $m[1];
    $month = $m[2];
    $year = !empty($m[3]) ? $m[3] : $y;

    if ($day < 10)
        $day = '0'.$day;

    $monthes = ['янв'=>'01', 'фев'=>'02', 'мар'=>'03', 'апр'=>'04', 'мая'=>'05', 'июн'=>'06', 'июл'=>'07', 'авг'=>'08', 'сен'=>'09', 'окт'=>'10', 'ноя'=>'11', 'дек'=>'12'];

    return $year.'-'.$monthes[$month].'-'.$day;
}

function getFile($url)
{
    global $config;
    $c = @file_get_contents($url);
    sleep(rand($config['minDelay'], $config['maxDelay']));
    return $c;
}

$offset = $config['startOffset'];
do {
    $url = $config['url'].'?offset='.$offset;
    echo 'Read page <'.$url.'>... ';

    $ch = curl_init(); 
    curl_setopt($ch , CURLOPT_URL, $url);
    curl_setopt($ch , CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36");
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1); 
    $content = curl_exec($ch);
    if (!$content) {
        echo 'Script can not load page <'.$url.'>'.PHP_EOL;
        break;
    }
    $content = iconv('windows-1251', 'utf-8', $content);
//    var_dump(htmlspecialchars($content));
//    die;
    echo 'ok'.PHP_EOL;

    $res = preg_match_all('/(<div\ id="post-(\d*_\d*)"\ class="post.*?<\/div>)(?=<div[^>]id="post-\d*_\d*"\ class="post)/imxus', $content, $matches);
    if ($res <= 0) {
        echo 'Nothing to found <'.$url.'>'.PHP_EOL;
        break;
    }

    for ($idx = 0; $idx < count($matches[0]); $idx++) {
        $m = $matches[1][$idx];
        echo '    Process '.($offset+$idx+1).'...'.PHP_EOL;

        // PostId
        $postId = $matches[2][$idx];

        // Date
        $r = preg_match('/<span\ class="rel_date">(.*?)<\/span>/imxus', $m, $arr);
        $date = $r ? $arr[1] : false;
        if ($date)
            $date = dateConvert($date);

        // Content
        $r = preg_match('/<div\ class="wall_post_text".*?>(.*?)<\/div>/imxus', $m, $arr);
        $content = $r ? $arr[1] : '';

        if (empty($content)) {
            echo '        empty'.PHP_EOL;
            continue;
        }

        // Images
        $images = [];
        $r = preg_match('/<div\ class="page_post_sized_thumbs.*?>(.*?)<\/div>\s*<\/div>/imxus', $m, $arr);
        if ($r) {
            $imagesHtml = $arr[1];
            $r = preg_match_all('/<a\ [^>]+&quot;base&quot;:&quot;(.+?)&quot;.*?&quot;y_&quot;:\[&quot;(.+?)&quot;.*?(\d+).*?(\d+).*?<img[^>]+src=".*?\.(\w+?)"/imxus', $imagesHtml, $arr);
            for ($i = 0; $i < count($arr[0]); $i++) {
                $images[] = [
                    'url' => $arr[1][$i].$arr[2][$i].'.'.$arr[5][$i],
                    'w' => $arr[3][$i],
                    'h' => $arr[4][$i],
                ];
            }
        }

        $path = './vkposts/'.$date.'_'.$postId;
        if (!is_dir($path)) {
            $r = mkdir($path, 0755, true);
            if (!$r) {
                echo 'Can not create directory <'.$path.'>'.PHP_EOL;
                break;
            }
        }
        $data = $date.PHP_EOL.PHP_EOL.$content;
        file_put_contents($path.'/post.html', $data);
        file_put_contents($path.'/post.txt', $data);
        echo '    Copy images:'.PHP_EOL;
        foreach ($images as $img) {
            $filename = pathinfo($img['url'], PATHINFO_FILENAME);
            $ext = pathinfo($img['url'], PATHINFO_EXTENSION);
            $imgName = $filename.'_'.$img['w'].'_'.$img['h'].'.'.$ext;
            echo '        '.$imgName.'... ';
            $c = getFile($img['url']);
            file_put_contents($path.'/'.$imgName, $c);
            echo 'ok'.PHP_EOL;
        }
    }
    $offset += count($matches[1]);
} while($offset < $config['postsCount']);

echo 'End offset = '.$offset.PHP_EOL;
