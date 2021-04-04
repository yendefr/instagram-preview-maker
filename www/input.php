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
    <title>Instagram preview</title>
</head>
<body>
<div class="settings">
  <a href="settings.php">Настройки</a>
  <div class="is-random">
    <label for="is-random">Уникализировать?</label>
    <input type="checkbox" name="is-random" id="is-random" form="gen" checked onclick="disableCheckbox()"> <br>
    <label for="is-politic">Добавить Privacy policy?</label>
    <input type="checkbox" name="is-politic" id="is-politic" form="gen" checked> <br>
    <label for="is-light">Светлый фон?</label>
    <input type="checkbox" name="is-light" id="is-light" form="gen" checked> <br>
    <label for="is-extra-edit">Расширенное редактирование</label>
    <input type="checkbox" name="is-extra-edit" id="is-extra-edit" form="gen" onclick="setExtraEdit()"> <br> <br> <br>
    <form action="./index.php" method="get"><input type="text" value="logout" name="logout" style="display: none;"><button>Выйти</button></form>
  </div>
</div>
<div class="form">
    <form action="./index.php" method="POST" id="gen" name="gen" enctype="multipart/form-data">
        <div class="input_link input">
            <label for="link">Введите ссылку на инста аккаунт</label> <br>
            <input type="text" name="link" id="link">
            <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') { ?>
              <div id="err">
                <p style="color: #c23436">Предупреждение</p> <br>
                <p style="color: #c23436">Данный аккаунт уже использовался. Использовать его повторно?</p>
                <div style="display: flex; flex-direction: row; margin-top: 5px;">
                  <button form="nothing" onclick="changeStatus()">Отмена</button>
                  <button form="force-gen" onclick="changeStatus()" style="margin-left: 3px;">Продолжить</button>
                </div>
              </div>
            <?php } ?>
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
        <div class="input_text input">
          <label for="extra-button">Текст на кнопке (по умолчанию Open in instagram)</label> <br>
          <input type="text" name="extra-button" id="extra-button">
        </div>
        <div class="input_text input">
          <label for="extra-time">Время редиректа (по умолчанию 2500=2,5сек ; 0 - отключает редирект)</label> <br>
          <input type="text" name="extra-time" id="extra-time">
        </div>
        <div class="input_text input">
          <label for="extra-photo">Дополнительная картинка</label> <br>
          <input type="file" name="extra-photo" id="extra-photo">
        </div>
        <div class="input_text input">
          <label for="extra-text">Дополнительный текст</label> <br>
          <textarea name="extra-text" id="extra-text" cols="120" rows="10"></textarea>
        </div>
        <div class="input_text input" id="extra-edit-container" style="display: none;">
          <label for="extra-edit">Расширенное редактирование</label> <br>
          <textarea name="extra-edit" id="extra-edit" cols="120" rows="10">
            <title>Open in Instagram</title>
            <meta name="description" content="ТЕМА_ВАЙТА">
            <meta name="keywords" content="КЛЮЧИ_ПО_ОФФЕРУ+обязательно_по_тематике_вайта" />
            <meta property="og:title" content="ЭТО_БУДЕТ_ЗАГОЛОВОК_В_ФБ" />
            <meta property="og:description" content="ЭТО_БУДЕТ_ТЕКСТ_В_ФБ" />
            <meta property="og:type" content="website"/>
            <meta property="og:url" content="ССЫЛКА_ГДЕ_БУДЕТ_ВАЙТ"/>
            <link rel="canonical" href="ССЫЛКА_ГДЕ_БУДЕТ_ВАЙТ" />
          </textarea>
        </div>
        <button>Сгенерировать</button>
    </form>

    <form action="./index.php" method="POST" id="force-gen" name="force-gen" enctype="multipart/form-data" style="display: none">
      <input type="checkbox" name="is-force-gen" id="is-force-gen" form="force-gen" checked> <br>
      <input type="checkbox" name="is-random" id="is-random" form="force-gen" <?php if (isset($_POST['is-random'])) { echo "checked"; } ?>> <br>
      <input type="checkbox" name="is-politic" id="is-politic" form="force-gen" <?php if (isset($_POST['is-politic'])) { echo "checked"; } ?>> <br>
      <input type="checkbox" name="is-light" id="is-light" form="force-gen" <?php if (isset($_POST['is-light'])) { echo "checked"; } ?>> <br>
      <input type="checkbox" name="is-extra-edit" id="is-extra-edit" form="force-gen" <?php if (isset($_POST['is-extra-edit'])) { echo "checked"; } ?>> <br>
      <input type="text" name="link" id="link" value="<?= $_POST['link'] ?>">
      <select name="template" id="template">
        <option value="instawhite-1">instawhite-1</option>
      </select>
      <input type="text" name="folder" id="folder" value="<?= $_POST['folder'] ?>">
      <input type="text" name="extra-button" id="extra-button" value="<?= $_POST['extra-button'] ?>">
      <input type="text" name="extra-time" id="extra-time" value="<?= $_POST['extra-time'] ?>">
      <textarea name="extra-text" id="extra-text" cols="120" rows="10"><?= $_POST['extra-text'] ?></textarea>
      <textarea name="extra-edit" id="extra-edit" cols="120" rows="10"><?= $_POST['extra-edit'] ?></textarea>
    </form>
</div>
<script src="scripts/main.js"></script>
</body>
</html>