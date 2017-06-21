{{ content() }}
<div class="login">
    <h2>
        Войдите используя форму
    </h2>

    {{ form("users/login", "method": "post") }}

    <div class="form-group">
        <label for="name">Имя:</label>
        {{ form.render("name") }}
    </div>

    <br>

    <br>
    <div class="">
        <label for="password">Пароль:</label>
        {{ form.render("password") }}
    </div>



    <br>
    <div>
        {{ submit_button("Войти", "class": "btn btn-primary") }}
    </div>
    {{ endForm() }}
</div>