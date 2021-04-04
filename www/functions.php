<?php

$base_url = '/';

function create_zip($files = array(),$destination = '',$overwrite = false) {
    if(file_exists($destination) && !$overwrite) { return false; }
    $valid_files = array();
    if(is_array($files)) {
        foreach($files as $file) {
            if(file_exists($file)) {
                $valid_files[] = $file;
            }
        }
    }
    if(count($valid_files)) {
        $zip = new ZipArchive();
        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }
        foreach($valid_files as $file) {
            $zip->addFile($file,$file);
        }

        $zip->close();

        return file_exists($destination);
    }
    else
    {
        return false;
    }
}

function file_force_download($file) {
    if (ob_get_level()) {
        ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
}

function getToken() {
    $handle = fopen('extra/tokens.csv','r');
    $token = fgetcsv($handle);
    return $token[0];
}

function checkUser($base_url) {
    $access = [];
    $access = file('./extra/access.php');
    $login = trim($access[1]);
    if (!isset($_COOKIE['login']) or $_COOKIE['login'] != $login) {
        header('Location: '.$base_url.'login.php');
    }
}

function setUser($base_url) {
    $access = [];
    $access = file('./extra/access.php');
    $login = trim($access[1]);
    $password = trim($access[2]);
    if (isset($_COOKIE['login']) and $_COOKIE['login'] == $login) {
        header('Location: '.$base_url.'input.php');
    }
    if ($_POST['login'] == $login and $_POST['password'] = $password) {
        setcookie('login', $login, time()+999999, '/');
        header('Location: '.$base_url.'input.php');
    } else {
        header('Location: '.$base_url.'login.php');
    }
}

function unsetUser($base_url) {
    setcookie('login', '', -1, '/');
    header('Location: '.$base_url.'login.php');
}