<?php

function debug($par){
  echo '<pre>';
  print_r($par); 
  echo '</pre>'; 
}

class Calc {

  protected function processArr($arr) {
    $index = array_search('+', $arr);
    if($index) {
      array_splice($arr, $index, 1, ' '. $arr[$index]);
      return $arr;
    } 
    $index = array_search('-', $arr);
    if ($index > 0) {
      array_splice($arr, $index, 1, ' '. $arr[$index]);
      return $arr;
    }
    if($index === 0) {
      array_shift($arr);
      $index = array_search('-', $arr);
      array_splice($arr, $index, 1, ' '. $arr[$index]);
      array_unshift($arr, '-');
      return $arr;
    }
    return false;
  }

  protected function checkEnter($a, $b) :array {
    $a = trim($a);
    $b = trim($b);
    $arr = [$a, $b];
    $imp_arr = [];
    foreach($arr as $k) {
      if(preg_match("@^\(\-?\d+[+,-]\d+i\)$@i", $k)) {
        $k = trim($k, "()");
        $k = str_split($k);
        $imp_arr[] = implode($this->processArr($k));
      } else {
        echo 'Проверьте введенные данные!';
        die;
      }
    }
    $array_x = [];
    $array_y = [];
    foreach($imp_arr as $k) {
      $x = explode(' ', $k);
      $y = explode('i', $x[1]);
      $x = intval($x[0]);
      $y = intval($y[0]);
      $array_x[] = $x;
      $array_y[] = $y;
    }
    $arr = compact('array_x', 'array_y');
    return $arr;
  }

  protected function result($res_x, $res_y) :string {
    if($res_y !== 0){
      $res_y = $res_y . 'i';
    } elseif ($res_y === 0) {
      $res_y = '';
    }
    if($res_x === 0){
      $res_x = '';
    }
    $res = $res_x . $res_y;
    if($res == 0){
      $res = 0;
    }
    return $res;
  }

  public function sum($a, $b) :string {
    extract($this->checkEnter($a, $b));
    $res_x = array_sum($array_x);
    $res_y = array_sum($array_y);
    $res = $this->result($res_x, $res_y);
    return $res;
  }

  public function subtract($a, $b) :string {
    extract($this->checkEnter($a, $b));
    $x = 2*$array_x[0];
    $y = 2*$array_y[0];
    foreach($array_x as $k){
      $x = $x - $k;
    }
    foreach($array_y as $k){
      $y = $y - $k;
    }
    $res_x = $x;
    $res_y = $y;
    $res = $this->result($res_x, $res_y);
    return $res;
  }

  public function multiply($a, $b) :string {
    extract($this->checkEnter($a, $b));
    $res_x = $array_x[0] * $array_x[1] - $array_y[0]*$array_y[1];
    $res_y = $array_x[0] * $array_y[1] + $array_y[0]*$array_x[1];
    $res = $this->result($res_x, $res_y);
    return $res;
  }

  public function divide($a, $b) :string {
    extract($this->checkEnter($a, $b));
    $divider = pow($array_x[1], 2) + pow($array_y[1], 2);
    if($divider === 0) {
      $divider = 1;
    }
    $res_x = ($array_x[0]*$array_x[1] + $array_y[0]*$array_y[1]) / $divider;
    $res_y = ($array_y[0]*$array_x[1] - $array_x[0]*$array_y[1]) / $divider;
    $res = $this->result($res_x, $res_y);
    return $res;
  }
}
