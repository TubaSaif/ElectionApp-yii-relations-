<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<div class="form-container">
    <h2>Login</h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn']) ?>
    </div>

    <p>Don't have an account? <?= Html::a('Register here', ['auth/register']) ?></p>

    <?php ActiveForm::end(); ?>
</div>
