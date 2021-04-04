<?php

use GuzzleHttp\Client;
use InstagramScraper\Instagram;

require __DIR__ . '/../vendor/autoload.php';
include_once __DIR__. '/functions.php';

if ($_SERVER['REQUEST_URI'] == $base_url) {
    checkUser($base_url);
    include "./input.php";
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['login'])) {
        setUser($base_url);
    } elseif (isset($_POST['link'])) {
        checkUser($base_url);
        session_start();
        try {
            $link = trim($_POST['link']);
    
            if (!isset($_POST['is-force-gen'])) {
                $handle = fopen("extra/history.txt", "r");
                $buffer = explode(';', fgets($handle));
                fclose($handle);
    
                array_pop($buffer);
                foreach ($buffer as $l) {
                    if ($l === $link) {
                        $_SESSION['status'] = 'error';
                        if (isset($_FILES['extra-photo']) and $_FILES['extra-photo']['size'] != 0) {
                            copy($_FILES['extra-photo']['tmp_name'], 'tmp/extra-photo.png');
                        }
                        include "./input.php";die;
                    }
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
    
        $files_to_zip = array(
            $folder.'/index.html',
            $folder.'/logo.png'
        );
    
        $url = $account->getProfilePicUrl();
        file_put_contents($folder.'/logo.png', file_get_contents($url));
    
        if (file_exists('tmp/extra-photo.png')) {
            copy('tmp/extra-photo.png', $folder.'/extra-photo.png');
            $files_to_zip[] = $folder.'/extra-photo.png';
        } elseif (isset($_FILES['extra-photo']) and $_FILES['extra-photo']['size'] != 0) {
            copy($_FILES['extra-photo']['tmp_name'], $folder . '/extra-photo.png');
            $files_to_zip[] = $folder . '/extra-photo.png';
        }
    
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
        ob_end_clean();
    
        if (isset($_POST['is-politic'])) {
            $website = $account->getUsername();
            ob_start();
            include "./extra/privacy-policy.html";
            $output = ob_get_contents();
            $file = fopen($folder.'/privacy-policy.html',"wt");
            fputs($file, $output);
            fclose($file);
            ob_end_clean();
    
            ob_start();
            include "./extra/terms.html";
            $output = ob_get_contents();
            $file = fopen($folder.'/terms.html',"wt");
            fputs($file, $output);
            fclose($file);
            ob_end_clean();
    
            $files_to_zip[] = $folder.'/privacy-policy.html';
            $files_to_zip[] = $folder.'/terms.html';
        }
    
        $result = create_zip($files_to_zip, $folder.'/'.$folder.'.zip');
        file_force_download($folder.'/'.$folder.'.zip');
    
        unlink($folder.'/'.$folder.'.zip');
        unlink($folder.'/index.html');
        unlink($folder.'/logo.png');
        unlink($folder.'/privacy-policy.html');
        unlink($folder.'/terms.html');
        unlink($folder.'/extra-photo.png');
        if (file_exists('tmp/extra-photo.png')) {
            unlink('tmp/extra-photo.png');
        }
        rmdir($folder);
    
        file_put_contents('extra/history.txt', $link. ';', FILE_APPEND);
        session_unset();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['logout'])) {
        unsetUser($base_url);
    } elseif ($_SERVER['REQUEST_URI'] == $base_url."login.php") {
        checkUser($base_url);
        include "./login.php";
    } elseif ($_SERVER['REQUEST_URI'] == $base_url."settings.php") {
        checkUser($base_url);
        include "./settings.php";
    } else {
        checkUser($base_url);
        include "./input.php";
    }

    if (isset($_GET['token']) and $_GET['token'] !== null) {
        checkUser($base_url);
        $token = $_GET['token'];
        $tokens = fopen('extra/tokens.csv', 'a');
        fputcsv($tokens, array($token));
    } elseif (isset($_GET['del_token'])) {
        checkUser($base_url);
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
        header('Location: '.$base_url.'settings.php');
    }
}