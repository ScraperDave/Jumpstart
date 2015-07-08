<?php namespace GeneaLabs\Jumpstart\Commands;

use Carbon\Carbon;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Jumpstart extends Command
{
    use AppNamespaceDetectorTrait;

    private $shouldBackup;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:jumpstart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up your vanilla Laravel project with auth and other goodies. DO NOT run this if you already have your users table and auth views set up.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $namespace = $this->getAppNamespace();
        $this->shouldBackup = ('n' === strtolower($this->askWithCompletion('Do you want to overwrite files when copying? (Saying \'no\' will create time-stamped copies of the originals.)', ['y', 'n'])));

        $this->copyJumpstartAsset(__DIR__ . '/../../assets/views/app.blade.php', base_path('resources/views/app.blade.php'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/views/home.blade.php', base_path('resources/views/home.blade.php'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/views/welcome.blade.php', base_path('resources/views/welcome.blade.php'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/views/auth/login.blade.php', base_path('resources/views/auth/login.blade.php'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/views/auth/register.blade.php', base_path('resources/views/auth/register.blade.php'));

        $this->copyJumpstartAsset(__DIR__ . '/../../assets/css/bootstrap-3.3.5.css.map', public_path('css/bootstrap-3.3.5.css.map'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/css/bootstrap-3.3.5.min.css', public_path('css/bootstrap-3.3.5.min.css'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/css/bootstrap-theme.css.map', public_path('css/bootstrap-theme.css.map'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/css/bootstrap-theme.min.css', public_path('css/bootstrap-theme.min.css'));

        $this->copyJumpstartAsset(__DIR__ . '/../../assets/js/bootstrap-3.3.5.min.js', public_path('js/bootstrap-3.3.5.min.js'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/js/jquery-2.1.4.min.js', public_path('js/jquery-2.1.4.min.js'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/js/jquery-2.1.4.min.map', public_path('js/jquery-2.1.4.min.map'));

        $this->copyJumpstartAsset(__DIR__ . '/../../assets/fonts/glyphicons-halflings-regular.eot', public_path('fonts/glyphicons-halflings-regular.eot'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/fonts/glyphicons-halflings-regular.svg', public_path('fonts/glyphicons-halflings-regular.svg'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/fonts/glyphicons-halflings-regular.ttf', public_path('fonts/glyphicons-halflings-regular.ttf'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/fonts/glyphicons-halflings-regular.woff', public_path('fonts/glyphicons-halflings-regular.woff'));
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/fonts/glyphicons-halflings-regular.woff2', public_path('fonts/glyphicons-halflings-regular.woff2'));

        $this->copyJumpstartAsset(__DIR__ . '/../../assets/routes.php', app_path('Http/routes.php'));

        $this->copyJumpstartAsset(__DIR__ . '/../../assets/Controllers/HomeController.php', base_path('app/Http/Controllers/HomeController.php'), $namespace);
        $this->copyJumpstartAsset(__DIR__ . '/../../assets/Controllers/WelcomeController.php', base_path('app/Http/Controllers/WelcomeController.php'), $namespace);

        $this->copyJumpstartMigrationAsset(__DIR__ . '/../../assets/database/migrations/_add_name_fields_to_users_table_jumpstart.php', base_path('database/migrations/' . Carbon::now()->format('Y_m_d_His') . '_add_name_fields_to_users_table_jumpstart.php'));
        $this->copyJumpstartMigrationAsset(__DIR__ . '/../../assets/database/migrations/_add_softdeletes_to_users_table_jumpstart.php', base_path('database/migrations/' . Carbon::now()->format('Y_m_d_His') . '_add_softdeletes_to_users_table_jumpstart.php'));

        if ('y' === strtolower($this->ask('Do you want to run the migrations?', 'y'))) {
            Artisan::call('migrate');
        }

    }

    /**
     * @param string $sourceFile
     * @param string $targetFile
     * @param string $namespace
     */
    private function copyJumpstartAsset($sourceFile, $targetFile, $namespace = 'App\\')
    {
        $fileName = basename($targetFile);

        if ($this->shouldBackup && File::exists($targetFile)) {
            $fileNameParts = explode('.', $fileName);
            $newFileName = array_shift($fileNameParts) . '-original-' . Carbon::now('UTC')->format('Y-m-d_h:i:s') . '.' . implode('.', $fileNameParts);
            File::move($targetFile, dirname($targetFile) . '/' . $newFileName);
            $this->info("File '{$fileName}' already exists - renamed to '{$newFileName}'.");
        } elseif (! File::exists(dirname($targetFile))) {
            File::makeDirectory(dirname($targetFile), 0755, true, true);
        }

        if ($namespace == 'App\\') {
            File::copy($sourceFile, $targetFile);
        } else {
            $sourceFileContent = File::get($sourceFile);
            $targetFileContent = str_replace('namespace App\\', 'namespace ' . $namespace, $sourceFileContent);
            File::put($targetFile, $targetFileContent);
        }

        $this->info("File '{$fileName}' copied.");
    }

    /**
     * @param string $sourceFile
     * @param string $targetFile
     */
    private function copyJumpstartMigrationAsset($sourceFile, $targetFile)
    {
        $existingFileNames = File::files(dirname($targetFile));

        foreach ($existingFileNames as $fileName) {
            if (strpos($fileName, basename($sourceFile))) {
                return;
            }
        }

        $this->copyJumpstartAsset($sourceFile, $targetFile);
    }
}
