<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
 */
namespace Arikaim\Extensions\Translations\Console;

use Arikaim\Core\Console\ConsoleCommand;
use Arikaim\Core\Console\ConsoleHelper;
use Arikaim\Core\Arikaim;
use Arikaim\Extensions\Translations\Console\TranslateConsole;

/**
 * Translate theme component command
 */
class TranslateComponent extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('translate:component')->setDescription('Translate component.');
        $this->addOptionalArgument('theme','Theme Name'); 
        $this->addOptionalArgument('component','Theme component name'); 
        $this->addOptionalArgument('language','Translate to language code'); 
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function executeCommand($input, $output)
    {       
        $translate = new TranslateConsole(function($componentName,$indent) {
            $this->style->write(\str_pad("- ",$indent," ",STR_PAD_LEFT) . ConsoleHelper::getLabelText($componentName,'yellow'));
        },function($componentName) {
            $this->style->writeLn(ConsoleHelper::getLabelText(' done'));
        },function($componentName,$message) {
            $this->style->writeLn(ConsoleHelper::getLabelText($message,'red'));
        },function($componentName) {
            $this->style->writeLn('');
        });

        $theme = $input->getArgument('theme');       
        if (empty($theme) == true) {
            $this->showError("Missing theme name option!");
            return;
        }
        
        $componentName = $input->getArgument('component');
        if (empty($componentName) == true) {
            $this->showError("Missing component name option!");
            return;
        }

        $language = $input->getArgument('language');
        if (empty($language) == true) {
            $this->showError("Missing language code option!");
            return;
        }

        $manager = Arikaim::packages()->create('template');
        if ($manager->hasPackage($theme) == false) {
            $this->showError("Theme name $theme not valid!");
            return;
        }

        $driverName = Arikaim::options()->get('translations.service.driver');
        $driver = Arikaim::driver()->create($driverName);
        if (\is_object($driver) == false) {
            $this->showError('Not valid translation api driver');
            return;
        }

        $package = $manager->createPackage($theme);
    
        $this->style->writeLn('');
        $this->showTitle('Translate component ');

        $this->style->writeLn('Theme: ' . ConsoleHelper::getLabelText($theme,'green'));
        $this->style->writeLn('Component: ' . ConsoleHelper::getLabelText($componentName,'green'));
        $this->style->write('From ' . ConsoleHelper::getLabelText('en','green'));
        $this->style->writeLn(' to ' . ConsoleHelper::getLabelText($language,'green') . ' language.');
        $this->style->writeLn('Translation Driver: ' . ConsoleHelper::getLabelText($driverName,'green'));

        $this->style->writeLn('');
       
        $translate->translateComponent($package,$driver,$language,$componentName);

        $this->style->writeLn('');
        $this->showCompleted();
    }    
}
