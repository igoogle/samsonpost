<?

  namespace Samsonpost;

  use Bitrix\Highloadblock\HighloadBlockTable;
  use Bitrix\Main\Loader;

  class Main
  {

    const HL_USER_SALES_ID = 4;

    public static function getEntityHLClass($hlId)
    {

      Loader::includeModule("highloadblock");
      $hlBlock = HighloadBlockTable::getById($hlId)->fetch();
      $entity = HighloadBlockTable::compileEntity($hlBlock);
      return $entity->getDataClass();

    }

    public static function saleCodeGenerate($length)
    {

      $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
      for ($i = 0; $i < $length; $i++) {
        $n = rand(0, strlen($alphabet) - 1);
        $code[$i] = $alphabet[$n];
      }
      return implode($code);

    }

  }