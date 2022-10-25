<?php
namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener{

    /**
     *
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function prePersist(User $user){
        return $this->encode($user);
    }

    public function preUpdate(User $user){
        return $this->encode($user);
    }

    /**
     * encoder le mot de passe
     *
     * @param User $user
     * @return void
     */
    public function encode(User $user){
        if(!$user->getPlainPassword()  === null){
            return;
        }
        $user->setPassword($user,$this->encoder->hashPassword($user->getPlainPassword()));
    }
}