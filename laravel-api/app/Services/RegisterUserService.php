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
 * Handles user and profile registration, including creating the user, 
 * generating a password, and sending the credentials via email.
 *
 * @package App\Services
 */
class RegisterUserService
{
    protected $profile = null;
    protected $user = null;
    protected array $userDataFields = ['email'];
    protected string $identificationKey;
    protected string $profileClass;

    /**
     * Constructor.
     * 
     * @param string $profileClass Profile class name (e.g., SurveyorProfile).
     */
    public function __construct(string $profileClass)
    {
        $this->profileClass = $profileClass;
        $this->identificationKey = $profileClass === SurveyorProfile::class ? 'surveyor_reg_no' : 'staff_no';
    }

    /**
     * Registers the user and profile, generates credentials, and sends email.
     *
     * @param array $data User and profile data.
     * @return array Created user and profile.
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

        $this->sendUserCredentialsMail($user->username, $generatedPassword, $user);

        return [$user, $profile];
    }

    /**
     * Generates a random password.
     *
     * @return string The generated password.
     */
    private function generateRandomPassword()
    {
        return bin2hex(random_bytes(10));
    }

    /**
     * Sends the user's credentials via email.
     *
     * @param string $username User's username.
     * @param string $password User's password.
     * @param User $user User instance.
     */
    private function sendUserCredentialsMail(string $username, string $password, User $user)
    {
        if ($user) {
            Mail::to($user->email)->send(new UserCredentialsMail($username, $password));
        }
    }
}
