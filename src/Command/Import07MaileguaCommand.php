<?php

namespace App\Command;

use App\Entity\Bizikleta;
use App\Entity\Eguraldia;
use App\Entity\Gunea;
use App\Entity\Ibilbidea;
use App\Entity\Mailegua;
use App\Entity\Udala;
use App\Entity\User;
use App\Entity\Zigorra;
use DateTime;
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
    name: 'app:import:07-mailegua',
    description: 'Add a short description for your command',
)]
class Import07MaileguaCommand extends Command
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

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('fitxategia');
        $em = $this->manager;

        $maileguak = $this->getCsvAsArray($filename);
        $progressBar = new ProgressBar($output, count($maileguak));
        $progressBar->start();
        $udala = $em->getRepository(Udala::class)->findOneBy(['id' => 1]);

        foreach ($maileguak as $m) {
            $ma = new Mailegua();
            $ma->setUdala($udala);
            $u = $em->getRepository(User::class)->findOneBy(['oldid' => $m['bezeroa_id']]);
            $ma->setErabiltzailea($u);
            $ma->setDateStart(new DateTime($m['fetxa_hasi']));
            $ma->setDateEnd(new DateTime($m['fetxa_amaitu']));
            if ( $m['eguraldia_id'] !== "" ) {
                $eguraldia = $em->getRepository(Eguraldia::class)->findOneBy(['oldid' => $m['eguraldia_id']]);
                $ma->setEguraldia($eguraldia);
            }

            $guneHasi = $em->getRepository(Gunea::class)->findOneBy(['oldid' => $m['guneahasi_id']]);
            $ma->setStartGunea($guneHasi);
            if ( $m['guneaamaitu_id'] !== "" ) {
                $guneEnd = $em->getRepository(Gunea::class)->findOneBy(['oldid' => $m['guneaamaitu_id']]);
                $ma->setEndGunea($guneEnd);
            }
            if ( $m['bizikleta_id'] ) {
                $bizikleta = $em->getRepository(Bizikleta::class)->findOneBy(['oldid' => $m['bizikleta_id']]);
                $ma->setBizikleta($bizikleta);
            }
            if ($m['ibilbidea_id'] !== "") {
                $ibi = $em->getRepository(Ibilbidea::class)->findOneBy(['oldid' => $m['ibilbidea_id']]);
                $ma->setIbilbidea($ibi);
            }

            $em->persist($ma);
            $progressBar->advance();
        }

        $em->flush();
        $io->success('Maileguak inportatu dira.');
        return Command::SUCCESS;
    }

    private function getCsvAsArray($filename) {
        $inputFile = $this->projectDir . '/' . $filename ;
        $decorder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        return $decorder->decode(file_get_contents($inputFile), 'csv', [CsvEncoder::DELIMITER_KEY => '|']);
    }
}
