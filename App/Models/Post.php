<?php

namespace App\Models;

class Post
{
    private static $table = 'posts';
    private static $tableUser = 'users';
    private static $tableCategories = 'categories';

    public static function insert($data)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        if (!empty($data['post_text'])) {
            $SQL = "INSERT INTO " . self::$table . " VALUES(0,:id_user,:post_text,:publish_date)";
            $stmt = $connPDO->prepare($SQL);
            $stmt->bindValue(':post_text', $data['post_text']);
            $stmt->bindValue(':id_user', $data['id_user']);
            $stmt->bindValue(':publish_date', date("Y-m-d H:i:s")); 
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Post realizado com sucesso!";
            } else {
                throw new \Exception("Erro ao realizar post");
            }
        } else {
            throw new \Exception("Insira um texto no post!");
        }

        $connPDO = null;
    }

    public static function delete($data)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = "DELETE FROM " . self::$table . " WHERE id_post = :id";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindValue(':id', $data['id_post']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Sucesso ao deletar post";
        } else {
            throw new \Exception("Erro ao deletar post");
        }

        $connPDO = null;
    }

    public static function update($data)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        if ($data['post_text'] != '') {
            $sql = 'UPDATE ' . self::$table . ' SET post_text = :post_text WHERE id_post = :id';
            $stmt = $connPDO->prepare($sql);
            $stmt->bindValue(':id', $data['id_post']);
            $stmt->bindValue(':post_text', $data['post_text']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Dados atualizados com sucesso";
            } else {
                throw new \Exception("Erro ao atualizar dados");
            }
        } else {
            throw new \Exception("Insira um texto no post!");
        }

        $connPDO = null;
    }

    public static function selectAll()
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = "SELECT * FROM ". self::$table . " INNER JOIN ". self::$tableUser . " ON ".self::$tableUser.".id_user = ".self::$table.".id_user INNER JOIN ".self::$tableCategories." ON ".self::$tableCategories.".id_category = ".self::$tableUser.".id_category ORDER BY publish_day DESC LIMIT 0, 50";
        $stmt = $connPDO->query($sql);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } else {
            throw new \Exception("Não há posts");
        }
    }

    public static function selectProfile(int $id_user)
    {
        $connPDO = new \PDO(DBDRIVE . ':hostname=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = "SELECT * FROM ". self::$table . " WHERE id_user = :id_user ORDER BY publish_day DESC LIMIT 0, 50";
        $stmt = $connPDO->prepare($sql);
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } else {
            throw new \Exception("Não há posts");
        }
    }
}
