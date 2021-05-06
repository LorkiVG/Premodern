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
<div class="modal_skins">
  <p class="modal_skins__close"></p>
  <div class="modal_skins__conteiner">
    <div class="modal_skins__skin" id="skin_1">
      <div class="skin_view">
        <canvas data-num="1" class="modal_skins__skin__skin_view skin_view_1" id="skin_view"></canvas>
        <form action="/account/set_active_skin" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input type="hidden" name="skin_num" value="1">
          <input data-num="1" id="skin_active_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
          <button data-num="1" class="modal_skins__skin__button skin_view_select_skin_1 skin_view_select_skin">Выбрать</button>
        </form>
      </div>
      <form action="/upload_skin" method="POST">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="skin_num" value="1">
        <input data-num="1" id="skin_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
        <input data-num="1" class="modal_skins__skin__input" type="file" name="" accept="image/png" id="skin_view_d_input_1">
        <div data-num="1" class="modal_skins__skin__preview_skin skin_view_preview_1"></div>
        <div>
          <label for="skin_view_d_input_1" data-num="1" class="modal_skins__skin__button skin_view__d_to_preload_1">Загрузить</label>
          <button data-num="1" class="modal_skins__skin__button skin_view__d_to_server_1">Установить</button>
        </div>
      </form>
    </div>
    <div class="modal_skins__skin" id="skin_2">
      <div class="skin_view">
        <canvas data-num="2" class="modal_skins__skin__skin_view skin_view_2" id="skin_view"></canvas>
        <form action="/account/set_active_skin" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input type="hidden" name="skin_num" value="2">
          <input data-num="2" id="skin_active_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
          <button data-num="2" class="modal_skins__skin__button skin_view_select_skin_2 skin_view_select_skin">Выбрать</button>
        </form>
      </div>
      <form action="/upload_skin" method="POST">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="skin_num" value="2">
        <input data-num="2" id="skin_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
        <input data-num="2" class="modal_skins__skin__input" type="file" name="" accept="image/png" id="skin_view_d_input_2">
        <div data-num="2" class="modal_skins__skin__preview_skin skin_view_preview_2"></div>
        <div>
          <label for="skin_view_d_input_2" data-num="2" class="modal_skins__skin__button skin_view__d_to_preload_2">Загрузить</label>
          <button data-num="2" class="modal_skins__skin__button skin_view__d_to_server_2">Установить</button>
        </div>
      </form>
    </div>
    <div class="modal_skins__skin" id="skin_3">
      <div class="skin_view">
        <canvas data-num="3" class="modal_skins__skin__skin_view skin_view_3" id="skin_view"></canvas>
        <form action="/account/set_active_skin" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input type="hidden" name="skin_num" value="3">
          <input data-num="3" id="skin_active_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
          <button data-num="3" class="modal_skins__skin__button skin_view_select_skin_3 skin_view_select_skin">Выбрать</button>
        </form>
      </div>
      <form action="/upload_skin" method="POST">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="skin_num" value="3">
        <input data-num="3" id="skin_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
        <input data-num="3" class="modal_skins__skin__input" type="file" name="" accept="image/png" id="skin_view_d_input_3">
        <div data-num="3" class="modal_skins__skin__preview_skin skin_view_preview_3"></div>
        <div>
          <label for="skin_view_d_input_3" data-num="3" class="modal_skins__skin__button skin_view__d_to_preload_3">Загрузить</label>
          <button data-num="3" class="modal_skins__skin__button skin_view__d_to_server_3">Установить</button>
        </div>
      </form>
    </div>
    <div class="modal_skins__skin" id="skin_4">
      <div class="skin_view">
        <canvas data-num="4" class="modal_skins__skin__skin_view skin_view_4" id="skin_view"></canvas>
        <form action="/account/set_active_skin" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input type="hidden" name="skin_num" value="4">
          <input data-num="4" id="skin_active_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
          <button data-num="4" class="modal_skins__skin__button skin_view_select_skin_4 skin_view_select_skin">Выбрать</button>
        </form>
      </div>
      <form action="/upload_skin" method="POST">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="skin_num" value="4">
        <input data-num="4" id="skin_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
        <input data-num="4" class="modal_skins__skin__input" type="file" name="" accept="image/png" id="skin_view_d_input_4">
        <div data-num="4" class="modal_skins__skin__preview_skin skin_view_preview_4"></div>
        <div>
          <label for="skin_view_d_input_4" data-num="4" class="modal_skins__skin__button skin_view__d_to_preload_4">Загрузить</label>
          <button data-num="4" class="modal_skins__skin__button skin_view__d_to_server_4">Установить</button>
        </div>
      </form>
    </div>
    <div class="modal_skins__skin" id="skin_5">
      <div class="skin_view">
        <canvas data-num="5" class="modal_skins__skin__skin_view skin_view_5" id="skin_view"></canvas>
        <form action="/account/set_active_skin" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input type="hidden" name="skin_num" value="5">
          <input data-num="5" id="skin_active_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
          <button data-num="5" class="modal_skins__skin__button skin_view_select_skin_5 skin_view_select_skin">Выбрать</button>
        </form>

      </div>
      <form action="/upload_skin" method="POST">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="skin_num" value="5">
        <input data-num="5" id="skin_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
        <input data-num="5" class="modal_skins__skin__input" type="file" name="" accept="image/png" id="skin_view_d_input_5">
        <div data-num="5" class="modal_skins__skin__preview_skin skin_view_preview_5"></div>
        <div>
          <label for="skin_view_d_input_5" data-num="5" class="modal_skins__skin__button skin_view__d_to_preload_5">Загрузить</label>
          <button data-num="5" class="modal_skins__skin__button skin_view__d_to_server_5">Установить</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="wrapper">
  <div class="content">
    <div class="content__block_1 block">
      <div class="content__block_1__skin_view">
        <canvas class="content__block_1__skin_view_canvas" id="skin-preview-active"></canvas>
      </div>
      <form action="/profile" method="POST" id="general_settings" class="content__block_1__form form">

        <legend class="content__block_1__form__legend form__legend">Общие настройки</legend>

        <p class="content__block_1__form__p form__p">Ваш логин:</p>

        <input value="<?= $_SESSION['authorize']['login'] ?>" name="login" class="content__block_1__form__input form__input" type="text">

        <p class="content__block_1__form__p form__p">Ваш email:</p>

        <input name="email" class="content__block_1__form__input form__input" type="text">

        <p class="content__block_1__form__p form__p">Для сохранения введите пароль:</p>

        <input name="password" class="content__block_1__form__input form__input" type="password">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="form_name" value="general_settings">
        <input id="general_settings_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
        <div>
          <span></span>
          <button class="content__block_1__form__button form__button" type="submit">Изменить</button>
        </div>

      </form>
    </div>
    <div class="content__block_2 block">
      <div class="content__block_2__element">
        <button class="content__block_2__element__button form__button" type="submit">МОИ СКИНЫ</button>
        <a href="/logout" class="content__block_2__element__button form__button" type="submit">Выйти из аккаунт</a>

      </div>
      <form action="/profile" method="POST" id="password_settings" class="content__block_2__form form">

        <legend class="content__block_2__form__legend form__legend">Смена пароля</legend>

        <p class="content__block_2__form__p form__p">Новый пароль:</p>

        <input name="new_password" class="content__block_2__form__input form__input" type="password">

        <p class="content__block_2__form__p form__p">Старый пароль:</p>

        <input name="old_password" class="content__block_2__form__input form__input" type="password">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input id="password_settings_g-recaptcha-response" type="hidden" name="g-recaptcha-response">
        <input type="hidden" name="form_name" value="password_settings">
        <div>
          <a href="/fpassword" class="content__block_2__link form__link">Забыл пароль</a>
          <button class="content__block_2__form__button form__button" type="submit">Изменить</button>
        </div>

      </form>
    </div>
    <?php if ($_SESSION['authorize']['is_admin'] != 0): ?>
    <a href = "/admin" class="content__block_2__form__button to_admin form__button"  type="submit">В админку</a>
    <?php endif;?>
  </div>
</div>
<?php require "backend/views/components/footer.php" ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= $public_key_recaptha ?>"></script>
<script src="/frontend/js/jquery.min.js"></script>
<script src="/frontend/js/Modal.min.js"></script>
<script src="/frontend/js_dev/SendForm.js" defer></script>
<script src="/frontend/js/three.min.js"></script>
<script src="/frontend/js/skinview3d.js"></script>
<script src="/frontend/js/slick.min.js"></script>
<script src="/frontend/js/onscroll.min.js"></script>