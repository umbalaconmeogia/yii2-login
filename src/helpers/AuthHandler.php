<?php
namespace umbalaconmeogia\systemuser\helpers;

use umbalaconmeogia\systemuser\models\Auth;
use umbalaconmeogia\systemuser\models\SystemUser as User;
use Yii;
use yii\authclient\ClientInterface;

class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();

        // Check if Google authentication registered.
        /** @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) { // If not logged in
            $user = NULL;
            if ($auth) { // If Google account registered, then login corresponding user.
                $user = $auth->user;
            } else { // Register Auth for an existing user.
                $email = $this->getGoogleUserEmail($attributes);
                Yii::debug("Email $email");
                $user = User::findByUsername($email);
                Yii::debug("SystemUser " . print_r($user, TRUE));
                if (!$user) {
                    $this->setFlashError("User $email is not allowed to login");
                } else {
                    if (!$this->createAuth($user->id, $this->client)) {
                        $user = NULL; // Not login user.
                        $this->setFlashError('Error creating Auth');
                    }
                }
            }
            // Login user if success.
            if ($user) {
                Yii::$app->user->login($user);
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider if not registered.
                $this->createAuth(Yii::$app->user->id, $this->client);
            }
        }
    }

    /**
     * Get email from user attributes of Google Authentication client.
     * Google client return email in "emails" array.
     * @param array $attributes
     * @return string May be null if does not exist.
     */
    private function getGoogleUserEmail($attributes)
    {
        $result = NULL;
        if (isset($attributes['email'])) {
            $result = $attributes['email'];
        }
        return $result;
    }

    /**
     * Create an Auth object, and save it into DB.
     * @param int $userId
     * @param yii\authclient\ClientInterface $client
     * @return boolean Result of Auth#save()
     */
    private function createAuth($userId, $client)
    {
        $auth = new Auth([
            'user_id' => $userId,
            'source' => $client->getId(),
            'source_id' => $client->getUserAttributes()['id'],
        ]);
        return $auth->save();
    }

    /**
     * @param string $message
     */
    private function setFlashError($message)
    {
        Yii::$app->getSession()->setFlash('error', $message);
    }

    /**
     * Callback when "auth" success.
     *
     * Usage: Add the code below into SiteController#actions()
     * ```php
     * 'auth' => [
     *    'class' => 'yii\authclient\AuthAction',
     *     'successCallback' => ['umbalaconmeogia\systemuser\helpers\AuthHandler', 'onAuthSuccess'],
     * ],
     * ```
     * @param yii\authclient\ClientInterface $client
     */
    public static function onAuthSuccess(ClientInterface $client)
    {
        (new AuthHandler($client))->handle();
    }
}