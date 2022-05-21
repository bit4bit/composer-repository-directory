<?php

namespace Bit4bit\ComposerRepositoryDirectory;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\Loader\ArrayLoader;
use Composer\Plugin\PluginInterface;
use Composer\Json\JsonFile;
use Composer\Semver\Constraint\MatchAllConstraint;

class Plugin implements PluginInterface
{
    public function activate($composer, $io)
    {
        $loader = new ArrayLoader(null, true);
        $repositoryManager = $composer->getRepositoryManager();
        $config = $composer->getPackage()->getExtra()['composer-repository-directory'] ?? [];
        $directories = $config['directories'] ?? [];
        $requires = $config['require'] ?? [];
        $devRequires = $config['require-dev'] ?? [];

        foreach($directories as $directory) {
            $packages = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR|GLOB_NOSORT);

            foreach($packages as $package) {
                $composer_of_package = $package . DIRECTORY_SEPARATOR . 'composer.json';
                
                if(!file_exists($composer_of_package)) continue;

                $jsonFile = new JsonFile($composer_of_package);
                $packageData = $jsonFile->read();

                // use path repository
                $localRepository = $repositoryManager->createRepository(
                    'path', ['url' => $package], $packageData['name']
                );
                $repositoryManager->addRepository($localRepository);
            }
        }

        $requiresLink = $loader->parseLinks(
            $composer->getPackage()->getName(),
            $composer->getPackage()->getFullPrettyVersion(),
            'requires',
            $requires,
        );
        $devRequiresLink = $loader->parseLinks(
            $composer->getPackage()->getName(),
            $composer->getPackage()->getFullPrettyVersion(),
            'devRequires',
            $devRequires);
        
        $composer->getPackage()->setRequires(
            array_merge($composer->getPackage()->getRequires(), $requiresLink)
        );
        $composer->getPackage()->setDevRequires(
            array_merge($composer->getPackage()->getDevRequires(), $devRequiresLink)
        );
    }

    public function deactivate($composer, $io)
    {
    }
    
    public function uninstall($composer, $io)
    {
    }
}
