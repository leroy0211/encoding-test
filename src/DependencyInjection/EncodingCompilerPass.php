<?php

namespace App\DependencyInjection;


use App\Algorithm\CompositeEncodingAlgorithm;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EncodingCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(CompositeEncodingAlgorithm::class)) {
            return;
        }

        $composite = $container->findDefinition(CompositeEncodingAlgorithm::class);

        $encoders = $container->findTaggedServiceIds('app.encoding_algorithm');

        foreach ($encoders as $encoder => $tags) {
            $composite->addMethodCall('add', [new Reference($encoder)]);
        }
    }

}
