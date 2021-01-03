<?php

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container_configurator): void {
    $parameters = $container_configurator->parameters();
    $parameters->set(Option::SETS, [
        // SetList::DEFLUENT,
        // SetList::ACTION_INJECTION_TO_CONSTRUCTOR_INJECTION,
        // SetList::CODE_QUALITY,
        // SetList::CODE_QUALITY_STRICT,
        // SetList::CODING_STYLE,
        // SetList::DEAD_CLASSES,
        // SetList::DEAD_CODE,
        // SetList::DEAD_DOC_BLOCK,
        SetList::LARAVEL_CODE_QUALITY,
        // SetList::LARAVEL_STATIC_TO_INJECTION,
        // SetList::ORDER,
        // SetList::PERFORMANCE,
        // SetList::PHP_80,
        // SetList::PHP_DI_DECOUPLE,
        // SetList::PHPUNIT_CODE_QUALITY,
        // SetList::PHPUNIT_EXCEPTION,
        // SetList::PHPUNIT_INJECTOR,
        // SetList::PHPUNIT_MOCK,
        // SetList::PHPUNIT_SPECIFIC_METHOD,
        // SetList::PHPUNIT_YIELD_DATA_PROVIDER,
        // SetList::PRIVATIZATION,
        // SetList::PSR_4,
        SetList::TYPE_DECLARATION,
        SetList::UNWRAP_COMPAT,
        SetList::EARLY_RETURN,
        // SetList::CARBON_2,
    ]);
};
