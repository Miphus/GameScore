<?php

class News {

    private $id;
    private string $title;
    private string $author;
    private string $publishDate;
    private string $content;
    private string $image;
    private string $url;
    private string $source;
    private string $address;

    // public function __set($name, $value)
    // {

    //     echo 'test';
    //     if ($name == 'publishDate' && is_string($value))
    //     {
    //         echo $value;
    //     }

    // }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getPublishDate(): string
    {
        
        return $this->publishDate;
    }

    public function setPublishDate(string $publishDate): void
    {
        
        $this->publishDate = $publishDate;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getImage():string
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
 }
?>