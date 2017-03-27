<?php
include 'function.php';

$sel = "SELECT * FROM category";
$cats = select($link,$sel);

//Редагування: робимо вибірку для заповня форми
if (isset($_POST['id'])){
    $sel = "SELECT * FROM news WHERE `id` = '{$_POST['id']}'";
    $news = select($link,$sel);
    $title = $news[0]['title'];
    $m_text = $news[0]['m_text'];
    $text = $news[0]['text'];
    $id_cat = $news[0]['id_cat'];
    $id = $news[0]['id'];

}
//Виборка для поля категорії
else {
    $title = "";
    $m_text = "";
    $text = "";
    $id_cat = "";

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
    <h3>Форма додавання нової статті: </h3>
    <form id="forma" action="admin.php" method="post">
        <label for="title">Заголовок</label>
        <input name="title" id="title" type="text" value="<?= $title ?>">
        <label for="cat">Виберіть категорію: </label>
        <select class="left" name="cat" id="cat" required>
            <?php foreach ($cats as $cat) :?>
                    <option value="<?= $cat['id'] ?>" <?php echo ($cat['id'] == $id_cat) ? "selected" : "" ?> ><?= $cat['cat'] ?></option>
            <?php endforeach; ?>
        </select>
        <a class="right new_cat" href="new_cat.php">Додати нову категорію</a>
        <label for="m_text">Короткий зміст новини: </label>
        <textarea name="m_text" id="m_text" cols="30" rows="5"><?= $m_text ?></textarea>
        <label for="text">Повний зміст новини: </label>
        <textarea name="text" id="text" cols="30" rows="10" required><?= $text ?></textarea>
        <input name="id_news" value="<?= $id ?>" type="hidden">
        <a class="btn-blue" href="admin.php"><--Повернутись без збереження</a>
        <?php if(isset($_POST['id'])): ?>
            <button class="btn-blue" name="upd">Зберегти</button>
            <?php else: ?>
            <button class="btn-blue" name="add">Додати</button>
        <?php endif; ?>

    </form>
</div>

</body>
</html>
