<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    public function login()
    {
        $user = User::findByEmail($this->email);
        if ($user && $user->validatePassword($this->password)) {
            return Yii::$app->user->login($user);
        }
        $this->addError('password', 'Invalid email or password');
        return false;
    }
}
