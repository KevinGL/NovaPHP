<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page d'accueil</title>
    </head>
    <body>
        <div>
            <h1>Bienvenue {{ $name }}</h1>
            <h2>Choisis ton arme {{ $name }}</h2>
            @if ($age > $ageMin)
                <p>Accès autorisé</p>
            @elseif ($age === $ageMin)
                <p>Tout juste majeur !</p>
            @else
                <p>Accès refusé</p>
            @endif
        </div>
    </body>
</html>
