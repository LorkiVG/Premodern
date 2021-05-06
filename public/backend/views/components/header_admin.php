<header class="header lock_padding">
  <div class="header__logo">
    <a href="/">
      <img src="/frontend/img/logo/logo_mini.png" alt="LOGO" class="header__logo__img anim-item always_active">
    </a>
    <a href="/admin" class="header__logo__text anim-item always_active">Admin Panel</a>
  </div>
  <div class="header__menu">
    <nav class="header__nav">
      <a href="/admin/statistic" class="header__nav__link always_active anim-item">Статистика</a>
      <a href="/admin/players" class="header__nav__link always_active anim-item">Игроки</a>
      <a href="/admin/others" class="header__nav__link always_active anim-item">Другие Настройки</a>
    </nav>
    <div class="header__account avatar">
      <a href="/admin/logout" class="header__account__text login always_active anim-item">Выйти из Админки</a>
      <a class="_avatar" href="/profile">

        <div class="header__account__avatar always_active anim-item"><span>
            <? echo substr($_SESSION['authorize']['login'], 0 , 1) ?></span></div>
      </a>
    </div>
  </div>
  <div class="header__burger">
    <div class="header__burger__lines"></div>
  </div>
</header>