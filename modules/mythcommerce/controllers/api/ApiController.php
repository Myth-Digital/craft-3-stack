<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\web\Controller;
use mythdigital\mythcommerce\models\ErrorResponse;
use mythdigital\mythcommerce\Module as MythCommerceModule;
use yii\web\BadRequestHttpException;

/**
 * The API Base Controller.
 * @package mythdigital\mythcommerce\controllers\api
 */
abstract class ApiController extends Controller
{

    #region Init

    /**
     * Init logic for the component.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $MythCommerceModule = MythCommerceModule::getInstance();
    }

    #endregion

    #region Events

    /**
     * Runs logic before the action.
     *
     * @param $action The action.
     * @return void
     */
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
    }

    #endregion

    #region Behaviors

    public function behaviors()
    {
        $parentBehaviors = parent::behaviors();

        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Allow-Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['X-Requested-With', 'Accept', 'Content-Type', 'Authorization', 'Referer', 'User-Agent', 'sec-ch-ua-mobile', 'sec-ch-ua'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
    }

    #endregion

    #region Methods

    /**
     * Throws a 400 error if this isn’t a DELETE request
     *
     * @throws BadRequestHttpException if the request is not a post request
     */
    public function requireDeleteRequest()
    {
        if (!$this->request->getIsDelete()) {
            throw new BadRequestHttpException('Delete request required');
        }
    }

    /**
     * Throws a 400 error if this isn’t a PUT request
     *
     * @throws BadRequestHttpException if the request is not a post request
     */
    public function requirePutRequest()
    {
        if (!$this->request->getIsPut()) {
            throw new BadRequestHttpException('Put request required');
        }
    }

    /**
     * Throws a 400 error if this isn’t a GET request
     *
     * @throws BadRequestHttpException if the request is not a post request
     */
    public function requireGetRequest()
    {
        if (!$this->request->getIsGet()) {
            throw new BadRequestHttpException('Get request required');
        }
    }

    /**
     * Gets the errors as JSON for return to the client.
     *
     * @param array $errors
     * @return ErrorResponse
     */
    public function errorsAsJson($errors)
    {
        $this->response->setStatusCode(400);

        $resp = new ErrorResponse();

        $resp->errors = $errors;

        return $this->asJson($resp);
    }

    #endregion

}