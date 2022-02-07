<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\controllers\PaymentSourcesController as CommercePaymentSourcesController;
use craft\commerce\Plugin as CommercePlugin;
use craft\commerce\services\PaymentSources;
use craft\errors\MissingComponentException;
use craft\web\Response;
use mythdigital\mythcommerce\models\CommercePaymentSource;
use Throwable;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

/**
 * A controller that returns payment sources owned by a user.
 * @package mythdigital\mythcommerce\controllers
 */
class PaymentSourcesController extends ApiController
{
    #region Fields

    /**
     * @var PaymentSources
     */
    private $paymentSources;

    /**
     * @var CommercePaymentSourcesController
     */
    private $innerController;

    #endregion

    #region Init

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $commerce = CommercePlugin::getInstance();

        $this->paymentSources = $commerce->getPaymentSources();
        $this->innerController = new CommercePaymentSourcesController('commerce-payment-sources', 'mythcommerce');
    }

    #endregion

    #region Actions

    /**
     * Gets the list of payment sources.
     * 
     * @SWG\Get(path="/payment-source",
     *     tags={"Payment Sources"},
     *     summary="Retrieves the list of user payment sources",
     *     security={
     *         {"apiKey": {}}
     *     },
     *     @SWG\Response(
     *         response = 200,
     *         description = "A successful response with the user payment sources",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref = "#/definitions/CommercePaymentSource")
     *         )
     *     )
     * )
     * 
     */
    public function actionIndex()
    {
        $currentUser = Craft::$app->getUser();

        $storedCards = $this->paymentSources->getAllPaymentSourcesByUserId($currentUser->id ?? null);

        $mappedCards = array_map(function($p) {

            $model = new CommercePaymentSource();
            $model->populateFromPaymentSource($p);
            return $model;

        }, $storedCards);

        return $this->asJson($mappedCards);
    }

    /**
     * Adds a payment source.
     * @SWG\Post(path="/payment-source/add",
     *     tags={"Payment Sources"},
     *     summary="Adds a payment source",
     *     security={
     *         {"apiKey": {}}
     *     },
     *     @SWG\Parameter(
     *         description="Payload to save a payment source",
     *         in="body",
     *         name="body",
     *         required=true,
     *         @SWG\Schema(ref = "#/definitions/CommerceAddPaymentSource")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "A successful response indicating the card has been added"
     *     )
     * )
     *
     * @return Response|null
     * @throws HttpException
     * @throws MissingComponentException
     * @throws InvalidConfigException
     * @throws BadRequestHttpException
     */
    public function actionAdd()
    {
        return $this->innerController->actionAdd();
    }

    /**
     * Deletes a payment source.
     * @SWG\Post(path="/payment-source/delete",
     *     tags={"Payment Sources"},
     *     summary="Deletes a payment source",
     *     security={
     *         {"apiKey": {}}
     *     },
     *     @SWG\Parameter(
     *         description="Payload to save a payment source",
     *         in="body",
     *         name="body",
     *         required=true,
     *         @SWG\Schema(ref = "#/definitions/CommerceDeletePaymentSource")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "A successful response indicating the card has been removed."
     *     )
     * )
     *
     * @return Response|null
     * @throws Throwable if failed to delete the payment source on the gateway
     * @throws BadRequestHttpException if user not logged in
     */
    public function actionDelete()
    {
        return $this->innerController->actionDelete();
    }

    #endregion
}