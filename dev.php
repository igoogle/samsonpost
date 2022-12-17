<?

  /**
   * @var CMain $APPLICATION;
   */

  require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
  $APPLICATION->SetTitle("Скидки");
?>

<?
  $APPLICATION->IncludeComponent("samsonpost:sale.get", "", Array());
?>

<?
  require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>