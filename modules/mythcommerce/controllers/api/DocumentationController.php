<?php

namespace mythdigital\mythcommerce\controllers\api;

use craft\web\Controller;
use Yii;
use yii\helpers\Url;

/**
 * A controller that returns documentation for the API.
 * @package mythdigital\mythcommerce\controllers\api
 * @SWG\Swagger(
 *     basePath="/api",
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(version="1.0", title="MythCommerce API"),
 *     @SWG\SecurityScheme(
 *      securityDefinition="apiKey",
 *      name="Authorization",
 *      type="apiKey",
 *      in="header"
 *     )
 * )
 */
class DocumentationController extends Controller
{
    #region Fields

    protected $allowAnonymous = true;

    #endregion

    #region Actions

    public function actions()
    {
        return [
            'docs' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => '/api/json-schema',
            ],
            'json-schema' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    Yii::getAlias('@mythcommerce/controllers/api'),
                    Yii::getAlias('@mythcommerce/models'),
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    #endregion
}
