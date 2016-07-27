<?php

class Crypt
{
  private static $private;

  function __construct ( $private_key )
  {
    self::$private = $private_key;
  }

  private static function CryptFunction ( $data )
  {
    $array = [];

    for ( $i=0, $k=0; $i<=strlen($data); $i+=3, $k++ )
    {
      $row = mb_substr($data, $i, 3);
      $array[$k] = strrev($row);
    }

    return implode($array);
  }

  public function _crypt ( $data )
  {
    self::$private = md5(self::$private);
    $size = strlen(md5(self::$private));
    $point = $size/2;

    if( is_int($point) )
    {
      $st = mb_substr(self::$private, 0, $point, 'utf-8');
      $nd = mb_substr(self::$private, $point, $size, 'utf-8');
    }
    else
    {
      $st = mb_substr(self::$private, 0, $point-0.5, 'utf-8');
      $nd = mb_substr(self::$private, 0, $point+0.5, 'utf-8');
    }
    return self::CryptFunction(strrev(base64_encode($st.htmlentities($data).$nd)));
  }

  public function _decrypt ( $data )
  {
    self::$private = md5(self::$private);
    $size = strlen(self::$private);
    $point = $size/2;

    $result = base64_decode(strrev(self::CryptFunction($data)));
    if( is_int($point) )
    {
      $result = substr($result, $point);
      $result = substr($result, 0, -($point));
    }
    else
    {
      $result = substr($result, $point-0.5);
      $result = substr($result, 0, -($point+0.5));
    }
    return $result;
  }

  public function password ($password)
  {
    $size = strlen(self::$private);
    $point = $size/2;

    if( is_int($point) )
    {
      $st = mb_substr(self::$private, 0, $point, 'utf-8');
      $nd = mb_substr(self::$private, $point, $size, 'utf-8');
    }
    else
    {
      $st = mb_substr(self::$private, 0, $point-0.5, 'utf-8');
      $nd = mb_substr(self::$private, 0, $point+0.5, 'utf-8');
    }
    return md5(sha1($st.htmlentities($password).$nd));
  }
}

?>
