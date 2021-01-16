<?php

namespace App\Actions\ProcessProperty;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\PropertyAmenity;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class RightmoveAction extends ProviderAction implements RespondsToProviderUrlInterface
{
    /** @var string */
    public const PROVIDER_NAME = 'Rightmove';

    protected Crawler $crawler;

    public function __construct(
        protected Property $property,
        string $html_content,
    ) {
        $this->crawler = new Crawler($html_content);
    }

    public function __invoke()
    {
        $data = [
            'broadband_speed' => $this->processBroadbandSpeed(),
            'description' => $this->processDescription(),
            'price' => $this->processPrice(),
            'title' => $this->processTitle(),
        ];
        foreach ($this->processAmenityNames() as $amenity_name) {
            $amenity = Amenity::firstOrCreate(['name' => $amenity_name]);

            PropertyAmenity::create([
                'amenity_id' => $amenity->id,
                'property_id' => $this->property->id,
            ]);
        }

        $this->property->update($data);

        return $this->property;
    }

    public static function respondsTo(string $url): bool
    {
        $supported_base_urls = [
            'https://rightmove.co.uk/',
            'https://www.rightmove.co.uk/',
        ];

        foreach ($supported_base_urls as $base_url) {
            if (str_starts_with($url, $base_url)) {
                return true;
            }
        }

        return false;
    }

    protected function processAmenityNames(): array
    {
        $amenities_crawler = $this->crawler->filter('li.lIhZ24u1NHMa5Y6gDH90A');
        if ($amenities_crawler->count() === 0) {
            // TODO item not found, throw?
            return [];
        }

        return $amenities_crawler->each(function (Crawler $node): string {
            return Str::limit($node->text(), 255);
        });
    }

    protected function processBroadbandSpeed(): ?string
    {
        // A link needs to be clicked which fetches this data
        return null;
    }

    protected function processDescription(): ?string
    {
        $description_crawler = $this->crawler->filter('.STw8udCxUaBUMfOOZu0iL._3nPVwR0HZYQah5tkVJHFh5 div');
        if ($description_crawler->count() === 0) {
            // TODO item not found, throw?
            return null;
        }

        return strip_tags($description_crawler->first()->html(), '<br><strong>');
    }

    protected function processPrice(): ?int
    {
        $price_crawler = $this->crawler->filter('._1gfnqJ3Vtd1z40MlC0MzXu span');
        if ($price_crawler->count() === 0) {
            // TODO price not found: throw?
            return null;
        }

        return (int) str_replace(
            ['£', ','],
            '',
            $price_crawler->first()->text()
        );
    }

    protected function processTitle(): ?string
    {
        $title_crawler = $this->crawler->filter('title');
        if ($title_crawler->count() === 0) {
            // TODO item not found, throw?
            return null;
        }

        return Str::limit($title_crawler->first()->text(), 255);
    }
}
