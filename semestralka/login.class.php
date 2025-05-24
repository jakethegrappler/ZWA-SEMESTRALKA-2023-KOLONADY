<?php

/**
 * Třída LoginUser slouží k ověření přihlašovacích údajů.
 */
class LoginUser
{
    /**
    * Proměnné pro uložení uživatelských údajů.
    */
    private $username;
    private $password;
    public $error;
    public $success;

    /**
     * Proměnné pro uložení souboru s uloženými uživateli
     */
    private $storage = "jsons/data.json";

    /**
     * @var array $stored_users Pole s uloženými uživateli načtenými ze souboru.
     */
    private $stored_users;

    /**
     * Konstruktor pro inicializaci třídy s předáním údajů pro přihlášení.
     *
     * @param string $username Uživatelské jméno pro přihlášení.
     * @param string $password Heslo pro přihlášení.
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        //načtení uložených uživatelů z json souboru
        $this->stored_users = json_decode(file_get_contents($this->storage), true);
        //volání metody pro ověření přihlašovacích údajů
        $this->checkCredentials();
    }

    /**
     * Metoda pro ověření přihlašovacích údajů.
     *
     * @return bool True, pokud jsou přihlašovací údaje správné, jinak false.
     */
    private function checkCredentials() {
        //procházení pole uložených uživatelů
        foreach ($this->stored_users as $user) {
            //porovnání zadaného uživatelského jména s uloženým
            if ($user['username'] == $this->username) {
                if (password_verify($this->password, $user['password'])) {
                    //pokud se heslo shoduje, nastavení proměnných pro přihlášení
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $this->username;
                    $this->success = "Welcome, " . $_SESSION['username'];
                    return true;
                }
            }
        }
        $this->error = "Wrong username or password, please try again.";
        return false;
    }

    /**
     * Metoda pro zjištění, zda je uživatel přihlášen.
     *
     * @return bool True, pokud je uživatel přihlášen, jinak false.
     */
    public function isLoggedIn()
    {
        return (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true);
    }

    /**
     * Metoda pro získání uživatelského jména.
     *
     * @return string Uživatelské jméno nebo "Nepřihlášen".
     */
    public function getUsername()
    {
        if ($this->isLoggedIn()) {
            return $_SESSION['username'];
        }
        return "Not logged in";
    }

    /**
     * Metoda pro získání e-mailové adresy uživatele.
     *
     * @return string E-mailová adresa nebo null, pokud uživatel není přihlášen.
     */
    public function getMail(){
        if ($this->isLoggedIn()) {
            foreach ($this->stored_users as $user) {
                if ($this->getUsername() == $user['username']) {
                    return $user['email'];
                }
            }
        }
        return null;
    }


}
