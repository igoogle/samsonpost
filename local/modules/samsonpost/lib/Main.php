<?php

  namespace Samsonpost;

  use Bitrix\Highloadblock\HighloadBlockTable;
  use Bitrix\Main\Loader;
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  class Main
  {

    public static function getEntityHLClass($hlId)
    {

      Loader::includeModule("highloadblock");
      $hlBlock = HighloadBlockTable::getById($hlId)->fetch();
      $entity = HighloadBlockTable::compileEntity($hlBlock);
      return $entity->getDataClass();

    }

    public static function getOnlyDigits($string)
    {
      return preg_replace("/[^0-9]/", '', $string);
    }

    public static function passwordGenerate($length)
    {

      $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
      for ($i = 0; $i < $length; $i++) {
        $n = rand(0, strlen($alphabet) - 1);
        $pass[$i] = $alphabet[$n];
      }
      return implode($pass);

    }

    public static function passwordGenerate__digits($length)
    {

      $alphabet = "123456789";
      for ($i = 0; $i < $length; $i++) {
        $n = rand(0, strlen($alphabet) - 1);
        $pass[$i] = $alphabet[$n];
      }
      return implode($pass);

    }

  }
