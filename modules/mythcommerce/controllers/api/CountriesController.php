<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\controllers\BaseController;
use craft\commerce\controllers\BaseFrontEndController;
use craft\commerce\Plugin as CommercePlugin;
use craft\commerce\services\Countries;
use craft\commerce\models\Settings as CommerceSettings;
use Exception;
use yii\web\HttpException;

/**
 * A controller that returns the country list.
 * @package mythdigital\mythcommerce\controllers
 */
class CountriesController extends BaseFrontEndController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $commerce = CommercePlugin::getInstance();

        $this->countries = $commerce->getCountries();
    }

    /**
     * @var Countries
     */
    private $countries;

    // Public Methods
    // =========================================================================

    /**
     * GET /countries/
     */
    public function actionIndex()
    {
        $countries = $this->countries->getAllCountries();

        return $this->asJson($countries);
    }
}