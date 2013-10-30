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
        if ($say) {
            $text = 'Saying... '.$say;
        } else {
            $text = 'Saying...';
        }

        if ($input->getOption('yell')) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
        
        $mailer = $this->getContainer()->get('mailer');
        
        $message = \Swift_Message::newInstance()
                  //->setContentType('text/html')
                  ->setSubject('Test email')
                  ->setFrom('support@any.tv', 'any.TV')
                  ->setTo('dennis@any.tv')
                  ->setBody('This is a test email for Dennis.');
            
                $mailer->send($message);  
    }
}
