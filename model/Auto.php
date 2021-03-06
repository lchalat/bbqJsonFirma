<?php

/**
 * Description of Auto
 *
 * @author Teilnehmer
 */
class Auto implements Aenderbar, JsonSerializable {

    private $id;
    private $hersteller; // objekt
    private $name;
    private $kennzeichen;

    public static function getNames() {
        return ['Hersteller', 'Modell', 'Kennzeichen'];
    }
    
    public function getDropName()
    {
        return $this->hersteller->getName().' '.$this->getName().' '.$this->getKennzeichen();
    }

    public function __construct($name, Hersteller $hersteller, $kennzeichen, $id = NULL) {
        $this->hersteller = $hersteller;
        $this->name = $name;
        $this->kennzeichen = $kennzeichen;
        $this->id = $id;
    }

    public function jsonSerialize() {
        return['id' => $this->id,
            'hersteller' => $this->hersteller,
            'name' => $this->name,
            'kennzeichen' => $this->kennzeichen];
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getHersteller() {
        return $this->hersteller;
    }

    public function getKennzeichen() {
        return $this->kennzeichen;
    }

    public static function getAll() {
        
         error_reporting(E_ALL - E_ERROR);

        function meinFehlerbehandler($fehlernummer, $fehlertext, $fehlerdatei, $fehlerzeile) {
            echo"Frag Ossama";
//            file_put_contents($filename, $data, $flags, $context);
            file_put_contents('fehler.txt', "<b>Dicker Fehler:</b> [$fehlernummer] $fehlertext<br> Fehler in Zeile $fehlerzeile in Datei $fehlerdatei<br>\n",  FILE_APPEND);
            
//            echo "<b>Dicker Fehler:</b> [$fehlernummer] $fehlertext<br>";
//            echo " Fehler in Zeile $fehlerzeile in Datei $fehlerdatei<br>";
        }
        set_error_handler("meinFehlerbehandler");

        
        
        
        
        
        $pdo = DbConnect::connect();
        $sql = "SELECT * from auto";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $autos = [];

        foreach ($rows as $row) {
            $autos[$row['id']] = new Auto($row['name'], Hersteller::getById($row['hersteller_id']), $row['kennzeichen'], $row['id']);
        }
        return $autos;
    }

    public static function getById($id) {
        $pdo = DbConnect::connect();
        $sql = "SELECT * from auto WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return new Auto($rows[0]['name'], Hersteller::getById($rows[0]['hersteller_id']), $rows[0]['kennzeichen'], $rows[0]['id']);
    }

    public static function update($obj) {
        $pdo = DbConnect::connect();
        $sql = "UPDATE auto SET name =:name, hersteller_id =:hersteller_id,kennzeichen =:kennzeichen WHERE id =:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':name' => $obj->getName(), ':hersteller_id' => $obj->getHersteller()->getId(), ':kennzeichen' => $obj->getKennzeichen(), ':id' => $obj->getId()]);
    }

    public static function insert($id) {
        $pdo = DbConnect::connect();
        $sql = "INSERT INTO auto(name,hersteller_id,kennzeichen) VALUES (:name,:hersteller_id,:kennzeichen)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':name' => $id->getName(), ':hersteller_id' => $id->getHersteller()->getId(), ':kennzeichen' => $id->getKennzeichen()]);
    }

    public static function delete($id) {
        $pdo = DbConnect::connect();
        $sql = "DELETE from auto WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

}
