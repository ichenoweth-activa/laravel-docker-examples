<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para probar la funcionalidad de mandar correo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return $this->view('emails.cuenta_usuario_aprende', [
            'url' => 'https://tecnolochicas.estudiolab.app/',
            'nombre' => 'Miguel Mosqueda Lopez',
            'password_temporal' => 'abc12345',
            'email' => 'Gq213oas2do43pw3qe2po@g.nive.la',
        ])->subject('Bienvenida a la plataforma Tecnolochicas!');
    }
}
