<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_map")
 */
class TeamMap
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="link_to_page", nullable=false)
     */
    private $mapLink;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMapLink(): ?string
    {
        return $this->mapLink;
    }

    /**
     * @param string $mapLink
     */
    public function setMapLink(string $mapLink)
    {
        $this->mapLink = $mapLink;
    }
}