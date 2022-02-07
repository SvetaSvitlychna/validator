<?php


class  Validator{


    protected $pdo;


        public function __construct($pdo){

                $this->pdo =$pdo;
            }

        /*$string $table -> name of necessary table in DB
        * $string $email -> email for checking
        * return array $user
        */

        public function checkByEmail($table,$email){

        $sql="SELECT * FROM {$table} WHERE email =:email";
        $statement=$this->pdo->prepare($sql);
        $statement->execute(['email'=>$email]);
        $user=$statement->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

        /*$string $table -> name of necessary table in DB
        * $string $email -> email for checking
        * $string $password -> password for checking
        */
        public function userVerification($table, $email, $password){
        $user = $this->checkByEmail("{$table}",$email);

        if(empty($user)){
            FlashMessage::setMessage('danger', 'Your email is incorrect');
            header("LOCATION:test.php");exit;
        }

        if(!password_verify($password,$user['password'])){
            FlashMessage::setMessage('danger', 'Your password is incorrect');
            header("LOCATION:test.php");exit;
        }
                $_SESSION['user'] =$user;

    }


}
