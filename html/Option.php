<?php

// erstellt ein Array für DropDown-Menu:

class Option
{
    public static function buildOptions($className, $selected = NULL, $zeroOption = NULL)
    {
        $objectArr = [];
        if(!in_array('getId', get_class_methods($className)))
        {
            throw new Exception('Methode getId() fehlt in Parameter zu Option::buildOptions $classname: mit Wert ' .$className);
        }
        if(!in_array('getName', get_class_methods($className)) && !in_array('getDropName', get_class_methods($className)))
        {
            throw new Exception('Methode getName() fehlt in Parameter zu Option::buildOptions $classname: mit Wert ' .$className);
        }
        if($selected !== NULL)
        {
            // check: $selected ist Zahl
            if(is_numeric($selected))
            {
                $selected = (int)$selected;
            }
            else
            {
                throw new Exception('$selected enthält keine ganze Zahl(PK): ' .$selected);
            }
        }
        
        // falls Auswahl keine Pflicht ist
        if($zeroOption)
        {
            $objectArr[0] = ['value' => 0, 'label' => ""];
        }
        else
        {
            $objectArr[0] = ['value' => 0, 'label' => ""];
        }
        
        $objects = $className::getAll();
        foreach($objects as $o)
        {
            if(in_array('getDropName', get_class_methods($className)))
            {
                $objectArr[$o->getId()] = ['value' => $o->getId(), 'label' => $o->getDropName()];
            }
            else
            {
                $objectArr[$o->getId()] = ['value' => $o->getId(), 'label' => $o->getName()];
            }
            if($selected === $o->getId())
            {
                $objectArr[$o->getId()]['selected'] = 'selected';
            }
        }
        
        return $objectArr;
    }
}

?>

