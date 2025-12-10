<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EnsureStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:ensure-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure storage link exists in production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = storage_path('app/public');
        $link = public_path('storage');

        if (file_exists($link)) {
            $this->info('El enlace de storage ya existe.');
            return 0;
        }

        if (!is_dir($target)) {
            mkdir($target, 0755, true);
            $this->info('Directorio storage/app/public creado.');
        }

        symlink($target, $link);
        $this->info('Enlace simbólico de storage creado exitosamente.');
        return 0;
    }
}
