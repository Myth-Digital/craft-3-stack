<?php 

namespace mythdigital\mythcommerce\helpers;

use craft\commerce\elements\Order;
use craft\commerce\elements\Product;

class MapperHelpers
{
    /**
     * Re-works an order array for use on the API
     *
     * @param Order $order
     * @return array a mapped order
     */
    public static function updateOrderArray(Order $order)
    {
        $orderArray = $order->toArray();

        // Break out Order Status into Order.
        $orderArray['orderStatus'] = !empty($order->orderStatus) ? $order->orderStatus->name : '';
        $orderArray['orderStatusDisplayLabel'] = !empty($order->orderStatus) ? $order->orderStatus->displayName : '';

        // Format the dates for JS.
        if (!empty($orderArray['dateOrdered'])) {
            $orderArray['dateOrdered'] = $order->dateOrdered->format(DATE_ATOM);
        }

        if (!empty($orderArray['datePaid'])) {
            $orderArray['datePaid'] = $order->datePaid->format(DATE_ATOM);
        }

        if (!empty($orderArray['dateAuthorized'])) {
            $orderArray['dateAuthorized'] = $order->dateAuthorized->format(DATE_ATOM);
        }

        if (!empty($orderArray['dateCreated'])) {
            $orderArray['dateCreated'] = $order->dateCreated->format(DATE_ATOM);
        }

        if (!empty($orderArray['dateUpdated'])) {
            $orderArray['dateUpdated'] = $order->dateUpdated->format(DATE_ATOM);
        }

        return $orderArray;
    }
}