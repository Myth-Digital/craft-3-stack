<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\controllers\PaymentsController as CommercePaymentsController;
use craft\commerce\Plugin as CommercePlugin;
use craft\web\Response;
use yii\web\HttpException;

/**
 * A controller that returns payment sources owned by a user.
 * @package mythdigital\mythcommerce\controllers
 */
class PaymentsController extends ApiController
{
    #region Fields

    /**
     * @var CommercePaymentsController
     */
    private $innerController;

    /**
     * @inheritdoc
     */
    protected $allowAnonymous = [
        'pay' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
        'complete-payment' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
    ];

    #endregion

    #region Init

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $commerce = CommercePlugin::getInstance();

        $this->innerController = new CommercePaymentsController('commerce-payments', 'mythcommerce');
    }

    #endregion

    #region Before Action

    public function beforeAction($action)
    {
        return $this->innerController->beforeAction($action);
    }

    #endregion

    #region Actions

    /**
     * @return Response|null
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     * @throws NotSupportedException
     */
    public function actionPay()
    {
        return $this->innerController->actionPay();
    }

    /**
     * Processes return from off-site payment
     *
     * @throws Exception
     * @throws HttpException
     */
    public function actionCompletePayment(): Response
    {
        return $this->innerController->actionCompletePayment();
    }

    #endregion
}