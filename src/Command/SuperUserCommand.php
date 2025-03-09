<?php

namespace App\Command;

use App\Entity\Udala;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:super-user',
    description: 'Add a short description for your command',
)]
class SuperUserCommand extends Command
{
    protected UserPasswordHasherInterface $encoder;
    protected EntityManagerInterface $manager;

    public function __construct( UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->encoder = $passwordHasher;
        $this->manager = $manager;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');

        $qName = new Question('Izena => ', 'superadmin');
        $qEmail = new Question('Email => ', 'iibarguren@pasaia.net');
        $qLang= new Question('Hizkuntza (eu/es) => ', 'eu');
        $qUsername = new Question('Erabiltzaile izena => ', 'superadmin');
        $qPasswd= new Question('Pasahitza => ', 'superadmin');
        //$qUdala= new Question('Udala (pasaia/lezo/...) => ', 'pasaia');

        $name = $helper->ask($input, $output, $qName);
        $email = $helper->ask($input, $output, $qEmail);
        $lang = $helper->ask($input, $output, $qLang);
        $username = $helper->ask($input, $output, $qUsername);
        $passwd = $helper->ask($input, $output, $qPasswd);
        //$udalaText = $helper->ask($input, $output, $qUdala);

//        $udala = $this->manager->getRepository(Udala::class)->findUdalaNameContainsText($udalaText);
//
//        if (!$udala) {
//            $io->error('Udala ez da topatu');
//            return Command::FAILURE;
//        }
//
//        $udala = $udala[0];

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setLanguage($lang);
        $user->setUsername($username);
        $user->setRoles(['ROLE_SUPER_ADMIN']);

     //   $user->setUdala($udala);
        $hashedPassword = $this->encoder->hashPassword(
            $user,
            $passwd
        );
        $user->setPassword($hashedPassword);

        $this->manager->persist($user);
        $this->manager->flush();

        $io->success('Erabiltzailea sortu da.');

        return Command::SUCCESS;
    }
}
