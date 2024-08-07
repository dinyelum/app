<?php
function show($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function purify($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function trimwords($haystack, $needle, $position='both') {
    //position first, last, both
    switch($position) {
        case 'first':
            $position = strpos($haystack, $needle);
            $length = strlen($needle);
            $new_string = substr_replace($haystack, '', $position, $length);
            break;
        case 'last':
            $position = strrpos($haystack, $needle);
            $new_string = substr_replace($haystack, '', $position);
            break;
        default:
            $first = strpos($haystack, $needle);
            $length = strlen($needle);
            $temp_string = substr_replace($haystack, '', $first, $length);
            $last = strrpos($temp_string, $needle);
            $new_string = substr_replace($temp_string, '', $last);
    }
    return $new_string;
}

if(!function_exists('array_is_list')) {
    function array_is_list(array $arr) {
        if($arr === []) {
            return true;
        }
        return array_keys($arr) === range(0, count($arr)-1);
    }
}

function in_array_multi($needle, $haystack, $strict = false) {
    //recursive function
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_multi($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

//foreach array_search, used somethig similar in betagamers insertfetchamt

function images(array $img, $screens=false) {
    //'name', 'image', 'alt', 'text', 'section'
    if($screens === true) {?>
<picture>
<source media="(max-width:600px)" srcset="/images/<?=$img?>1x.webp" type="image/webp">
<source media="(max-width:600px)" srcset="/images/<?=$img?>1x.jpg" type="image/jpeg">
<source media="(max-width:1680px)" srcset="/images/<?=$img?>2x.webp" type="image/webp">
<source media="(max-width:1680px)" srcset="/images/<?=$img?>2x.jpg" type="image/jpeg">
<source media="(max-width:3840px)" srcset="/images/<?=$img?>3x.webp" type="image/webp">
<source media="(max-width:3840px)" srcset="/images/<?=$img?>3x.jpg" type="image/jpeg">
<source media="(min-width:3840px)" srcset="/images/<?=$img?>4x.webp" type="image/webp">
<source media="(min-width:3840px)" srcset="/images/<?=$img?>4x.jpg" type="image/jpeg">
<img src="/tilaseats/images/<?=$img?>2x.jpg" alt="<?=$alt?>" style="width:100%">
</picture><?php
    } else {?>
        <img src="/tilaseats/images/<?=$img['image']?>" alt="<?=$img['imagealt']?>" style="width:100%"><?php
    }
}

function download($file) {
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        exit("This file doesn't exit.");
    }
}