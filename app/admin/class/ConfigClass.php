<?php
class Config {
    public $user =  
        [
            1 => [
                'id'        => 1,
                'name'      => 'K',
                'firstname' => 'Melting',
                'mail'      => 'integrateur@melting-k.fr',
                'pass'      => 'cnifcnif31',
                'role'      => 'admin'
            ],
            2 => [
                'id'        => 2,
                'name'      => 'contact',
                'firstname' => 'BMS',
                'mail'      => 'contact@bms-sante.com',
                'pass'      => '68mS8cwQT',
                'role'      => 'author'
            ]
        ];
     public $site =  
         [
            'name'          => 'BMS SANTE',
            'mail'          => 'contact@bms-sante.com',
            'domain'        => 'www.bms-sante.com',
            'url'           => 'https://www.bms-sante.com',
            'srcimg'        => 'img/logo-blanc.png',
            'colorimg'      => '#243648'
        ];
};
?>