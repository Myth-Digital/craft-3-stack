<?php

namespace mythdigital\mythcommerce\models;

use craft\base\Model;

/**
 * Represents a search request.
 * @SWG\Definition(title="CommerceProductSearchRequest")
 *
 * @SWG\Property(property="rootCategory", type="string"),
 * @SWG\Property(property="query", type="string"),
 * @SWG\Property(property="offset", type="integer"),
 * @SWG\Property(property="limit", type="integer"),
 * @SWG\Property(property="childCategory", type="array", @SWG\Items(type = "string"))
 * @SWG\Property(property="filterCategory", type="array", @SWG\Items(type = "string"))
 * @SWG\Property(property="brandCategory", type="array", @SWG\Items(type = "string"))
 * @SWG\Property(property="sort", type="string"),
 */
class CommerceProductSearchRequest extends Model
{
    /**
     * The Root Category slug or ID.
     *
     * @var string|int
     */
    public $rootCategory;
    
    /**
     * The search query.
     *
     * @var string
     */
    public $query;

    /**
     * The offset.
     *
     * @var int
     */
    public $offset = 0;

    /**
     * The limit.
     *
     * @var int
     */
    public $limit;

    /**
     * Child Categories.
     *
     * @var array
     */
    public $childCategory = [];

    /**
     * The filter categories.
     *
     * @var array
     */
    public $filterCategory = [];

    /**
     * The brand categories.
     *
     * @var array
     */
    public $brandCategory = [];

    /**
     * The sort order.
     *
     * @var string
     */
    public $sort = 'mostRelevant';
}