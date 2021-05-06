<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/frontend/css/preloader.min.css">
  <link rel="stylesheet" href="/frontend/css/fonts.min.css">
  <link rel="stylesheet" href="/frontend/css/main.min.css">
  <link rel="stylesheet" href="/frontend/css/body.min.css">
  <?php if (isset($style_general)):?>
  <link rel="stylesheet" href = <?= $style_general?>>
  <?php endif;?>
  <link rel="stylesheet" href= <?= $style ?>>
  <title><?php if (isset($title)) {echo $title;} ?></title>
</head>
<body>
  <?php require "backend/views/components/preloader.php"?>
  <?php echo $view;?>
  <script src="/frontend/js/preloader.min.js"></script>
  <script src="/frontend/js/burger.min.js" defer></script>
  <script src="<?=$js?>"></script>
</body>
</html>