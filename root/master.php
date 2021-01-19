<?php
require_once "bdConfig.php";


// Conexión sa la base de datos
     function conectBd()
     {
         try {
             // chain de conexíon
             $GLOBALS['pdo'] = new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['bd']."", $GLOBALS['user'], $GLOBALS['password']);
             $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             print "Error!: No se puede conectar a la base de datos".$bd."<br/>";
             print "\nError!: ".$e."<br/>";
             die();
         }
     }

    // Desconexión de la base de datos
     function disconectBd()
     {
         $GLOBALS['pdo']=null;
     }

     function __Encripting($chain)
     {
         $exit = false;
         $Key = hash('sha256', SECRET_KEY);
         $IV = substr(hash('sha256', SECRET_IV), 0, 16);
         $exit = openssl_encrypt($chain, METHOD, $Key, 0, $IV);
         $exit = base64_encode($exit);
         return $exit;
     }
    /**
     *Funcion que permite desencriptar loe datos
    */
     function __Descripting($chain)
     {
         $Key = hash('sha256', SECRET_KEY);
         $IV = substr(hash('sha256', SECRET_IV), 0, 16);
         $exit = openssl_decrypt(base64_decode($chain), METHOD, $Key, 0, $IV);
         return $exit;
     }
    /**
     *Funcion que permite construir codigos al azar
    */
     function __RandomCodeGenerate($letter, $long, $number)
     {
         for ($i=1; $i <= $long ; $i++) {
             $Num = rand(0, 9);
             $letter.= $Num;
         }
         return $letter ."-". $number;
     }
    /**
     *Funcion que permite filtrar la informacion ingresada y evitar la inyeccion SQL
    */
     function __ChainFilter($chain)
     {
         $chain = trim($chain);
         $chain = stripslashes($chain);
         $chain = str_ireplace("<script>", "", $chain);
         $chain = str_ireplace("</script>", "", $chain);
         $chain = str_ireplace("<script src", "", $chain);
         $chain = str_ireplace("<script type=", "", $chain);
         $chain = str_ireplace("--", "", $chain);
         $chain = str_ireplace("^", "", $chain);
         $chain = str_ireplace("[", "", $chain);
         $chain = str_ireplace("]", "", $chain);
         $chain = str_ireplace("==", "", $chain);
         $chain = str_ireplace("{", "", $chain);
         $chain = str_ireplace("}", "", $chain);
         $chain = str_ireplace(";", "", $chain);
         $chain = str_ireplace("SELECT * FROM", "", $chain);
         $chain = str_ireplace("DELETE FROM", "", $chain);
         $chain = str_ireplace("INSERT INTO", "", $chain);
         $chain = str_ireplace("UPDATE", "", $chain);
         return $chain;
     }

    // función que retorna los datos solicitados
     function methodGet($query)
     {
         try {
             conectBd();
             $statement = $GLOBALS['pdo']->prepare($query);
             $statement->setFetchMode(PDO::FETCH_ASSOC);
             $statement->execute();
             disconectBd();
             return $statement;
         } catch (Exception $e) {
             die("Error: ".$e);
         }
     }

    // función que envía los datos enviados desde formularios
     function methodPost($query, $idAutoincrement)
     {
         try {
             conectBd();
             $statement = $GLOBALS['pdo']->prepare($query);
             $statement->execute();
             $idIncrementable = methodGet($idAutoincrement)->fetch(PDO::FETCH_ASSOC);
             $respuesta = array_merge($idIncrementable, $_POST);
             $statement->closeCursor();
             disconectBd();
             return $respuesta;
         } catch (Exception $e) {
             die("Error: ".$e);
         }
     }

    // función que registra los datos enviados
     function methodPut($query)
     {
         try {
             conectBd();
             $statement = $GLOBALS['pdo']->prepare($query);
             $statement->execute();
             $respuesta = array_merge($_GET, $_POST);
             $statement->closeCursor();
             disconectBd();
             return $respuesta;
         } catch (Exception $e) {
             die("Error: ".$e);
         }
     }

    // función que elimina los datos solicitados
     function methodDelete($query)
     {
         try {
             conectBd();
             $statement = $GLOBALS['pdo']->prepare($query);
             $statement->execute();
             $statement->closeCursor();
             disconectBd();
             return $_GET['id'];
         } catch (Exception $e) {
             die("Error: ".$e);
         }
     }
