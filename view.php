<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Robin Moser - SSO</title>
    <style>
<?php include("includes/style.css"); ?>
<?php if ($success) { ?>
  input[type='password'] + button::before {
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

    <form action="https://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" method="post">
      <input id="container" type="password" autofocus name="password" placeholder="Password">
      <button type="submit"></button>
    </form>

  <script>
    <?php include("includes/script.js"); ?> 
  </script>
  </body>
</html>

