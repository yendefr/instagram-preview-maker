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
    <input type="checkbox" name="is-random" id="is-random" form="gen" checked> <br>
    <label for="is-politic">Добавить Privacy policy?</label>
    <input type="checkbox" name="is-politic" id="is-politic" form="gen" checked> <br>
    <label for="is-light">Светлый фон?</label>
    <input type="checkbox" name="is-light" id="is-light" form="gen" checked> <br>
  </div>
</div>
<div class="form">
    <form action="./index.php" method="POST" id="gen" name="gen">
        <div class="input_link input">
            <label for="link">Введите ссылку на инста аккаунт</label> <br>
            <input type="text" name="link" id="link" onclick="changeStatus()">
            <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') { ?>
              <!-- The Modal -->
              <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h2>Предупреждение</h2>
                  </div>
                  <div class="modal-body">
                    <p>Данный аккаунт уже использовался. Использовать его повторно?</p>
                    <button form="nothing" class="close">Отмена</button>
                    <button form="force-gen" class="force-gen">Продолжить</button>
                  </div>
                </div>
              </div>
              <script>
                  // Get the modal
                  let modal = document.getElementById('myModal');

                  // Get the <span> element that closes the modal
                  let close = document.getElementsByClassName("close")[0];
                  let forceGen = document.getElementsByClassName("force-gen")[0];

                  close.onclick = function() {
                      modal.style.display = "none";
                  }
                  forceGen.onclick = function() {
                      modal.style.display = "none";
                  }

                  window.onclick = function(event) {
                      if (event.target === modal) {
                          modal.style.display = "none";
                      }
                  }
              </script>
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
          <label for="extra-text">Дополнительный текст</label> <br>
          <textarea name="extra-text" id="extra-text" cols="120" rows="10"></textarea>
        </div>
        <button>Сгенерировать</button>
    </form>

    <form action="./index.php" method="POST" id="force-gen" name="force-gen" style="display: none">
      <input type="checkbox" name="is-force-gen" id="is-force-gen" form="force-gen" checked> <br>
      <input type="checkbox" name="is-random" id="is-random" form="force-gen" <?php if (isset($_POST['is-random'])) { echo "checked"; } ?>> <br>
      <input type="checkbox" name="is-politic" id="is-politic" form="force-gen" <?php if (isset($_POST['is-politic'])) { echo "checked"; } ?>> <br>
      <input type="checkbox" name="is-light" id="is-light" form="force-gen" <?php if (isset($_POST['is-light'])) { echo "checked"; } ?>> <br>
      <input type="text" name="link" id="link" value="<?= $_POST['link'] ?>">
      <select name="template" id="template">
        <option value="instawhite-1">instawhite-1</option>
      </select>
      <input type="text" name="folder" id="folder" value="<?= $_POST['folder'] ?>">
      <textarea name="extra-text" id="extra-text" cols="120" rows="10"><?= $_POST['extra-text'] ?></textarea>
    </form>
</div>
<script src="scripts/main.js"></script>
</body>
</html>