<?

  /**
   * @var $arResult
   */

  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

?>

<div class="row">
  <div class="col-sm-6">

    <h4>Получить скидку</h4>

    <form class="js-sale-get">
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Получить скидку"/>
      </div>
    </form>
    <div class="js-sale-result-box js-hidden"></div>

  </div>
  <div class="col-sm-6">

    <h4>Проверить скидку</h4>

    <form class="js-sale-check">
      <div class="form-group">
        <input type="text" name="code" class="form-control" placeholder="Введите код" title=""/>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Проверить скидку"/>
      </div>
    </form>
    <div class="js-sale-check-box js-hidden"></div>

  </div>
</div>



