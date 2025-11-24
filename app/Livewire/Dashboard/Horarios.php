<?php

namespace App\Livewire\Dashboard;

class Horarios
{
    public static function generar($duracion = 30)
    {
        $maniana = [
            'inicio' => '07:30',
            'fin'    => '11:00',
        ];

        $tarde = [
            'inicio' => '14:30',
            'fin'    => '17:00',
        ];

        $horarios = [];

        $inicio = strtotime($maniana['inicio']);
        $fin    = strtotime($maniana['fin']);

        while ($inicio + ($duracion * 60) <= $fin) {
            $horarios[] = date('H:i', $inicio);
            $inicio += $duracion * 60;
        }

        $inicio = strtotime($tarde['inicio']);
        $fin    = strtotime($tarde['fin']);

        while ($inicio + ($duracion * 60) <= $fin) {
            $horarios[] = date('H:i', $inicio);
            $inicio += $duracion * 60;
        }

        return $horarios;
    }
}
