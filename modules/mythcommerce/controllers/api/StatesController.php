<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\controllers\BaseController;
use craft\commerce\controllers\BaseFrontEndController;
use craft\commerce\Plugin as CommercePlugin;
use craft\commerce\services\States;
use craft\commerce\models\Settings as CommerceSettings;
use Exception;
use yii\web\HttpException;

/**
 * A controller that returns the state list.
 * @package mythdigital\mythcommerce\controllers
 */
class StatesController extends BaseFrontEndController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $commerce = CommercePlugin::getInstance();

        $this->states = $commerce->getStates();
    }

    /**
     * @var States
     */
    private $states;

    // Public Methods
    // =========================================================================

    /**
     * GET /states/
     */
    public function actionIndex()
    {
        $states = $this->states->getAllStates();

        return $this->asJson($states);
    }
}