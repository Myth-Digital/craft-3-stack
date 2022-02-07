<?php

namespace mythdigital\mythcommerce\models;

use Craft;
use craft\base\Model;
use craft\elements\User;
use craft\fields\data\MultiOptionsFieldData;

/**
 * Represents a user login request.
 * @SWG\Definition(title="UserInfo")
 *
 * @SWG\Property(property="emailAddress", type="string")
 * @SWG\Property(property="newPassword", type="string")
 * @SWG\Property(property="firstName", type="string")
 * @SWG\Property(property="lastName", type="string")
 * @SWG\Property(property="phoneNumber", type="string")
 */
class UserInfo extends Model
{
    #region Fields

    /**
     * The email address
     *
     * @var string
     */
    public $emailAddress;

    /**
     * The new password to be set for the user
     *
     * @var string
     */
    public $newPassword;

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
     * A flag indicating if the user is admin.
     *
     * @var array
     */
    public $isAdmin;

    #endregion

    #region Rules

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emailAddress'], 'email']
        ];
    }

    #endregion

    #region Methods

    /**
     * Populates the model from a user.
     *
     * @param User $user The user
     * @return void
     */
    public function populateFromUser(User $user)
    {
        $this->emailAddress = $user->email;
        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;
        $this->phoneNumber = $user->userPhoneNo;
        $this->isAdmin = (boolean)$user->admin;
    }

    /**
     * Maps the model to a User.
     *
     * @param User $user The user.
     * @return void
     */
    public function mapToUser(User $user)
    {
        $user->email = $this->emailAddress;
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;

        $user->setFieldValue('userPhoneNo', $this->phoneNumber);

        if (!empty($this->newPassword)) {
            $user->newPassword = $this->newPassword;
        }
    }

    #endregion
}