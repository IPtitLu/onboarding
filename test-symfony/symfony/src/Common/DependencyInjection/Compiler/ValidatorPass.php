<?php

namespace App\Common\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

class ValidatorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $validatorBuilder = $container->getDefinition('validator.builder');
        $validatorFiles = [];
        $finder = new Finder();
        try {
            foreach ($finder->files()->in($container->getParameter('kernel.root_dir') . '/Domain/*/Validation')->name('/.*\.ya?ml/') as $file) {
                $validatorFiles[] = $file->getRealPath();
            }
            $validatorBuilder->addMethodCall('addYamlMappings', [$validatorFiles]);
        } catch (DirectoryNotFoundException $e) {
        }
    }
}