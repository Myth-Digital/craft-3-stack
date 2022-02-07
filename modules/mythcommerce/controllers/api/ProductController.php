<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\elements\Product;
use craft\elements\Category;
use mythdigital\mythcommerce\models\CommerceProduct;
use mythdigital\mythcommerce\models\CommerceProductList;
use mythdigital\mythcommerce\helpers\MapperHelpers;
use yii\web\NotFoundHttpException;

/**
 * A controller that can be used to get Product data.
 * @package mythdigital\mythcommerce\controllers\api
 */
class ProductController extends ApiController
{
    #region Fields

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
    }

    #endregion

    #region Actions

    
    /**
     * GET /products/
     */

    public function actionIndex($productCategory)
    {
        $request = Craft::$app->getRequest();

        $offset = $request->getQueryParam('offset', 0);
        $limit = $request->getQueryParam('limit', Craft::$app->config->general->defaultPageSize);
        $searchQuery = $request->getQueryParam('query', '');

        if ($limit > Craft::$app->config->general->maxPageSize) {
            $limit = Craft::$app->config->general->maxPageSize;
        }

        $existingCategory = Category::find()->group('shopCategories')
        ->where([
            'elements.id' => $productCategory
        ])
        ->orWhere(['slug' => $productCategory])
        ->first();

        if (empty($existingCategory)) return $this->asJson([]);
        
        $productQuery = Product::find()->relatedTo($existingCategory);

        if (!empty($searchQuery)) {
            $productQuery = $productQuery->andWhere(['like', 'title', $searchQuery]);
        }

        if (!empty($recommendedUserLevel)) {
            $productCategory = $productQuery->andWhere(['like', 'content.field_productRecommendationUserLevel', $recommendedUserLevel]);
        }

        $products = $productQuery
            ->offset($offset)
            ->limit($limit)
            ->all();

        $mappedProducts = array_map(function($p) {
            return MapperHelpers::mapProduct($p);
        }, $products);

        return $this->asJson($mappedProducts);
    }

    /**
     * Gets a single product by its ID.
     * 
     * @SWG\Get(path="/product/<id>",
     *     tags={"Product"},
     *     summary="Retrieves the product with the specified ID.",
     *     @SWG\Parameter(
     *         description="The product ID.",
     *         in="query",
     *         name="id",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "The product",
     *         @SWG\Schema(ref = "#/definitions/CommerceProduct")
     *     ),
     *     @SWG\Response(
     *         response = 404,
     *         description = "Product not found"
     *     )
     * )
     * 
     */
    public function actionGetProduct($id)
    {
        $product = Product::findOne($id);

        if (empty($product)) {
            throw new NotFoundHttpException('A product could not be found with the specified ID.');
        }

        $model = new CommerceProduct();
        $model->populateFromProduct($product);

        return $this->asJson($model);
    }


    /**
     * Searches for products.
     *
     * @SWG\Get(path="/product/search",
     *     tags={"Product"},
     *     summary="Retrieves the product with the specified ID.",
     *     @SWG\Parameter(
     *         description="The search query.",
     *         in="query",
     *         name="query",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="The number of items to take.",
     *         in="query",
     *         name="take",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         description="The number of items to skip.",
     *         in="query",
     *         name="skip",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         description="The product types to include.",
     *         in="query",
     *         name="type",
     *         required=false,
     *         type="array",
     *         @SWG\Items(type = "string")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "The product",
     *         @SWG\Schema(ref = "#/definitions/CommerceProductList")
     *     )
     * )
     * 
     */
    public function actionSearchProducts()
    {
        $this->requireAcceptsJson();
        $this->requireGetRequest();

        $query = $this->request->getQueryParam('query', null);
        $take = $this->request->getQueryParam('take', 10);
        $skip = $this->request->getQueryParam('skip', 0);

        $productQuery = Product::find()
            ->orderBy(['title' => SORT_ASC, 'defaultPrice' => SORT_ASC ]);

        if (!empty($query)) {
            $productQuery = $productQuery->search($query);
        }

        if (!empty($skip)) {
            $productQuery = $productQuery->offset($skip);
        }

        if (!empty($take)) {
            $productQuery = $productQuery->limit($take);
        }

        $totalCount = $productQuery->count();
        $allResults = $productQuery->all();

        $model = new CommerceProductList();

        $model->total = $totalCount;
        $model->skip = $skip;
        $model->take = $take;
        $model->products = [];

        /** @var Product $product */
        foreach ($allResults as $product) {
            $productModel = new CommerceProduct();
            $productModel->populateFromProduct($product);
            $model->products[] = $productModel;
        }

        return $this->asJson($model);
    }

    #endregion
}
