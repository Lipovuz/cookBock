<?php

namespace app\models;

use yii\base\Model;
use app\models\User;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $name
 * @property string $email
 * @property int $tel
 * @property string $img
 * @property int $status
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $name;
    public $email;


    public function rules()
    {
        return [
            [['username','name','email'],'trim'],
            [['username','password','name','email'],'required'],
            ['username','unique','targetClass'=>'\app\models\User','message'=>'Данне ім\'я користувача вже використовується.'],
            ['username','string','min'=>2,'max'=>255],
            ['email','email'],
            ['email','string','max'=>255],
            ['email','unique','targetClass'=>'\app\models\User','message'=>'Данний E-mail вже використовується.'],
            ['name','string','min'=>5,'max'=>255],
            ['password','string','min'=>6,'max'=>255]
        ];
    }

    public function signup(){
        if (!$this->validate()){
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = 'user';
        $user->generateAuthKey();
        return $user->save() ? $user:null;
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Nickname',
            'password' => 'Пароль',
            'name' => 'ПІБ',
            'email' => 'E-mail',
        ];
    }
}
