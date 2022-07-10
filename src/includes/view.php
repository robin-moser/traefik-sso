<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= ( strlen(getenv('WEB_TITLE')) ) ? getenv('WEB_TITLE') : "SSO" ?></title>
    <style>
<?php include("assets/style.css"); ?>
<?php if ($logout) { ?>
  input.singlepass[type='password'] + button.singlepass::before {
    width: 20px;
    height: 10px;
    border-top: 3px solid #0f0;
    border-right: 3px solid #0f0;
    transform: translate(0px,-4px) rotate(135deg);
  }
  <?php } ?>
    </style>
  </head>
  <body>
  <?php if ($requireuser) { ?>

    <form class="userpass" action="https://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" method="post">
      <input class="userpass" id="user" type="text" autofocus name="user" placeholder="Benutzer">
      <input class="userpass" id="password" type="password" name="password" placeholder="Passwort">
      <button class="userpass" type="submit">Login</button>
    </form>

  <?php } else { ?>

    <form class="singlepass" action="https://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" method="post">
      <input class="singlepass" id="password" type="password" autofocus name="password" placeholder="Passwort">
      <button class="singlepass" type="submit"></button>
    </form>

  <?php } ?>

  <script>
    <?php /* include("assets/script.js"); */ ?>
  </script>

  </body>
</html>

