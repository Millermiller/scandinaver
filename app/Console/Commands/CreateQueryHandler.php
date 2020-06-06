<?php


namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class CreateQueryHandler
 *
 * @package App\Console\Commands
 */
class CreateQueryHandler extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'createQueryHandler';

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    protected $queryHandlerPath = 'Application/Handlers';

    /**
     * @var string
     */
    protected $type = 'QueryHandler';

    /**
     * @inheritDoc
     */
    protected function getStub(): string
    {
        return __DIR__ . '/Stubs/custom-query-handler.stub';
    }

    /**
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return "Scandinaver";
    }

    /**
     * @return bool|void|null
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $name = $this->getNameInput();

        $this->domain = $this->argument('domain');

        $path = $this->getPath($name);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type . ' created successfully.');

        Artisan::call('createQueryHandlerInterface', [
            'name'   => "{$name}Interface",
            'domain' => $this->domain
        ]);
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
            ['domain', InputArgument::REQUIRED, 'The name of the domain'],
        ];
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->getDefaultNamespace($name), '', $name);
        $name = str_replace('\\', '/', $name);
        $path = Str::replaceFirst('app', '', $this->laravel['path']);

        return "{$path}src/{$this->getDefaultNamespace($name)}/{$this->domain}/{$this->queryHandlerPath}/{$name}.php";
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getNamespace($name): string
    {
        $queryNamespace = str_replace('/', '\\', $this->queryHandlerPath);
        return "{$this->getDefaultNamespace($name)}\\$this->domain\\$queryNamespace";
    }

    /**
     * @param string $stub
     * @param string $name
     *
     * @return string|string[]
     */
    protected function replaceClass($stub, $name)
    {
        $class          = str_replace($this->getNamespace($name) . '\\', '', $name);
        $queryNamespace = str_replace('/', '\\', 'Application/Query');
        $queryClass     = str_replace('Handler', 'Query', $class);
        return str_replace([
            'DummyClass',
            'DummyQueryClass',
            'DummyQueryNamespace'
        ], [$class, $queryClass, "{$this->getDefaultNamespace($name)}\\$this->domain\\$queryNamespace\\$queryClass"], $stub);
    }
}