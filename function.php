<?php
$link = mysqli_connect('localhost','root','','drupl') or die ("з'єднати з базою данних не вдалось: ") . mysqli_error($link);
mysqli_set_charset( $link,'utf8' );

function select($link,$sel)
{
    $res = mysqli_query($link,$sel);
    $rows = array();
    while ($row = mysqli_fetch_assoc($res)){
        $rows[] = $row;
    }
    return $rows;
    mysqli_free_result($res);
};

//function stmt_execute($link,$change,$typs,$var){
//    $stmt = mysqli_prepare($link,$change);
//    mysqli_stmt_bind_param($stmt,$typs,$var);
//    mysqli_stmt_execute($stmt);
//    mysqli_close($link);
//    return true;
//};