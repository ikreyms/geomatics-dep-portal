<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use App\Mail\UserCredentialsMail;
use App\Models\SurveyorProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Class RegisterUserService
 *
 * Handles user registration, profile creation, password generation, and email notification.
 *
 * @package App\Services
 */
class RegisterUserService
{
    /**
     * @var string|null $profile The profile instance.
     */
    protected $profile = null;

    /**
     * @var User|null $user The user instance.
     */
    protected $user = null;

    /**
     * @var array $userDataFields The user data fields to extract from input data.
     */
    protected array $userDataFields = ['email'];

    /**
     * @var string $identificationKey The key for user identification (e.g., 'surveyor_reg_no').
     */
    protected string $identificationKey;

    /**
     * @var string $profileClass The profile model class (e.g., SurveyorProfile).
     */
    protected string $profileClass;

    /**
     * Initialize the service with profile class and identification key.
     *
     * @param string $profileClass The profile model class.
     */
    public function __construct(string $profileClass)
    {
        $this->profileClass = $profileClass;
        $this->identificationKey = $profileClass === SurveyorProfile::class ? 'surveyor_reg_no' : 'staff_no';
    }

    /**
     * Registers the user and profile, generates a password, and sends credentials email.
     *
     * @param array $data The user and profile data.
     * @return array The created user and profile instances.
     */
    public function handle(array $data)
    {
        $userData = Arr::only($data, $this->userDataFields);
        $profileData = Arr::except($data, $this->userDataFields);
        $userData['username'] = $profileData[$this->identificationKey];
        $generatedPassword = $this->generateRandomPassword();
        $userData['password'] = $generatedPassword;
        $userData['profileable_type'] = $this->profileClass;

        DB::transaction(function () use (&$profile, &$user, $profileData, $userData) {
            $profile = $this->profileClass::create($profileData);
            $user = new User($userData);
            $user->profileable_id = $profile->id;
            $user->save();
        });

        // TODO:: use a job to send the email. and quickly return the user and profile.
        $this->sendUserCredentialsMail($user->username, $generatedPassword, $user);

        return [$user, $profile];
    }

    /**
     * Generates a random password (10 bytes, 20 hex characters).
     *
     * @return string The generated password.
     */
    private function generateRandomPassword()
    {
        return bin2hex(random_bytes(10));
    }

    /**
     * Sends the user's credentials (username and password) via email.
     *
     * @param string $username The user's username.
     * @param string $password The user's password.
     * @param User   $user The user instance.
     */
    private function sendUserCredentialsMail(string $username, string $password, User $user)
    {
        if ($user) {
            Mail::to($user->email)->send(new UserCredentialsMail($username, $password));
        }
    }
}
