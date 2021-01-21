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
    <title>Instagram preview</title>
</head>
<body>
<div class="settings">
  <a href="settings.php">Настройки</a>
  <div class="is-random">
    <label for="is-random">Уникализировать?</label>
    <input type="checkbox" name="is-random" id="is-random" form="gen" checked>
  </div>
</div>
<div class="form">
    <form action="./index.php" method="POST" id="gen">
        <div class="input_link input">
            <label for="link">Введите ссылку на инста аккаунт</label> <br>
            <input type="text" name="link" id="link" onclick="changeStatus()">
            <?php
              if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
                echo "<p class=\"error\" id='err'>Этот аккаунт уже использовался</p>";
              }
            ?>
        </div>
        <div class="input_template input">
            <label for="template">Выберите шаблон</label> <br>
            <select name="template" id="template">
                <option value="instawhite-1">instawhite-1</option>
            </select>
        </div>
        <div class="input_link input">
          <label for="folder">Название папки</label> <br>
          <input type="text" name="folder" id="folder">
        </div>
        <button>Сгенерировать</button>
    </form>
</div>
<script src="scripts/main.js"></script>
</body>
</html>