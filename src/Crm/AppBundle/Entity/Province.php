<?php

namespace Crm\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Province
 */
class Province
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     * @return Province
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var \Crm\AppBundle\Entity\Country
     */
    private $country;


    /**
     * Set country
     *
     * @param \Crm\AppBundle\Entity\Country $country
     * @return Province
     */
    public function setCountry(\Crm\AppBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Crm\AppBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get province
     *
     * @return \Crm\AppBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this;
    }
}
