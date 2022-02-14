<?php

namespace mythdigital\mythcommerce\variables;

use Craft;
use craft\commerce\elements\Product;
use craft\elements\Category;
use mythdigital\mythcommerce\models\CommerceProductList;
use mythdigital\mythcommerce\models\CommerceProductSearchRequest;
use mythdigital\mythcommerce\Module as MythCommerceModule;

class MythCommerceVariable
{
    #region Methods

    /**
     * Builds a Product Search Request from the request.
     *
     * @param string $productCategory
     * @return CommerceProductSearchRequest
     */
    public function buildProductSearchRequest($productCategory = null)
    {
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

        return $request;
    }

    /**
     * Searches for Products based on the specified request.
     *
     * @param CommerceProductSearchRequest $request
     * @return CommerceProductList
     */
    public function doProductSearch(CommerceProductSearchRequest $request)
    {
        $moduleInstance = MythCommerceModule::getInstance();
        $productService = $moduleInstance->getProductService();

        $products = $productService->searchProducts($request);

        return $products;
    }

    #endregion
}