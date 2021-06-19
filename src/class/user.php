<?php

class user
{

    private string $login;
    private string $password;
    private string $name;
    private string $surname;
    private string $sex;

    /**
     * @throws Exception
     */
    public function addToDB(): void
    {
        //check if it is possible to add this user - login should be unique
        try {
            require_once __DIR__ . "./../dbConnect.php";
            global $db;
            $db->beginTransaction();

            $query = $db->prepare("INSERT INTO users (login, password, name, surname, sex) VALUES (:login, :password, :name, :surname, :sex)");

            $query->bindValue(":login", $this->login, PDO::PARAM_STR);
            $query->bindValue(":password", password_hash($this->password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $query->bindValue(":name", $this->name, PDO::PARAM_STR);
            $query->bindValue(":surname", $this->surname, PDO::PARAM_STR);
            $query->bindValue(":sex", $this->sex, PDO::PARAM_STR);

            $query->execute();

            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
            throw new Exception("User with the same login exist. Unable to create account.");
        }

        $this->password = "";
    }

    public function Login()
    {
        require_once __DIR__ . "./../dbConnect.php";
        global $db;

        $query = $db->prepare("SELECT * FROM users WHERE login = :login");
        $query->bindValue(":login", $this->login, PDO::PARAM_STR);
        $query->execute();

        $user = null;
        if($query->rowCount() == 1) {
            $result = $query->fetchAll(PDO::FETCH_CLASS, "user");
            if(password_verify($this->password, $result[0]->password)) {
                $user = $result[0];
            }
        }

        return $user;
    }


    public static function s_userLogged(): User
    {
        session_start();
        if (!isset($_SESSION["user"])) {
            header("Location: ./index.php");
            exit();
        }

        return unserialize($_SESSION["user"]);
    }

    //******************************
    //Getters and setters
    //******************************


    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @throws Exception
     */
    public function setLogin(string $login): void
    {
        if(strlen($login) < 6) throw new Exception("Login is too short, should be 6 characters or longer");
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        if(strlen($password) < 8) throw new Exception("Password is too short, should be 8 characters or longer");
        $this->password = $password;
    }

    /**
     *
     */
    public function clearPassword(): void
    {
        $this->password = "";
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     */
    public function setSex(string $sex): void
    {
        $this->sex = $sex;
    }

}