<?php

namespace app\models;

use app\models\Users as TUsers;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id_user;
    public $email;
    public $password;
    public $fullname;
    public $phone;
    public $joindate;
    public $role;
    public $active;
    public $authKey;
    public $accessToken;

	const ROLE_USER = 3;
	const ROLE_MODERATOR = 2;
	const ROLE_ADMIN = 1;


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id_user)
    {
        $TableUsers = TUsers::find()->where(["id_user"=>$id_user])->one();
        if(!count([$TableUsers])) {
            return null;
        }
        return new static($TableUsers);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
         $TableUsers = TUsers::find()->where(["accessToken"=>$token])->one();
        if(!count([$TableUsers])) {
            return null;
        }
        return new static($TableUsers);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($email)
    {
       $TableUsers = TUsers::find()->where(["email"=>$email,'active'=>'1'])->one();
        if(!count([$TableUsers])) {
            return null;
        }
        return new static($TableUsers); 
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id_user;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
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
        return $this->password === bin2hex($password);
    }
}
