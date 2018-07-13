<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Files which can provide for downloading
 *
 * Class File
 *
 * @package AppBundle\Entity
 * @ORM\Entity
 * @Gedmo\Uploadable
 */
class File
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
     * @ORM\Column(name="name", type="string")
     * @Gedmo\UploadableFileName
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @var \DateTime
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->createAt = new \DateTime('now');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPath():? string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path = null)
    {
        $this->path = $path;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    public function fetchDownloadPath(string $path)
    {
        return str_replace($path, '', $this->path);
    }
}