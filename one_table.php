<?php

  // Подключаемся к БД
  require_once "db-connector.php";

  $thisTable = $_GET["tableName"];
  $thisField = $_GET["field"];

  // echo "<pre>";
  // var_dump($thisTable);
  // echo "</pre>";

  // Удаляем поле таблицы
  if (isset($thisField) and isset($thisTable) ){
    $deleteFiled = "ALTER TABLE $thisTable DROP COLUMN $thisField";
    $statement = $connect->prepare($deleteFiled);
    $statement->execute();
   }

//  echo "<pre>";
//  var_dump($deleteFiled);
//  echo "</pre>";
//
//  echo "<pre>";
//  var_dump($thisTable);
//  echo "</pre>";


  // Выводим поля этой таблицы
  if (!empty($thisTable)) {
    $oneTable = "DESCRIBE $thisTable";
    $statement = $connect->prepare($oneTable);
    $statement->execute();
  }

  $results = [];

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $results[] = $row;
  }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,700&amp;subset=cyrillic" rel="stylesheet">
  <link rel="stylesheet" href="./css/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>

<div class="wrapper">

  <h1>Структура таблицы <?= "\"" . ucfirst($thisTable) . "\"" ?></h1>
  <table class="db-list">
    <tr>
      <th>Имя столбца</th>
      <th>Тип данных</th>
      <th>NULL?</th>
      <th>Ключ</th>
      <th>Значение по умолчанию</th>
      <th>Дополнительно</th>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <?php foreach ($results as $row): ?>
      <tr>
        <td class="field-name"><?php echo $row["Field"] ?></td>
        <td><?php echo $row["Type"] ?></td>
        <td><?php echo $row["Null"] ?></td>
        <td><?php echo $row["Key"] ?></td>
        <td><?php echo $row["Default"] ?></td>
        <td><?php echo $row["Extra"] ?></td>
        <td class="actions"><a class="edit-type" href="" title="Изменить тип"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
        <td class="actions"><a class="edit-name" href="" title="Изменить название"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
        <td class="actions"><a class="delete" href="?field=<?= $row["Field"] ?>&tableName=<?= $thisTable ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <a href="index.php">Вернуться на главную</a>

</div>

</body>
</html>
