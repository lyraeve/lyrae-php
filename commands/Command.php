<?php 
namespace Console;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Finder\JavBus\Parser;
class Command extends SymfonyCommand {
  public function __construct() {
    parent::__construct();
  }
  protected function findNumberCmd(InputInterface $input, OutputInterface $output) {

    $output -> write(var_dump($this -> findNumber($input -> getArgument('number'))));
    $output -> writeln(['']);
  }
  private function findNumber($number) {
    $ps = new Parser;
    return $ps-> run_parser($number);
  }
}
?>