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

function redirect($location) {
    header("location: $location");
    exit;
}

function str_replace_first($haystack, $needle, $replace) {
    $pos = stripos($haystack, $needle);
    if ($pos !== false) {
        return $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
    }
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

function array_key_index($key, $array) {
    return array_search($key, array_keys($array));
}

//foreach array_search, used somethig similar in betagamers insertfetchamt

function images(array $img, $screens=false) {
    //'name', 'image', 'alt', 'text', 'section'
    $imgurl = HOME.'/assets/images/'.$img['name'];
    if($screens === true) {
        return "<picture>
<source media='(max-width:600px)' srcset='$imgurl"."1x.webp' type='image/webp'>
<source media='(max-width:600px)' srcset='$imgurl"."1x.jpg' type='image/jpeg'>
<source media='(max-width:1680px)' srcset='$imgurl"."2x.webp' type='image/webp'>
<source media='(max-width:1680px)' srcset='$imgurl"."2x.jpg' type='image/jpeg'>
<source media='(max-width:3840px)' srcset='$imgurl"."3x.webp' type='image/webp'>
<source media='(max-width:3840px)' srcset='$imgurl"."3x.jpg' type='image/jpeg'>
<source media='(min-width:3840px)' srcset='$imgurl"."4x.webp' type='image/webp'>
<source media='(min-width:3840px)' srcset='$imgurl"."4x.jpg' type='image/jpeg'>
<img src='$imgurl"."2x.jpg' alt='".$img['alt']."' style='width:100%'>
</picture>";
    } else {
        return "<img src='".HOME.'/assets/images/'.$img['image']."' alt='".$img['imagealt']."' style='width:100%'>";
    }
}

function download($file, $unlink=false) {
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        readfile($file);
        if($unlink===true) unlink($file);
        exit;
    } else {
        exit("This file doesn't exit.");
    }
}

function generate_hash() {
    return $hash = sha1(rand(0,1000));
}

function set_signature() {
    $_SESSION['newuser']['id'] = $_SESSION['newuser']['id'] ?? uniqid(LANG, true);
    $_SESSION['newuser']['regcount'] = $_SESSION['newuser']['regcount'] ?? 0;
    return hash_hmac('sha1', $_SESSION['newuser']['id'], FORM_SIGNATURE_KEY);
}

function check_signature($page, $hash) {
    $genclass = new General;
    if($page!='reset') {
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != account_links($page)) exit($genclass->resp_invalid_request());
    }
    //$_SESSION['newuser']['id'] = $_SESSION['newuser']['id'] ?? uniqid(LANG, true);
    $_SESSION['newuser']['regcount'] = $_SESSION['newuser']['regcount'] ?? 0;
    if($_SESSION['newuser']['regcount'] > 10) exit($genclass->resp_many_registrations());
    $fromform = explode('_', ($_POST['signature']))[1] ?? 'nonsense';
    if(!hash_equals($hash, $fromform)) {
        exit();
    }
    return true;
}

if(!function_exists('str_starts_with_number')) {
    function str_starts_with_number($string, $length=1) {
        return is_numeric(substr($string,0,$length));
    }
}

function trim_starting_number($str) {
    static $length = 0;
    $length++;
    if(str_starts_with_number($str, $length)) {
        return trim_starting_number($str);
    } else {
        $offset = $length-1;
        $length = 0;
        return substr($str, $offset);
    }
}

function form_format($formfields) {
    foreach($formfields as $key=>$val) {
        $line = $selopt = '';
        if($key=='radio') {
            // $useid = true;
            $output[$val['name']] = form_format($val['buttons']);
            continue;
            //return $output;
        }
        foreach($val as $subkey=>$subval) {
            if($subkey=='label') {
                $label = "<label for=".$val['id'].">$subval</label>";
            }
            if($subkey=='tag' || $subkey=='error' || $subkey=='label') continue;
            if($subkey=='options' || $subkey=='options_single') {
                foreach($subval as $optkey=>$optval) {
                    if(is_array($optval)) {
                        $selopt .= "<optgroup label='$optkey'>";
                        foreach($optval as $sub2key=>$sub2val) {
                            $option = $subkey=='options_single' ? $sub2val : $sub2key;
                            $selopt .= "<option value='".(str_starts_with($option, 'default_opt_') ? str_replace('default_opt_', '', $option) : ($option ?? ''))."'>".($option ?? 'Select '.ucfirst($val['name']))."</option>";
                        }
                    } else {
                        $option = $subkey=='options_single' ? $optval : $optkey;
                        $selopt .= "<option value='".(str_starts_with($option, 'default_opt_') ? str_replace('default_opt_', '', $option) : ($option ?? ''))."'>".($optval ?? 'Select '.ucfirst($val['name']))."</option>";
                    }
                }
            }
            $line .= is_numeric($subkey) ? " $subval" : (!is_array($subval) ? " $subkey='$subval'" : '');
        }
        $line = '<'.$val['tag'].$line.'>'.($val['tag']=='select' ? "$selopt</select>" : '').($val['tag']=='textarea' ? ($val['value'] ?? '').'</textarea>' : '').($label ?? '');
        $output[$val['id'] ?? $val['name']] = $line;
    }
    return $output;
}

function zip($sourcePath, $destination) {
    // Remove any trailing slashes from the path
    // $sourcePath = rtrim($sourcePath, '\\/');

    // Get real path for our folder
    $sourcePath = realpath($sourcePath);

    // Initialize archive object
    $zip = new ZipArchive();
    $openzip = $zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    if($openzip!==true) return false;

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourcePath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir())
        {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($sourcePath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    return $zip->close();
}

function unzip($file, array $exts=[]) {
    // ['ziplocation', 'archivepathtofile', 'filename', 'savepath']
    // $exts if you're unsure of filename extension, in that case, 'archivepathtofile' and 'filename' would temporarily not be with extension
    $zip = new ZipArchive();
    // echo $file['ziplocation'];
    var_dump(file_exists($file['ziplocation']));
    if ($zip->open($file['ziplocation']) === true) {
        if(count($exts)) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                foreach($exts as $val) {
                    // echo $file['filename']."<br>";
                    if($filename==$file['filename'].".$val") {
                        $file['archivepathtofile'] = $file['archivepathtofile'].".$val";
                        $file['filename'] = $file['filename'].".$val";
                        break;
                    }
                }
            }
        }
        // echo $file['archivepathtofile'];
        if ($iconData = $zip->getFromName($file['archivepathtofile'])) {
            $zip->close();
            // echo 'yes';
            file_put_contents($file['savepath'].$file['filename'], $iconData);
            return $file['filename'];
        }
        // elseif($iconData = $zip->getFromName($file['subarchivepathtofile'])) backup archive path to file in case of teams/teams.html instead of just teams.html
    }
}

function validate_zip_filetypes($file, $filetypes) {
    $zip = new ZipArchive();
    // echo $file['ziplocation'];
    var_dump(file_exists($file['ziplocation']));
    if ($zip->open($file['ziplocation']) === true) {
        if(count($exts)) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                foreach($exts as $val) {
                    // echo $file['filename']."<br>";
                    if($filename==$file['filename'].".$val") {
                        $file['archivepathtofile'] = $file['archivepathtofile'].".$val";
                        $file['filename'] = $file['filename'].".$val";
                        break;
                    }
                }
            }
        }
        //zip entry_open, entry close for opening / closing zip folders
        // echo $file['archivepathtofile'];
        if ($iconData = $zip->getFromName($file['archivepathtofile'])) {
            $zip->close();
            // echo 'yes';
            file_put_contents($file['savepath'].$file['filename'], $iconData);
            return $file['filename'];
        }
        // elseif($iconData = $zip->getFromName($file['subarchivepathtofile'])) backup archive path to file in case of teams/teams.html instead of just teams.html
    }
}

function format_word_htm($filecontent) {
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $contentType = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    $dom->loadHTML($contentType.$filecontent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_use_internal_errors(false);
    $body = $dom->getElementsByTagName("html");
    $nodes = $body->item(0)->getElementsByTagName('*');
    for ($i = $nodes->length; --$i >= 0; ) {
        $node = $nodes->item($i);
        if($node->tagName=='script' || $node->tagName=='h1') $node->parentNode->removeChild($node);
        // if($node->tagName=='a') {
        //     foreach($node->attributes as $aattr) {
        //         if($aattr->name!='href') $node->removeAttribute($aattr->name); 
        //     }
        //     continue;
        // }
        if($node->tagName=='body') {
            $innerHTML = '';
            $chnodes = $node->childNodes;
            foreach($chnodes as $chnode) {
                $innerHTML .= $node->parentNode->ownerDocument->saveHTML($chnode);
            }
        }
        $attributes = $node->attributes;
        foreach ($attributes as $attr) {
            if($node->tagName=='a' && $attr->nodeName=='href') continue;
            $node->removeAttribute($attr->nodeName);
        }
        // while ($attributes->length) {
        //     $node->removeAttribute($attributes->item(0)->name);
        // }
    }
    // $text = trim(preg_replace('/\s+/', ' ', $innerHTML));
    return $text = str_ireplace(['<span>', '</span>', '<p><p> </p></p>', '<br>'], '',$innerHTML);
}


function old_format_word_htm($str) {
    $patterns = ['/<(\w+)[^\>]*>/ui', '/<span>([^\>]*)<\/span>/ui', '/<script.*<\/script>/ui'];
    $replace = ['<$1>', '$1', ''];
    $text = preg_replace($patterns, $replace, $str);
    $text = str_replace(['<p><span><o>&nbsp;</o:p></span></p>', '<p><o>&nbsp;</o:p></p>'], '', $text);
    return $text;
}

function locale_sort(&$arrayToSort, $locale) {
    uasort($arrayToSort, function ($a, $b) use ($locale) {
        // return strcasecmp($a['name'], $b['name']);
        $coll = collator_create( $locale );
        return collator_compare( $coll, $a['name'], $b['name'] );
    });
}