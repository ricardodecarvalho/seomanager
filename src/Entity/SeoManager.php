<?php

namespace SeoManager\Entity;

/**
 * @Entity @Table(name="SeoManager")
 */
class SeoManager
{
    /**
     * @Id @Column(type="integer", name="id_seoManager") @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", length=100)
     */
    protected $url;

    /**
     * @Column(type="string", length=50)
     */
    protected $title;

    /**
     * @Column(type="string", length=160)
     */
    protected $description;

    /**
     * @Column(type="string", length=200)
     */
    protected $keywords;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
}
