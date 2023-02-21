<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="data")
 */
class Data
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

    /**
     * @ORM\Column(type="integer")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    // getters and setters here

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGatewayeui(): ?string
    {
        return $this->gateway_eui;
    }

    public function setGatewayeui(string $gatewayeui): self
    {
        $this->gatewayeui = $gatewayeui;

        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(string $profileId): self
    {
        $this->profileId = $profile;

        return $this;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getCluster(): ?string
    {
        return $this->cluster;
    }

    public function setCluster(string $cluster): self
    {
        $this->cluster = $cluster;

        return $this;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function setAttribute(string $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}