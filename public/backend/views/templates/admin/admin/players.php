<?php require "backend/views/components/header_admin.php" ?>
<div class="wrapper">
  <div class="content">
    <div class="search">
      <input name='player' id='input_set' class="form__input search__input" type="text" autocomplete="off">
      <button id='input_button' class="form__button search__button">Поиск 🔍</button>
      <a href="/admin/players" id='input_button' class="form__button search__link">Все игроки</a>
    </div>
    <?php
    if (isset($players)) :
    ?>
      <table>
        <thead>
          <tr>
            <th scope="col">Ник</th>
            <th scope="col">Email</th>
            <th scope="col">Дата Регистрации</th>
            <th scope="col">Активный слот скина</th>
            <th scope="col">Состояние бана</th>
            <th scope="col">Забанен до</th>
            <th acope="col">Причина бана</th>
            <th acope="col">Warns</th>
            <th scope="col">Редактирование</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($players as $key => $values) {
            $login;
            $ban;
            echo '<tr>';
            foreach ($values as $k => $value) {
              if ($k == "login") {
                $login = $value;
                echo "<th>$value</th>";
                continue;
              }
              if ($k == "is_banned") {
                if ($value == 0) {
                  echo "<td>Не забанен</td>";
                  $ban = false;
                  continue;
                } else {
                  $ban = true;
                  echo "<td>Забанен</td>";
                  continue;
                }
              }
              if ($k == "banned_before_time") {
                if ($ban == true) {
                  if ($value == "forever") {
                    echo "<td>НАВСЕГДА</td>";
                    continue;
                  } else {
                    echo "<td>$value</td>";
                    continue;
                  }
                } else {
                  echo "<td>Не забанен</td>";
                  continue;
                }
              }
              if ($k == "banned_reason") {
                if ($ban == true) {
                  if ($value == "") {
                    echo "<td>Причина не указана</td>";
                    continue;
                  } else {
                    echo "<td>$value</td>";
                    continue;
                  }
                } else {
                  echo "<td>Не забанен</td>";
                  continue;
                }
              }
              echo "<td>$value</td>";
            }
            echo "<td><a class=\"form__button\" href=\"/admin/players/edit_player?player=$login\">Редактировать</a></td>";
            echo '</tr>';
          } ?>
        </tbody>
      </table>
    <?php
    else :
    ?>
      <p class="form__p">Данного игрока не найдено</p>
    <?php endif; ?>
  </div>
</div>

</div>
<script src="/frontend/js/onscroll.min.js"></script>
<?php require "backend/views/components/footer.php" ?>