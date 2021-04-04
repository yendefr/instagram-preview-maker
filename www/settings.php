<?php
  include_once "./functions.php";
  checkUser($base_url);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon"  href="styles/favicon.ico">
    <title>Настройки</title>
</head>
<body>
<div class="settings">
    <a href="/">Назад</a>
</div>
<h1>Токены</h1>
<div class="form">
    <form action="./index.php" method="GET">
        <div class="input_token input">
            <label for="token">Введите токен</label> <br>
            <input type="text" name="token" id="token">
        </div>
        <button>Добавить</button>
    </form>
    <div class="tokens">
        <h2>Активные токены</h2>
        <?php
            ini_set('auto_detect_line_endings',TRUE);
            $handle = fopen('extra/tokens.csv','r');
            while ( ($data = fgetcsv($handle) ) !== FALSE) {
                if ($data[0] == null) { continue; }
                echo "<form method='GET' action='./index.php'><div class='form-line'><input type='text' value='$data[0]' name='del_token' class='unclickable' readonly><button>Удалить</button></div></form>";
            }
            ini_set('auto_detect_line_endings',FALSE);
        ?>
    </div>
</div>
</body>
</html>