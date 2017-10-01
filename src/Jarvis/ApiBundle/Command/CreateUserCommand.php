<?php

namespace Jarvis\ApiBundle\Command;

use Jarvis\DomainBundle\Entity\Access\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-user')
            ->setDescription('Create user in application')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $user = new User();
        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($user);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $encoded = $encoder->encodePassword($password, '');

        $user
            ->setUsername($username)
            ->setPassword($encoded);

        try {
            $em->persist($user);
            $em->flush($user);

            $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
        } catch (\Exception $e) {
            $output->writeln(sprintf('Can\'t create user <comment>%s</comment>', $username));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('username')) {
            $question = new Question('Please choose a username: ');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }
                return $username;
            });
            $questions['username'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password: ');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }
                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}
