<?php


namespace App\Repository;


use App\Db\Mysql;
use App\Entity\Invoice;

class InvoiceRepository extends Repository
{
    protected string $table = 'invoice';
    protected string $entityClass = 'App\Entity\Invoice';

    public function persist(Invoice $invoice, $update = false)
    {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();

        if ($update === true) {
            if ($invoice->getId() !== null) {
                $PDOStatement = $pdo->prepare('UPDATE invoice SET date = :date, number = :number,  
                                                    total_tax_excl = :total_tax_excl, total_tax_incl = :total_tax_incl,
                                                      tax_rate = :tax_rate, title = :title, client_id = :client_id  WHERE id = :id'
                );
                $PDOStatement->bindValue(':id', $invoice->getId(), $pdo::PARAM_INT);
            } else {
                return false;
            }

        } else {
            $PDOStatement = $pdo->prepare('INSERT INTO invoice(date, number, total_tax_excl,
                                                         total_tax_incl, tax_rate, title, client_id, created_at) 
                                                    VALUES (:date, :number, :total_tax_excl,
                                                        :total_tax_incl, :tax_rate, :title, :client_id, :created_at)'
            );

            $PDOStatement->bindValue(':created_at', $invoice->getCreatedAt()->format('Y-m-d H:i:s'), $pdo::PARAM_STR);

            // On met à jour le numéro de facture uniquement à la création
            $invoiceNumber = $invoice->getDate()->format('dmY').'-'.$invoice->getClientId().'-'.rand(10,99);
            $invoice->setNumber($invoiceNumber);
        }

        // Calclul du TTC
        $invoiceTotalTaxIncl = $invoice->getTotalTaxExcl() * (1+$invoice->getTaxRate()/100);
        $invoice->setTotalTaxIncl($invoiceTotalTaxIncl);

        $PDOStatement->bindValue(':date', $invoice->getCreatedAt()->format('Y-m-d H:i:s'), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':title', $invoice->getTitle(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':number', $invoice->getNumber(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':total_tax_excl', $invoice->getTotalTaxExcl(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':total_tax_incl', $invoice->getTotalTaxIncl(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':tax_rate', $invoice->getTaxRate(), $pdo::PARAM_STR);
        $PDOStatement->bindValue(':client_id', $invoice->getClientId(), $pdo::PARAM_STR);

        return $PDOStatement->execute();

    }

    public function removeById(int $id)
    {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();

        $PDOStatement = $pdo->prepare('DELETE FROM invoice WHERE id = :id'
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