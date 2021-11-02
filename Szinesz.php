<?php

class Szinesz {
    private $id;
    private $nev;
    private $magassag;
    private $szul_datum;
    private $dijak_szama;
    private $forgatason_van;

    public function __construct(string $nev, int $magassag, DateTime $szul_datum, int $dijak_szama, bool $forgatason_van) {
        $this->nev = $nev;
        $this->magassag = $magassag;
        $this->szul_datum = $szul_datum;
        $this->dijak_szama = $dijak_szama;
        $this->forgatason_van = $forgatason_van;
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function getNev() : string {
        return $this->nev;
    }

    public function getMagassag() : int {
        return $this->magassag;
    }

    public function getSzulDatum() : DateTime {
        return $this->szul_datum;
    }

    public function getDijakSzama() : int {
        return $this->dijak_szama;
    }

    public function getForgatasonVan() : bool {
        return $this->forgatason_van;
    }

    public function setNev(string $nev) : void {
        $this->nev = $nev;
    }

    public function setMagassag(int $magassag) : void {
        $this->magassag = $magassag;
    }

    public function setSzulDatum(DateTime $szul_datum) : void {
        $this->szul_datum = $szul_datum;
    }

    public function setDijakSzama(int $dijak_szama) : void  {
        $this->dijak_szama = $dijak_szama;
    }

    public function setForgatasonVan(bool $forgatason_van) : void {
        $this->forgatason_van = $forgatason_van;
    }

    public static function osszes() : array {
        global $db;

        $t = $db->query("SELECT * FROM szinesz")
            ->fetchAll();
        $eredmeny = [];

        foreach ($t as $elem) {
            $szinesz = new Szinesz($elem['nev'], $elem['magassag'], new DateTime($elem['szul_datum']), $elem['dijak_szama'], $elem['forgatason_van']);
            $szinesz->id = $elem['id'];
            $eredmeny[] = $szinesz;
        }

        return $eredmeny;
    }

    public static function getById(int $id) : Szinesz {
        global $db;

        $stmt = $db->prepare('SELECT * FROM szinesz WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $eredmeny = $stmt->fetchAll();

        if (count($eredmeny) !== 1) {
            throw new Exception('Rósz :/');
        }

        $szinesz = new Szinesz($eredmeny[0]['nev'], $eredmeny[0]['magassag'], new DateTime($eredmeny[0]['szul_datum']),
                               $eredmeny[0]['dijak_szama'], $eredmeny[0]['forgatason_van']);
        $szinesz->id = $eredmeny[0]['id'];
        return $szinesz;
    }

    public function mentes() {
        global $db;

        $db->prepare('UPDATE szinesz SET nev = :nev, magassag = :magassag, szul_datum = :szul_datum, dijak_szama = :dijak_szama, forgatason_van = :forgatason_van
            WHERE id = :id')
            ->execute([
                ':id' => $this->id,
                ':nev' => $this->nev,
                ':magassag' => $this->magassag,
                ':szul_datum' => $this->szul_datum->format('Y-m-d'),
                ':dijak_szama' => $this->dijak_szama,
                ':forgatason_van' => $this->forgatason_van
            ]);
        
        header('Location: index.php');
    }

    public function uj() {
        global $db;

        $db->prepare('INSERT INTO szinesz (nev, magassag, szul_datum, dijak_szama, forgatason_van)
                    VALUES (:nev, :magassag, :szul_datum, :dijak_szama, :forgatason_van)')
            ->execute([
                ':nev' => $this->nev,
                ':magassag' => $this->magassag,
                ':szul_datum' => $this->szul_datum->format('Y-m-d'),
                ':dijak_szama' => $this->dijak_szama,
                ':forgatason_van' => $this->forgatason_van
            ]);
    }

    public static function torol(int $id) {
        global $db;

        $db->prepare('DELETE FROM szinesz WHERE id = :id')
            ->execute([':id' => $id]);
    }
}