{{ get_doctype() }}
<html>
<head>
    <meta charset="utf-8">
    {{ getTitle() }}
    {{ stylesheet_link('css/bootstrap.min.css') }}
    {{ stylesheet_link('css/style.css') }}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- static navigation panel -->
      <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                </button>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li>{{ link_to(
                    "/", "<h3>Learning</h3>") }}
                    </li>

                    <li>{{ link_to(
                    "users/register", "<h3>Регистрация</h3>") }}
                    </li>

                    <li>{{ link_to("session/page",
                    "<h3>Моя страница</h3>") }}
                    </li>

                    <li>{{ link_to("users/loginshow",
                    "<h3>Войти</h3>") }}
                    </li>

                    <li>{{ link_to("users/logout",
                    "<h3>Выйти</h3>") }}</li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
      </nav>
</head>

<body>

  {{ content() }}
  {{ javascript_include('js/jquery.min.js') }}
  {{ javascript_include('js/bootstrap.min.js') }}
  {{ javascript_include('js/utils.js') }}

</body>

<!-- bottom page -->
  <footer class="footer">
      <br>
      <h4 align="center">Ваше хранилище роботов в виде фотографий и изображений, и просмотра других роботов
          "Хранилище роботов - 2017"</h4>
  </footer>

</html>