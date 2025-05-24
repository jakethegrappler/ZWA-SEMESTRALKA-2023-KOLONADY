<?php
class RegisterUser{

    /**
     * Proměnné pro registraci uživatele
     */
    private $username;
    private $email;
    private $gender;
    private $image;
    private $raw_password;
    private $password2;
    private $encrypted_password;
    public $error = array();
    public $success;
    private $storage = "./jsons/data.json";
    private $stored_users;
    private $new_user;

    /**
     * Konstruktor třídy RegisterUser.
     *
     * @param string $username Jméno uživatele.
     * @param string $email Email uživatele.
     * @param string $password Nezašifrované heslo uživatele.
     * @param string $password2 Potvrzení hesla uživatele.
     * @param string $gender Pohlaví uživatele.
     * @param array $image Informace o nahraném obrázku uživatele.
     */
    public function __construct($username, $email, $password,$password2,$gender, $image){
        // inicializace proměnných
        $this->username = htmlspecialchars($username);
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->raw_password = htmlspecialchars($password);
        $this->password2 = $password2;
        $this->encrypted_password = password_hash($password,PASSWORD_DEFAULT);
        $this->gender = $gender;
        $this->image = $image;
        $this->stored_users = json_decode(file_get_contents($this->storage), true);


            // Nastaví jméno položky na "image{$name}.jpg"
        if ($image['tmp_name'] != null) {
            $file_name = "image" . $username . ".jpg";
            //Presune nahrany obrazek do permanentni lokace
            $upload_dir = __DIR__ . '/profiles/';
            move_uploaded_file($image['tmp_name'], $upload_dir . $file_name);
            $path = '/profiles/' . $image['tmp_name'];
        }
        else{
            $path = null;
        }

        $this->new_user = [
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->encrypted_password,
            "gender"=>$this->gender,
            "image"=>$path
        ];
        //Pokud je vše potřebné vyplněné, vloží uživatele do souboru
        if($this->checkFieldValues()){
            $this->insertUser();
        }
    }

    /**
     * Funkce kontrolující vyplněnost všech povinných polí a správný formát hodnot.
     *
     * @return bool True, pokud jsou všechny hodnoty v pořádku; jinak false.
     */
    private function checkFieldValues() {
        $isErr = false;

        // Kontrola vyplněnosti povinných polí
        if (empty($this->username) || empty($this->email) || empty($this->raw_password)|| empty($this->password2) /*todo pridat field pro kontrolu hesla*/) {
            $err = "Please fill all required fields";
            array_push($this->error, $err);
            $isErr = true;
        } else {
            // Kontrola formátu emailu
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $this->email)) {
                $err = "Invalid email format";
                array_push($this->error, $err);
                $isErr = true;
            }

            // Kontrola formátu uživatelského jména (alfanumerické znaky a podtržítka pouze)
            if (!preg_match("/^[a-zA-Z0-9_]+$/", $this->username)) {
                $err = "Invalid username format, it must be only letters and numbers";
                array_push($this->error, $err);
                $isErr = true;
            }

            // Kontrola délky username
            if(strlen($this->username) > 15){
                $err = "Username must be shorter than 16 characters";
                array_push($this->error, $err);
                $isErr = true;
            }

            // Kontrola délky hesla
            if (strlen($this->raw_password) < 4) {
                $err = "Password must be at least 4 characters long";
                array_push($this->error, $err);
                $isErr = true;
            }

            // Kontrola shody hesel
            if ($this->raw_password != $this->password2){
                $err = "Passwords must match";
                array_push($this->error, $err);
                $isErr = true;
            }
        }

        return !$isErr;
    }

    /**
     * Funkce kontrolující existenci uživatelského jména.
     *
     * @return bool True, pokud uživatelské jméno již existuje; jinak false.
     */
    private function usernameExists(){
        foreach ($this->stored_users as $user){
            if($this->username == $user['username']){
                $this->error[] = "Username is already taken, please choose a different one.";
                return true;
            }
        }
        return false;
    }

    /**
     * Funkce kontrolující existenci emailu.
     *
     * @return bool True, pokud email již existuje; jinak false.
     */
    private function emailExists(){
        foreach ($this->stored_users as $user){
            if($this->email == $user['email']){
                $this->error[] = "Email is already taken, please choose a different one.";
                return true;
            }
        }
        return false;
    }

    /**
     * Funkce vkládající nového uživatele do souboru.
     *
     * @return bool|array True, pokud registrace byla úspěšná; jinak pole s chybami.
     */
    private function insertUser(){
        if($this->usernameExists() == FALSE and $this->emailExists() == FALSE){
            array_push($this->stored_users, $this->new_user);
            if(file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))){
                return $this->success = true;
            } else {
                return ["error" => "Something went wrong, please try again"];
            }
        } else {
            // Vrátí pole s chybovými zprávami
            return ["error" => $this->error];
        }
    }




}