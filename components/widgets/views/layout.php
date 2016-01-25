<?php
use \common\models\Protocol;
use \common\models\ParamValue;
use \common\models\Auctions;
use components\helpers\DateTimeHelper;
use \common\models\Lots;

/**
 * @var $protocol \common\models\Protocol
 * @var $type
 */
?>

<!DOCTYPE HTML>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
</head>
<body>
<table cellpadding="7" valign="middle">
    <tr>
        <td><img class="logo" src="data:image/jpeg;base64,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"/></td>
        <td style="text-align: right;"><h1>Протокол №<?= $data['protocol_id']; ?></h1></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; font-size: 14px;">
            Электронные торги по продаже лота №<?= $data['lot_id'] ?>
            <strong><?=$data['status']; ?></strong>
        </td>
    </tr>
    <tr style="margin-top: 10px;">
        <td width="230">Товар:</td>
        <td style="text-transform: uppercase; font-weight: bold;"><?= $data['product_name']; ?></td>
    </tr>
    <tr>
        <td>Дата / время<br>окончания торгов:</td>
        <td><?= $data['end_auction']; ?></td>
    </tr>

    <?=$content; ?>

    <tr>
        <td>Организатор торгов:</td>
        <td><?=$protocol->organizer->ettd_name;?></td>
    </tr>
    <tr>
        <td>Продавец товара:</td>
        <td><?=$protocol->trader->ettd_name;?><br>Email - <?=$protocol->trader->ettd_email;?><br>Контактный номер телефона - <?=$protocol->trader->getParam('PR_ORGANIZER_PHONE');?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <?php if($this->data['algorithm'] == Auctions::ALGORITHM_STANDARD && $type == Protocol::TYPE_FINISHED_WITH_NAME): ?>
        <tr>
            <td colspan="2" style="font-size: 12px;">
                Для осуществления процедуры оплаты полной стоимости товара и его передачи
                с Вами свяжется наш представитель по номеру телефона, указанному в Вашем профиле.
            </td>
        </tr>
    <?php endif; ?>

    <tr>
        <td colspan="2" style="font-size: 12px;">
            Протокол №<?= $data['protocol_id']; ?> о реализации лота №<?= $data['lot_number'] ?>
            "<?=$data['product_name']; ?>" сформирован <?= $data['date_create']; ?>
            &copy; <span><?=$data['org_name']; ?>, <?= date("Y", time()); ?></span>
        </td>
    </tr>
    <?php if($type == Protocol::TYPE_FINISHED_WITH_NAME): ?>
        <tr>
            <td style="text-align: left; font-size: 12px; font-weight: bold;">Победитель: <?=$this->data['full_name']; ?></td>
            <td style="text-align: left; font-size: 12px; font-weight: bold;">_________________________________________________________</td>
        </tr>
        <tr>
            <td style="text-align: left; font-size: 12px; font-weight: bold;">Организатор: <?=$data['org_name']; ?></td>
            <td style="text-align: left; font-size: 12px; font-weight: bold;">__________________________________________________________</td>
        </tr>
    <?php endif; ?>
</table>
</body>
</html>

