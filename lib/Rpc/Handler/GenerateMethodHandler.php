<?php

namespace Phpactor\Rpc\Handler;

use Phpactor\Rpc\Handler;
use Phpactor\Rpc\Editor\EchoAction;
use Phpactor\CodeTransform\Domain\Refactor\GenerateMethod;
use Phpactor\Rpc\Editor\InputCallbackAction;
use Phpactor\Rpc\ActionRequest;
use Phpactor\Rpc\Editor\Input\TextInput;
use Phpactor\Rpc\Editor\ReplaceFileSourceAction;
use Phpactor\Rpc\Handler\AbstractHandler;

class GenerateMethodHandler extends AbstractHandler
{
    const NAME = 'generate_method';
    const PARAM_OFFSET = 'offset';
    const PARAM_SOURCE = 'source';
    const PARAM_PATH = 'path';

    /**
     * @var GenerateMethod
     */
    private $generateMethod;

    public function __construct(GenerateMethod $generateMethod)
    {
        $this->generateMethod = $generateMethod;
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function defaultParameters(): array
    {
        return [
            self::PARAM_PATH => null,
            self::PARAM_SOURCE => null,
            self::PARAM_OFFSET => null,
        ];
    }

    public function handle(array $arguments)
    {
        $sourceCode = $this->generateMethod->generateMethod(
            $arguments[self::PARAM_SOURCE],
            $arguments[self::PARAM_OFFSET]
        );

        return ReplaceFileSourceAction::fromPathAndSource($arguments[self::PARAM_PATH], (string) $sourceCode);
    }
}
