<?php

namespace App\DependencyInjection;


use App\Algorithm\CompositeEncodingAlgorithm;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EncodingCompilerPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    private $compositeService;
    private $loaderTag;

    /**
     * EncodingCompilerPass constructor.
     * @param $compositeService
     * @param $loaderTag
     */
    public function __construct($compositeService = CompositeEncodingAlgorithm::class, $loaderTag = 'app.encoding_algorithm')
    {
        $this->compositeService = $compositeService;
        $this->loaderTag = $loaderTag;
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->compositeService)) {
            return;
        }

        $composite = $container->findDefinition($this->compositeService);

        foreach ($this->findAndSortTaggedServices($this->loaderTag, $container) as $id) {
            $composite->addMethodCall('add', [$id]);
        }
    }

}
