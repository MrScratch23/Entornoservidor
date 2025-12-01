<!-- 
    Página de datos de héroes
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
-->
<?php

// Presupuesto inicial para que el estratega forme su equipo.
const PRESUPUESTO_INICIAL = 2000;

// Array constante con la lista de héroes disponibles para reclutar.
const HEROES = [
    [
        'id' => 'h01',
        'nombre' => 'Sir Gideon',
        'clase' => 'Caballero',
        'ataque' => 80,
        'defensa' => 95,
        'magia' => 10,
        'coste' => 444,
        'imagen' => 'caballero_01.png'
    ],
    [
        'id' => 'h02',
        'nombre' => 'Elara Whisperwind',
        'clase' => 'Arquero',
        'ataque' => 90,
        'defensa' => 60,
        'magia' => 20,
        'coste' => 408,
        'imagen' => 'arquera_01.png'
    ],
    [
        'id' => 'h03',
        'nombre' => 'Mordenkai el Sabio',
        'clase' => 'Mago',
        'ataque' => 20,
        'defensa' => 30,
        'magia' => 100,
        'coste' => 360,
        'imagen' => 'mago_01.png'
    ],
    [
        'id' => 'h04',
        'nombre' => 'Bror Furiabarba',
        'clase' => 'Guerrero',
        'ataque' => 95,
        'defensa' => 75,
        'magia' => 5,
        'coste' => 420,
        'imagen' => 'guerrero_01.png'
    ],
    [
        'id' => 'h05',
        'nombre' => 'Lyra Nocheveloz',
        'clase' => 'Pícaro',
        'ataque' => 85,
        'defensa' => 50,
        'magia' => 30,
        'coste' => 396,
        'imagen' => 'picara_01.png'
    ],
    [
        'id' => 'h06',
        'nombre' => 'Padre Theron',
        'clase' => 'Clérigo',
        'ataque' => 40,
        'defensa' => 70,
        'magia' => 80,
        'coste' => 456,
        'imagen' => 'clerigo_01.png'
    ],
    [
        'id' => 'h07',
        'nombre' => 'Valeria Escudoférreo',
        'clase' => 'Caballero',
        'ataque' => 75,
        'defensa' => 100,
        'magia' => 5,
        'coste' => 432,
        'imagen' => 'caballero_02.png'
    ],
    [
        'id' => 'h08',
        'nombre' => 'Sylas el Silencioso',
        'clase' => 'Arquero',
        'ataque' => 95,
        'defensa' => 55,
        'magia' => 25,
        'coste' => 420,
        'imagen' => 'arquero_02.png'
    ],
    [
        'id' => 'h09',
        'nombre' => 'Ignis Piroclasta',
        'clase' => 'Mago',
        'ataque' => 15,
        'defensa' => 25,
        'magia' => 110,
        'coste' => 360,
        'imagen' => 'mago_02.png'
    ],
    [
        'id' => 'h10',
        'nombre' => 'Grog Martillopesado',
        'clase' => 'Guerrero',
        'ataque' => 100,
        'defensa' => 70,
        'magia' => 0,
        'coste' => 408,
        'imagen' => 'guerrero_02.png'
    ],
    [
        'id' => 'h11',
        'nombre' => 'Vex la Sombra',
        'clase' => 'Pícaro',
        'ataque' => 90,
        'defensa' => 45,
        'magia' => 35,
        'coste' => 408,
        'imagen' => 'picara_02.png'
    ],
    [
        'id' => 'h12',
        'nombre' => 'Hermana Adeline',
        'clase' => 'Clérigo',
        'ataque' => 30,
        'defensa' => 65,
        'magia' => 90,
        'coste' => 444,
        'imagen' => 'clerigo_02.png'
    ]
];
