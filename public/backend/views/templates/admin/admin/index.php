<?php require "backend/views/components/header_admin.php" ?>
<div class="wrapper">
  <div class="content">
    <h1 class="content__title">Админ-Панель</h1>
    <div class="content__items">
      <div class="content__items__item">
        <div class="content__img">
          <img src="/frontend/img/svg/admin/statistic.svg" alt="">
        </div>
        <a href="/admin/statistic" class=" content__button">Статистика</a>
      </div>
      <div class="content__items__item">
        <div class="content__img">
          <img src="/frontend/img/svg/admin/players.svg" alt="">
        </div>
        <a href="/admin/players" class=" content__button">Игроки</a>
      </div>
      <div class="content__items__item">
        <div class="content__img">
          <img src="/frontend/img/svg/admin/others.svg" alt="">
        </div>
        <a href="/admin/site" class=" content__button">Другие Настройки</a>
      </div>
      <div class="content__items__item">
        <div class="content__img">
          <img src="/frontend/img/svg/admin/exit.svg" alt="">
        </div>
        <a href="/admin/logout" class=" content__button">Выйти из админки</a>
      </div>
    </div>
  </div>

</div>
<script src="/frontend/js/onscroll.min.js"></script>
<?php require "backend/views/components/footer.php" ?>