
<?php require "backend/views/components/header.php" ?>
<div class="wrapper">
  <div class="content">
    <h1>Произошла ошибка</h1>
    <p><b>Код ошибки:</b> <?= $errno ?></p>
    <p><b>Текст ошибки:</b> <?= $errstr ?></p>
    <p><b>Файл, в котором произошла ошибка:</b> <?= $errfile ?></p>
    <p><b>Строка, в которой произошла ошибка:</b> <?= $errline ?></p>
  </div>
</div>
<script src="/frontend/js/onscroll.min.js"></script>
<?php require "backend/views/components/footer.php" ?>