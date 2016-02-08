<?php
class MitarbeiterAbteilungVorgesetzterController {

    public static function doAction($action, $view, $id) {
        switch ($action) {
            case 'showList':
                $out = MitarbeiterAbteilungVorgesetzter::getAll();
//                echo 'mitte';
//                echo '<pre>';
//                print_r($out);
//                echo '</pre>';
                break;
            default:
                break;
        }
        return $out;
    }

}
