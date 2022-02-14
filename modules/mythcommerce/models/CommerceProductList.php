<?php

namespace mythdigital\mythcommerce\models;

use Craft;
use craft\base\Model;
use craft\commerce\elements\Product;
use craft\elements\MatrixBlock;

/**
 * Represents a paged list of products
 * @SWG\Definition(title="CommerceProductList")
 *
 * @SWG\Property(property="total", type="integer"),
 * @SWG\Property(property="limit", type="integer"),
 * @SWG\Property(property="offset", type="integer"),
 * @SWG\Property(property="products", type="array", @SWG\Items(ref = "#/definitions/CommerceProduct"))
 * @SWG\Property(property="rootCategoryTree", ref="#/definitions/CommerceProductSearchMetadata"),
 */
class CommerceProductList extends Model
{
    #region Fields

    /**
     * The total number of results.
     *
     * @var string
     */
    public $total;

    /**
     * The number of items to retrieve
     *
     * @var int
     */
    public $limit;

    /**
     * The number of items to skip.
     *
     * @var int
     */
    public $offset;

    /**
     * The products
     *
     * @var array
     */
    public $products;

    /**
     * The metadata
     *
     * @var CommerceProductSearchMetadata
     */
    public $metadata;

    #endregion
}