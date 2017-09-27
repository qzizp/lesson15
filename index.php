<?php

  // Подключаемся к БД
  require_once "db-connector.php";

  // Запоминаем имя таблицы
  $thisTable = $_GET["tableName"];

  // Удаляем таблицу (если надо)
  if ($_GET["action"] == "drop") {
    $dropThisTable = "DROP TABLE $thisTable";
    $statement = $connect->prepare($dropThisTable);
    $statement->execute();
  }

  // Создаем новую таблицу
  if (isset($_POST["submit"])) {
      $createNewTable = $_POST["tableRules"];
      $statement = $connect->prepare($createNewTable);
      $statement->execute();
  }

  // Показываем все таблицы этой БД
  $allTables = "SHOW TABLES";
  $statement = $connect->prepare($allTables);
  $statement->execute();

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
  <link rel="stylesheet" href="css/style.css ">
  <title>Document</title>
</head>
<body>

  <div class="wrapper">
    <div class="clearfix">
        <div class="make-table">
            <h1>Создать свою таблицу</h1>
              <form action="" method="post">
                  <label for="make-table">Напишите команды для создания таблицы здесь:</label><br>
                  <textarea name="tableRules" id="make-table" placeholder="CREATE TABLE `Имя вашей таблицы`(
                `id` mediumint NOT NULL auto_increment, // Очень рекомендуемое поле
                `title` varchar(255) NOT NULL, // Ещё какое-нибудь поле, например, название статьи
                PRIMARY KEY(id)
                )"></textarea>
                  <input class="mt-submit" name="submit" type="submit" value="Создать таблицу">
              </form>
        </div>
        <div class="table-list">
            <h1>Уже созданные таблицы</h1>
            <table>
              <tr>
                <th>Имя таблицы</th>
                <td></td>
              </tr>
              <?php foreach ($results as $row): ?>
                <tr>
                  <td class=""><a class="see-structure" href="one_table.php?tableName=<?= $row["Tables_in_lesson15_db"] ?>" title="Посмотреть структуру таблицы"><?= ucfirst($row["Tables_in_lesson15_db"]) ?></a></td>
                  <td class="actions pudum"><a class="delete-table" href="?tableName=<?= $row["Tables_in_lesson15_db"] ?>&action=drop" title="Дропнуть таблицу"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                </tr>
              <?php endforeach; ?>
            </table>
        </div>
    </div>
      <div class="offer">
          <p>Если вы хотите создавать таблицы в удобной админке-конструкторе, <a href="offer.html"> оформите подписку</a>.</p>
      </div>
  </div>

</body>
</html>


