<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDO;
use PDOException;

class InstallController extends Controller
{
    protected const REQUIRED_EXTENSIONS = [
        'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo',
    ];

    protected const WRITABLE_PATHS = [
        'storage',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'bootstrap/cache',
    ];

    protected function lockPath(): string
    {
        return storage_path('installed.lock');
    }

    protected function isInstalled(): bool
    {
        return file_exists($this->lockPath());
    }

    protected function guardAlreadyInstalled()
    {
        if ($this->isInstalled()) {
            return redirect()->route('home')->with('info', 'This application is already installed.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->guardAlreadyInstalled()) {
            return $redirect;
        }

        return view('install.index');
    }

    public function checkServer()
    {
        if ($redirect = $this->guardAlreadyInstalled()) {
            return $redirect;
        }

        $phpOk = version_compare(PHP_VERSION, '8.2.0', '>=');

        $extensions = [];
        foreach (self::REQUIRED_EXTENSIONS as $extension) {
            $extensions[$extension] = extension_loaded($extension);
        }

        $paths = [];
        foreach (self::WRITABLE_PATHS as $path) {
            $full = base_path($path);
            $paths[$path] = is_dir($full) && is_writable($full);
        }

        $envWritable = is_writable(base_path('.env'));

        $allOk = $phpOk
            && !in_array(false, $extensions, true)
            && !in_array(false, $paths, true)
            && $envWritable;

        return view('install.check-server', compact('phpOk', 'extensions', 'paths', 'envWritable', 'allOk'));
    }

    public function details()
    {
        if ($redirect = $this->guardAlreadyInstalled()) {
            return $redirect;
        }

        return view('install.details', [
            'old' => [
                'app_url'      => rtrim(request()->getSchemeAndHttpHost(), '/'),
                'db_host'      => '127.0.0.1',
                'db_port'      => '3306',
                'db_database'  => '',
                'db_username'  => '',
                'site_name'    => config('app.name', 'Fazal Mobiles'),
                'admin_email'  => 'admin@example.com',
            ],
        ]);
    }

    protected function rules(): array
    {
        return [
            'app_url'       => ['required', 'url'],
            'db_host'       => ['required', 'string', 'max:255'],
            'db_port'       => ['required', 'numeric'],
            'db_database'   => ['required', 'string', 'max:255'],
            'db_username'   => ['required', 'string', 'max:255'],
            'db_password'   => ['nullable', 'string', 'max:255'],
            'site_name'     => ['required', 'string', 'max:255'],
            'admin_name'    => ['required', 'string', 'max:255'],
            'admin_email'   => ['required', 'email', 'max:255'],
            'admin_password'=> ['required', 'string', 'min:8'],
        ];
    }

    protected function testConnection(array $data): ?string
    {
        try {
            $dsn = "mysql:host={$data['db_host']};port={$data['db_port']};dbname={$data['db_database']}";
            new PDO($dsn, $data['db_username'], $data['db_password'] ?? '', [
                PDO::ATTR_TIMEOUT => 5,
            ]);
        } catch (PDOException $e) {
            return $this->friendlyDbError($e->getMessage());
        }

        return null;
    }

    protected function friendlyDbError(string $message): string
    {
        return match (true) {
            str_contains($message, 'Unknown database') => 'That database does not exist yet. Create it first, then try again.',
            str_contains($message, 'Access denied')     => 'Access denied — check the database username and password.',
            str_contains($message, "Name or service not known"),
            str_contains($message, 'getaddrinfo'),
            str_contains($message, 'Connection refused') => 'Could not reach that database host/port. Check the host and port.',
            default => 'Could not connect to the database: ' . $message,
        };
    }

    public function postDetails(Request $request)
    {
        if ($redirect = $this->guardAlreadyInstalled()) {
            return $redirect;
        }

        $data = $request->validate($this->rules());

        if ($error = $this->testConnection($data)) {
            return back()->withInput()->withErrors(['db_database' => $error]);
        }

        if (!is_writable(base_path('.env'))) {
            session(['install.pending' => $data]);

            return redirect()->route('install.installAlternate');
        }

        $this->runInstall($data);
        $this->writeEnv($data);

        return redirect()->route('install.success');
    }

    public function installAlternate(Request $request)
    {
        if ($redirect = $this->guardAlreadyInstalled()) {
            return $redirect;
        }

        $data = session('install.pending');

        if (!$data) {
            return redirect()->route('install.details');
        }

        if ($request->isMethod('post') && $request->boolean('confirm_manual_env')) {
            if ($error = $this->testConnection($data)) {
                return back()->withErrors(['db_database' => $error]);
            }

            $this->runInstall($data);
            session()->forget('install.pending');

            return redirect()->route('install.success');
        }

        return view('install.manual-env', [
            'envContents' => $this->buildEnvContents($data),
        ]);
    }

    protected function buildEnvContents(array $data): string
    {
        $lines = file(base_path('.env.example'), FILE_IGNORE_NEW_LINES);
        $overrides = $this->envOverrides($data);
        $applied = [];

        $lines = array_map(function ($line) use ($overrides, &$applied) {
            $bare = ltrim($line, '# ');

            foreach ($overrides as $key => $value) {
                if (str_starts_with($bare, $key . '=')) {
                    $applied[$key] = true;
                    return $key . '=' . $value;
                }
            }

            return $line;
        }, $lines);

        foreach ($overrides as $key => $value) {
            if (empty($applied[$key])) {
                $lines[] = $key . '=' . $value;
            }
        }

        return implode("\n", $lines) . "\n";
    }

    protected function envOverrides(array $data): array
    {
        return [
            'APP_NAME'     => '"' . addslashes($data['site_name']) . '"',
            'APP_ENV'      => 'production',
            'APP_DEBUG'    => 'false',
            'APP_URL'      => $data['app_url'],
            'APP_KEY'      => 'base64:' . base64_encode(random_bytes(32)),
            'DB_CONNECTION'=> 'mysql',
            'DB_HOST'      => $data['db_host'],
            'DB_PORT'      => $data['db_port'],
            'DB_DATABASE'  => $data['db_database'],
            'DB_USERNAME'  => $data['db_username'],
            'DB_PASSWORD'  => $data['db_password'] ?? '',
            'SITE_NAME'    => '"' . addslashes($data['site_name']) . '"',
            'SITE_EMAIL'   => $data['admin_email'],
        ];
    }

    protected function writeEnv(array $data): void
    {
        file_put_contents(base_path('.env'), $this->buildEnvContents($data));
    }

    protected function runInstall(array $data): void
    {
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => $data['db_host'],
            'database.connections.mysql.port' => $data['db_port'],
            'database.connections.mysql.database' => $data['db_database'],
            'database.connections.mysql.username' => $data['db_username'],
            'database.connections.mysql.password' => $data['db_password'] ?? '',
        ]);
        DB::purge('mysql');
        DB::setDefaultConnection('mysql');

        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);

        AdminUser::updateOrCreate(
            ['email' => $data['admin_email']],
            [
                'name'      => $data['admin_name'],
                'password'  => Hash::make($data['admin_password']),
                'is_active' => true,
            ]
        );

        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        file_put_contents($this->lockPath(), now()->toDateTimeString());
    }

    public function success()
    {
        if (!$this->isInstalled()) {
            return redirect()->route('install.index');
        }

        return view('install.success');
    }

    public function updateConfirmation()
    {
        if (!$this->isInstalled()) {
            return redirect()->route('install.index');
        }

        return view('install.update-confirmation');
    }

    public function update()
    {
        if (!$this->isInstalled()) {
            return redirect()->route('install.index');
        }

        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return redirect()->route('install.updateConfirmation')->with('status', 'Migrations applied successfully.');
    }
}
