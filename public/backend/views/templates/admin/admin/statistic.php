<?php require "backend/views/components/header_admin.php" ?>

<div class="wrapper">
  <div class="content">
    <div class="content__charts">
      <div class="content__charts__chart always_active anim-item">
        <canvas width='900' height='590' class="content__charts__chart__canvas"></canvas>
      </div>
      <div class="content__charts__settings always_active anim-item">
        <a href="/admin/statistic?n=all" class="content__charts__settings__button content__button ">Вcя статистика</a>
        <a href="/admin/statistic" class="content__charts__settings__button content__button">Последней недели</a>
        <div class="content__charts__settings__set">
          <p style="margin-top:0px;" class="content__charts__settings__set__p form__p">Последних</p>
          <input name='number' id='input_set' class="form__input content__charts__settings__set__input" type="number" autocomplete="off">
          <p class="content__charts__settings__set__p form__p">дней</p>
          <button id='input_button' class="content__charts__settings__set__button content__button">Смотреть</button>
        </div>
      </div>
    </div>

  </div>
</div>
<?php require "backend/views/components/footer.php" ?>
<script src="/frontend/js/jquery.min.js"></script>
<script src="/frontend/js/chart.min.js"></script>
<script>
  let chart = document.querySelector(".content__charts__chart__canvas");
  let chart_ctx = chart.getContext("2d");
  let chart_view = new Chart(chart_ctx, {
    type: "line",
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
        label: "Кол-во игроков",
        data: <?php echo json_encode($quantity); ?>,
        backgroundColor: "rgba(242,183,5, 0.2)",
        borderColor: "rgba(255, 206, 86, 1)",
        borderWidth: 1
      }]
    },
    options: {
      animation: {
        duration: 1000,
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
</script>
<script src="/frontend/js/onscroll.min.js"></script>