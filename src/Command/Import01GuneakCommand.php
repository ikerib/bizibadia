<?php

namespace App\Command;

use App\Entity\Bizikleta;
use App\Entity\Gunea;
use App\Entity\Udala;
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
use Symfony\Component\Serializer\SerializerInterface;


#[AsCommand(
    name: 'app:import:01-guneak',
    description: 'Guneak inportatu',
)]
class Import01GuneakCommand extends Command
{
    protected static $defaultName = 'app:import:01-guneak';
    protected static $defaultDescription = 'Guneak inportatu';

    protected EntityManagerInterface $manager;
    private string $projectDir;

    public function __construct( $projectDir, EntityManagerInterface $manager)
    {
        $this->projectDir = $projectDir;
        parent::__construct();
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

        $guneak = $this->getCsvAsArray($filename);
        $progressBar = new ProgressBar($output, count($guneak));
        $progressBar->start();

        $udala = $em->getRepository(Udala::class)->findOneBy(['id' => 1]);

        foreach ($guneak as $g) {
            $gunea = new Gunea();
            $gunea->setUdala($udala);
            $gunea->setName($g['izena']);
            $gunea->setHelbidea($g['helbidea']);
            $gunea->setOrdutegia($g['ordutegia']);
            $gunea->setLatitude($g['latitude']);
            $gunea->setLongitude($g['longitude']);
            $gunea->setOldid($g['id']);
            $em->persist($gunea);
            $progressBar->advance();
        }
        $em->flush();
        $io->success('Guneak inportatu dira.');

        return Command::SUCCESS;
    }

    private function getCsvAsArray($filename) {
        $inputFile = $this->projectDir . '/' . $filename ;
        $decorder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        return $decorder->decode(file_get_contents($inputFile), 'csv', [CsvEncoder::DELIMITER_KEY => '|']);
    }
}
