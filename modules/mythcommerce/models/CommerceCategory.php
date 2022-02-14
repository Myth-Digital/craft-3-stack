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
 * @SWG\Property(property="slug", type="string")
 * @SWG\Property(property="parentSlug", type="string")
 * @SWG\Property(property="parentId", type="string")
 * @SWG\Property(property="parentName", type="string")
 * @SWG\Property(property="childCategories", type="array", @SWG\Items(ref = "#/definitions/CommerceCategory"))
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

    /**
     * The category slug
     *
     * @var string
     */
    public $slug;

    /**
     * The parent handle, if set.
     *
     * @var string
     */
    public $parentSlug;

    /**
     * The parent id, if set.
     *
     * @var int
     */
    public $parentId;

    /**
     * The parent name, if set.
     *
     * @var string
     */
    public $parentName;

    /**
     * The child categories.
     *
     * @var CommerceCategory[]
     */
    public $childCategories;

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
        $this->slug = $category->slug;

        // Set the parent handle.
        $parent = $category->getParent();
        if (!empty($parent)) {
            $this->parentId = $parent->id;
            $this->parentSlug = $parent->slug;
            $this->parentName = $parent->title;
        }

        // Get the children.
        $childrenQuery = $category->getChildren()->level('>1');
        $this->childCategories = array_map(function(Category $c) {
            $childCategory = new CommerceCategory();
            $childCategory->populateFromCategory($c);
            return $childCategory;
        }, $childrenQuery->all());
    }

    #endregion
}