<?php

namespace mythdigital\mythcommerce;

use Craft;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;
use craft\events\DefineRulesEvent;
use craft\commerce\models\Address;
use craft\web\twig\variables\CraftVariable;
use mythdigital\mythcommerce\services\ProductService;
use mythdigital\mythcommerce\variables\MythCommerceVariable;
use yii\base\Event;

/**
 * MythCommerce Module
 *
 * This class will be available throughout the system via:
 * `Craft::$app->getModule('mythcommerce')`.
 *
 * You can change its module ID ("mythcommerce") to something else from
 * config/app.php.
 *
 * If you want the module to get loaded on every request, uncomment this line
 * in config/app.php:
 *
 *     'bootstrap' => ['mythcommerce']
 *
 * Learn more about Yii module development in Yii's documentation:
 * http://www.yiiframework.com/doc-2.0/guide-structure-modules.html
 */
class Module extends \yii\base\Module
{
    #region Init

    /**
     * Initializes the module.
     */
    public function init()
    {
        #region Init Logic

        parent::init();

        Craft::setAlias('@mythcommerce', __DIR__);
        Craft::setAlias('@mythdigital/mythcommerce', __DIR__);

        $this->registerControllerNamespaces();
        $this->registerCraftVariable();

        #endregion

        #region Components

        $this->setComponents([
            'productservice' => ProductService::class,
        ]);

        #endregion

        #region Event Handlers

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            [$this, 'onRegisterUrlRules']
        );

        Event::on(
            Address::class,
            Address::EVENT_DEFINE_RULES,
            [$this, 'onRegisterAddressValidationRules']
        );

        #endregion
    }

    #endregion

    #region Methods

    /**
     * Returns the Product service
     *
     * @return ProductService The Product service
     */
    public function getProductService(): ProductService
    {
        return $this->get('productservice');
    }

    /**
     * Registers address validation rules with Craft.
     */
    public function onRegisterAddressValidationRules(DefineRulesEvent $event)
    {
        $event->rules[] = [['firstName'], 'required'];
        $event->rules[] = [['lastName'], 'required'];
        $event->rules[] = [['address1'], 'required'];
        $event->rules[] = [['city'], 'required'];
        $event->rules[] = [['zipCode'], 'required'];
        $event->rules[] = [['phone'], 'required'];
        $event->rules[] = [['countryId'], 'required'];
    }

    /**
     * Registers the namespaces for Web and Console requests with Craft.
     */
    public function registerControllerNamespaces()
    {
        // Set the controllerNamespace based on whether this is a console or web request
        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            $this->controllerNamespace = 'mythdigital\\mythcommerce\\console';
        } else {
            $this->controllerNamespace = 'mythdigital\\mythcommerce\\controllers';
        }
    }

    /**
     * Registers frontend routes with Craft.
     */
    public function onRegisterUrlRules(RegisterUrlRulesEvent $event)
    {
        $craft = Craft::$app;
        $apiBase = $craft->config->general->apiUrl;

        #region Documentation

        $event->rules["$apiBase/docs"] = ['route' => 'mythcommerce/api/documentation/docs', 'verb' => ['GET', 'OPTIONS']];
        $event->rules["$apiBase/json-schema"] = ['route' => 'mythcommerce/api/documentation/json-schema', 'verb' => ['GET', 'OPTIONS']];

        #endregion

        #region Hello World

        $event->rules["$apiBase/hello-world"] = ['route' => 'mythcommerce/api/hello-world/index', 'verb' => ['GET', 'OPTIONS']];

        #endregion

        #region Cart

        $event->rules["$apiBase/cart"] = ['route' => 'mythcommerce/api/cart/get-cart', 'verb' => ['GET', 'OPTIONS']];
        $event->rules["$apiBase/cart/update"] = ['route' => 'mythcommerce/api/cart/update-cart', 'verb' => ['POST', 'OPTIONS']];

        #region Orders

        $event->rules["$apiBase/orders/my"] = ['route' => 'mythcommerce/api/order/my-orders', 'verb' => ['GET', 'OPTIONS']];
        $event->rules["$apiBase/orders/<orderId>"] = ['route' => 'mythcommerce/api/order/get-order', 'verb' => ['GET', 'OPTIONS']];

        #endregion

        #region Pay

        $event->rules["$apiBase/pay"] = ['route' => 'mythcommerce/api/payments/pay', 'verb' => ['POST', 'OPTIONS']];

        #region Standing Data

        $event->rules["$apiBase/countries"] = [ 'route' => 'mythcommerce/api/countries/index', 'verb' => 'GET' ];
        $event->rules["$apiBase/states"]    = [ 'route' => 'mythcommerce/api/states/index', 'verb' => 'GET' ];
        $event->rules["$apiBase/addresses"]    = [ 'route' => 'mythcommerce/api/address/index', 'verb' => 'GET' ];

        #endregion

        #region Payment Sources

        $event->rules["$apiBase/payment-source"] = ['route' => 'mythcommerce/api/payment-sources/index', 'verb' => ['GET', 'OPTIONS']];
        $event->rules["$apiBase/payment-source/add"] = ['route' => 'mythcommerce/api/payment-sources/add', 'verb' => ['POST', 'OPTIONS']];
        $event->rules["$apiBase/payment-source/delete"] = ['route' => 'mythcommerce/api/payment-sources/delete', 'verb' => ['POST', 'OPTIONS']];

        #region User

        $event->rules["$apiBase/user/register"] = ['route' => 'mythcommerce/api/user/register-user', 'verb' => ['PUT', 'OPTIONS']];

        #endregion

        #region Product Thumbnails

        $event->rules['api/product/<productId:\d+>/thumb'] = ['route' => 'mythcommerce/api/product-thumb/get-product-primary', 'verb' => ['GET', 'OPTIONS']];

        #region Products

        $event->rules["$apiBase/product/<id:\d+>"] = ['route' => 'mythcommerce/api/product/get-product', 'verb' => ['GET', 'OPTIONS']];
        $event->rules["$apiBase/product/search"] = ['route' => 'mythcommerce/api/product/index', 'verb' => ['GET', 'OPTIONS']];
        $event->rules["$apiBase/product/search/<productCategory>"] = ['route' => 'mythcommerce/api/product/index', 'verb' => ['GET', 'OPTIONS']];

        #endregion
    }

    /**
     * Registers our plugin with the Craft variable.
     */
    public function registerCraftVariable()
    {
        // Register our variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('mythcommerce', MythCommerceVariable::class);
            }
        );
    }

    #endregion
}
