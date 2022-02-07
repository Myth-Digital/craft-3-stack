<?php

namespace mythdigital\mythcommerce\models;

use Craft;
use craft\base\Model;
use craft\commerce\elements\Product;
use craft\commerce\helpers\Currency;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\MatrixBlock;
use craft\elements\User;
use craft\fields\data\MultiOptionsFieldData;

/**
 * Represents a product.
 * @SWG\Definition(title="CommerceProduct")
 *
 * @SWG\Property(property="productId", type="string")
 * @SWG\Property(property="purchasableId", type="string")
 * @SWG\Property(property="productType", type="string")
 * @SWG\Property(property="productTypeHandle", type="string")
 * @SWG\Property(property="title", type="string")
 * @SWG\Property(property="imageUrls", type="array", @SWG\Items(type = "string"))
 * @SWG\Property(property="description", type="string")
 * @SWG\Property(property="price", type="number")
 * @SWG\Property(property="priceAsCurrency", type="string")
 * @SWG\Property(property="shopCategories", type="array", @SWG\Items(ref = "#/definitions/CommerceCategory"))
 */
class CommerceProduct extends Model
{
    #region Fields

    /**
     * The product id.
     *
     * @var string
     */
    public $productId;

    /**
     * The purchasable id.
     *
     * @var string
     */
    public $purchasableId;

    /**
     * The product type.
     *
     * @var string
     */
    public $productType;

    /**
     * The product type handle.
     *
     * @var string
     */
    public $productTypeHandle;

    /**
     * The product title.
     *
     * @var string
     */
    public $title;

    /**
     * The image URLs.
     *
     * @var array
     */
    public $imageUrls;

    /**
     * The product description
     *
     * @var string
     */
    public $description;

    /**
     * The product price
     *
     * @var float
     */
    public $price;

    /**
     * The formatted price.
     *
     * @var string
     */
    public $priceAsCurrency;

    /**
     * The product categories
     *
     * @var array
     */
    public $shopCategories;

    #endregion

    #region Methods

    /**
     * Populates the model from a user.
     *
     * @param Product $product The Product.
     * @return void
     */
    public function populateFromProduct(Product $product)
    {
        $this->productId = $product->id;
        $this->purchasableId = $product->defaultVariantId;
        $this->title = $product->title;
        $this->productType = $product->getType()->name;
        $this->productTypeHandle = $product->getType()->handle;
        $this->imageUrls = [];

        $images = $product->productImages->all();

        foreach ($images as $image)
        {
            /** @var Asset $image */
            $this->imageUrls[] = $image->getUrl();
        }

        $this->description = $product->productDescription;
        $this->price = $product->defaultPrice;
        $this->priceAsCurrency = Currency::formatAsCurrency($this->price, 'gbp');
        $this->shopCategories = [];

        $linkedshopCategories = empty($product->shopCategories) ? [] : $product->shopCategories->all();

        foreach ($linkedshopCategories as $category)
        {
            /** @var Category $category */
            $categoryModel = new CommerceCategory();
            $categoryModel->populateFromCategory($category);
            $this->shopCategories[] = $categoryModel;
        }

    }

    #endregion
}
