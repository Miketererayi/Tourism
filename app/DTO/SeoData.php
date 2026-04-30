<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

readonly class SeoData implements Arrayable
{
    public function __construct(
        public string $title,
        public string $description,
        public string $canonical,
        public string $og_type = 'website',
        public ?string $og_image = null,
        public ?string $og_title = null,
        public ?string $og_description = null,
        public ?string $robots = null,
        public ?string $json_ld = null,
    ) {}

    /**
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'title'          => $this->title,
            'description'    => $this->description,
            'canonical'      => $this->canonical,
            'og_type'        => $this->og_type,
            'og_image'       => $this->og_image,
            'og_title'       => $this->og_title ?? $this->title,
            'og_description' => $this->og_description ?? $this->description,
            'robots'         => $this->robots,
            'json_ld'        => $this->json_ld,
        ];
    }
}
