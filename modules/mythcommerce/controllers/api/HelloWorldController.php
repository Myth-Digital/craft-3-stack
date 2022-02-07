<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;

/**
 * A controller that can be used to test Auth integration with the API.
 * @package mythdigital\mythcommerce\controllers\api
 */
class HelloWorldController extends ApiController
{
    #region Fields

    /**
     * @inheritdoc
     */
    protected $allowAnonymous = true;

    #endregion

    #region Actions

    /**
     * Returns a response from the API for testing.
     *
     * @return void
     */
    public function actionIndex()
    {
        $userId = null;
        $loggedIn = !Craft::$app->getUser()->getIsGuest();

        if ($loggedIn) {
            $userId = Craft::$app->getUser()->getIdentity()->getId();
        }

        return $this->asJson(['success' => true, 'authenticated' => $loggedIn, 'userId' => $userId]);
    }

    #endregion
}
