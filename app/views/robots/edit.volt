{{ content() }}
<div class="add-robot">
    <h2>
        Отредактируйте поля, чтобы изменить своего робота!
    </h2>

    {{ form("robots/save", "method": "post") }}

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
        {{ submit_button("Сохранить изменения", "class": "btn btn-primary") }}
    </div>
    {{ endForm() }}
</div>