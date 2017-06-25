{{ content() }}

{% for user in users %}
    {{ user.id }} - {{ user.name }} - {{ user.email }}<br>
{% endfor %}
<br>