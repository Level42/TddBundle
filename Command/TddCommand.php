<?php
/**
 * This file is part of Level42TddBundle.
 *
 * (c) Level42
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\TddBundle\Command;

use Level42\TddBundle\Exceptions\FileAllreadyExistException;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Level42\TddBundle\Services\GeneratorInterface;

/**
 * Main command class
 * @author fperinel
 *
 */
class TddCommand extends Command
{
    /**
     * Service container
     * @var Container
     */
    private $container = null;
    
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {     
        $this->setName('tdd:generate')
                ->setDescription('Generate test class for a Bundle')
                ->addArgument('bundle', InputArgument::REQUIRED, 'Bundle name to scan')
                ->addOption('force', null, InputOption::VALUE_NONE, 'If set, the existing files will be replaced');   
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generated = false;
        $this->container = $this->getApplication()->getKernel()->getContainer();     
        
        $bundle = $input->getArgument('bundle');
        $force = $input->getOption('force');
        $force = ($force != null ? true : false);

        $output->writeln("<info>Generate test classes for bundle $bundle</info>");
        
        $service = $this->container->get('level42.tdd.generator.service');
        /* @var $service GeneratorInterface */
        
        try {
            $testClasses = $service->scanForClassToTest($bundle);
            
            foreach ($testClasses as $testClass)
            {
            	try {
            		$testCases = $service->getTestCase($testClass);
            		$output->writeln("<comment>  Class '$testClass' contain ".count($testCases)." methods to test</comment>");
            
            		$output->writeln("<info>  Generating '$testClass' test class</info>");
            		$code = $service->generateTestClass($testClass, $testCases);
            
            		$path = $service->getTestClassPath($testClass);
            		$service->saveTestClass($path, $code, $force);
            		$generated = true;
            		$output->writeln("<comment>  Test class saved in '$path'</comment>");
            	} catch (FileAllreadyExistException $ex) {
            		$output->writeln("<comment>  Test class '$testClass' allready exist (use --force argument to overwrite)</comment>");
            	} catch (\Exception $ex) {
            		$output->writeln("<error>  Exception for '$testClass' class</error>");
            		$output->writeln("<error>    ".$ex->getMessage()."</error>");
            	}
            }
        } catch (BundleNotFoundException $ex) {
            $output->writeln("<error>  EXCEPTION for '$bundle' bundle</error>");
            $output->writeln("<error>    ".$ex->getMessage()."</error>");
        }

        if ($generated) 
        {
            $output->writeln("<info>Success</info>");
        } else {
            $output->writeln("<info>No test classes to generate</info>");
        }
    }
}
