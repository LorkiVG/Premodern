<?php require "backend/views/components/header.php" ?>
<div class="wrapper">
  <div class="content">
    <h1>Ошибка в двигателе</h1>
    <h1>Ошибка <?php echo $status_error;?>.<?php echo $message;?></h1>
  </div>
</div>
<script src="/frontend/js/onscroll.min.js"></script>
<?php require "backend/views/components/footer.php" ?>