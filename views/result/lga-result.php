<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<?php
// echo "<pre>";
// print_r($parties);
// echo "</pre>";
?>
<h2>LGA Total Result</h2>

<?php $form = ActiveForm::begin(); ?>

<div style="display: flex; gap: 10px; align-items: center;">
    <?= Html::dropDownList('lga_id', $selectedLgaId,
        ArrayHelper::map($lgas, 'lga_id', 'lga_name'),
        ['prompt' => 'Select a Local Government']
    ) ?>

    <?= Html::submitButton('Show Result', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php if ($selectedLgaId): ?>
    <h2>Polling Unit Results</h2>

    <table border="1" cellpadding="7" cellspacing="3">
        <thead>
            <tr>
                <th>Polling Unit</th>
                <?php foreach ($parties as $party): ?>
                    <th><?= Html::encode($party) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
<?php
$partyTotals = array_fill_keys($parties, 0);
?>

<?php foreach ($results as $item): ?>
    <tr>
        <td><?= Html::encode($item['polling_unit_name']) ?> (<?= Html::encode($item['unit_id']) ?>)</td>
        <?php foreach ($parties as $party): ?>
            <?php
            $score = $item['results'][$party] ?? 0;
            $partyTotals[$party] += $score;
            ?>
            <td><?= $score ?></td>
        <?php endforeach; ?>
    </tr>
<?php endforeach; ?>

<!-- Total Row -->
<tr style="font-weight: bold; background-color: #f0f0f0;">
    <td>Total</td>
    <?php foreach ($partyTotals as $score): ?>
        <td><?= $score ?></td>
    <?php endforeach; ?>
</tr>
</tbody>

    </table>
<?php endif; ?>
