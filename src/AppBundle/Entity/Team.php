<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Team")
 * @ORM\Table(name="team")
 * @Gedmo\Uploadable
 */
class Team
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
     * @var int
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer", name="position")
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="link_to_page")
     */
    private $linkToPage;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="need_players")
     */
    private $needPlayers = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="need_coaches")
     */
    private $needCoaches = false;

    /**
     * @var string
     *
     * @Gedmo\UploadableFilePath
     * @ORM\Column(type="string", name="image")
     */
    private $image;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPosition():? int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position = null)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name = null)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLinkToPage():? string
    {
        return $this->linkToPage;
    }

    /**
     * @param string $linkToPage
     */
    public function setLinkToPage(string $linkToPage = null)
    {
        $this->linkToPage = $linkToPage;
    }

    /**
     * @return bool
     */
    public function isNeedPlayers(): bool
    {
        return $this->needPlayers;
    }

    /**
     * @param bool $needPlayers
     */
    public function setNeedPlayers(bool $needPlayers)
    {
        $this->needPlayers = $needPlayers;
    }

    /**
     * @return bool
     */
    public function isNeedCoaches(): bool
    {
        return $this->needCoaches;
    }

    /**
     * @param bool $needCoaches
     */
    public function setNeedCoaches(bool $needCoaches)
    {
        $this->needCoaches = $needCoaches;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image = null)
    {
        $this->image = $image;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getViewPath(string $path)
    {
        return str_replace($path, '', $this->image);
    }
}