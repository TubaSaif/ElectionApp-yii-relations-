<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Register';
?>

<div class="form-container">
    <h2>Register</h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Register', ['class' => 'btn']) ?>
    </div>

    <p>Already have an account? <?= Html::a('Login here', ['auth/login']) ?></p>

    <?php ActiveForm::end(); ?>
</div>
