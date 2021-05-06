<?php require "backend/views/components/header_admin.php" ?>
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
      </div>
    </div>
    <div class="modal_skins__skin" id="skin_2">
      <div class="skin_view">
        <canvas data-num="2" class="modal_skins__skin__skin_view skin_view_2" id="skin_view"></canvas>
      </div>
    </div>
    <div class="modal_skins__skin" id="skin_3">
      <div class="skin_view">
        <canvas data-num="3" class="modal_skins__skin__skin_view skin_view_3" id="skin_view"></canvas>
      </div>
    </div>
    <div class="modal_skins__skin" id="skin_4">
      <div class="skin_view">
        <canvas data-num="4" class="modal_skins__skin__skin_view skin_view_4" id="skin_view"></canvas>
      </div>
    </div>
    <div class="modal_skins__skin" id="skin_5">
      <div class="skin_view">
        <canvas data-num="5" class="modal_skins__skin__skin_view skin_view_5" id="skin_view"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="wrapper">
  <div class="content">
    <div class="content__block">
      <p class="form__p">Ник: <?= $player['0']['login'] ?></p>
      <p style="font-size: 22px" class="form__p">Email: <?= $player['0']['email'] ?></p>
      <p class="form__p">Активный скин: <?= $player['0']['active_skin'] ?></p>
      <p class="form__p">Дата регистрации: <?= $player['0']['date_register'] ?></p>
      <?php if ($player['0']['is_banned'] == 1) : ?>
        <p class="form__p">Состояние бана: Забанен</p>
        <p style="font-size: 23px" class="form__p">Забанен до: <?php if ($player['0']['banned_before_time'] == "forever") {
          echo "Навсегда";
        } else {
          echo $player['0']['banned_before_time'];
        }
          ?></p>
        <p class="form__p">Причина: <?php if ($player['0']['banned_reason'] == "") {
                                      echo "Не указана";
                                    } else {
                                      echo $player['0']['banned_reason'];
                                    } ?></p>
      <?php else : ?>
        <p class="form__p">Состояние бана: Не забанен</p>
      <?php endif; ?>
      <button class="content__button open__modal">Смотреть скины</button>

    </div>
    <div class="content__block">
      <p class="form__p">Действия с <?= $player['0']['login'] ?></p>
      <?php if ($player['0']['is_banned'] == 1) : ?>
        <form class="form unban" data-n="1" action="/admin/players/edit_player?player=<?= $player['0']['login'] ?>" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input id="g-recaptcha-response_1" type="hidden" name="g-recaptcha-response">
          <input type="hidden" name="name" value="unban">
          <button class="content__button">Разбанить!</button>
        </form>
      <?php endif; ?>
      <form class="form" data-n="2" action="/admin/players/edit_player?player=<?= $player['0']['login'] ?>" method="POST">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input id="g-recaptcha-response_2" type="hidden" name="g-recaptcha-response">
        <div>
          <p class="form__p">Причина бана:</p>
          <input type="hidden" name="name" value="ban_forever">
          <input style="width: 300px" class="form__input" type="text" name="ban_reason">
          <button style="max-width: 280px" class="content__button">Забанить навсегда!</button>
        </div>

      </form>
      <form style="max-height: 250px" class="form" data-n="3" action="/admin/players/edit_player?player=<?= $player['0']['login'] ?>" method="POST">
        <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
        <input id="g-recaptcha-response_3" type="hidden" name="g-recaptcha-response">
        <input type="hidden" name="name" value="ban_before_time">
        <p style="font-size: 22px" class="form__p">Формат: 21.02.21-09:42:00</p>
        <div style="justify-content:center">
          <p class="form__p">Забанить до:</p>
          <input style="width: 300px;margin-left:10px" type="text" class="form__input" name="before_time">
        </div>
        <div>
          <p class="form__p">Причина бана:</p>
          <input style="width: 300px" class="form__input" type="text" name="ban_reason">
          <button style="max-width: 280px" class="content__button">Забанить!</button>
        </div>

      </form>
      <div class="warns">
        <form class="form" data-n="4" action="/admin/players/edit_player?player=<?= $player['0']['login'] ?>" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input id="g-recaptcha-response_4" type="hidden" name="g-recaptcha-response">
          <input type="hidden" name="name" value="plus_warn">
          <button class="content__button">Выдать варн!</button>
        </form>
        <form class="form" data-n="5" action="/admin/players/edit_player?player=<?= $player['0']['login'] ?>" method="POST">
          <input type="hidden" name="security_token" value="<?= $csrf_token ?>">
          <input id="g-recaptcha-response_5" type="hidden" name="g-recaptcha-response">
          <input type="hidden" name="name" value="minus_warn">
          <button class="content__button">Отнять варн!</button>
        </form>
      </div>

    </div>


  </div>

</div>
<script>
  let name_player = "<?= $player['0']['login'] ?>";
</script>
<script src="https://www.google.com/recaptcha/api.js?render=<?= $public_key_recaptha ?>"></script>
<script src="/frontend/js/jquery.min.js"></script>
<script src="/frontend/js/Modal.min.js"></script>
<script src="/frontend/js/SendForm.min.js" defer></script>
<script src="/frontend/js/three.min.js"></script>
<script src="/frontend/js/skinview3d.js"></script>
<script src="/frontend/js/slick.min.js"></script>
<script src="/frontend/js/onscroll.min.js"></script>
<?php require "backend/views/components/footer.php" ?>