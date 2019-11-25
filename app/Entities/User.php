<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Laravel\Passport\HasApiTokens;
use LaravelDoctrine\ACL\Roles\HasRoles;
use LaravelDoctrine\ACL\Mappings as ACL;
use App\Entities\Traits\UsesPasswordGrant;
use LaravelDoctrine\ACL\Contracts\Permission;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ORM\Notifications\Notifiable;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionsContract;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements AuthenticatableContract, CanResetPasswordContract, HasRolesContract, HasPermissionsContract
{
    use HasPermissions;
    use Authenticatable;
    use CanResetPassword;
    use Timestamps;
    use Notifiable;
    use HasApiTokens;
    use UsesPasswordGrant;
    use HasRoles;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ACL\HasRoles()
     * @var ArrayCollection|\LaravelDoctrine\ACL\Contracts\Role[]
     */
    protected $roles;

    /**
     * @ACL\HasPermissions
     */
    public $permissions;

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->getId();
    }

    /**
     * @inheritDoc
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
