<?php

  /** @global CUser $USER */
  /** @global CMain $APPLICATION */

  /** @global string $mid */

  use Bitrix\Main\ArgumentException;
  use \Bitrix\Main\Loader as Loader;
  use \Bitrix\Main\LoaderException as LoaderException;
  use Bitrix\Main\ObjectPropertyException;
  use Bitrix\Main\Page\Asset;
  use Bitrix\Main\SystemException;

  if (!$USER->IsAdmin())
    return false;

  global $APPLICATION;

  const HL_SITE_CATALOG_CONTENT = 9;

  if (
  !($USER->CanDoOperation('fileman_edit_existent_folders')
    || $USER->CanDoOperation('fileman_admin_folders'))
  )
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

  $params = [
    'module-id' => "samsonpost"
  ];

  Loader::includeModule("fileman");
  Loader::includeModule("iblock");

  $request = \Bitrix\Main\HttpApplication::getInstance()->getContext()->getRequest();
  if ($request->getRequestMethod() === 'POST' && check_bitrix_sessid()) {

    // Тут весь $_POST
    $post = $request->getPostList()->toArray();

    if (isset($post['seo-counters']) && $post['seo-counters'])
      \Bitrix\Main\Config\Option::set($params['module-id'], 'seo-counters', $post['seo-counters']);

    if (isset($post['seo-counters-bottom']) && $post['seo-counters-bottom'])
      \Bitrix\Main\Config\Option::set($params['module-id'], 'seo-counters-bottom', $post['seo-counters-bottom']);

    LocalRedirect('/bitrix/admin/settings.php?mid=samsonpost&lang=ru');

  }

  $values['seo-counters'] = \Bitrix\Main\Config\Option::get($params['module-id'], "seo-counters");
  $values['seo-counters-bottom'] = \Bitrix\Main\Config\Option::get($params['module-id'], "seo-counters-bottom");

  $arIblocks = [];
  $res = CIBlock::GetList(
    array(),
    array(
      'TYPE' => 'aspro_next_catalog',
      'SITE_ID' => 'SE',
      'ACTIVE' => 'Y',
      "CNT_ACTIVE" => "Y",
    ), true
  );
  while ($ar_res = $res->Fetch()) {
    $arIblocks[] = $ar_res;
  }

  IncludeModuleLangFile(__FILE__);
?>

<?php

  $tabControl = new CAdminTabControl(
    'tabControl',
    [
      [
        'DIV' => 'mainConfig',
        'TAB' => "Обновление комплектов",
        'TITLE' => "Обновление комплектов из oData"
      ],
      [
        'DIV' => 'seoConfig',
        'TAB' => "SEO",
        'TITLE' => "SEO"
      ],
    ]
  );

  $tabControl->Begin();
?>

<form method="post"
      action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($mid) ?>&amp;lang=<? echo LANGUAGE_ID ?>"
      enctype="multipart/form-data"
>

  <?= bitrix_sessid_post(); ?>

  <?php $tabControl->BeginNextTab(); ?>
  <tr>
    <td class="admin-left-td--30">
      <label for="iblock-id-odata-set-update">Инфоблок:</label>
    </td>
    <td>

      <select name="iblock-id-list[]" title="">
        <? foreach ($arIblocks as $arIblock): ?>
          <option <? if ($arIblock['ID'] == 102): ?>selected=""<? endif; ?>
                  value="<?= $arIblock['ID']; ?>"><?= $arIblock['NAME']; ?></option>
        <? endforeach; ?>
      </select>

    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
      <input type="submit"
             name="iblock-items-update"
             value="Обновить"
             title=""
             class="adm-btn-save js-iblock-sets-btn-o-data"
      >
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div class="js-odata-status-box js-hidden"></div>
    </td>
  </tr>
  <?php $tabControl->EndTab(); ?>

  <?php $tabControl->BeginNextTab(); ?>

  <tr>
    <td>Счётчики в head</td>
    <td>
      <textarea name="seo-counters" id="" cols="60" rows="20" title=""><?= $values['seo-counters']; ?></textarea>
    </td>
  </tr>

  <tr>
    <td>Счётчики внизу сайта</td>
    <td>
      <textarea name="seo-counters-bottom" id="" cols="60" rows="20" title=""><?= $values['seo-counters-bottom']; ?></textarea>
    </td>
  </tr>

  <?php $tabControl->EndTab(); ?>

  <?php $tabControl->Buttons(); ?>

  <input type="submit" name="save"
         value="Сохранить"
         title="Сохранить"
         class="adm-btn-save"/>

  <? $tabControl->End(); ?>
</form>

<style>
    .admin-left-td--30 {
        width: 30%;
    }

    .js-odata-status-box {
        font-size: 13px;
        display: block;
        font-family: monospace;
        white-space: pre;
        margin: 1em 0;
    }

    .text-error {
        color: #ff0000;
    }
</style>