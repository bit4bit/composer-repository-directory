<?php

namespace Bit4bit\ComposerRepositoryDirectory;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Json\JsonFile;

class Plugin implements PluginInterface
{
    public function activate($composer, $io)
    {
        $repositoryManager = $composer->getRepositoryManager();
        $config = $composer->getPackage()->getExtra()['composer-repository-directory'] ?? [];
        $directories = $config['directories'] ?? [];

        foreach($directories as $directory) {
            $packages = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR|GLOB_NOSORT);
            foreach($packages as $package) {
                $composer_of_package = $package . DIRECTORY_SEPARATOR . 'composer.json';
                if(file_exists($composer_of_package)) continue;

                $packageData = JsonFile::parseJson(null, $composer_of_package);

                $localRepository = $repositoryManager->createRepository('path',
                                                                        ['url' => $package],
                                                                        $packageData['name']);
                $repositoryManager->addRepository($localRepository);
            }
        }
    }

    public function deactivate($composer, $io)
    {
    }
    
    public function uninstall($composer, $io)
    {
    }
}
