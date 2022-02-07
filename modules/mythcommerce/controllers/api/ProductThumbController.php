<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\controllers\BaseFrontEndController;
use craft\commerce\Plugin as CommercePlugin;
use craft\commerce\services\Products;
use craft\commerce\services\Variants;

/**
 * A controller that returns product thumbnails
 * @package mythdigital\mythcommerce\controllers
 */
class ProductThumbController extends BaseFrontEndController
{
    #region Fields

    /**
     * @var Products
     */
    private $productService;

    /**
     * @var Variants
     */
    private $variantService;

    /**
     * @inheritdoc
     * Allow open access to the Product endpoints.
     */
    protected $allowAnonymous = true;

    #endregion

    #region Init

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $commerce = CommercePlugin::getInstance();

        $this->productService = $commerce->getProducts();
        $this->variantService = $commerce->getVariants();
        // $this->commerceSettings = $commerce->getSettings();
    }

    #endregion

    #region Actions

    /**
     * GET /product/{productId}/thumb
     */
    public function actionGetProductPrimary($productId)
    {
        if (Craft::$app->config->general->disableImageGeneration) return $this->redirect('https://mythcommerce.test/index.php?p=admin/actions/assets/thumb&uid=ec74747d-7894-4be7-8965-f03c278efebb&width=760&height=380&v=1590441512');

        $product = $this->productService->getProductById($productId);

        $images = $product->productImages->all();

        if (empty($images)) return null;

        $primaryImage = $images[0];

        $thumbConfig = 	[
            'mode' => 'crop',
            'width' => 750,
            'height' => 995,
            'position' => 'center-center',
            'quality' => 85
        ];

        $thumb = $primaryImage->getUrl($thumbConfig);

        $this->redirect($thumb);
    }
    
    /**
     * GET /product/{productId}/{variantId}/thumb
     */
    public function actionGetVariantPrimary($productId, $variantId)
    {
        if (Craft::$app->config->general->disableImageGeneration) return;

        $variant = $this->variantService->getVariantById($variantId);

        if ($variant->productId != $productId) return null;

        $images = $variant->variantImage->all();

        if (empty($images)) return null;

        $primaryImage = $images[0];

        $thumbConfig = 	[
            'mode' => 'crop',
            'width' => 750,
            'height' => 995,
            'position' => 'center-center',
            'quality' => 85
        ];

        $thumb = $primaryImage->getUrl($thumbConfig);

        $this->redirect($thumb);
    }

    /**
     * GET /product/{productId}/thumb/{assetId}
     */
    public function actionGetProductImage($productId, $assetId)
    {
        if (Craft::$app->config->general->disableImageGeneration) return;

        $product = $this->productService->getProductById($productId);

        $images = $product->productImages->all();

        if (empty($images)) return null;

        $requestedImage = array_filter($images, function($i) use ($assetId) {

            return $i->id === $assetId;

        });

        if (sizeof($requestedImage) !== 1) return null;

        $image = array_values($requestedImage)[0];

        $thumb = $image->getUrl();

        $this->redirect($thumb);
    }     

    #endregion
}