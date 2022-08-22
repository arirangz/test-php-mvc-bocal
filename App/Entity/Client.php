<?php


namespace App\Entity;
use App\Db\Mysql;
use App\Tools\StringTools;

class Client extends Entity
{
    protected ?int $id = null;
    protected String $first_name = '';
    protected String $last_name = '';
    protected String $email = '';
    protected ?String $phone = '';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): String
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(String $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): String
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(String $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): String
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(String $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?String
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?String $phone): void
    {
        $this->phone = $phone;
    }

    public function getFullname(): string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }


}