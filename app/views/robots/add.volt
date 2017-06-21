{{ content() }}
<div class="add-robot">
  <h2>
    Заполните эту форму, чтобы добавить своего робота!
  </h2>

  {{ form("robots/add", "method": "post") }}

    <div>
        <div>
            <label for="name">Имя робота:</label>
            {{ form.render("name") }}
        </div>

    </div>
    <br>

    <div>
          <div>
              <label for="type">Тип робота:</label>
              {{ form.render("type") }}
          </div>

    </div>
    <br>

        <div>
            <div>
                <label for="year">Год создания робота:</label>
                {{ form.render("year") }}
            </div>

        </div>
        <br>

        <br>
        <div>
            {{ submit_button("Добавить робота", "class": "btn btn-primary") }}
        </div>
        {{ endForm() }}
</div>
