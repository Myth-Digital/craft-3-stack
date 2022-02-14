<?php

namespace mythdigital\mythcommerce\models;

use craft\base\Model;
use craft\commerce\elements\Product;
use craft\elements\Category;

/**
 * Represents a variant category group, modeled as children under a parent.
 * @SWG\Definition(title="CommerceVariantCategoryGroup")
 *
 * @SWG\Property(property="categoryId", type="integer")
 * @SWG\Property(property="name", type="string")
 * @SWG\Property(property="slug", type="string")
 * @SWG\Property(property="variantCategories", type="array", @SWG\Items(ref = "#/definitions/CommerceCategory"))
 */
class CommerceVariantCategoryGroup extends Model
{
    #region Fields

    /**
     * The category ID.
     *
     * @var int
     */
    public $categoryId;

    /**
     * The category name.
     *
     * @var string
     */
    public $name;

    /**
     * The category slug
     *
     * @var string
     */
    public $slug;

    /**
     * The category group
     *
     * @var CommerceCategory[]
     */
    public $variantCategories = [];

    #endregion
}