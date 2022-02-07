<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\controllers\CartController as CommerceCartController;
use mythdigital\mythcommerce\Module as MythCommerceModule;

/**
 * A controller that manages the cart.
 * @package mythdigital\mythcommerce\controllers\api
 */
class CartController extends ApiController
{
    #region Fields

    /**
     * @var CommerceCartController
     */
    private $innerController;

    /**
     * @inheritdoc
     */
    protected $allowAnonymous = [
        'get-cart' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
        'update-cart' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
        'load-cart' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
    ];

    #endregion

    #region Init

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->innerController = new CommerceCartController('commerce-cart-controller', 'mythcommerce');
    }

    #endregion

    #region Actions

    /**
     * Gets the orders that belong to the current user.
     * 
     * @SWG\Get(path="/cart",
     *     tags={"Cart"},
     *     summary="Retrieves the users current cart.",
     *     security={
     *         {"apiKey": {}}
     *     },
     *     @SWG\Response(
     *         response = 200,
     *         description = "The order object that represents the current cart.",
     *         @SWG\Schema(ref = "#/definitions/CommerceOrder")
     *     )
     * )
     * 
     */
    public function actionGetCart()
    {
        return $this->innerController->actionGetCart();
    }

    /**
     * Gets the orders that belong to the current user.
     * 
     * @SWG\Post(path="/cart/update",
     *     tags={"Cart"},
     *     summary="Updates the cart",
     *     security={
     *         {"apiKey": {}}
     *     },
     *     @SWG\Parameter(
     *         description="Payload to update the cart",
     *         in="body",
     *         name="body",
     *         required=true,
     *         @SWG\Schema(ref = "#/definitions/CommerceOrder")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "The order object that represents the current cart.",
     *         @SWG\Schema(ref = "#/definitions/CommerceOrderResponse")
     *     )
     * )
     * 
     */
    public function actionUpdateCart()
    {
        return $this->innerController->actionUpdateCart();
    }

    /**
     * @return Response|null
     * @throws \craft\errors\MissingComponentException
     * @since 3.1
     */
    public function actionLoadCart()
    {
        return $this->innerController->actionLoadCart();
    }

    #endregion

}