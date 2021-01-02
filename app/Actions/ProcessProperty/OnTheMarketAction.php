<?php

namespace App\Actions\ProcessProperty;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\PropertyAmenity;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class OnTheMarketAction extends ProviderAction implements RespondsToProviderUrlInterface
{
    const PROVIDER_NAME = 'OnTheMarket';

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
            'https://onthemarket.com/',
            'https://www.onthemarket.com/',
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
        // No data available
        return [];
    }

    protected function processBroadbandSpeed(): ?string
    {
        // No data available
        return null;
    }

    protected function processDescription(): ?string
    {
        $description_crawler = $this->crawler->filter('div.description');
        if ($description_crawler->count() === 0) {
            // TODO item not found, throw?
            return null;
        }

        return strip_tags($description_crawler->first()->html(), '<br><strong>');
    }

    protected function processPrice(): ?int
    {
        $price_crawler = $this->crawler->filter('span.price-data');
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
        $title_crawler = $this->crawler->filter('h1');
        if ($title_crawler->count() === 0) {
            // TODO item not found, throw?
            return null;
        }

        return Str::limit($title_crawler->first()->text(), 255);
    }
}
