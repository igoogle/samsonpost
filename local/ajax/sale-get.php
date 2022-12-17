<?

  /**
   * @var CUser $USER ;
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

  // Чтобы таблица не росла старые удалить записи старше 3 часов
  $result = $hsUserSales::getList([
    'filter' => [
      '<UF_DATE' => Bitrix\Main\Type\DateTime::createFromTimestamp(time() - 10800)
    ]
  ])->fetchAll();

  if (is_array($result) && count($result) > 0) {

    foreach ($result as $item) {
      $hsUserSales::delete($item['ID']);
    }

  }

  // Проверить есть ли у данного пользователя скидка, сгенерированная менее 1 часа
  $result = $hsUserSales::getList([
    'filter' => [
      '>UF_DATE' => Bitrix\Main\Type\DateTime::createFromTimestamp(time() - 3600),
      'UF_USER_ID' => $userId
    ]
  ])->fetch();

  if (is_array($result) && count($result) > 0) {

    $percent = $result['UF_PERCENT'];
    $code = $result['UF_CODE'];

  } else {

    // Случайная скидка от 1 до 50
    $percent = rand(1, 50);

    // Записать в HL
    $code = [
      0 => \Samsonpost\Main::saleCodeGenerate(4),
      2 => \Samsonpost\Main::saleCodeGenerate(4),
      4 => \Samsonpost\Main::saleCodeGenerate(4),
    ];

    $hsUserSales::add([
      'UF_DATE' => date('d.m.Y H:i:s'),
      'UF_USER_ID' => $userId,
      'UF_PERCENT' => $percent,
      'UF_CODE' => implode('-', $code)
    ]);

  }

  $message = $percent;

  echo json_encode([
    'status' => 'ok',
    'message' => 'Скидка: ' . $message . '%' . '<br />' . 'Код: ' . $code
  ]);