<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    //represent database table
    public static function tableName()
    {
        return 'user';
    }
    //defines validation rules
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            ['email', 'email'],//email must follow a valid email format.
            ['email', 'unique'],
        ];
    }

    //Finds a user by their email.
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    //Finds a user by their username.
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    //Finds a user by their ID.-for sessions
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    //Used for API authentication (e.g., via bearer token).
    public static function findIdentityByAccessToken($token, $type = null) 
    { 
        return null; 
    }
    //Returns the user’s ID.-for sessions
    public function getId() { return $this->id; }
    // Automattic login-cookies-remember me
    public function getAuthKey()
    {
        return $this->auth_key;
        //return '';
    }
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    //Compares the plain password input to the hashed password stored in the database.
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
