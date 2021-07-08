<?php
namespace Finder\JavBus;
use PhpQuery\PhpQuery;
use Finder\Lyr;
const KEY_MAP = array(
  "識別碼:" => "Number",
	"發行日期:" => "PublishAt",
  "長度:" => "Length",
  "導演:" => "Director",
	"製作商:" => "Producer",
	"發行商:" => "Publisher",
	"系列:" => "Series",
);
const BASE_JAVBUS_URL = 'https://www.javbus.com';
class Parser {
  public function fetch_data($path) {
    return file_get_contents($path);
  }
  public function fetch_from_javbus($number) {
    return file_get_contents(BASE_JAVBUS_URL . '/' . $number);
  }
  public function parse($content) {
    $parseResult = new PhpQuery;
    $lyrObj = new Lyr();
    $parseResult -> load_str($content);
    // fetch Title and Cover
    $Title = $parseResult -> query('h3')[0]-> textContent;
    $Cover = $parseResult -> query(".movie .screencap .bigImage img")[0]->getAttribute('src');
    $lyrObj->Title= $Title;
    $lyrObj->Cover = BASE_JAVBUS_URL .''. $Cover;
    // fetch 
    foreach ($parseResult -> query(".movie .info p") as $item) {
      $size = $item -> childNodes -> length;
      $count = 0;
      $key = "";
      $value = "";
      $arrValue = array();
      foreach(($item -> childNodes) as $node) {
        // Skip Null Node
        if ($node == null) {
          continue;
        }
        $currentValue = trim($node -> textContent);
         // Skip Null Node
        if ($currentValue == "") {
          continue;
        }
         // Skip Unrelated Node
        if ($count >= $size) {
          continue;
        } 
        switch ($count) {
          case 0: // first Node as key
            $key = $currentValue;
            break;
          case 1: // second as first key
            $value = $currentValue;
            break;
          case 2: // value more than 2
            array_push($arrValue, $value, $currentValue);
            break;
          default:
            array_push($arrValue, $value);
        }
        $count = $count + 1; 
      }
      // map key to array
      if (array_key_exists($key, KEY_MAP)) {
        $result_value = $count == 2 ? $value: $arrValue;
        $currentKey = KEY_MAP[$key];
        $lyrObj-> $currentKey = $result_value;
      }
    }
    // fetch ScreenShots
    $ScreenShots = array();
    foreach ($parseResult -> query(".sample-box .photo-frame img") as $item2) {
      // var_dump($item2);
      if ($item2 !== null) {
        array_push($ScreenShots, BASE_JAVBUS_URL . '' . $item2->getAttribute('src'));
      }
    }
    $lyrObj->ScreenShots = $ScreenShots;
    return $lyrObj;
  }
  public function run_parser($number) {
    $content = $this -> fetch_from_javbus($number);
    return $this -> parse($content);
  }
}
?>