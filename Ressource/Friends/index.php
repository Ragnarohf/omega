<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="https://bootswatch.com/5/cyborg/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>systeme d'amis</title>
</head>

<body>

    <form class="container" action="connect.php" method="POST">
        <h1>Login</h1>

        <div class="form-group row">

        </div>
        <div class="form-group">
            <label for="username" class="form-label mt-4">username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="username">

        </div>
        <div class="form-group">
            <label for="password" class="form-label mt-4">password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>