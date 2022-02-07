<?php

namespace mythdigital\mythcommerce\models;

use craft\base\Model;
use craft\commerce\models\OrderHistory;

/**
 * Represents order status history.
 * @SWG\Definition(title="OrderStatusHistory")
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="message", type="string")
 * @SWG\Property(property="prevStatusId", type="integer")
 * @SWG\Property(property="prevStatusName", type="string")
 * @SWG\Property(property="prevStatusDisplayName", type="string")
 * @SWG\Property(property="newStatusId", type="integer")
 * @SWG\Property(property="newStatusName", type="string")
 * @SWG\Property(property="newStatusDisplayName", type="string")
 * @SWG\Property(property="dateCreated", type="string")
 */
class OrderStatusHistory extends Model
{
    #region Fields

    /**
     * @var int ID
     */
    public $id;

    /**
     * @var string Message
     */
    public $message;

    /**
     * @var int Previous Status ID
     */
    public $prevStatusId;

    /**
     * @var string Previous Status Name.
     */
    public $prevStatusName;

    /**
     * @var string Previous Status Display Name.
     */
    public $prevStatusDisplayName;

    /**
     * @var int New status ID
     */
    public $newStatusId;

    /**
     * @var string New Status Name.
     */
    public $newStatusName;

    /**
     * @var string New Status Display Name.
     */
    public $newStatusDisplayName;

    /**
     * @var Datetime|null
     */
    public $dateCreated;

    #endregion

    #region Methods

    /**
     * Populates the model from an order history record. 
     *
     * @param OrderHistory $history The History.
     * @return void
     */
    public function populateFromOrderHistory(OrderHistory $history)
    {
        $this->id = $history->id;
        $this->message = $history->message;

        if (!empty($history->prevStatusId)) {
            $this->prevStatusId = $history->prevStatusId;
            $this->prevStatusName = $history->getPrevStatus()->name;
            $this->prevStatusDisplayName = $history->getPrevStatus()->displayName;
        }

        if (!empty($history->newStatusId)) {
            $this->newStatusId = $history->newStatusId;
            $this->newStatusName = $history->getNewStatus()->name;
            $this->newStatusDisplayName = $history->getNewStatus()->displayName;
        }

        $history->dateCreated = $history->dateCreated;
    }

    #endregion
}