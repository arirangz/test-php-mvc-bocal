<?php


namespace App\Repository;


use App\Db\Mysql;
use App\Entity\Client;
use App\Tools\StringTools;

class ClientRepository extends Repository
{
    protected string $table = 'client';
    protected string $entityClass = 'App\Entity\Client';

    public function persist(Client $client, $update = false)
    {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();

        if ($update === true) {
            if ($client->getId() !== null) {
                $PDOStatement = $pdo->prepare('UPDATE client SET first_name = :first_name, last_name = :last_name,  
                                                    email = :email, phone = :phone  WHERE id = :id'
                );
                $PDOStatement->bindValue(':id', $client->getId(), $pdo::PARAM_INT);
            } else {
                return false;
            }

        } else {
            $PDOStatement = $pdo->prepare('INSERT INTO client(first_name, last_name, email, phone, created_at) 
                                                    VALUES (:first_name, :last_name, :email, :phone, :created_at)'
            );
            $PDOStatement->bindValue(':created_at', $client->getCreatedAt()->format('Y-m-d H:i:s'), $pdo::PARAM_STR);

        }

        $PDOStatement->bindValue(':first_name', $client->getFirstName(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':last_name', $client->getLastName(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':email', $client->getEmail(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':phone', $client->getPhone(), $pdo::PARAM_STR);

        return $PDOStatement->execute();

    }

    public function removeById(int $id)
    {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();

        $PDOStatement = $pdo->prepare('DELETE FROM client WHERE id = :id'
        );
        $PDOStatement->bindValue(':id', $id, $pdo::PARAM_INT);
        $PDOStatement->execute();

        if ($PDOStatement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }


    }
}