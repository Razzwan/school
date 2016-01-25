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
    <td>Цена продажи:</td>
    <td style="font-weight: bold;"><?= $data['price']; ?> грн.</td>
</tr>