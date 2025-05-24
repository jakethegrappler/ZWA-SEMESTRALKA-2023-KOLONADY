<?php
/**
 * Serverová validace vstupních dat pro registraci uživatele.
 *
 * Tento skript zpracovává POST požadavky pro validaci vstupních dat na serverové straně.
 * Obsahuje validaci pro jednotlivá pole jako jméno, e-mail a heslo. Výsledek validace je odeslán
 * ve formátu JSON.
 *
 * @package ServerValidation
 */

/**
 * Zpracování pouze POST požadavků
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /**
     * Získání hodnoty pole a hodnoty z POST dat
     */
    $field = $_POST['field'];
    $value = $_POST['value'];

    /**
     * Volání funkce pro validaci pole a hodnoty
     */
    $isValid = validateField($field, $value);

    /**
     * Sestavení výsledku validace ve formátu JSON
     */
    $result = array('isValid' => $isValid['isValid'], 'message' => $isValid['message']);
    echo json_encode($result);
} else {
    /**
     * Chybný požadavek, jelikož nebyl přijat POST požadavek
     */
    echo json_encode(array('isValid' => false, 'message' => 'Invalid request'));
}

    /**
     * Funkce pro validaci vstupních dat podle pole a hodnoty.
     *
     * @param string $field Pole, které se má validovat (např. 'username', 'email', 'password').
     * @param string $value Hodnota pole pro validaci.
     * @return array Výsledek validace obsahující 'isValid' (true/false) a 'message' (popis validace).
     */
function validateField($field, $value) {
    /**
     * Validace podle pole ($field) a hodnoty ($value)
     * Například, validace pro jméno
     */
    if ($field === 'username') {
        if ($value!=null && strlen($value) < 15 ) {
            return array('isValid' => true, 'message' => '');
        } else {
            return array('isValid' => false, 'message' => 'Invalid username');
        }
    }
    /**
     * Validace pro email
     */
    if ($field === 'email') {
        if ($value!=null && preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $value)) {
            return array('isValid' => true, 'message' => '');
        } else {
            return array('isValid' => false, 'message' => 'Invalid email');
        }
    }
    /**
     * Validace pro heslo
     */
    if ($field === 'password') {
        // Vaše validační pravidla pro jméno
        if (strlen($value) > 4 && $value != null) {
            return array('isValid' => true, 'message' => '');
        } else {
            return array('isValid' => false, 'message' => 'Invalid password');
        }

    }


}
?>
