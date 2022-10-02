<?php

declare(strict_types=1);

namespace App\Services\DiscogsApi;

use Illuminate\Support\Collection;

/**
 * @author JolitaGrazyte <https://github.com/JolitaGrazyte>
 */
class SearchParameters
{
    protected string $type;

    protected string $title;

    protected string $label;

    protected string $genre;

    protected int $year;

    protected string $format;

    protected string $catno;



    public static function make(): static
    {
        return (new static());
    }

    public function get(): Collection
    {
        $fields = [
            'type'   => $this->type,
            'title'  => $this->title,
            'label'  => $this->label,
            'genre'  => $this->genre,
            'year'   => $this->year,
            'format' => $this->format,
            'catno'  => $this->catno,
        ];

        return collect($fields)->reject(fn ($value) => is_null($value));
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @param string $genre
     * @return $this
     */
    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @param int $year
     * @return $this
     */
    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param string $catalogNumber
     * @return $this
     */
    public function setCatalogNumber(string $catalogNumber): static
    {
        $this->catno = $catalogNumber;

        return $this;
    }
}
