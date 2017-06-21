{{ content() }}
<div class="user-show">
  <h2>
    Заполните эту форму!
  </h2>

  {{  form("users/useradd", "method": "post") }}

  <div>
    <div>
      <label for="about">Обо мне:</label>
    </div>

      {{ form.render("about") }}

  </div>

  <br>
  <div>
      {{ submit_button("Добавить", "class": "btn btn-primary") }}
  </div>
  {{ endForm() }}
</div>
