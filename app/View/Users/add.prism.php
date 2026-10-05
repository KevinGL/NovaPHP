<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nouvel utilisateur</title>
    </head>
    <body>
        <div>
            <h1>Nouvel utilisateur</h1>
            <form method="post">
                <div>
                    <label>Nom</label>
                    <input type="text" name="name" required />
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" required />
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required />
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="description"></textarea>
                </div>
                <div>
                    <button type="submit">Envoyer</button>
                </div>
            </form>
        </div>
    </body>
</html>