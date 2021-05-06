<?php require "backend/views/components/header.php" ?>
<div class="info_modal">
  <div class="info_modal__content">
    <p class="info_modal__content__text"></p>
    <p class="info_modal__content__close"></p>
  </div>
</div>
<div class="error_modal">
  <div class="error_modal__content">
    <p class="error_modal__content__text"></p>
    <p class="error_modal__content__close"></p>
  </div>
</div>
<div class="wrapper">
  <form action="/admin/login" method="post" class="form">
    <p class="form__p">Пароль</p>
    <input name='password' id='password' class="form__input" type="password" autocomplete="off">
    <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
    <input id="g-recaptcha-response" type="hidden" name="g-recaptcha-response">
    <button id='password_repeat' class="form__button" type="submit">В админку</button>

  </form>
</div>
<?php require "backend/views/components/footer.php" ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= $public_key_recaptha ?>"></script>
<script src="/frontend/js/jquery.min.js"></script>
<script src="/frontend/js/Modal.min.js"></script>
<script src="/frontend/js/SendForm.min.js" defer></script>
<script src="/frontend/js/onscroll.min.js"></script>