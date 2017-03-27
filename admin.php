<?php
include 'function.php';

//Отримали данні з форми
if (isset($_POST['add']) || isset($_POST['upd'])){
    $title = htmlspecialchars($_POST['title']);
    $m_text = htmlspecialchars($_POST['m_text']);
    $text = htmlspecialchars($_POST['text']);
    $id_cat = $_POST['cat'];
    $id = $_POST['id_news'];
    $date = date("Y-m-d H:i:s");

    //Редагування новини
    if (isset($_POST['upd'])){
        $query  = "UPDATE news SET title = ?, m_text = ?, text = ?, id_cat = '" . $id_cat . "', date = '" . $date . "' ";
        $query .= "WHERE id = '" . $id . "'";
    }
    //Додавання нової новини
    if (isset($_POST['add'])){
        $query = "INSERT INTO news (`title`,`m_text`,`text`,`id_cat`,`date`) VALUE (?,?,?,'" . $id_cat . "','" . $date ."')";
    };
    $stmt = mysqli_prepare($link,$query);
    mysqli_stmt_bind_param($stmt,'sss',$title,$m_text,$text);
    mysqli_stmt_execute($stmt);

};
//Видалення
if (isset($_POST['del'])){
    $del = "DELETE FROM news WHERE id = '" . $_POST['id'] . "'";
    mysqli_query($link,$del) or die("Видалення не пройшло: ") . mysqli_error($link);
};
//Опублыкування статті
if (isset($_POST['publish'])){
    $query  = "UPDATE news SET id_status = '2' WHERE id = '" . $_POST['id'] . "'";
    mysqli_query($link, $query);
}
//Прибрати з публікації статтю
if (isset($_POST['no_pudlish'])){
    $query  = "UPDATE news SET id_status = '1' WHERE id = '" . $_POST['id'] . "'";
    mysqli_query($link, $query);
}
if (isset($_POST['one_news'])){
    //Вивід одної статті
    $sel  = "SELECT title, m_text, text, cat, date, n.id, id_status, status FROM news n INNER JOIN category c ";
    $sel .= "ON c.id = n.id_cat LEFT JOIN status s ON id_status = s.id WHERE n.id= '" . $_POST['id'] . "'";
    $news = select($link,$sel);
}else {
    //Вивід всіх новин з БД
    $sel_all  = "SELECT title, m_text, text, cat, date, n.id, id_status, status FROM news n INNER JOIN category c ";
    $sel_all .= " ON c.id = n.id_cat LEFT JOIN status s ON id_status = s.id ORDER BY date DESC ";
    $news = select($link, $sel_all);
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
<div class="container admin">
    <h1> < АДМІНІСТРУВАННЯ > </h1>
    <a class="nav" href="index.php"><-- Головна</a>
    <a class="nav right" href="forma.php">Додати нову статтю --></a>

    <?php foreach ($news as $data): ?>
        <div class="news">
            <h2 class="left"><?= $data['title'] ?></h2>
            <p class="date right"><?= date("d.m.Y",strtotime($data['date'])) ?></p>
            <div class="m_text"><?= $data['m_text'] ?></div>
            <?php if(isset($_POST['one_news'])): ?>
                <div class="text"><?= $data['text'] ?></div>
            <?php endif; ?>
            <div class="cat left" name="cat">Категорія: <?= $data['cat'] ?></div>
            <div class="status right">Статус: <?= $data['status'] ?></div>
        </div>
        <div class="option">
            <form action="" method="post">
                <input name="id" type="hidden" value="<?= $data['id'] ?>">
                <button name="del">Видалити</button>
                <button name="upd" formaction="forma.php">Редагувати</button>
                <button name="one_news">Подивитись повний зміст</button>
                <?php if ($data['id_status'] == '1'): ?>
                    <button class="right" name="publish">Опублікувати</button>
                <?php else: ?>
                    <button class="right" name="no_pudlish">Прибрати з публікації</button>
                <?php endif; ?>
            </form>
        </div>
    <?php endforeach; ?>

    <?php if(isset($_POST['one_news'])): ?>
        <form action="">
            <button class="btn-blue">Повернутись</button>
        </form>
    <?php endif; ?>

</div>
</body>
</html>

<?php
mysqli_close($link);
?>