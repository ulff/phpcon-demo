<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ClearProjectionCommand extends ProjectionCommand
{

    /**
     * Configuration
     */
    protected function configure()
    {
        $help = <<<TXT
\tThe <info>%command.name%</info> command removes all items from selected projection.
\t<info>php %command.full_name% --name=populator-name</info>
TXT;

        $this
            ->setName('ulff:projection:clear')
            ->setDescription('Clears selected projection')
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'Name of the projection you want to clear',
                null
            )
            ->setHelp($help);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->validateParameters($input, $output);

        $populator = $this->getPopulator();
        $populator->clear();

        $output->writeln('Finished!');
        $output->writeln(
            sprintf(
                'Removed <info>%s</info> projections',
                $populator->getStats()->getRemoved()
            )
        );

        return;
    }
}
