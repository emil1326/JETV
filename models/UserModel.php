<?php

require_once 'models/ItemModel.php'; // requier ici au lieu de dedans le controller vu qui faut toujour le faire anyways
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
            $stm = $this->pdo->prepare('SELECT alias, nom, prenom, caps, dexteriter, pv, poidsMax, isAdmin, playerPassword, playerImageLink FROM joueure WHERE joueureID=:id');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                if ($data['playerImageLink'] == null) {
                    $data['playerImageLink'] = 'default.webp';
                }

                return new User(
                    $id,
                    $data['alias'],
                    $data['nom'],
                    $data['prenom'],
                    $data['playerPassword'],
                    $data['caps'],
                    $data['dexteriter'],
                    $data['pv'],
                    $data['poidsMax'],
                    $data['isAdmin'],
                    $data['playerImageLink'],
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
            $stm = $this->pdo->prepare('SELECT AliasAvailable(:username)');
            $stm->bindValue(':username', $username, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            return array_values($data)[0] == 1 ? true : false;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function createUser(string $username, string $firstName, string $lastName, string $password, string $profileImage = null): null|PDOException
    {
        if ($profileImage == null) {
            $profileImage = 'default.webp';
        }

        try {
            $stm = $this->pdo->prepare('SELECT CreateJoueur(?, ?, ?, ?, ?)');
            $stm->execute([$username, $lastName, $firstName, $password, $profileImage]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function getDexteriter(int $PlayerID): int
    {
        $inventoryModel = new InventoryModel($this->pdo);

        $weight = $inventoryModel->totalWeight($PlayerID);

        $player = $this->selectById($PlayerID);

        $overDraft = $weight - $player->getMaxWeight();
        $overDraft = $overDraft > 0 ? $overDraft : 0;

        $dext = $player->getDexterity() - $overDraft;

        return $dext;
    }

    public function setCaps(int $caps, int $playerID): bool
    {
        try {
            $stm = $this->pdo->prepare('call setCaps(?, ?)');
            $stm->execute([$caps, $playerID]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function addCaps(int $caps, int $playerID): bool
    {
        return $this->setCaps($this->selectById($playerID)->getCaps() + $caps, $playerID);
    }
    public function updateUser(string $username, string $firstName, string $lastName): bool
    {
        try {
            $stm = $this->pdo->prepare('call ModifyUser;(?, ?, ?)');
            $stm->execute([$username, $lastName, $firstName]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function updatePassword(string $username, string $password): bool
    {
        try {
            $stm = $this->pdo->prepare('call updatePassword;(?, ?)');
            $stm->execute([$username, $password]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
