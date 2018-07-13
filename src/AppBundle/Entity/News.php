<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\News")
 * @ORM\Table(name="news")
 *
 */
class News
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
     * @ORM\Column(type="string", name="headline")
     */
    private $headline;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="short_description")
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1000, name="msg")
     */
    private $msg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="create_date")
     */
    private $createDate;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="is_published")
     */
    private $isPublished = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="published_date", nullable=true)
     */
    private $publishedDate;

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param mixed $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isIsPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * @param bool $isPublished
     */
    public function setIsPublished(bool $isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedDate():? \DateTime
    {
        return $this->publishedDate;
    }

    /**
     * @param \DateTime $publishedDate
     */
    public function setPublishedDate(\DateTime $publishedDate = null)
    {
        $this->publishedDate = $publishedDate;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }
}