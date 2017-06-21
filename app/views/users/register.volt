{{ content() }}
<div class="register">
  <h2>
    Зарегиcтрируйтесь используя форму
  </h2>

  {{ form("users/register", "method": "post") }}

  <div class="form-group">
    <label for="name">Имя:</label>
    {{  form.render("name") }}
  </div>

  <br>

  <div class="">
    <label for="email">E-Mail:</label>
    {{ form.render("email") }}
  </div>


  <br>
  <div class="">
      <label for="password">Пароль:</label>
      {{ form.render("password") }}
  </div>

  <br>
  <div>
      {{ submit_button("Зарегистрироваться", "class": "btn btn-primary") }}
  </div>
  {{ endForm() }}
</div>
