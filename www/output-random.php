<?php
  function rand_color() {
      echo '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
  }

  $container = substr(str_shuffle('qwertyuiopasdjklzxccvbnm'), 1, 5) . bin2hex(random_bytes(10));
  $btn = substr(str_shuffle('qwertyuiopasdjklzxccvbnm'), 1, 5) . bin2hex(random_bytes(10));
  $btn_open = substr(str_shuffle('qwertyuiopasdjklzxccvbnm'), 1, 5) . bin2hex(random_bytes(10));
  $img_round = substr(str_shuffle('qwertyuiopasdjklzxccvbnm'), 1, 5) . bin2hex(random_bytes(10));
  $open_descriptor = substr(str_shuffle('qwertyuiopasdjklzxccvbnm'), 1, 5) . bin2hex(random_bytes(10));
  $info = substr(str_shuffle('qwertyuiopasdjklzxccvbnm'), 1, 5) . bin2hex(random_bytes(10));
  $bio = substr(str_shuffle('qwertyuiopasdjklzxccvbnm'), 1, 5) . bin2hex(random_bytes(10));
 ?>
<!doctype html>
<html lang="ru">
<head>
    <title>Open in Instagram</title>
    <meta charset="utf-8">
    <meta name="viewport" content="<?php echo random_int(400, 800).'px' ?>">
  <style>
        body {
            min-width: <?php echo random_int(300, 600).'px' ?>;
            background: <?php rand_color() ?>;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }

        * {
            -moz-box-sizing: border-box; /* Firefox */
            box-sizing: border-box;
        }

        h1 {
          margin-top: <?php echo random_int(5, 50).'px' ?>;
        }

        .<?php echo $container ?> {
            width: 100%;
            max-width: <?php echo random_int(300, 600).'px' ?>;
            margin: 0 auto;
            padding: <?php echo random_int(5, 30).'px' ?> <?php echo random_int(5, 30).'px' ?>;
            text-align: center;
        }

        .<?php echo $btn ?> {
          <?php $btn_pdg = random_int(5, 30).'px' ?>
            display: block;
            background: <?php rand_color() ?>;
            border-radius: <?php echo random_int(10, 100).'px' ?>;
            border: <?php echo random_int(0, 5).'px' ?> solid <?php rand_color() ?>;
            font-size: <?php echo random_int(12, 24).'px' ?>;
            color: <?php rand_color() ?>;
            padding-top: <?php echo $btn_pdg ?>;
            padding-bottom: <?php echo $btn_pdg ?>;
            outline: 0;
            font-weight: bold;
            box-shadow: <?php echo random_int(0, 3).'px' ?> <?php echo random_int(0, 3).'px' ?> <?php echo random_int(0, 3).'px' ?> <?php echo random_int(0, 3).'px' ?> <?php rand_color() ?>;
            text-shadow: <?php echo random_int(0, 1).'px' ?> <?php echo random_int(0, 1).'px' ?> <?php echo random_int(0, 1).'px' ?> <?php rand_color() ?>;
            -o-transition: .2s;
            -ms-transition: .2s;
            -moz-transition: .2s;
            -webkit-transition: .2s;
            transition: .2s;
            cursor: pointer;
            text-decoration: none;
        }

        .<?php echo $btn_open ?> {
          margin: <?php echo random_int(5, 100).'px' ?> auto 0;
          width: <?php echo random_int(30, 100).'%' ?>;
          font-size: <?php echo random_int(12, 24).'px' ?>;
        }

        .<?php echo $img_round ?> {
            <?php $img_size = random_int(120, 160).'px' ?>
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            margin-top: <?php echo random_int(5, 80).'px' ?>;
            border: <?php echo random_int(1, 5).'px' ?> solid <?php rand_color() ?>;
            width: <?php echo $img_size ?>;
            height: <?php echo $img_size ?>;
        }

        .<?php echo $open_descriptor ?> {
            font-size: <?php echo random_int(12, 24).'px' ?>;
            font-weight: <?php echo random_int(200, 700).'px' ?>;
            color: <?php rand_color() ?>;
            display: block;
            margin-top: <?php echo random_int(5, 100).'px' ?>;
        }
        .<?php echo $info?> {
          margin-top: <?php echo random_int(5, 100).'px' ?>;
        }
        .<?php echo $bio ?> {
          margin-top: <?php echo random_int(5, 100).'px' ?>;
        }
    </style>
</head>
<body>
<div class="<?php echo $container ?>" style="text-align: center;">
    <img src="./logo.png" class="<?php echo $img_round ?>"/>
    <h1><?= $account->getFullName() ?></h1>
    <div class="<?php echo $info?>">
        <p class="<?php echo $open_descriptor ?>"><?= $account->getFollowedByCount() ?> Followers, <?= $account->getFollowsCount() ?> Following, <?= $account->getMediaCount() ?> Posts</p>
    </div>
    <div class="<?php echo $bio ?>">
      <p><?= $account->getBiography() ?></p>
    </div>

  <a href="<?= /** @var string $link */
    $link ?>" class="<?php echo $btn ?> <?php echo $btn_open ?>">Open in Instagram</a>
</div>
<script>
    //setTimeout(function(){window.location.replace('<?//= $link ?>//');}, 2500);
</script>
</body>
</html>