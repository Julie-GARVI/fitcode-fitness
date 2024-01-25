<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercices admins</title>
    <link rel="stylesheet" href="/assets/css/reset.css">
</head>

<body>

@foreach ($exercices as $exercice)
        {{-- Affichez les détails de chaque exercice --}}
        <h1>{{ $exercice->name }}</h1>
@endforeach

</body>
</html>
