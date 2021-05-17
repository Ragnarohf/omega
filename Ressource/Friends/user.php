<?php
session_start();
require "db.php";

$query = $db->prepare("SELECT * FROM friend WHERE username_1=:username_1 OR username_2=:username_2");
$query->execute([
    "username_1" => $_SESSION['user'],
    "username_2" => $_SESSION['user']
]);
$data = $query->fetchAll(); // bouffon si tu fais un fetch tu passe heure a trouver la solution  
//var_dump($data);
if ($_SESSION['user']) {
    $user_check[] = $_SESSION['user'];
    var_dump($user_check);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="https://bootswatch.com/5/cyborg/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>User</title>
</head>

<body>
    <div class="container">
        <h1>Bienvenue <?= $_SESSION['user'] ?></h1>
        <h2>Liste d'amis : </h2>
        <?php
        for ($i = 0; $i < sizeof($data); $i++) {

            if ($data[$i]['username_1'] == $_SESSION['user']) {

                echo $data[$i]['username_2'] . " <a href='action.php?action=delete&id=" . $data[$i]['id']  . "'>suprimer en ami</a>";
                //casse ggueule la concatenation
                $user_check[] = $data[$i]['username_2'];

                if ($data[$i]['is_pending'] == true) {
                    echo '(en attente detre accepté)';
                }
            } else {
                if ($data[$i]['is_pending'] == false) {

                    echo $data[$i]['username_1'] . " <a href='action.php?action=delete&id=" . $data[$i]['id']  . "'>suprimer en ami</a>";
                    $user_check[] = $data[$i]['username_1'];
                }
            }
            echo '<br>';
        }
        ?>

        <h2>demande d'amis : </h2>
        <?php
        for ($i = 0; $i < sizeof($data); $i++) {
            if ($data[$i]['is_pending'] == true && $data[$i]['username_2'] == $_SESSION['user']) {
                echo $data[$i]['username_1'] . " <a href='action.php?action=accept&id=" . $data[$i]['id'] . "'>Accepter</a>  <a href='action.php?action=delete&id=" . $data[$i]['id']  . "'>refuser</a>";
                $user_check[] = $data[$i]['username_1'];
            }
        }
        ?>

        <h2>autres utilisateurs : </h2>
        <?php
        $query = $db->query("SELECT * FROM user");
        $data = $query->fetchAll();
        //var_dump($data);
        for ($i = 0; $i < sizeof($data); $i++) {
            if (!in_array($data[$i]['username'], $user_check)) {

                echo $data[$i]['username'] . " <a href='action.php?action=add&username=" . $data[$i]['username'] . "'>Invitez en ami</a><br>";
            }
        }
        ?>
    </div>


</body>

</html>