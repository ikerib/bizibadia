<?php

namespace App\Command;

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
    name: 'app:super-user-change-passwd',
    description: 'Add a short description for your command',
)]
class SuperUserChangePasswdCommand extends Command
{
    protected EntityManagerInterface $entityManager;
    protected UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'Erabiltzaile izena')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');

        if ($username) {
            $io->note(sprintf('Zehaztu erabiltzaile izena. Adibidez app:super-user-change-password superadmin'));
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (!$user) {
            $io->error('Ez da erabiltzailerik aurkitu erabiltzaile izen horrekin');
            return Command::FAILURE;
        }

        $helper = $this->getHelper('question');

        $qPass = new Question('Pasahitz berria => ', '');
        $passwd = $helper->ask($input, $output, $qPass);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $passwd
        );
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('Pasahitza aldatua izan da.');

        return Command::SUCCESS;
    }
}
