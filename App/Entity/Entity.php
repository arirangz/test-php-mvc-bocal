<?php


namespace App\Entity;
use \DateTime;


abstract class Entity
{
    protected DateTime $created_at;

    public function __construct()
    {
        $this->created_at = date_create();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

}