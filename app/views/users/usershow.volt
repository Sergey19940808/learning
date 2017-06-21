{{ content() }}
<div class="link">
  <h4 class="link-logout">
    {{ link_to("users/userdelete", "Удалить профиль", "class": "btn btn-danger") }}
  </h4>
</div>

<div class="user">
  <h3 style="color: #1ab7ea">
    Профиль пользователя и его описание:
  </h3>

  <br>

  <h4 style="color: #00a65a">Имя пользователя:
    {{ name }}
  </h4>

  <br>

  <h4 style="color: #00a65a">Описание пользователя: {{ about }}

    <br>
    <br>

    {% if about === null %}
        {{ link_to("users/userabout/$name", "Добавить информацию обо мне",
        "class": "btn btn-primary") }}

    {% else %}
        {{ link_to("users/useredit/$name","Редактировать информацию обо мне",
        "class": "btn btn-primary") }}
    {% endif %}

    <br>
    <br>
  </h4>

  <h4 style="color: #00a65a">Электронная почта пользователя:
    {{ email }}
  </h4>

  <br>

  <h4>
    {{ link_to("robots/add/$name", "Добавить робота",
    "class": "btn btn-primary") }}
  </h4>

  <br>

  <h4 style="color: #00a65a">Список ваших роботов:</h4>
  <br>
  <ul style="color: #00a7d0">

  {% for robot in robots %}
      <li><h4>{{ robot.name }} - {{ robot.type }} - {{ robot.year }}</h4><br>

      {{ link_to("robots/edit/" ~ robot.id, "Редактировать робота",
      "class": "btn btn-warning") }}

      {{ link_to("robots/delete/" ~ robot.id,"Удалить робота",
      "class": "btn btn-danger") }}</li><br>
  {% endfor %}
  </ul>
</div>
