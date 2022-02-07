<?php

namespace mythdigital\mythcommerce\models;

use craft\base\Model;
use craft\commerce\models\OrderHistory;

/**
 * Represents an order status progression
 * @SWG\Definition(title="OrderStatusUpdate")
 *
 * @SWG\Property(property="message", type="string")
 * @SWG\Property(property="newStatusHandle", type="string")
 */
class OrderStatusUpdate extends Model
{
    #region Fields

    /**
     * @var string Message
     */
    public $message;

    /**
     * @var string New status handle
     */
    public $newStatusHandle;

    #endregion

    #region Methods

    public function rules()
    {
        return [
            [['newStatusHandle'], 'required']
        ];
    }

    #endregion
}