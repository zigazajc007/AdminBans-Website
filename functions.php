<?php

function chatColor($text){

    if (strpos($text, '&') !== false) {
      $text = str_replace('&0', "<strong style='color: #000;'>", $text);
      $text = str_replace('&1', "<strong style='color: #00A;'>", $text);
      $text = str_replace('&2', "<strong style='color: #0A0;'>", $text);
      $text = str_replace('&3', "<strong style='color: #0AA;'>", $text);
      $text = str_replace('&4', "<strong style='color: #A00;'>", $text);
      $text = str_replace('&5', "<strong style='color: #A0A;'>", $text);
      $text = str_replace('&6', "<strong style='color: #FA0;'>", $text);
      $text = str_replace('&7', "<strong style='color: #AAA;'>", $text);
      $text = str_replace('&8', "<strong style='color: #555;'>", $text);
      $text = str_replace('&9', "<strong style='color: #55F;'>", $text);
      $text = str_replace('&a', "<strong style='color: #5F5;'>", $text);
      $text = str_replace('&b', "<strong style='color: #5FF;'>", $text);
      $text = str_replace('&c', "<strong style='color: #F55;'>", $text);
      $text = str_replace('&d', "<strong style='color: #F5F;'>", $text);
      $text = str_replace('&e', "<strong style='color: #FF5;'>", $text);
      $text = str_replace('&f', "<strong style='color: #FFF;'>", $text);
      $text = str_replace('&g', "<strong style='color: #DDD605;'>", $text);

      $text = str_replace('&k', "", $text);
      $text = str_replace('&l', "", $text);
      $text = str_replace('&m', "", $text);
      $text = str_replace('&n', "", $text);
      $text = str_replace('&o', "", $text);
      $text = str_replace('&r', "", $text);
    }
    return $text;
}

?>
