<?php

namespace App\Command;

use App\Entity\Ibilbidea;
use App\Entity\Udala;
use App\Entity\Zigorra;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'app:import:05-zigorra',
    description: 'Add a short description for your command',
)]
class Import05ZigorraCommand extends Command
{
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

        $zigorrak = $this->getCsvAsArray($filename);
        $progressBar = new ProgressBar($output, count($zigorrak));
        $progressBar->start();

        $udala = $em->getRepository(Udala::class)->findOneBy(['id' => 1]);

        foreach ($zigorrak as $z) {
            $zi = new Zigorra();
            $zi->setUdala($udala);
            $zi->setName($z['izena']);
            $zi->setEgunak((int)$z['egunak']);
            $zi->setCanRent($z['alokatzen_utzi']);
            $zi->setDeskribapena($z['deskribapena']);
            $zi->setMaila($z['maila']);
            $zi->setZenbatekoa((float)$z['zenbatekoa']);
            $zi->setOldid($z['id']);
            $em->persist($zi);
            $progressBar->advance();
        }
        $em->flush();
        $io->success('zigorrak inportatu dira.');
        return Command::SUCCESS;
    }

    private function getCsvAsArray($filename) {
        $inputFile = $this->projectDir . '/' . $filename ;
        $decorder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        return $decorder->decode(file_get_contents($inputFile), 'csv', [CsvEncoder::DELIMITER_KEY => '|']);
    }
}
