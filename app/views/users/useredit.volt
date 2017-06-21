{{ content() }}
<div class="user-show">
    {{ form("users/usersave", "method": "post") }}

    <div>
      <div>
        <label for="about">Обо мне:</label>
      </div>

         {{ form.render("about") }}

         </div>

         <br>
         <div>
           {{ submit_button("Редактировать", "class": "btn btn-primary") }}
         </div>
         {{ endForm() }}
    </div>