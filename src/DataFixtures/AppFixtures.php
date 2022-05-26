<?php

namespace App\DataFixtures;

use App\Entity\Bizikleta;
use App\Entity\Eguraldia;
use App\Entity\Gunea;
use App\Entity\Ibilbidea;
use App\Entity\Udala;
use App\Entity\User;
use App\Entity\Zigorra;
use App\Factory\BizikletaFactory;
use App\Factory\EguraldiaFactory;
use App\Factory\GuneaFactory;
use App\Factory\IbilbideaFactory;
use App\Factory\UserFactory;
use App\Factory\ZigorraFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $faker;
    protected UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->encoder = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        // UDALAK
        $udalaP = new Udala();
        $udalaP->setCreatedAt(new DateTime());
        $udalaP->setUpdatedAt(new DateTime());
        $udalaP->setName('Pasaiako Udala');
        $manager->persist($udalaP);

        $udalaL = new Udala();
        $udalaL->setCreatedAt(new DateTime());
        $udalaL->setUpdatedAt(new DateTime());
        $udalaL->setName('Lezoko Udala');
        $manager->persist($udalaL);

        // ERABILTZAILEAK
        $superUser = new User();
        $superUser->setName('SuperUser');
        $superUser->setSurname('-');
        $superUser->setEmail('superuser@udal.com');
        $superUser->setUsername('superadmin');
        $superUser->setLanguage('Eu');
        $superUser->setRoles(['ROLE_SUPER_ADMIN']);
        $hashedPassword = $this->encoder->hashPassword(
            $superUser,
            '!Superadmin'
        );
        $superUser->setPassword($hashedPassword);
        $manager->persist($superUser);

        $userLezo = new User();
        $userLezo->setName('Lezoko Udala');
        $userLezo->setSurname('Udala');
        $userLezo->setRoles(['ROLE_ADMIN']);
        $userLezo->setLanguage('Es');
        $userLezo->setUsername('lezo');
        $hashedPassword = $this->encoder->hashPassword(
            $userLezo,
            'lezokoak'
        );
        $userLezo->setPassword($hashedPassword);
        $userLezo->setEmail('lezo@udal.com');
        $userLezo->setUdala($udalaL);
        $manager->persist($userLezo);

        $userPasaia = new User();
        $userPasaia->setName('Pasaiako Udala');
        $userPasaia->setSurname('Udala');
        $userPasaia->setRoles(['ROLE_ADMIN']);
        $userPasaia->setLanguage('Eu');
        $userPasaia->setUsername('pasaia');
        $hashedPassword = $this->encoder->hashPassword(
            $userPasaia,
            'pasaiakoak'
        );
        $userPasaia->setPassword($hashedPassword);
        $userPasaia->setEmail('lezo@udal.com');
        $userPasaia->setUdala($udalaP);
        $manager->persist($userPasaia);

        $udalak = [$udalaP, $udalaL];
        $hizkuntzak = ['Eu', 'Es'];
        for ($i = 0; $i < 20; $i++) {
            $username = "username$i";
            $udal = $udalak[array_rand($udalak)];
            $u = new User();
            $u->setName($username);
            $u->setSurname("Surname $udal");
            $u->setUsername($username . $i);
            $u->setEmail("$username@udala.com");
            $u->setLanguage($hizkuntzak[array_rand($hizkuntzak)]);
            $u->setUdala($udal);
            $u->setCanRent(true);
            $u->setRoles(['ROLE_USER']);
            $hashedPassword = $this->encoder->hashPassword(
                $u,
                (string)$username
            );
            $u->setPassword($hashedPassword);
            $manager->persist($u);
        }

//        $guneak = [];
//        $g1 = new Gunea();
//        $g1->setUdala($udalaP);
//        $g1->setName('Donibaneko Kirolgunea');
//        $g1->setOrdutegia('Astelehenetik ostiralera / De lunes a viernes  9:00-21:00. Larunbatetan / sábados 9:00-19:00, Igandeetan/domingos 9:00-13:00. 943345371');
//        $g1->setHelbidea('Donibaneko Kirolgunea, donibane kalea 1. 943345371');
//        $g1->setLatitude('43.323713');
//        $g1->setLongitude('-1.915745');
//        $guneak [] = $g1;
//        $manager->persist($g1);
//
//        $g2 = new Gunea();
//        $g2->setUdala($udalaP);
//        $g2->setName('Trintxerpeko kirolgunea');
//        $g2->setOrdutegia('Astelehenetik ostiralera / De lunes a viernes 9:00-13:00 / 16:00-21:00. Larunbatetan / sábados 9:00-13:00. Igandeetan/domingos 9:00-13:00. 943399753');
//        $g2->setHelbidea('Trintxerpeko Kirolgunea, euskadi etorbidea z/g. Azoka eraikina 3. solairua. 943399753');
//        $g2->setLatitude('43.322734');
//        $g2->setLongitude('-1.934191');
//        $guneak [] = $g2;
//        $manager->persist($g2);
//
//        $g3 = new Gunea();
//        $g3->setUdala($udalaP);
//        $g3->setName('Kirol Saila');
//        $g3->setOrdutegia('Astelehentik ostiralera / De lunes a viernes 8:00-14:30. 943004330');
//        $g3->setHelbidea('Euskadi etorbidea 61. 943004330');
//        $g3->setLatitude('43.323152');
//        $g3->setLongitude('-1.930232');
//        $guneak [] = $g3;
//        $manager->persist($g3);
//
//        $g4 = new Gunea();
//        $g4->setUdala($udalaP);
//        $g4->setName('Antxoko Ibaiondo pilotalekua');
//        $g4->setOrdutegia('Egunero arratsaldez eta irekiera-ordutegiaren arabera. Todos los días por la tarde y en función del horario de apertura.');
//        $g4->setHelbidea('Antxoko Ibaiondo pilotalekua. Ibaiondo parkea z/g.');
//        $g4->setLatitude('43.31758');
//        $g4->setLongitude('-1.915587');
//        $guneak [] = $g4;
//        $manager->persist($g4);
//
//        $g5 = new Gunea();
//        $g5->setUdala($udalaP);
//        $g5->setName('San Pedroko Gimnasioa');
//        $g5->setOrdutegia('Eskaera bidezko mailegu puntua');
//        $g5->setHelbidea('Herriko plaza zg');
//        $g5->setLatitude('43.325089');
//        $g5->setLongitude('-1.926332');
//        $guneak [] = $g5;
//        $manager->persist($g5);
//
//        $g6 = new Gunea();
//        $g6->setUdala($udalaP);
//        $g6->setName('Udal langileentzako bizikletak');
//        $g6->setOrdutegia('Egunero');
//        $g6->setHelbidea('Donibane Kalea 1');
//        $g6->setLatitude('43.324');
//        $g6->setLongitude('-1.916');
//        $guneak [] = $g6;
//        $manager->persist($g6);
//
//        $g6 = new Gunea();
//        $g6->setUdala($udalaL);
//        $g6->setName('Lezoko Kiroldegia');
//        $g6->setOrdutegia('08:00–21:00');
//        $g6->setHelbidea('Euskal Herria Plaza, 2, 20100 Lezo, Gipuzkoa');
//        $g6->setLatitude('43.319');
//        $g6->setLongitude('-1.9');
//        $guneak [] = $g6;
//        $manager->persist($g6);
//
//        for ( $i = 0; $i < 15; $i++) {
//            $udal = $udalak[array_rand($udalak)];
//            $gunea = new Gunea();
//            $gunea->setName("Gunea-$udal-$i");
//            $gunea->setUdala($udal);
//            $gunea->setHelbidea("Herri kalea $i");
//            $gunea->setOrdutegia('9:00 - 14:00');
//            $guneak [] = $gunea;
//            $manager->persist($gunea);
//        }
//
//        for ( $i = 0; $i < 30; $i++ ) {
//            $udal = $udalak[array_rand($udalak)];
//            $b = new Bizikleta();
//            $b->setUdala($udal);
//            $b->setName("Bizikleta-$udal-$i");
//            $b->setGunea($guneak[array_rand($guneak)]);
//            $b->setIsAlokatuta(false);
//            $b->setCode("BIZ00$udal$i");
//            $b->setErregistroa("BiZ-Erre-$udal-00$i");
//            $b->setBastidorea("BAS-$udal-000$i");
//            $manager->persist($b);
//        }
//
//
//        for ( $i = 0; $i < 10; $i++) {
//            $udal = $udalak[array_rand($udalak)];
//            $ibi = new Ibilbidea();
//            $ibi->setUdala($udal);
//            $ibi->setName("Ibilbidea-$udal-$i");
//            $manager->persist($ibi);
//        }
//
//        for ( $i = 0; $i < 10; $i++ ) {
//            $udal = $udalak[array_rand($udalak)];
//            $egu = new Eguraldia();
//            $egu->setUdala($udal);
//            $egu->setIzena("Eguraldia-$udal-$i");
//            $manager->persist($egu);
//        }
//
//
//        $bol = [true, false];
//        for ( $i = 0; $i < 10; $i++ ) {
//            $udal = $udalak[array_rand($udalak)];
//            $zir = new Zigorra();
//            $zir->setUdala($udal);
//            $k = $i + 10;
//            $zir->setName("Zigorra-$udal-$k");
//            $zir->setCanRent($bol[array_rand($bol)]);
//            $zir->setEgunak($k);
//            $manager->persist($zir);
//        }
//        UserFactory::createMany(100, function () use ($udalak) {
//            return [
//                'udala' => $udalak[array_rand($udalak)]
//            ];
//        });
//        GuneaFactory::createMany(12, function () use ($udalak) {
//            return [
//                'udala' => $udalak[array_rand($udalak)]
//            ];
//        });
//        BizikletaFactory::createMany(40, function () use ($udalak) {
//            return [
//                'udala' => $udalak[array_rand($udalak)]
//            ];
//        });
//        IbilbideaFactory::createMany(40, function () use ($udalak) {
//            return [
//                'udala' => $udalak[array_rand($udalak)]
//            ];
//        });
//        EguraldiaFactory::createMany(40, function () use ($udalak) {
//            return [
//                'udala' => $udalak[array_rand($udalak)]
//            ];
//        });
//        ZigorraFactory::createMany(40, function () use ($udalak) {
//            return [
//                'udala' => $udalak[array_rand($udalak)]
//            ];
//        });

        $manager->flush();
    }
}
