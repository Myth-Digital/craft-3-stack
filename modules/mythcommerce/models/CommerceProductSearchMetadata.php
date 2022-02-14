<?php

namespace mythdigital\mythcommerce\models;

use Craft;
use craft\base\Model;
use craft\commerce\elements\Product;
use craft\elements\MatrixBlock;

/**
 * Represents a paged list of products
 * @SWG\Definition(title="CommerceProductSearchMetadata")
 *
 * @SWG\Property(property="rootCategoryTree", ref="#/definitions/CommerceCategory"),
 * @SWG\Property(property="brandCategories", type="array", @SWG\Items(ref = "#/definitions/CommerceCategory"))
 * @SWG\Property(property="variantCategories", type="array", @SWG\Items(ref = "#/definitions/CommerceVariantCategoryGroup"))
 */
class CommerceProductSearchMetadata extends Model
{
    #region Fields

    /**
     * The available child categories.
     *
     * @var CommerceCategory
     */
    public $rootCategoryTree;

    /**
     * The available brand categories.
     *
     * @var CommerceCategory[]
     */
    public $brandCategories;

    /**
     * The available variant categories.
     *
     * @var CommerceVariantCategoryGroup[]
     */
    public $variantCategories;

    #endregion
}