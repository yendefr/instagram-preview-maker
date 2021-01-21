<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
    <title>Instagram preview</title>
</head>
<body>
<div class="form">
    <form action="./input.php" method="POST">
        <div class="input_link input">
            <label for="username">Введите логин</label> <br>
            <input type="text" name="username" id="username">
        </div>
        <div class="input_template input">
            <label for="password">Введите пароль</label> <br>
            <input type="password" name="password">
        </div>
        <button>Войти</button>
    </form>
</div>
</body>
</html>
