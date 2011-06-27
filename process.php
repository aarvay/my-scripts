<?php
/**
*
* The Main Processing Happens here!
* @author: Vignesh Rajagopalan (@Aarvay)
*
**/
  
  error_reporting (E_ALL ^ E_NOTICE);
  
  global $rankings;
  $rankings = array();
  
  function fetchWords($uid) {
    global $facebook;
    $feeds = $facebook->api('/'.$uid.'/feed?access_token={$token}&limit=10');
    $feeds = $feeds['data'];
    
    $words = "random content..";
    foreach($feeds as $feed){
      if($feed['from']['id'] == $uid){
        $words = $words." ".$feed['message'];
      }
    }
    return $words;
  }
  
  function parsify($data, $uid, $key) {
    global $rankings;
    $index = array();
    $find = array('/\r/', '/\n/', '/\s\s+/');
    $replace = array(' ', ' ', ' ');
    
    $data = file_get_contents($data);
    $data = preg_replace('/[>][<]/', '> <', $data);
    $data = strip_tags($data);
    $data = strtolower($data);
    $data = preg_replace($find, $replace, $data);
    $data = trim($data);
    $data = explode(' ', $data);
    natcasesort($data);
    
    $i = 0;
    foreach($data as $word) {
      $word = trim($word);
      $junk = preg_match('/[^a-zA-Z]/', $word);
      if($junk == 1) {
        $word = '';
      }
      if( (!empty($word)) && ($word != '') ) {
        if(!isset($index[$i]['word'])) { // notset => new index
          $index[$i]['word'] = $word;
          $index[$i]['count'] = 1;
        } 
        elseif( $index[$i]['word'] == $word ) {  // count repeats
          $index[$i]['count'] += 1;
        } 
        else { // else this is a different word, increment $i and create an entry
          $i++;
          $index[$i]['word'] = $word;
          $index[$i]['count'] = 1;
        }
      }
    }
    //print_r($index);
    $rank = count($index);
    $rankings[$key]['id'] = $uid;
    $rankings[$key]['rank'] = $rank; 
  } 
  
  function computeRankings() {
    global $user;
    global $rankings;
    global $facebook;
    $friends = null;
    $friends = $facebook->api('me/friends');
    $friends = $friends['data'];
    $key=0;
    //print_r($friends);
    foreach($friends as $friend) {
      $postData = fetchWords($friend['id']);
      $file = 'data/'.$user['id'].'.txt';
      $fp = fopen($file, 'w');
      fwrite($fp, $postData);
      fclose($fp);
      parsify($file, $friend['id'], $key);
      $key++;
    }
    $file = 'data/'.$user['id'].'_rank.txt';
    $fp = fopen($file, 'w');
    fwrite($fp, $postData);
    fclose($fp);
  }
?>
