<?php

namespace App\Command;

use App\Entity\Udala;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'app:import:02-bezeroa',
    description: 'Add a short description for your command',
)]
class Import02BezeroaCommand extends Command
{
    protected UserPasswordHasherInterface $encoder;
    protected EntityManagerInterface $manager;
    private string $projectDir;

    public function __construct( $projectDir, UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $manager)
    {
        $this->projectDir = $projectDir;
        parent::__construct();
        $this->encoder = $passwordHasher;
        $this->manager = $manager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('fitxategia', InputArgument::REQUIRED, 'fitxategia')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('fitxategia');
        $em = $this->manager;

        $bezeroak = $this->getCsvAsArray($filename);
        $progressBar = new ProgressBar($output, count($bezeroak));
        $progressBar->start();

        $udala = $em->getRepository(Udala::class)->findOneBy(['id' => 1]);

        foreach ($bezeroak as $b) {
            $user = new User();
            $user->setName($b['izena']);
            $user->setSurname($b['izena']);
            $user->setUsername($b['nan']);
            $hashedPassword = $this->encoder->hashPassword(
                $user,
                $b['nan']
            );
            $user->setPassword($hashedPassword);
            $user->setUdala($udala);
            $user->setNan($b['nan']);
            $user->setBazkidea($b['bazkidea']);
            $user->setOrdainketa($b['ordainketa']);
            $user->setPasaitarra($b['pasaitarra']);
            $user->setMugikorra($b['mugikorra']);
            $user->setEmail($b['email']);
            $user->setSinatuta($b['sinatuta']);
            $user->setOharrak($b['oharrak']);
            $user->setAlokatua($b['alokatua']);
            $user->setUdallangilea($b['udallangilea']);
            $user->setBaimenberezia($b['baimenberezia']);
            $user->setIraungitze(new \DateTime($b['iraungitze']));
            $user->setOldid($b['id']);
            $em->persist($user);
            $progressBar->advance();
        }
        $em->flush();

        $io->success('Bezeroak inportatu dira.');

        return Command::SUCCESS;
    }

    private function getCsvAsArray($filename) {
        $inputFile = $this->projectDir . '/' . $filename ;
        $decorder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        return $decorder->decode(file_get_contents($inputFile), 'csv', [CsvEncoder::DELIMITER_KEY => '|']);
    }
}
