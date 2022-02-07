<?php

namespace mythdigital\mythcommerce\models;

use craft\base\Model;
use craft\commerce\elements\Product;
use craft\elements\Category;

/**
 * Represents a category.
 * @SWG\Definition(title="CommerceCategory")
 *
 * @SWG\Property(property="categoryId", type="integer")
 * @SWG\Property(property="name", type="string")
 * @SWG\Property(property="groupHandle", type="string")
 * @SWG\Property(property="group", type="string")
 */
class CommerceCategory extends Model
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
     * The category group handle
     *
     * @var string
     */
    public $groupHandle;

    /**
     * The category group
     *
     * @var string
     */
    public $group;

    #endregion

    #region Methods

    /**
     * Populates the model from a category. 
     *
     * @param Category $category The Category.
     * @return void
     */
    public function populateFromCategory(Category $category)
    {
        $this->name = $category->title;
        $this->group = $category->getGroup()->name;
        $this->groupHandle = $category->getGroup()->handle;
        $this->categoryId = $category->getId();
    }

    #endregion
}