<?php use yii\helpers\Html; ?>
<h2>Polling Unit Result</h2>

<?= Html::beginForm(); ?>
<?= Html::dropDownList('polling_unit_uniqueid', $selectedUnitId,
    \yii\helpers\ArrayHelper::map($units, 'uniqueid', 'polling_unit_name'),
    ['prompt' => 'Select a Polling Unit']
) ?>
<br><br>
<?= Html::submitButton('Show Result', ['class' => 'btn btn-primary']) ?>
<?= Html::endForm(); ?>

<?php if ($results): ?>
    <h3>Results:</h3>
    <table class="table table-bordered">
        <tr>
            <th>Party</th>
            <th>Score</th>
        </tr>
        <?php foreach ($results as $result): ?>
            <tr>
                <td><?= Html::encode($result->party_abbreviation) ?></td>
                <td><?= Html::encode($result->party_score) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h3>No Result found on your selection</h3>   
<?php endif; ?>
