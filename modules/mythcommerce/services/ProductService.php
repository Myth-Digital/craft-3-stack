<?php

namespace mythdigital\mythcommerce\services;

use craft\commerce\elements\db\ProductQuery;
use craft\commerce\elements\Product;
use craft\commerce\elements\Variant;
use craft\elements\Category;
use mythdigital\mythcommerce\helpers\MapperHelpers;
use mythdigital\mythcommerce\models\CommerceCategory;
use mythdigital\mythcommerce\models\CommerceProduct;
use mythdigital\mythcommerce\models\CommerceProductList;
use mythdigital\mythcommerce\models\CommerceProductSearchMetadata;
use mythdigital\mythcommerce\models\CommerceProductSearchRequest;
use mythdigital\mythcommerce\models\CommerceVariantCategoryGroup;
use yii\base\Component;

/**
 * A service that provide functionality concerning Products.
 * Class ProductService
 * @package mythdigital\mythcommerce\services
 */
class ProductService extends Component
{
    #region Constants

    const SHOP_CATEGORIES_GROUP = 'shopCategories';

    const SHOP_VARIANTS_GROUP = 'shopVariants';

    const SHOP_BRANDS_GROUP = 'shopBrands';

    #endregion

    #region Init

    /**
     * Performs init logic for the service.
     */
    public function init()
    {

    }

    #endregion

    #region Methods

    public function searchProducts(CommerceProductSearchRequest $request) : CommerceProductList
    {
        $productQuery = Product::find();

        #region Apply a root-level Product Category scope if one if specified.

        $rootCategory = null;

        if (!empty($request->rootCategory)) {

            $rootCategory = Category::find()->group(ProductService::SHOP_CATEGORIES_GROUP)
            ->where([
                'elements.id' => $request->rootCategory
            ])
            ->orWhere(['slug' => $request->rootCategory])
            ->one();
    
            if (!empty($rootCategory)) {
                $productQuery = $productQuery->relatedTo($rootCategory);
            }
        }

        #endregion

        #region Apply Search Query if specified

        if (!empty($request->query)) {

            $productQuery = $productQuery->search($request->query);
        }

        #endregion

        #region Apply a Variant Category Filter if any are specified

        if (!empty($request->filterCategory)) {

            $selectedVariantCategories = [];

            foreach ($request->filterCategory as $category) {

                $filterCategorySelection = Category::find()
                    ->group(ProductService::SHOP_VARIANTS_GROUP)
                    ->slug($category)
                    ->one();

                if (empty($filterCategorySelection)) continue;

                if (empty($selectedVariantCategories)) {
                    $selectedVariantCategories = ['or', $filterCategorySelection];
                } else {
                    $selectedVariantCategories[] = $filterCategorySelection;
                }
            }

            // Apply the filter. Shop Variant Categories apply to Variants.
            $variantsLinkedToCategories = Variant::find()->relatedTo($selectedVariantCategories)->all();
            $productIds = array_map(function(Variant $v) {
                return $v->productId;
            }, $variantsLinkedToCategories);

            // Factor this into the main product query.
            if (!empty($productIds)) {
                $productQuery->ids($productIds);
            }
        }

        #endregion

        #region Apply a Child Category Filter if specified.

        if (!empty($request->childCategory)) {

            $selectedChildCategories = [];

            foreach ($request->childCategory as $category) {

                $childCategorySelection = Category::find()
                    ->group(ProductService::SHOP_CATEGORIES_GROUP)
                    ->slug($category)
                    ->one();

                if (empty($childCategorySelection)) continue;

                if (empty($selectedChildCategories)) {
                    $selectedChildCategories = ['or', $childCategorySelection];
                } else {
                    $selectedChildCategories[] = $childCategorySelection;
                }
            }

            // Apply the filter. Shop Categories apply to Products. Factor into main Product query.
            if (!empty($selectedChildCategories)) {
                $productQuery->relatedTo($selectedChildCategories);
            }
        }

        #endregion

        #region Apply a Brand filter if specified

        if (!empty($request->brandCategory)) {

            $selectedBrandCategories = [];

            foreach ($request->brandCategory as $category) {

                $brandCategorySelection = Category::find()
                    ->group(ProductService::SHOP_BRANDS_GROUP)
                    ->slug($category)
                    ->one();

                if (empty($brandCategorySelection)) continue;

                if (empty($selectedBrandCategories)) {
                    $selectedBrandCategories = ['or', $brandCategorySelection];
                } else {
                    $selectedBrandCategories[] = $brandCategorySelection;
                }
            }

            // Apply the filter. Shop Categories apply to Products. Factor into main Product query.
            if (!empty($selectedBrandCategories)) {
                $productQuery->relatedTo($selectedBrandCategories);
            }
        }
        
        #endregion

        #region Apply the Order By Clause

        if (!empty($request->sort)) {

            if ($request->sort === 'name') {
                $productQuery = $productQuery->orderBy('title asc');
            }
            if ($request->sort === 'priceAsc') {
                $productQuery = $productQuery->orderBy('defaultPrice asc');
            }
            if ($request->sort === 'priceDesc') {
                $productQuery = $productQuery->orderBy('defaultPrice desc');
            }            

        }

        #endregion

        $allResultQuery = clone $productQuery;
        $allResultQuery->select('elements.id');
        $matchingProductIds = array_map(function(Product $p) {
            return $p->id;
        }, $allResultQuery->all());

        #region Page the result set

        $productQuery = $productQuery->offset($request->offset)->limit($request->limit);

        #endregion

        #region Build the result metadata

        #endregion

        $totalCount = $productQuery->count();
        $allResults = $productQuery->all();

        $model = new CommerceProductList();

        $model->total = $totalCount;
        $model->offset = $request->offset;
        $model->limit = $request->limit;
        $model->products = [];

        /** @var Product $product */
        foreach ($allResults as $product) {
            $productModel = new CommerceProduct();
            $productModel->populateFromProduct($product);
            $model->products[] = $productModel;
        }

        $metadata = $this->getSearchMetadata($rootCategory, $matchingProductIds);

        $model->metadata = $metadata;

        return $model;
    }

    #endregion

    #region Helper Methods

    /**
     * Builds the search metadata object.
     *
     * @param Category $resolvedRootCategory
     * @param array $matchingProductIds
     * @return CommerceProductSearchMetadata
     */
    private function getSearchMetadata(Category $resolvedRootCategory, $matchingProductIds) : CommerceProductSearchMetadata
    {
        // Make the model
        $model = new CommerceProductSearchMetadata();

        #region Get the child categories list.

        $rootCategory = new CommerceCategory();
        $rootCategory->populateFromCategory($resolvedRootCategory);
        $model->rootCategoryTree = $rootCategory;

        #endregion
        
        #region Get the brand categories

        $brandCategories = Category::find()->group(ProductService::SHOP_BRANDS_GROUP)->relatedTo($matchingProductIds)->all();

        $model->brandCategories = array_map(function(Category $c) {
            $categoryModel = new CommerceCategory();
            $categoryModel->populateFromCategory($c);
            return $categoryModel;
        }, $brandCategories);

        #endregion

        #region Get the variant categories

        $variantIdQuery = Variant::find()->productId($matchingProductIds)->select('elements.id');
        $variantIds = array_map(function (Variant $v) {
            return $v->id;
        }, $variantIdQuery->all());
        
        $variantCategoriesQuery = Category::find()->group(ProductService::SHOP_VARIANTS_GROUP)->relatedTo($variantIds)->level('>1');

        /** @var CommerceCategory[] */
        $variantCategories = array_map(function(Category $c) {
            $categoryModel = new CommerceCategory();
            $categoryModel->populateFromCategory($c);
            return $categoryModel;
        }, $variantCategoriesQuery->all());

        $groupedVariantCategories = [];

        foreach ($variantCategories as $variantCategory)
        {
            $parentSlug = $variantCategory->parentSlug;

            if (empty($groupedVariantCategories[$parentSlug])) {
                $variantGroup = new CommerceVariantCategoryGroup();
                $variantGroup->categoryId = $variantCategory->parentId;
                $variantGroup->name = $variantCategory->parentName;
                $variantGroup->slug = $variantCategory->parentSlug;
                $variantGroup->variantCategories[] = $variantCategory;

                $groupedVariantCategories[$parentSlug] = $variantGroup;
            } else {
                $groupedVariantCategories[$parentSlug]->variantCategories[] = $variantCategory;
            }
        }

        $model->variantCategories = array_values($groupedVariantCategories);

        #endregion

        return $model;
    }

    #endregion
}