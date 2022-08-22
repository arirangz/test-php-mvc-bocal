<?php


namespace App\Repository;


use App\Db\Mysql;
use App\Tools\StringTools;

abstract class Repository
{
    protected string $table;
    protected string $entityClass;


    public function findOneById(int $id) {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();

        //$req = $pdo->query('SELECT * FROM '.$this->table.' WHERE id='.(int)$id);
        $PDOStatement = $pdo->prepare('SELECT * FROM '.$this->table.' a WHERE a.id = :id ');
        $PDOStatement->bindValue(':id', (int)$id, $pdo::PARAM_INT);

        $PDOStatement->execute();
        $res = $PDOStatement->fetch($pdo::FETCH_ASSOC);
        if ($res) {
            $entity = new $this->entityClass();
            foreach($res as $key=>$value) {
                if ($key == 'created_at') {
                    $value = new \DateTime($value);
                }
                if ($key == 'date') {
                    $value = new \DateTime($value);
                }
                $entity->{'set'.StringTools::toPascalCase($key)}($value);
            }
            return $entity;
        } else {
            return false;
        }


    }

    public function findAll() {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();

        $PDOStatement = $pdo->prepare('SELECT * FROM '.$this->table);
        $PDOStatement->execute();
        $res = $PDOStatement->fetchAll($pdo::FETCH_ASSOC);
        if ($res) {
            $entities = [];
            foreach ($res as $row) {
                $entity = new $this->entityClass();
                foreach($row as $key=>$value) {
                    if ($key == 'created_at') {
                        $value = new \DateTime($value);
                    }
                    if ($key == 'date') {
                        $value = new \DateTime($value);
                    }
                    $entity->{'set'.StringTools::toPascalCase($key)}($value);
                }
                $entities[] = $entity;
            }
            return $entities;

        } else {
            return false;
        }


    }
}