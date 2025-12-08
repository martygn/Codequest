<?php

namespace App\Console\Commands;

use App\Models\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetJuezPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'juez:reset-password {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resetear la contraseña de un juez por su correo electrónico';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');

        $juez = Usuario::where('correo', $email)->where('tipo', 'juez')->first();

        if (! $juez) {
            $this->error("No se encontró ningún juez con el correo: {$email}");

            return 1;
        }

        $nuevaPassword = $this->secret('Ingrese la nueva contraseña');
        $confirmarPassword = $this->secret('Confirme la nueva contraseña');

        if ($nuevaPassword !== $confirmarPassword) {
            $this->error('Las contraseñas no coinciden.');

            return 1;
        }

        if (strlen($nuevaPassword) < 8) {
            $this->error('La contraseña debe tener al menos 8 caracteres.');

            return 1;
        }

        // Actualizar la contraseña directamente
        $juez->contrasena = Hash::make($nuevaPassword);
        $juez->save();

        $this->info("✓ Contraseña actualizada correctamente para: {$juez->nombre_completo} ({$email})");

        return 0;
    }
}
