<?php
    session_start();
    require_once("./../connection.php");

    if(isset($_SESSION["erreur"])){
        if($_SESSION["erreur"] == 11) {
            echo "<script>alert('Vous ne pouvez pas envoyer un commentaire vide.')</script>";
            $_SESSION['erreur']=0;
        } else if ($_SESSION["erreur"] == 12) {
            echo "<script>alert('L'id qui a été rentré n'est pas bon.')</script>";
            $_SESSION['erreur']=0;
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaire</title>


    <link rel="stylesheet" type="text/css" href="./../css/gestion_compte.css">
    <link rel="stylesheet" type="text/css" href="./../css/style.css">
    <link rel="stylesheet" type="text/css" href="./../css/header.css">
    <link rel="stylesheet" type="text/css" href="./../css/footer.css">
    <link rel="stylesheet" type="text/css" href="./../css/page_commentaire.css">

    <script src="./../js/script.js" defer></script>
</head>
<body>
    <?php
        require_once("./../header.php");
        require_once("./../gestion_compte.php");
    ?>
    <main>
    <?php
        if (isset($_GET["id_eve"]) && ctype_digit($_GET["id_eve"])){
            $id=$_GET["id_eve"];
            $query = "SELECT  identifiant, com FROM Commentaire WHERE id_eve=?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "i",$id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(!$result){
                die("La recherche dans la base de données n'a pas fonctionné.");
            } else {
                if(mysqli_num_rows($result)==0){
                    echo "<p>Il n'y a aucun commentaire pour cet évènement.<p>";
                }else{
                    while($data_commentaire = mysqli_fetch_assoc($result)){
                        echo "<div class='commentaire'><i class='nom'>{$data_commentaire["identifiant"]}</i><p>{$data_commentaire["com"]}</p></div>";
                    }
                }
            }
            
        }
    
    ?>
    </main>

    <?php if (isset($_GET["id_eve"]) && ctype_digit($_GET["id_eve"])): ?>
    <form method="post" class="formulaire" action="gestion_page_commentaire.php?id_eve=<?php echo htmlspecialchars($_GET['id_eve']); ?>">
        <textarea name="commentaire" placeholder="Laisser un commentaire" class="ecrire"></textarea>
        <button type="submit" class="envoyer">Envoyer</button>
    </form>
    <?php endif; ?>

    <?php
        require_once("./../footer.php");
    ?>
</body>
</html>