<?php

require_once 'src/class/User.php';

class UserModel
{
    public function __construct(private PDO $pdo) {}

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
}
