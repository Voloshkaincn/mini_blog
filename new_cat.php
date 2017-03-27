<?php
include 'function.php';


$mess = "";
if (isset($_POST['new_cat'])){
    $new_cat = htmlspecialchars(mb_strtolower(trim($_POST['new_cat'])));
    if ($new_cat !=  "") {
        $sel_cat = "SELECT * FROM category";
        $cats = select($link, $sel_cat);
        foreach ($cats as $cat) {
            if ($new_cat == $cat['cat']) {
                $mess = "Така категорія вже існує. Оберіть її у випадаючому списку форми.";
                $test = "no";
                break;
            } else {
                $test = "";
            }

        }
        if ($test == "") {
            $add = "INSERT INTO category (cat) VALUE (?)";
            $stmt = mysqli_prepare($link, $add);
            mysqli_stmt_bind_param($stmt, 's', $new_cat);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $mess = "Все ок. Нова категорія додана.";
        }
    }
}
?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>drupal naumenko</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="forma">
    <div class="mess"><?= $mess ?></div>
    <form class="form_cat" action="new_cat.php" method="post">
        <label for="new_cat">Введіть назву нової категорії</label>
        <input name="new_cat" id="new_cat" type="text">
        <button class="btn-blue">Додати</button>
    </form>

    <a class="btn-blue" href="forma.php">Повернутись до заповнення форми</a>

    <!--<input class="btn-blue" type="button" value="Закрити це вікно." onclick="window.close()">-->
    
</div>

</body>
</html>
