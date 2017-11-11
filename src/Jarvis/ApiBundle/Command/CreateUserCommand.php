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
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = $userManager->findUserByUsername($username);

        if ($user === null) {
            /** @var User $user */
            $user = $userManager->createUser();

            $user->setUsername($username);
            $user->setEmail($email);
            $user->setEnabled(true);
            $user->addRole('ROLE_USER');
            $user->setPlainPassword($password);
            $userManager->updateUser($user);

            try {
                $em->persist($user);
                $em->flush($user);

                $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
            } catch (\Exception $e) {
                $output->writeln(sprintf('Can\'t create user <comment>%s</comment>', $username));
            }
        } else {
            $output->writeln(sprintf('User <comment>%s</comment> already exists', $username));
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

        if (!$input->getArgument('email')) {
            $question = new Question('Please choose an email: ');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }
                return $email;
            });
            $questions['email'] = $question;
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
