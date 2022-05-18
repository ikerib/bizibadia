<?php

namespace App\Factory;

use App\Entity\Zigorra;
use App\Repository\ZigorraRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Zigorra>
 *
 * @method static Zigorra|Proxy createOne(array $attributes = [])
 * @method static Zigorra[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Zigorra|Proxy find(object|array|mixed $criteria)
 * @method static Zigorra|Proxy findOrCreate(array $attributes)
 * @method static Zigorra|Proxy first(string $sortedField = 'id')
 * @method static Zigorra|Proxy last(string $sortedField = 'id')
 * @method static Zigorra|Proxy random(array $attributes = [])
 * @method static Zigorra|Proxy randomOrCreate(array $attributes = [])
 * @method static Zigorra[]|Proxy[] all()
 * @method static Zigorra[]|Proxy[] findBy(array $attributes)
 * @method static Zigorra[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Zigorra[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ZigorraRepository|RepositoryProxy repository()
 * @method Zigorra|Proxy create(array|callable $attributes = [])
 */
final class ZigorraFactory extends ModelFactory
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
            'createdAt' => new \DateTime(), // TODO add DATETIME ORM type manually
            'updatedAt' => new \DateTime(), // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Zigorra $zigorra): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Zigorra::class;
    }
}
