<?php

namespace mythdigital\mythcommerce\variables;

use craft\commerce\elements\Product;
use craft\elements\Category;

class MythCommerceVariable
{
    #region Methods

    /**
     * Retrives the categories to be included for product filtering.
     *
     * @param Category $category
     * @param array $filterCategorySlugs
     * @return array
     */
    public function getProductQueryCategories($filterCategorySlugs = [])
    {
        return Category::find()->slug($filterCategorySlugs)->all();
    }

    /**
     * Retrieves the categories, arranged into groups, that are used by products of the specified type.
     *
     * @param array $categories
     * @return array
     */
    public function getGroupedCategoriesForProductCategory(Category $category)
    {
        $productQuery = Product::find()->relatedTo($category);

        $categories = Category::find()->relatedTo($productQuery)->orderBy('title')->all();

        $groups = [];

        foreach ($categories as $category) {

            /** @var Category $category */
            $group = $category->getGroup();
            $groupHandle = $group->handle;

            if (!array_key_exists($groupHandle, $groups)) {
                $groups[$groupHandle] = [
                    'id' => $group->id,
                    'name' => $group->name,
                    'handle' => $group->handle,
                    'categories' => []
                ];
            }

            $groups[$groupHandle]['categories'][] = $category;
        }

        return $groups;
    }

    #endregion
}