<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="routingKey")
 */
class RoutingKey
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $gateway_eui;

    /**
     * @ORM\Column(type="integer")
     */
    private $profile;

    /**
     * @ORM\Column(type="integer")
     */
    private $endpoint;

    /**
     * @ORM\Column(type="integer")
     */
    private $cluster;

    /**
     * @ORM\Column(type="integer")
     */
    private $attribute;

    // getters and setters here
}



/**
 * @ORM\Entity
 * @ORM\Table(name="extraInfo")
 */
class ExtraInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    // getters and setters here
}