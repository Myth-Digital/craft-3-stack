<?php

namespace mythdigital\mythcommerce\models;

use Craft;
use craft\base\Model;
use craft\commerce\models\PaymentSource;
use craft\elements\MatrixBlock;

/**
 * Represents a payment source
 * @SWG\Definition(title="CommercePaymentSource")
 *
 * @SWG\Property(property="id", type="string"),
 * @SWG\Property(property="gatewayId", type="string")
 * @SWG\Property(property="primary", type="boolean")
 * @SWG\Property(property="description", type="string")
 */
class CommercePaymentSource extends Model
{
    #region Fields

    /**
     * The payment source id.
     *
     * @var string
     */
    public $id;

    /**
     * The gateway id.
     *
     * @var string
     */
    public $gatewayId;

    /**
     * A flag indicating if this is a primary payment source.
     *
     * @var bool
     */
    public $primary;

    /**
     * The description.
     *
     * @var string
     */
    public $description;

    #endregion

    #region Methods

    public function populateFromPaymentSource(PaymentSource $paymentSource)
    {
        $payload = json_decode($paymentSource->response, true);
        
        $this->id = $paymentSource->id;
        $this->gatewayId = $paymentSource->gatewayId;
        $this->primary = !empty($payload['primary']) && $payload['primary'];
        $this->description = $paymentSource->description;
    }

    #endregion
}