<?php
//Clase para crear objetos usuarios
class User{
    private $name;
    private $email;
    private $password;
    private $dni;
    private $creditCard;
    private $address;
    private $postcode;
    private $phone;
    private $registerDate;
    private $secretQuestion;
    private $secretAnswer;


    public function __construct($name, $email, $password, $dni, $creditCard, $address, $postcode, $phone, $registerDate, $secretQuestion, $secretAnswer)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->dni = $dni;
        $this->creditCard = $creditCard;
        $this->address = $address;
        $this->postcode = $postcode;
        $this->phone = $phone;
        $this->registerDate = $registerDate;
        $this->secretQuestion = $secretQuestion;
        $this->secretAnswer = $secretAnswer;
    } //Constructor básico
//Getter y Setters básicos
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this;
    }

    public function getCreditCard()
    {
        return $this->creditCard;
    }

    public function setCreditCard($creditCard)
    {
        $this->creditCard = $creditCard;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;
        return $this;
    }

    public function getSecretQuestion()
    {
        return $this->secretQuestion;
    }

    public function setSecretQuestion($secretQuestion)
    {
        $this->secretQuestion = $secretQuestion;
        return $this;
    }

    public function getSecretAnswer()
    {
        return $this->secretAnswer;
    }

    public function setSecretAnswer($secretAnswer)
    {
        $this->secretAnswer = $secretAnswer;
        return $this;
    }
}

?>

