<?php 
namespace Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\Command;

class FindConmmand extends Command {
  public function configure() {
    $this -> setName('find')
      -> setDescription('查詢番號的指令')
      -> setHelp('find <番號>')
      -> addArgument('number', InputArgument::REQUIRED, '<番號>');
  }

  public function execute(InputInterface $input, OutputInterface $output) {
    $this -> findNumberCmd($input, $output);
    return 0;
  }
}
?>