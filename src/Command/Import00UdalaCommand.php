<?php

namespace App\Command;

use App\Entity\Udala;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-00-udala',
    description: 'Add a short description for your command',
)]
class Import00UdalaCommand extends Command
{
    protected EntityManagerInterface $manager;

    public function __construct( $projectDir, EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->manager;

        $udala = new Udala();
        $udala->setName('Pasaiako Udala');
        $em->persist($udala);
        $em->flush();

        $io->success('Udala sortu da.');

        return Command::SUCCESS;
    }
}
