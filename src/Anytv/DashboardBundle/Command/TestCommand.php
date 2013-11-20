<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:test')
            ->setDescription('Testing command line.')
            ->addArgument('say', InputArgument::OPTIONAL, 'What do you want to say?')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $say = $input->getArgument('say');
        
        $text = 'Testing... ';
        if ($say) 
        {
            $text .= $say;
        } 

        if ($input->getOption('yell')) {
            $text = strtoupper($text);
        }
        
        $kernel = $this->getApplication()->getKernel();
                
        $output->writeln($text.' - '.$kernel->getEnvironment());
    }
}
