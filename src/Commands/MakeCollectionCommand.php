<?php

namespace Winavin\MagicCollection\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeCollectionCommand extends GeneratorCommand
{
    protected $signature = 'make:collection {name}';

    protected $description = 'Create a new custom Eloquent Collection class';

    protected $type = 'Collection';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/collection.php.stub';
    }

    protected function getDefaultNamespace( $rootNamespace )
    {
        return $rootNamespace . '\\Collections';
    }

    protected function getArguments()
    {
        return [
            [ 'name', InputArgument::REQUIRED, 'The name of the collection class' ],
        ];
    }
}
