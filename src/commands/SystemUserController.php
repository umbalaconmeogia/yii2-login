<?php
namespace umbalaconmeogia\systemuser\commands;

use umbalaconmeogia\systemuser\models\SystemUser;
// use giannisdag\yii2CheckLoginAttempts\models\LoginAttempt;
use yii\console\Controller;

class SystemUserController extends Controller
{
    /**
     * @var array
     */
    protected $actionOptions = [
        'create' => [
            'username',
            'password',
            'email',
        ],
    ];

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $email;

    /**
     * {@inheritDoc}
     * @see \yii\console\Controller::options()
     */
    public function options($actionID)
    {
        $result = [];
        if (isset($this->actionOptions[$actionID])) {
            $result = $this->actionOptions[$actionID];
        }
        return $result;
    }

    /**
     * Syntax
     * php yii systemuser/system-user/hello
     */
    public function actionHello()
    {
        echo "Hello\n";
    }

    /**
     * Create new user
     *
     * Syntax
     * ```shell
     *   php yii systemuser/system-user/create --username=<username> --password=<password> --email=<email>
     * ```
     * If username is not set, email will be used as username.
     *
     * Example
     *   ```shell
     *     php yii systemuser/system-user/create --password=mypassword --email=thanhtt@example.com
     *   ```
     */
    public function actionCreate()
    {
        // Set email as username if username is not set.
        if (!$this->username && $this->email) {
            $this->username = $this->email;
        }
        SystemUser::getDb()->transaction(function() {
            SystemUser::createUser([
                'username' => $this->username,
                'password' => $this->password,
                'email' => $this->email,
            ]);
        });
        echo "DONE\n";
    }

    /**
     * After three times of login failure, user will be locked for a while.
     * To clear all user locking, run
     * ```shell
     * php yii user/clear-login-failure
     * ```
     * Syntax:
     *   php yii user/clear-login-failure
     */
    public function actionClearLoginFailure($username = NULL)
    {
        LoginAttempt::deleteAll();
        echo "DONE\n";
    }
}
