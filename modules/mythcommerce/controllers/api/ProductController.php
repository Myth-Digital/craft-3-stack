<?php

namespace mythdigital\mythcommerce\controllers\api;

use Craft;
use craft\commerce\elements\Product;
use craft\commerce\elements\Variant;
use craft\elements\Category;
use mythdigital\mythcommerce\models\CommerceProduct;
use mythdigital\mythcommerce\models\CommerceProductList;
use mythdigital\mythcommerce\helpers\MapperHelpers;
use mythdigital\mythcommerce\models\CommerceProductSearchRequest;
use mythdigital\mythcommerce\Module;
use mythdigital\mythcommerce\services\ProductService;
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

    /**
     * Product Service.
     *
     * @var ProductService
     */
    private $productService;

    #endregion

    #region Init

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $module = Module::getInstance();
        $this->productService = $module->getProductService();
    }

    #endregion

    #region Actions

    /**
     * Searches for products.
     * 
     * @SWG\Get(path="/product/search/<productCategory>",
     *     tags={"Product"},
     *     summary="Searches for products based on a set of criteria.",
     *     @SWG\Parameter(
     *         description="The root category to search by slug or ID.",
     *         in="path",
     *         name="id",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="A search query",
     *         in="query",
     *         name="query",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="A paging offset. Defaults to 0",
     *         in="query",
     *         name="offset",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="A page size. Defaults to the configured value",
     *         in="query",
     *         name="limit",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="An array of child categories to filter on",
     *         in="query",
     *         name="childCategory",
     *         required=false,
     *         type="array",
     *         @SWG\Items(type = "string")
     *     ),
     *     @SWG\Parameter(
     *         description="An array of variant categories to filter on",
     *         in="query",
     *         name="filterCategory",
     *         required=false,
     *         type="array",
     *         @SWG\Items(type = "string")
     *     ),
     *     @SWG\Parameter(
     *         description="An array of brand categories to filter on",
     *         in="query",
     *         name="brandCategory",
     *         required=false,
     *         type="array",
     *         @SWG\Items(type = "string")
     *     ),
     *     @SWG\Parameter(
     *         description="The sort preference",
     *         in="query",
     *         name="sort",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "The product search results",
     *         @SWG\Schema(ref = "#/definitions/CommerceProductList")
     *     ),
     * )
     * 
     */
    public function actionIndex($productCategory = null)
    {
        $this->requireAcceptsJson();
        $this->requireGetRequest();

        $request = Craft::$app->getRequest();

        $searchQuery = $request->getQueryParam('query', '');
        $offset = $request->getQueryParam('offset', 0);
        $limit = $request->getQueryParam('limit', Craft::$app->config->general->defaultPageSize);
        $childCategory = $request->getQueryParam('childCategory', []);
        $filterCategory = $request->getQueryParam('filterCategory', []);
        $brandCategory = $request->getQueryParam('brandCategory', []);
        $orderBy = $request->getQueryParam('sort', 'mostRelevant');

        $request = new CommerceProductSearchRequest();

        $request->rootCategory = $productCategory;
        $request->query = $searchQuery;
        $request->offset = $offset;
        $request->limit = $limit;
        $request->childCategory = $childCategory;
        $request->filterCategory = $filterCategory;
        $request->brandCategory = $brandCategory;
        $request->sort = $orderBy;

        $results = $this->productService->searchProducts($request);

        return $this->asJson($results);
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

    #endregion
}
