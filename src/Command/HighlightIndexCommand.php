<?php

namespace App\Command;

use App\Entity\Disc;
use App\Entity\Artists;
use App\Entity\HighlightIndex;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HighlightIndexCommand extends Command
{
    protected static $defaultName = 'app:highlight-index';
    private $container;

    public function __construct(ContainerInterface $container)
{
    parent::__construct();
    $this->container = $container;
}

    protected function configure()
    {
        $this
            ->setDescription('Change the highlight on the index page')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->container->get('doctrine')->getManager();
        
        $repoArtist = $this->container->get('doctrine')->getRepository(Artists::class);
        $artist = $repoArtist->findOneRandomArtist();

        $repoDisc = $this->container->get('doctrine')->getRepository(Disc::class);
        $disc = $repoDisc->findOneRandomDisc();

        $repoHighlight = $this->container->get('doctrine')->getRepository(HighlightIndex::class);
        $highlight = $repoHighlight->findAll();


        foreach ($highlight as $value) {
            
            if($value->getName() == "artists"){

                while($value->getTargetId() == $artist->getId()){

                    $artist = $repoArtist->findOneRandomArtist();

                }

                $value->setTargetId($artist->getId());

            }

            if($value->getName() == "disc"){

                while($value->getTargetId() == $disc->getId()){

                    $disc = $repoDisc->findOneRandomDisc();

                }

                $value->setTargetId($disc->getId());
            }

            
            $em->persist($value);
            $em->flush();
        }

        $io->success('You have set new highlight.');

        return 0;
    }
}
