<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Tabs - Default functionality</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#tabs").tabs();
        });
    </script>
</head>

<body>

    <div id="tabs" style="width:1250px">
        <ul>
            <li><a href="index.php?controlador=Daltonism&accion=tableReport">Reporte General</a></li>
            <li><a href="index.php?controlador=Daltonism&accion=typeReport">Reporte por tipo</a></li>
            <li><a href="index.php?controlador=Daltonism&accion=ageReport">Reporte por edades</a></li>
        </ul>


    </div>


</body>

</html>