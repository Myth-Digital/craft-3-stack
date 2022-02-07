<?php

namespace mythdigital\mythcommerce\models;

use Craft;
use craft\base\Model;
use craft\elements\User;

/**
 * Represents a user login request.
 * @SWG\Definition(title="RegisterUser")
 *
 * @SWG\Property(property="emailAddress", type="string")
 * @SWG\Property(property="password", type="string")
 * @SWG\Property(property="firstName", type="string")
 * @SWG\Property(property="lastName", type="string")
 * @SWG\Property(property="phoneNumber", type="string")
 */
class RegisterUser extends Model
{
    #region Fields

    /**
     * The email address
     *
     * @var string
     */
    public $emailAddress;

    /**
     * The password
     *
     * @var string
     */
    public $password;

    /**
     * The first name
     *
     * @var string
     */
    public $firstName;

    /**
     * The last name
     *
     * @var string
     */
    public $lastName;

    /**
     * The phone number
     *
     * @var string
     */
    public $phoneNumber;

    #endregion

    #region Rules

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emailAddress'], 'email'],
            [['emailAddress', 'password', 'firstName', 'lastName', 'phoneNumber'], 'required'],
            [['emailAddress'], function ($attribute, $params) {
                // Check the email address doesn't already exist.
                if (User::find()->where(['username' => $this->$attribute])->orWhere(['email' => $this->$attribute])->count() > 0) {
                    $this->addError($attribute, 'The username already exists');
                }
            }]
        ];
    }

    #endregion

    #region Methods

    /**
     * Maps to a new user element.
     *
     * @return User
     */
    public function mapToUserElement()
    {
        $newUser = new User();

        $newUser->username = $this->emailAddress;
        $newUser->email = $this->emailAddress;
        $newUser->firstName = $this->firstName;
        $newUser->lastName = $this->lastName;
        $newUser->newPassword = $this->password;

        $newUser->setFieldValue('userPhoneNo', $this->phoneNumber);

        return $newUser;
    }

    #endregion
}