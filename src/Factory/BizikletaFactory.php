<?php

namespace App\Factory;

use App\Entity\Bizikleta;
use App\Repository\BizikletaRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service_locator;

/**
 * @extends ModelFactory<Bizikleta>
 *
 * @method static Bizikleta|Proxy createOne(array $attributes = [])
 * @method static Bizikleta[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Bizikleta|Proxy find(object|array|mixed $criteria)
 * @method static Bizikleta|Proxy findOrCreate(array $attributes)
 * @method static Bizikleta|Proxy first(string $sortedField = 'id')
 * @method static Bizikleta|Proxy last(string $sortedField = 'id')
 * @method static Bizikleta|Proxy random(array $attributes = [])
 * @method static Bizikleta|Proxy randomOrCreate(array $attributes = [])
 * @method static Bizikleta[]|Proxy[] all()
 * @method static Bizikleta[]|Proxy[] findBy(array $attributes)
 * @method static Bizikleta[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Bizikleta[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BizikletaRepository|RepositoryProxy repository()
 * @method Bizikleta|Proxy create(array|callable $attributes = [])
 */
final class BizikletaFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'code' =>self::faker()->randomNumber(),
            'erregistroa' => self::faker()->text(10),
            'bastidorea' => self::faker()->text(10),
            'isAlokatuta' => self::faker()->boolean,
            'createdAt' => new \DateTime(),
            'updatedAt' => new \DateTime()
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Bizikleta $bizikleta): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Bizikleta::class;
    }
}
