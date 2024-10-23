<?php

class Conexion
{

	static public function conectar()
	{

		$link = new PDO(
			"mysql:host=localhost;dbname=tuagewci_jaime",
			"tuagewci_jaime",
			"Jaime2024."
		);

		$link->exec("set names utf8");

		return $link;
	}
}

/*
class Conexion {

    static public function conectar() {

        $link = new PDO("mysql:host=localhost;dbname=agua",
                        "root",
                        "");

        $link->exec("set names utf8");

        return $link;

    }

}
*/