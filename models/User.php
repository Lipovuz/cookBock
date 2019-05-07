<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $name
 * @property string $email
 * @property int $tel
 * @property string $img
 * @property string $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Recipe[] $recipe
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_WORKED = 5;
    const STATUS_ACTIVE = 10;
    public $defaultRole = 'user';


    public static function tableName()
    {
        return '{{%users}}';
    }
    
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Активний',
            self::STATUS_WORKED => 'Модерація',
        ];
    }

    public function getRecipe()
    {
        return $this->hasMany(Recipe::className(),['id'=>'user_id']);
    }

    public  function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password', 'name', 'email'], 'required'],
            [['tel', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password', 'password_reset_token', 'auth_key', 'name', 'email', 'img'], 'string', 'max' => 255],
            [['role','tel'], 'string', 'max' => 10],
            ['role', 'string', 'max' => 64],
            [['img'], 'file', 'extensions' => 'png, jpg'],
            ['status','default','value'=> self::STATUS_WORKED],
            ['status','in','range' => [self::STATUS_ACTIVE, self::STATUS_WORKED]],
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status'=> self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
       throw  new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username'=>$username, 'status'=>self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)){
            return null;
        }
        return static::findOne([
            'password_reset_token'=>$token,
            'status'=>self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)){
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token,'_')+1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email'=>$email, 'status'=>self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password,$this->password);
    }

    public function  setPassword ($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey ()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'name' => 'Назва',
            'email' => 'Email',
            'tel' => 'Телефон',
            'img' => 'Фото',
            'role' => 'Роль',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
