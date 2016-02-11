<?php

namespace AppBundle\Command;

use Domain\ReadModel\ProjectionPopulator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ProjectionCommand extends ContainerAwareCommand
{

    const EXIT_CODE_EMPTY_PARAMETER = 4001;
    const EXIT_CODE_INVALID_PREFIX = 4002;

    /**
     * @var string
     */
    protected $populatorClassName;

    /**
     * @var string
     */
    protected $listenerClassName;

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function validateParameters(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption('name');
        if (empty($name)) {
            $errorMessage = sprintf('Empty required parameter <info>name</info>');

            throw new \Exception($errorMessage, ProjectionCommand::EXIT_CODE_EMPTY_PARAMETER);
        }

        $this->resolveClassName($name);
        if (!class_exists($this->populatorClassName)) {
            $errorMessage = sprintf(
                'Invalid class prefix: <info>%s</info>, class <info>%s</info> does not exist',
                $name,
                $this->populatorClassName
            );

            throw new \Exception($errorMessage, ProjectionCommand::EXIT_CODE_INVALID_PREFIX);
        }
    }

    /**
     * @param string $name
     */
    protected function resolveClassName($name)
    {
        $prefix = str_replace('-', '', ucwords($name, '-'));
        $this->populatorClassName = 'Domain\\ReadModel\\Populator\\'.$prefix.'Populator';
        $this->listenerClassName = 'Domain\\ReadModel\\Listener\\'.$prefix.'Listener';
    }

    /**
     * @return ProjectionPopulator
     */
    protected function getPopulator()
    {
        /** @var $populator ProjectionPopulator */
        $populator = new $this->populatorClassName(
            $this->getContainer()->get('event_storage'),
            $this->getContainer()->get('bulk_projection_storage'),
            new $this->listenerClassName(
                $this->getContainer()->get('event_bus'),
                $this->getContainer()->get('bulk_projection_storage')
            )
        );

        return $populator;
    }
}