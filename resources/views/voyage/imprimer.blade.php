<!DOCTYPE html>
<html>
<head>
    <title>Imprimer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" integrity="sha512-+8BbSZlGv/f47XlJZWbAm5fpt7e2cU6vk5gM+cRzD8WU6x+U3qX9yFqUHdV7MIuFv3q1ZwPxmc+Jjwyf2Q1lBQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons%401.7.2/font/bootstrap-icons.css" integrity="sha384-tQfHmB9kuuIIZhb8l0WQ5vblL6Gh0oRMZ8oUWUE6v+qBN9DWi6Uy8E+Oax6vB+kC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" /></head>
<body>
    <div class="card" style="margin-top: 50px; margin-right:10px; margin-left:10px">
        {!! $html !!}
    </div>
    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function () {
                window.close();
            }
        }
    </script>
</body>
</html>
