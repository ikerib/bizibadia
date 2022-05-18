<?php

namespace App\Factory;

use App\Entity\Eguraldia;
use App\Repository\EguraldiaRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Eguraldia>
 *
 * @method static Eguraldia|Proxy createOne(array $attributes = [])
 * @method static Eguraldia[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Eguraldia|Proxy find(object|array|mixed $criteria)
 * @method static Eguraldia|Proxy findOrCreate(array $attributes)
 * @method static Eguraldia|Proxy first(string $sortedField = 'id')
 * @method static Eguraldia|Proxy last(string $sortedField = 'id')
 * @method static Eguraldia|Proxy random(array $attributes = [])
 * @method static Eguraldia|Proxy randomOrCreate(array $attributes = [])
 * @method static Eguraldia[]|Proxy[] all()
 * @method static Eguraldia[]|Proxy[] findBy(array $attributes)
 * @method static Eguraldia[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Eguraldia[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EguraldiaRepository|RepositoryProxy repository()
 * @method Eguraldia|Proxy create(array|callable $attributes = [])
 */
final class EguraldiaFactory extends ModelFactory
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
            'izena' => self::faker()->text(),
            'createdAt' => new \DateTime(), // TODO add DATETIME ORM type manually
            'updatedAt' => new \DateTime(), // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Eguraldia $eguraldia): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Eguraldia::class;
    }
}
