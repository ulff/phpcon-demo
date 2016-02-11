<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateProjectionCommand extends ProjectionCommand
{

    /**
     * Configuration
     */
    protected function configure()
    {
        $help = <<<TXT
\tThe <info>%command.name%</info> command populates (or re-populates) selected projection.
\t<info>php %command.full_name% --name=populator-name</info>
TXT;

        $this
            ->setName('ulff:projection:populate')
            ->setDescription('Populates (or re-populates) selected projection')
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'Name of the projection you want to (re)populate',
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
        $populator->run();

        $output->writeln('Finished!');
        $output->writeln(
            sprintf(
                'Removed <info>%d</info> projections',
                $populator->getStats()->getRemoved()
            )
        );
        $output->writeln(
            sprintf(
                'Processed <info>%d</info> of total <info>%d</info> events from EventStorage',
                $populator->getStats()->getProcessedEvents(),
                $populator->getStats()->getTotalEvents()
            )
        );
        $output->writeln(
            sprintf(
                'Loaded <info>%d</info> new projections',
                $populator->getStats()->getPopulatedProjections()
            )
        );
    }
}