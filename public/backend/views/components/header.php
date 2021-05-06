<?php if (!isset($_SESSION['authorize']['id'])) : ?>
  <header class="header lock_padding">
    <a href="/" class="header__logo">
      <img src="/frontend/img/logo/logo_mini.png" alt="LOGO" class="header__logo__img always_active anim-item">
    </a>
    <div class="header__menu">
      <nav class="header__nav">
        <a href="/helpme" class="header__nav__link always_active anim-item<?php if ($_SERVER['REQUEST_URI'] == "/helpme") {
                                                                            echo " url_active";
                                                                          } ?>">Поддержка</a>
        <a href="/info" class="header__nav__link always_active anim-item<?php if ($_SERVER['REQUEST_URI'] == "/info") {
                                                                          echo " url_active";
                                                                        } ?>">О сервере</a>
        <a href="/donate" class="header__nav__link always_active anim-item<?php if ($_SERVER['REQUEST_URI'] == "/donate") {
                                                                            echo " url_active";
                                                                          } ?>">Помощь Проекту</a>
      </nav>
      <div class="header__account">
        <a href="/login" class="header__account__text login always_active anim-item">Вход</a>
        <a href="/register" class="header__account__text register always_active anim-item">Регистрация</a>
      </div>
    </div>
    <div class="header__burger">
      <div class="header__burger__lines"></div>
    </div>

  </header>
<?php elseif (isset($_SESSION['authorize']['id'])) : ?>
  <header class="header lock_padding">
    <a href="/" class="header__logo">
      <img src="/frontend/img/logo/logo_mini.png" alt="LOGO" class="header__logo__img anim-item always_active">
    </a>
    <div class="header__menu">
      <nav class="header__nav">
        <a href="/helpme" class="header__nav__link always_active anim-item">Поддержка</a>
        <a href="/info" class="header__nav__link always_active anim-item">О сервере</a>
        <a href="/donate" class="header__nav__link always_active anim-item">Помощь Проекту</a>
      </nav>
      <div class="header__account avatar">
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
<?php endif; ?>