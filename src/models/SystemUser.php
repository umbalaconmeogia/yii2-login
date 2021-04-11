<?php
namespace umbalaconmeogia\systemuser\models;

/**
 * Wrapper of User class.
 *
 * Because User is copied from yii2 source code, we try to keep it as original one.
 * All additional code will be added to SystemUser.
 */
class SystemUser extends User
{

    /**
     * Create new user. This is used for import data.
     * @param array $config Should contain at least key 'username'.
     *                      Another key is password, email.
     * @return User
     */
    public static function createUser($config)
    {
        $username = $config['username'];
        $user = self::findOneCreateNew(['username' => $username]);
        foreach ($config as $attribute => $value) {
            if ($value) {
                $user->$attribute = $value;
            }
        }

        if (!$user->id) {
            $user->initiateUser();
        }
        $user->saveThrowError();
        return $user;
    }

    public function initiateUser()
    {
        if (!$this->password) {
            $this->password_hash = HRandom::generateRandomString(8);
        }
        $this->status = self::STATUS_ACTIVE;
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();
    }

    /**
     * Temporaryly store password for password getter/setter.
     * @var string
     */
    private $_password;

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        if ($password) {
            $this->_password = $password;
            parent::setPassword($password);
        }
    }

    /**
     * Get password (only possible in same PHP process that set password before).
     */
    public function getPassword()
    {
        return $this->_password;
    }
}
