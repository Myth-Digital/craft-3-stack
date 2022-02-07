<?php

namespace mythdigital\mythcommerce\models;

use Craft;
use craft\base\Model;
use craft\elements\User;

/**
 * The response when invalid is submitted
 * @SWG\Definition(title="ErrorResponse")
 *
 * @SWG\Property(property="errors", type="array", items="")
 */
class ErrorResponse extends Model
{
    /**
     * The validation errors.
     *
     * @var array
     */
    public $errors;
}