<?php

namespace App\Models;

class User
{
    private static $table = 'users';
    private static $table_cat = 'categories';

    public static function login(string $email, string $password)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sqlLogin = "SELECT * FROM " . self::$table . " INNER JOIN ". self::$table_cat ." ON ". self::$table_cat .".id_category = ". self::$table .".id_category WHERE email = :email AND password = :password";
        $stmt = $connPDO->prepare($sqlLogin);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', sha1($password));
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Informações incorretas!");
        }
    }

    public static function insert($data)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sqlEmail = "SELECT email FROM " . self::$table . " WHERE email = :email";
        $verifyEmail = $connPDO->prepare($sqlEmail);
        $verifyEmail->bindValue(':email', $data['email']);
        $verifyEmail->execute();

        if ($verifyEmail->rowCount() == 0) {
            $SQL = "INSERT INTO " . self::$table . " VALUES(0,:id_cat,:name,:email,:password)";
            $stmt = $connPDO->prepare($SQL);
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':id_cat', $data['id_cat']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':password', sha1($data['password']));
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Usuário cadastrado com sucesso!";
            } else {
                throw new \Exception("Erro no cadastro");
            }
        } else {
            throw new \Exception("Email já cadastrado!");
        }

        $connPDO = null;
    }

    public static function delete($data)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = "DELETE FROM " . self::$table . " WHERE id_user = :id";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindValue(':id', $data['id_user']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Sucesso ao deletar conta";
        } else {
            throw new \Exception("Erro ao deletar conta");
        }

        $connPDO = null;
    }

    public static function update($data)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'UPDATE ' . self::$table . ' SET name = :name, email = :email, password = :password, id_category = :id_cat WHERE id_user = :id';
        $stmt = $connPDO->prepare($sql);
        $stmt->bindValue(':id', $data['id_user']);
        $stmt->bindValue(":name", $data['name']);
        $stmt->bindValue(":email", $data['email']);
        $stmt->bindValue(':id_cat', $data['id_cat']);
        $stmt->bindValue(':password', sha1($data['password']));
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Dados atualizados com sucesso";
        } else {
            throw new \Exception("Erro ao atualizar dados");
        }

        $connPDO = null;
    }
}
