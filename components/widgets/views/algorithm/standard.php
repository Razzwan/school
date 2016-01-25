<?php
use \common\models\Protocol;
/**@var array $data*/
?>

<tr>
    <td>Победитель:</td>
    <td>
        <strong>
            Участник <?= $data['participant_number'] ?>
            <?php if($data['type_protocol'] == Protocol::TYPE_FINISHED_WITH_NAME): ?>
                :<br><?= $data['full_name']; ?>
            <?php endif; ?>
        </strong>
    </td>
</tr>
<tr>
    <td>Причина <br>победы:</td>
    <td class="first-letter"><?= $data['reason']; ?></td>
</tr>
<tr>
    <td>Стартовая цена:</td>
    <td><?= $data['start_price']; ?> грн.</td>
</tr>
<tr>
    <td>Цена продажи:</td>
    <td style="font-weight: bold;"><?=$data['price']; ?> грн.</td>
</tr>
<tr>
    <td>Уже оплачено:</td>
    <td><?= $data['paid']; ?> грн.</td>
</tr>
<tr>
    <td>Необходимо<br>дополнительно<br>оплатить:</td>
    <td style="font-weight: bold;"><?=$data['need_pay']?> грн.</td>
</tr>
<tr>
    <td>Реквизиты для оплаты:</td>
    <td>
        Получатель: <?= $data['pay_name']; ?><br>
        Счет получателя: <?= $data['pay_account']; ?><br>
        Код получателя (ЕГРПОУ): <?= $data['pay_recipient']; ?><br>
        Банк получателя: <?= $data['pay_bank']; ?><br>
        Код банка получателя (код МФО): <?= $data['pay_mfo']; ?><br>
        Назначение платежа: <?= $data['pay_purpose']; ?><br>
    </td>
</tr>