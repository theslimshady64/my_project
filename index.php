<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,
  initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <form method='post'>
    <textarea rows="10" cols="45" name="text"></textarea><br/>
    <button type="submit" name="submit">Отправить</button>
  </form>
</body>
</html>

<?php
  if(isset($_POST['submit'])) {
    class uniqueAdjectives {
      public $text;
      //Функция получения массива слов из текста
      function getWords($text) {
        if (preg_match_all("/\b(\w+)\b/ui", $text, $matches)) {
            return $matches[1];
        }
        return array();
      }
      //Функция получения прилагательных
      function getAdjectives($array){
        $arrayEnding = array('ный', 'ная', 'ное');
        mb_internal_encoding("UTF-8");
        foreach ($array as $value) {
          if(in_array(mb_substr($value, -3), $arrayEnding)){
            $adjectives[] = $value;
          };
        };
        return $adjectives;
      }
      //Функция удаления повторяющихся элементов
      function getUniqueObj($array) {
          $array = array_values(array_unique($array));
          return $array;
      }
    }

    $text = htmlspecialchars($_POST['text']);
    $uniqueAdjObj = new uniqueAdjectives();
    $getWordsResult = $uniqueAdjObj->getWords($text);
    $getAdjectivesResult = $uniqueAdjObj->getAdjectives($getWordsResult);
    $getUniqueObj = $uniqueAdjObj->getUniqueObj($getAdjectivesResult);

    //Создание массива объектов
    foreach ($getUniqueObj as $key => $value) {
        $object[] = new stdClass();
        $object[$key]->adjective = $value;
    }

    echo "<pre>";print_r($object);echo "</pre>";
  }

?>
