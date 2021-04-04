<!doctype html>
<html lang="ru">
<head>
    <?php if (!isset($_POST['is-extra-edit'])) { ?>
      <title>Open in Instagram</title>
    <?php } else {
      echo $_POST['extra-edit'];
    } ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=600">
    <?php if (isset($_FILES['extra-photo']) or file_exists('tmp/extra-photo.png')) {
      echo "<meta property=\"og:image\" content=\"./extra-photo.png\"/>";
    } ?>
  <style>
        body {
            min-width: 500px;
            background: #f5f5f5;

            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }

        * {
            -moz-box-sizing: border-box; /* Firefox */
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding-left: 30px;
            padding-right: 30px;
            padding-top: 15px;
            padding-bottom: 15px;
            text-align: center;
        }

        .btn {
            display: block;
            background: #745AE0;
            border-radius: 41px;
            border: 0px solid #C2CADE;
            font-size: 16px;
            color: #FFFFFF;
            padding-top: 18px;
            padding-bottom: 17px;
            width: 100%;
            outline: 0;
            font-weight: bold;
            box-shadow: 0px 15px 30px 0px rgba(116, 90, 224, 0.35);
            text-shadow: 0px 15px 30px rgba(116, 90, 224, 0.35);
            -o-transition: .2s;
            -ms-transition: .2s;
            -moz-transition: .2s;
            -webkit-transition: .2s;
            transition: .2s;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-open {
          margin: 30px auto 0;
          width: 400px; font-size: 20px; padding-top: 20px; padding-bottom: 22px;
        }

        .img-round {
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            display: block;
            margin: 0 auto;
            margin-top: 20px;
            border: 2px solid red;
            width: 150px;
            height: 150px;
        }

        .open-descriptor {
            font-size: 18px;
            font-weight: 300;
            color: #7d7d7d;
            display: block;
            margin-top: 35px;
        }
        .extra-text {
            max-width: 450px;
            font-size: 24px;
            margin-top: 30px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="./logo.png" class="img-round" width="150"/>
    <h1><?= $account->getFullName() ?></h1>
    <div style="margin-top: 30px;">
        <p class="open-descriptor"><?= $account->getFollowedByCount() ?> Followers, <?= $account->getFollowsCount() ?> Following, <?= $account->getMediaCount() ?> Posts</p>
    </div>
    <div style="margin-top: 30px;">
    </div>
    <p class=""><?= $account->getBiography() ?></p>

  <a href="<?= /** @var string $link */
    $link ?>" class="btn btn-open"><?php if ($_POST['extra-button'] !== '') { echo $_POST['extra-button']; } else { echo "Open in Instagram"; } ?></a> <br>
    <div>
      <?php if ((isset($_FILES['extra-photo']) and $_FILES['extra-photo']['size'] != 0) or file_exists('tmp/extra-photo.png')) { echo '<img src="./extra-photo.png" style="width: 100%; height: 100%; object-fit: contain;">'; } ?>
    </div>
    <div class="extra-text">
      <p><?php if (isset($_POST['extra-text'])) { echo $_POST['extra-text']; } ?></p>
    </div>
    <div style="position: relative; bottom: 0;">
      <?php
        if (isset($_POST['is-politic'])) {
          echo "<a href=\"./privacy-policy.html\">Privacy policy</a> | <a href=\"./terms.html\">Terms and Conditions</a>";
        }
      ?>
    </div>
</div>
<script>
    <?php if (trim($_POST['extra-time']) !== '0') { ?>
      setTimeout(function(){ window.location.replace('<?= $link ?>'); }, <?php if ($_POST['extra-time'] !== '') { echo intval($_POST['extra-time']); } else { echo 2500; } ?>);
    <?php } ?>
</script>
</body>
</html>