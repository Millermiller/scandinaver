<?php


namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class CreateCommandHandlerInterface
 *
 * @package App\Console\Commands
 */
class RebuildCommandsProvider extends GeneratorCommand
{

    protected $name = 'scandinaver:rebuild:commands';

    protected $description = 'Update service provider bindings';

    private ?string $domain;

    protected string $serviceProviderPath = 'Infrastructure';

    protected $type = 'Service provider';

    protected function getStub(): string
    {
        return __DIR__ . '/Stubs/custom-service-provider.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "Scandinaver";
    }

    protected function getArguments(): array
    {
        return [
            ['domain', InputArgument::REQUIRED, 'The name of the domain']
        ];
    }

    public function handle(): void
    {

        $this->domain = $this->argument('domain');
        $name = "{$this->domain}ServiceProvider";
        $path = $this->getPath($name);

        $rootPath = Str::replaceFirst('app', '', $this->laravel['path']);

        $commands = $this->files->files("$rootPath/src/Scandinaver/$this->domain/UI/Command");
        $queries = $this->files->files("$rootPath/src/Scandinaver/$this->domain/UI/Query");

        $commandBindings = $queryBindings = [];

        foreach ($commands as $command) {
            $class = Str::replaceFirst('Command.php', '', $command->getFilename());
            $classHandlerInterface = "{$class}HandlerInterface";
            $classHandler = "{$class}Handler";

            $commandBindings[] =
                '$this->app->bind('.PHP_EOL."            ".
                '\''.$classHandlerInterface.'\','.PHP_EOL."            ".
                '\'Scandinaver\\'.$this->domain.'\Application\Handler\Command\\'.$classHandler.'\''.PHP_EOL."        ".
                ');';
        }

        foreach ($queries as $query) {
            $class = Str::replaceFirst('Query.php', '', $query->getFilename());
            $classHandlerInterface = "{$class}HandlerInterface";
            $classHandler = "{$class}Handler";

            $queryBindings[] =
                '$this->app->bind('.PHP_EOL."            ".
                '\''.$classHandlerInterface.'\','.PHP_EOL."            ".
                '\'Scandinaver\\'.$this->domain.'\Application\Handler\Query\\'.$classHandler.'\''.PHP_EOL."        ".
                ');';
        }

        $serviceprovider = $this->buildClass($name);

        $serviceprovider = Str::replaceFirst('commands', implode(PHP_EOL.PHP_EOL."        ", $commandBindings), $serviceprovider);
        $serviceprovider = Str::replaceFirst('queryes', implode(PHP_EOL.PHP_EOL."        ", $queryBindings), $serviceprovider);

        //$this->files->put("$rootPath/src/Scandinaver/$this->domain/Infrastructure/qwe.php", $serviceprovider);
        //$this->files->chmod("$rootPath/src/Scandinaver/$this->domain/Infrastructure/qwe.php", 0777);

        $this->files->replace($path, $serviceprovider);

        $this->files->chmod($path, 0777);

        $this->info($name . ' created successfully.');
    }

    protected function getPath($name): string
    {
        $path = Str::replaceFirst('app', '', $this->laravel['path']);

        return "{$path}src/Scandinaver/{$this->domain}/Infrastructure/{$name}.php";
    }

    protected function getNamespace($name): string
    {
        $serviceProviderNamespace = str_replace('/', '\\', $this->serviceProviderPath);
        return "{$this->getDefaultNamespace($name)}\\$this->domain\\$serviceProviderNamespace";
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        return str_replace([
            'DummyClass',
            'DummyNamespace',
        ], [
            $class,
            "{$this->getDefaultNamespace($name)}\\$this->domain\\Infrastructure",
        ], $stub);
    }
}