<?php


namespace App\Entity;
use \DateTime;
use App\Db\Mysql;
use App\Tools\StringTools;

class Invoice extends Entity
{
    protected ?int $id = null;
    protected DateTime $date;
    protected String $number = '';
    protected float $total_tax_excl = 0;
    protected float $total_tax_incl = 0;
    protected float $tax_rate = 20;
    protected String $title = '';
    protected int $client_id = 0;
    protected Client $client;

    public function __construct()
    {
        $this->date = date_create();
        parent::__construct();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return float|int
     */
    public function getTotalTaxExcl()
    {
        return $this->total_tax_excl;
    }

    /**
     * @param float|int $total_tax_excl
     */
    public function setTotalTaxExcl($total_tax_excl): void
    {
        $this->total_tax_excl = $total_tax_excl;
    }

    /**
     * @return float|int
     */
    public function getTotalTaxIncl()
    {
        return $this->total_tax_incl;
    }

    /**
     * @param float|int $total_tax_incl
     */
    public function setTotalTaxIncl($total_tax_incl): void
    {
        $this->total_tax_incl = $total_tax_incl;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     */
    public function setClientId(int $client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return float|int
     */
    public function getTaxRate()
    {
        return $this->tax_rate;
    }

    /**
     * @param float|int $tax_rate
     */
    public function setTaxRate($tax_rate): void
    {
        $this->tax_rate = $tax_rate;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

}