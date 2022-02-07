<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\controllers\BaseController;
use craft\commerce\controllers\BaseFrontEndController;
use craft\commerce\Plugin as CommercePlugin;
use craft\commerce\services\Customers;
use craft\commerce\services\Addresses;
use craft\commerce\models\Settings as CommerceSettings;
use Exception;
use yii\web\HttpException;

/**
 * A controller that returns the customer address list.
 * @package mythdigital\mythcommerce\controllers
 */
class AddressController extends BaseFrontEndController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $commerce = CommercePlugin::getInstance();

        $this->customers = $commerce->getCustomers();
        $this->addresses = $commerce->getAddresses();
    }

    /**
     * @var Customers
     */
    private $customers;

    /**
     * @var Addresses
     */
    private $addresses;    

    // Public Methods
    // =========================================================================

    /**
     * GET /addresses/
     */
    public function actionIndex()
    {
        $currentCustomer = $this->customers->getCustomer();

        $addresses = $this->addresses->getAddressesByCustomerId($currentCustomer->id);

        return $this->asJson($addresses);
    }
}