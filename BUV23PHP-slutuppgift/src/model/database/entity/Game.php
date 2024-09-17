<?php
class Game
{
    private int $id;
    private string $name;
    private string $release_date;
    private float $rating;
    private ?int $metacritic;
    private string $image_background;
    private string $updated;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function setReleaseDate(string $release_date): void
    {
        $this->release_date = $release_date;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function getMetacritic(): ?int
    {
        return $this->metacritic;
    }

    public function setMetacritic(?int $metacritic): void
    {
        $this->metacritic = $metacritic;
    }

    public function getImageBackground(): string
    {
        return $this->image_background;
    }

    public function setImageBackground(string $image_background): void
    {
        $this->image_background = $image_background;
    }

    public function getUpdated(): string
    {
        return $this->updated;
    }

    public function setUpdated(string $updated): void
    {
        $this->updated = $updated;
    }
}