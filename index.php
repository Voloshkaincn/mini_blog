<?php
include 'function.php';

//Пагінація
$num = 10; //Кількість статтей на сторінці
$i = 0;
if (isset($_POST['page'])){
    $i = $_POST['page'];
}
$left_num = $i*$num;

if (isset($_POST['one_news'])){
    //Вивід одної статті
    $sel  = "SELECT title, m_text, text, id_cat, cat, date, n.id, id_status, status FROM news n INNER JOIN category c ";
    $sel .= "ON c.id = n.id_cat LEFT JOIN status s ON id_status = s.id WHERE n.id= '" . $_POST['id'] . "'";
    $news = select($link,$sel);

    $count_page = 0;

    //gthtdshrf
    print_r($_POST);
}
elseif (isset($_GET['cat'])){
    $sel_cat  = "SELECT title, m_text, text, id_cat, cat, date, n.id, id_status, status FROM news n INNER JOIN category c ";
    $sel_cat .= " ON c.id = n.id_cat LEFT JOIN status s ON id_status = s.id WHERE id_status = 2  AND id_cat = '" . $_GET['cat'] . "' ";
    $sel_cat .= "ORDER BY date DESC LIMIT " . $num . " OFFSET " . $left_num;
    $news = select($link, $sel_cat);

    $sel_count = "SELECT count(*) as count FROM news WHERE id_status = 2 AND id_cat = '" . $_GET['cat'] . "' ";
    $res = select($link,$sel_count);
    $total = $res[0]['count'];
    $count_page = ceil($total/$num);

}
else {
    //Вивід всіх новин з БД
    $sel_all  = "SELECT title, m_text, text, id_cat, cat, date, n.id, id_status, status FROM news n INNER JOIN category c ";
    $sel_all .= " ON c.id = n.id_cat LEFT JOIN status s ON id_status = s.id WHERE id_status = 2 ORDER BY date DESC LIMIT " . $num . " OFFSET " . $left_num ;
    $news = select($link, $sel_all);

    $sel_count = "SELECT count(*) as count FROM news WHERE id_status = 2";
    $res = select($link,$sel_count);
    $total = $res[0]['count'];
    $count_page = ceil($total/$num);

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
<div class="container">
    <h1> < ГОЛОВНА > </h1>
    <a class="nav" href="index.php">Головна</a>
    <a class="nav right" href="admin.php">Адміністрування --></a>


    <?php foreach ($news as $data): ?>
        <div class="news">
            <h2><?= $data['title'] ?></h2>
            <form action="">
                <button class="left link" name="cat" value="<?= $data['id_cat'] ?>"><?= $data['cat'] ?></button>
            </form>
            <p class="right"><?= date("d.m.Y",strtotime($data['date'])) ?></p>
            <div class="m_text"><?= $data['m_text'] ?></div>
            <?php if(isset($_POST['one_news'])): ?>
                <div class="text"><?= $data['text'] ?></div>
            <?php endif; ?>
            <div class="status">Статус: <?= $data['status'] ?></div>
        </div>
        <div class="option">
            <form action="" method="post">
                <input name="id" type="hidden" value="<?= $data['id'] ?>">
                <button name="one_news">Подивитись повний зміст</button>
            </form>
        </div>
    <?php endforeach; ?>

    <?php if(isset($_POST['one_news'])): ?>
        <form action="">
            <button class="btn-blue">Повернутись</button>
        </form>
    <?php endif; ?>

    <div class="pagination">
        <form action="" method="post">
            <?php for($i=0; $i < $count_page; $i++): ?>
                <button name="page" value="<?= $i ?>">Сторінка <?= $i+1 ?></button>
            <?php endfor; ?>
        </form>
    </div>

</div>


</body>
</html>

