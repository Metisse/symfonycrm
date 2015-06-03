<?php

namespace Crm\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 */
class Invoice
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $totalTaxable;

    /**
     * @var string
     */
    private $totalExpenses;

    /**
     * @var string
     */
    private $totalOutlays;

    /**
     * @var string
     */
    private $vat;

    /**
     * @var string
     */
    private $tax;

    /**
     * @var boolean
     */
    private $isPaid;

    /**
     * @var \DateTime
     */
    private $dueDate;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Crm\AppBundle\Entity\Company
     */
    private $company;

    /**
     * @var \Crm\AppBundle\Entity\InvoiceDetail[]
     */
    private $invoiceDetails;

    /**
     * @var \Crm\AppBundle\Entity\User
     */
    private $user;

    public function __construct() {
        $this->invoiceDetails = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Invoice
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set totalTaxable
     *
     * @param string $totalTaxable
     * @return Invoice
     */
    public function setTotalTaxable($totalTaxable)
    {
        $this->totalTaxable = $totalTaxable;

        return $this;
    }

    /**
     * Get totalTaxable
     *
     * @return string 
     */
    public function getTotalTaxable()
    {
        return $this->totalTaxable;
    }

    /**
     * Set totalExpenses
     *
     * @param string $totalExpenses
     * @return Invoice
     */
    public function setTotalExpenses($totalExpenses)
    {
        $this->totalExpenses = $totalExpenses;

        return $this;
    }

    /**
     * Get totalExpenses
     *
     * @return string 
     */
    public function getTotalExpenses()
    {
        return $this->totalExpenses;
    }

    /**
     * Set totalOutlays
     *
     * @param string $totalOutlays
     * @return Invoice
     */
    public function setTotalOutlays($totalOutlays)
    {
        $this->totalOutlays = $totalOutlays;

        return $this;
    }

    /**
     * Get totalOutlays
     *
     * @return string 
     */
    public function getTotalOutlays()
    {
        return $this->totalOutlays;
    }

    /**
     * Set vat
     *
     * @param string $vat
     * @return Invoice
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return string 
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set tax
     *
     * @param string $tax
     * @return Invoice
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string 
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set isPaid
     *
     * @param boolean $isPaid
     * @return Invoice
     */
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    /**
     * Get isPaid
     *
     * @return boolean 
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Invoice
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Invoice
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Invoice
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set company
     *
     * @param \Crm\AppBundle\Entity\Company $company
     * @return Invoice
     */
    public function setCompany(\Crm\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Crm\AppBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set user
     *
     * @param \Crm\AppBundle\Entity\User $user
     * @return Company
     */
    public function setUser(\Crm\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Crm\AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the invoice details.
     *
     * @return array
     */
    public function getInvoiceDetails()
    {
        return $this->invoiceDetails;
    }

    /**
     * Set the invoice details.
     *
     * @return array
     */
    public function setInvoiceDetails(ArrayCollection $invoiceDetails)
    {
        foreach ($invoiceDetails as $invoiceDetail) {
            $invoiceDetail->setInvoice($this);
        }

        $this->invoiceDetails = $invoiceDetails;
    }

    /**
     * Add an invoice detail to the invoice.
     *
     * @param \Crm\AppBundle\Entity\InvoiceDetail $invoiceDetail The invoice detail to add.
     */
    public function addInvoiceDetail(\Crm\AppBundle\Entity\InvoiceDetail $invoiceDetail)
    {
        $this->invoiceDetails->add($invoiceDetail);
        $invoiceDetail->setInvoice($this);
    }

    /**
     * Removes an invoice detail from the invoice.
     *
     * @param \Crm\AppBundle\Entity\InvoiceDetail $invoiceDetail The invoice detail to remove.
     */
    public function removeInvoiceDetail(\Crm\AppBundle\Entity\InvoiceDetail $invoiceDetail)
    {
        $this->invoiceDetails->removeElement($invoiceDetail);

    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt        = new \DateTime("now");
        $this->updatedAt        = new \DateTime("now");
        $this->setTotalAmounts();
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt        = new \DateTime("now");
        $this->setTotalAmounts();
    }

    /**
     * Calculate the total amounts for an invoice.
     */
    private function setTotalAmounts()
    {
        $taxable	= 0.00;
        $expenses   = 0.00;
        $outlays	= 0.00;

        foreach ($this->invoiceDetails as $invoiceDetail) {
            $amount = $invoiceDetail->getAmount();
            switch ($invoiceDetail->getType())
            {
                case 'incoming':
                    $taxable    += $amount;
                    break;
                case 'expense':
                    $taxable    += $amount;
                    $expenses   += $amount;
                    break;
                case 'outlay':
                    $outlays    += $amount;
                    break;
            }
        }

        $this->setTotalTaxable($taxable);
        $this->setTotalExpenses($expenses);
        $this->setTotalOutlays($outlays);
    }
}
