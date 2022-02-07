<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\controllers\UsersController as CraftUserController;
use craft\services\Elements;
use mythdigital\mythcommerce\models\RegisterUser;
use mythdigital\mythcommerce\Module as MythCommerceModule;

/**
 * A controller that can be used to access user functionality.
 * @package mythdigital\mythcommerce\controllers\api
 */
class UserController extends ApiController
{
    #region Fields

    /**
     * Element Service
     *
     * @var Elements
     */
    private $elementService;

    /**
     * @inheritdoc
     */
    protected $allowAnonymous = [
        'token' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
        'refresh-access-token' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
        'register-user' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
    ];

    #endregion

    #region Constructor

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $mythcommerceModule = MythCommerceModule::getInstance();
        $craft = Craft::$app;

        $this->elementService = $craft->getElements();
    }

    #endregion

    #region Actions

    /**
     * Creates a new user account.
     * 
     * @SWG\Put(path="/user/register",
     *     tags={"User"},
     *     summary="Creates a new user",
     *     @SWG\Parameter(
     *         description="Payload to create a new user.",
     *         in="body",
     *         name="body",
     *         required=true,
     *         @SWG\Schema(ref = "#/definitions/RegisterUser")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "A successful response indicating that the user has been created"
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "Submitted with validation errors",
     *         @SWG\Schema(ref = "#/definitions/ErrorResponse")
     *     ),
     * )
     */
    public function actionRegisterUser()
    {
        $this->requirePutRequest();
        $this->requireAcceptsJson();

        $request = Craft::$app->getRequest();

        $model = new RegisterUser();

        $model->emailAddress = $request->getBodyParam('emailAddress');
        $model->password = $request->getBodyParam('password');
        $model->firstName = $request->getBodyParam('firstName');
        $model->lastName = $request->getBodyParam('lastName');

        $isValid = $model->validate();

        if (!$isValid) {
            return $this->errorsAsJson($model->getErrors());
        }

        $newUser = $model->mapToUserElement();

        $this->elementService->saveElement($newUser);
        
        return $this->asJson(null);
    }

    #endregion
}
