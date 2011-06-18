<?php
/**
*
* DESC : A small script that fetches the even semester 2011 results (SASTRA University)
* @author : Vignesh Rajagopalan
*
*
**/
    
  $regno = $_REQUEST['reg'];

  $ch = curl_init();
  curl_setopt ($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_URL, "http://www.sastra.edu/results2011/");
  curl_setopt($ch, CURLOPT_POSTFIELDS,       "__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=%2FwEPDwUJNjk1MjY5MDQ5D2QWAgIDD2QWBAIHDzwrAA8BAA8WBB4LXyFEYXRhQm91bmRnHgtfIUl0ZW1Db3VudGZkZAIJDw9kDxAWAWYWARYCHg5QYXJhbWV0ZXJWYWx1ZWUWAWZkZBgBBQxEZXRhaWxzVmlldzEPZ2S5uBAJbk20yOaYSK1hI892sR%2BNVA%3D%3D&__EVENTVALIDATION=%2FwEWAwL3xOupAgLs0bLrBgKM54rGBrse22jFhESkdm9A%2BcmrHsUeYK5F&TextBox1={$regno}&Button1=Submit");
  curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 (CK) Firefox/3.0.1");
  curl_setopt ($ch, CURLOPT_REFERER, "http://www.sastra.edu/results2011/");
  curl_setopt ($ch, CURLOPT_HEADER, false);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
  $string = curl_exec($ch);
  curl_close($ch);
  
?>
