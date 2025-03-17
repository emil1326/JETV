<?php

require_once 'models/Model.php';
require_once 'src/class/User.php';

class UserModel extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectById(int $id): null|User
    {
        try {
            $stm = $this->pdo->prepare('SELECT alias, nom, prenom, caps, dexteriter, pv, poidsMax, isAdmin, playerPassword FROM joueure WHERE joueureID=:id');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return new User(
                    $id,
                    $data['alias'],
                    $data['nom'],
                    $data['prenom'],
                    $data['caps'],
                    $data['dexteriter'],
                    $data['pv'],
                    $data['poidsMax'],
                    $data['isAdmin'],
                    $data['playerPassword']
                );
            }

            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function authentify(string $username, string $password): int
    {
        try {
            $stm = $this->pdo->prepare('SELECT CheckLogin(:username, :password)');
            $stm->bindValue(':username', $username, PDO::PARAM_STR);
            $stm->bindValue(':password', $password, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            return array_values($data)[0];
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function isUsernameAvailable(string $username): bool
    {
        try {

            // Temporary return statement
            //  TODO: Create stored procedure: AliasAvailable
            return true;

            $stm = $this->pdo->prepare('SELECT AliasAvailable(:username)');
            $stm->bindValue(':username', $username, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            return array_values($data)[0];
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function createUser(string $username, string $firstName, string $lastName, string $password)
    {
        $stm = $this->pdo->prepare('CALL CreateJoueur(?, ?, ?, ?)');
        $stm->execute([$username, $lastName, $firstName, $password]);
        try {
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}
