<?php

namespace MyVendor\MyApp;

use Respect\Validation\Validator as v;

/**
 * @Stateless
 * @Processing("exception")
 */
class AuthService
{
    protected $credentials = array(
        'admin' => 'admin',
        'user'  => 'pass',
        'guest' => 'guest'
    );
    protected $username;
    protected $password;

    /**
     * @Requires(type="RespectValidation", constraint="v::not(v::email()->setName('Username'))->check($username)")
     */
    protected function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @Requires(type="RespectValidation", constraint="v::notEmpty()->setName('Password')->check($password)")
     */
    protected function setPassword($password)
    {
        $this->password = $password;
    }

    protected function auth()
    {
        if (isset($this->credentials[$this->username])
        && ($this->credentials[$this->username] === $this->password)) {
            return $this->username;
        }
        throw new \Exception('Username or Password invalid', 401);
    }

    public function login($credentials)
    {
        $this->setUsername($credentials->username);
        $this->setPassword($credentials->password);
        return $this->auth();
    }
}
