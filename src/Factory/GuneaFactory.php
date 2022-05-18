<?php

namespace App\Factory;

use App\Entity\Gunea;
use App\Repository\GuneaRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Gunea>
 *
 * @method static Gunea|Proxy createOne(array $attributes = [])
 * @method static Gunea[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Gunea|Proxy find(object|array|mixed $criteria)
 * @method static Gunea|Proxy findOrCreate(array $attributes)
 * @method static Gunea|Proxy first(string $sortedField = 'id')
 * @method static Gunea|Proxy last(string $sortedField = 'id')
 * @method static Gunea|Proxy random(array $attributes = [])
 * @method static Gunea|Proxy randomOrCreate(array $attributes = [])
 * @method static Gunea[]|Proxy[] all()
 * @method static Gunea[]|Proxy[] findBy(array $attributes)
 * @method static Gunea[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Gunea[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static GuneaRepository|RepositoryProxy repository()
 * @method Gunea|Proxy create(array|callable $attributes = [])
 */
final class GuneaFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(),
            'helbidea' => self::faker()->address(),
            'ordutegia' => self::faker()->text(),
            'latitude' => self::faker()->latitude(),
            'longitude' => self::faker()->longitude(),
            'createdAt' => new \DateTime(),
            'updatedAt' => new \DateTime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Gunea $gunea): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Gunea::class;
    }
}
