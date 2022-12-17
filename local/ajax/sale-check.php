<?

  /**
   * @var CUser $USER;
   */

  require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

  if(!$USER->IsAuthorized()) {

    echo json_encode([
      'status' => 'error',
      'message' => 'Вы не авторизованы'
    ]);
    die();

  }

  \Bitrix\Main\Loader::includeModule('samsonpost');

  $hsUserSales = Samsonpost\Main::getEntityHLClass(
    Samsonpost\Main::HL_USER_SALES_ID
  );

  $userId = $USER->GetID();

  $arRequest = Bitrix\Main\Context::getCurrent()->getRequest()->toArray();

  // Чтобы таблица не росла старые удалить записи старше 3 часов
  // Заодно это решит часть задачи
  $result = $hsUserSales::getList([
    'filter' => [
      '<UF_DATE' => Bitrix\Main\Type\DateTime::createFromTimestamp(time() - 10800)
    ]
  ])->fetchAll();

  if(is_array($result) && count($result) > 0)
    foreach($result as $item)
      $hsUserSales::delete($item['ID']);

  // Проверить есть ли у данного пользователя скидка
  $result = $hsUserSales::getList([
    'filter' => [
      'UF_USER_ID' => $userId,
      'UF_CODE' => htmlspecialcharsbx($arRequest['code'])
    ]
  ])->fetch();

  if(is_array($result) && count($result) > 0) {

    echo json_encode([
      'status' => 'ok',
      'message' => 'Ваша сидка: ' . $result['UF_PERCENT'] . '%'
    ]);

  } else {

    echo json_encode([
      'status' => 'ok',
      'message' => 'Скидка недоступна'
    ]);

  }