<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 31.10.2018
 * Time: 03:28
 */

function redirect($to)
{
    header("Location: ".$to);
}

if(!function_exists('str_split')){
  function str_split($string,$len = 1) {
        if ($len < 1) return false;
    for($i=0, $rt = Array();$i<ceil(strlen($string)/$len);$i++)
      $rt[$i] = substr($string, $len*$i, $len);
    return($rt);
  }
}

$slowa = Array(
  'minus',

  Array(
    'zero',
    'jeden',
    'dwa',
    'trzy',
    'cztery',
    'pięć',
    'sześć',
    'siedem',
    'osiem',
    'dziewięć'),

  Array(
    'dziesięć',
    'jedenaście',
    'dwanaście',
    'trzynaście',
    'czternaście',
    'piętnaście',
    'szesnaście',
    'siedemnaście',
    'osiemnaście',
    'dziewiętnaście'),

  Array(
    'dziesięć',
    'dwadzieścia',
    'trzydzieści',
    'czterdzieści',
    'pięćdziesiąt',
    'sześćdziesiąt',
    'siedemdziesiąt',
    'osiemdziesiąt',
    'dziewięćdziesiąt'),

  Array(
    'sto',
    'dwieście',
    'trzysta',
    'czterysta',
    'pięćset',
    'sześćset',
    'siedemset',
    'osiemset',
    'dziewięćset'),

  Array(
    'tysiąc',
    'tysiące',
    'tysięcy'),

  Array(
    'milion',
    'miliony',
    'milionów'),

  Array(
    'miliard',
    'miliardy',
    'miliardów'),

  Array(
    'bilion',
    'biliony',
    'bilionów'),

  Array(
    'biliard',
    'biliardy',
    'biliardów'),

  Array(
    'trylion',
    'tryliony',
    'trylionów'),

  Array(
    'tryliard',
    'tryliardy',
    'tryliardów'),

  Array(
    'kwadrylion',
    'kwadryliony',
    'kwadrylionów'),

  Array(
    'kwintylion',
    'kwintyliony',
    'kwintylionów'),

  Array(
    'sekstylion',
    'sekstyliony',
    'sekstylionów'),

  Array(
    'septylion',
    'septyliony',
    'septylionów'),

  Array(
    'oktylion',
    'oktyliony',
    'oktylionów'),

  Array(
    'nonylion',
    'nonyliony',
    'nonylionów'),

  Array(
    'decylion',
    'decyliony',
    'decylionów')
);

function odmiana($odmiany, $int){ // $odmiany = Array('jeden','dwa','pięć')
  $txt = $odmiany[2];
  if ($int == 1) $txt = $odmiany[0];
  $jednosci = (int) substr($int,-1);
  $reszta = $int % 100;
  if (($jednosci > 1 && $jednosci < 5) &! ($reszta > 10 && $reszta < 20))
    $txt = $odmiany[1];
  return $txt;
}

function liczba($int){ // odmiana dla liczb < 1000
  global $slowa;
  $wynik = '';
  $j = abs((int) $int);

  if ($j == 0) return $slowa[1][0];
  $jednosci = $j % 10;
  $dziesiatki = ($j % 100 - $jednosci) / 10;
  $setki = ($j - $dziesiatki*10 - $jednosci) / 100;

  if ($setki > 0) $wynik .= $slowa[4][$setki-1].' ';

  if ($dziesiatki > 0)
        if ($dziesiatki == 1) $wynik .= $slowa[2][$jednosci].' ';
  else
    $wynik .= $slowa[3][$dziesiatki-1].' ';

  if ($jednosci > 0 && $dziesiatki != 1) $wynik .= $slowa[1][$jednosci].' ';
  return $wynik;
}

function slownie($int){

  global $slowa;

  $in = preg_replace('/[^-\d]+/','',$int);
  $out = '';

  if ($in{0} == '-'){
    $in = substr($in, 1);
    $out = $slowa[0].' ';
  }

  $txt = str_split(strrev($in), 3);

  if ($in == 0) $out = $slowa[1][0].' ';

  for ($i = count($txt) - 1; $i >= 0; $i--){
    $liczba = (int) strrev($txt[$i]);
    if ($liczba > 0)
      if ($i == 0)
        $out .= liczba($liczba).' ';
          else
        $out .= ($liczba > 1 ? liczba($liczba).' ' : '')
          .odmiana( $slowa[4 + $i], $liczba).' ';
  }
  return trim($out);
}
function kwotaslownie($kwota){
  $kwota = explode('.', $kwota);

  $zl = preg_replace('/[^-\d]+/','', $kwota[0]);
  $gr = preg_replace('/[^\d]+/','', substr(isset($kwota[1]) ? $kwota[1] : 0, 0, 2));
  while(strlen($gr) < 2) $gr .= '0';

  return slownie($zl) . ' ' . odmiana(Array('złoty', 'złote', 'złotych'), $zl) .
      (intval($gr) == 0 ? '' :
      ' ' . slownie($gr) . ' ' . odmiana(Array('grosz', 'grosze', 'groszy'), $gr));
}


