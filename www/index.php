<?php

use GuzzleHttp\Client;
use InstagramScraper\Instagram;

require __DIR__ . '/../vendor/autoload.php';

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


if ($_SERVER['REQUEST_URI'] == "/") {
    include "./input.php";
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();
    try {
        $link = trim($_POST['link']);

        $handle = fopen("extra/history.txt", "r");
        $buffer = explode(';', fgets($handle));
        fclose($handle);

        array_pop($buffer);
        foreach ($buffer as $l) {
            if ($l === $link) {
                $_SESSION['status'] = 'error';
                include "./input.php";die;
            }
        }
        $_SESSION['status'] = 'done';

        preg_match('@^(?:https://www.instagram.com/)?([^/]+)@i', $link, $matches);
        $username = $matches[1];

        $instagram = new Instagram(new Client());
        $instagram->setRapidApiKey(getToken());
        $account = $instagram->getAccount($username);
    } catch (InstagramScraper\Exception\InstagramException $e) {
        if ($e->getCode() == 429) {
            $file = file("extra/tokens.csv");
            $file = array_splice($file, 1);
            file_put_contents("extra/tokens.csv", implode("", $file));
            header('Location: /');
        }
        echo 'Что то пошло не так, обратитесь к <a href="https://kwork.ru/inbox/yendefr">разработчику</a>: ' . $e;die;
    } catch (InstagramScraper\Exception\InstagramNotFoundException $e) {
        echo 'Аккаунт не существует';die;
    }

    if (isset($_POST['folder']) && $_POST['folder'] != '') {
        $folder = $_POST['folder'];
    } else {
        $folder = $account->getUsername();
    }
    mkdir($folder);

    ob_start();
    if (isset($_POST['is-random'])) {
        include "./output-random.php";
    } else {
        include "./output.php";
    }
    $output = ob_get_contents();
    $file = fopen($folder.'/index.html',"wt");
    fputs($file, $output);
    fclose($file);

    $url = $account->getProfilePicUrl();
    file_put_contents($folder.'/logo.png', file_get_contents($url));

    $files_to_zip = array(
        $folder.'/index.html',
        $folder.'/logo.png'
    );

    $result = create_zip($files_to_zip, $folder.'/'.$folder.'.zip');
    file_force_download($folder.'/'.$folder.'.zip');

    unlink($folder.'/'.$folder.'.zip');
    unlink($folder.'/index.html');
    unlink($folder.'/logo.png');
    rmdir($folder);

    file_put_contents('extra/history.txt', $link. ';', FILE_APPEND);
    session_unset();
} elseif ($_SERVER['REQUEST_URI'] == "/settings.php") {
    include "./settings.php";
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['token']) and $_GET['token'] !== null) {
        $token = $_GET['token'];
        $tokens = fopen('extra/tokens.csv', 'a');
        fputcsv($tokens, array($token));
    } elseif (isset($_GET['del_token'])) {
        $tokens = [];
        $token = $_GET['del_token'];
        $handle = fopen('extra/tokens.csv','r');
        while ( ($data = fgetcsv($handle) ) !== FALSE) {
            if ($data[0] !== $token and !is_null($data[0])) {
                $tokens[] = $data[0];
            }
        }
        fclose($handle);
        $handle = fopen('extra/tokens.csv', 'w');
        foreach ($tokens as $t) {
            fputcsv($handle, array($t));
        }
        fclose($handle);
    }
    header('Location: /settings.php');
}