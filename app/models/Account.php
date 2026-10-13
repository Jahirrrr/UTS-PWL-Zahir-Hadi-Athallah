<?php

class Account
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAccounts($search = '')
    {
        $query = $this->db->prepare(
            'SELECT a.*, t.name AS type_name FROM accounts a
             JOIN account_type t ON t.id = a.account_type_id
             WHERE a.deleted_at IS NULL AND t.deleted_at IS NULL
             AND (a.name LIKE ? OR a.email LIKE ? OR a.identification_number LIKE ? OR t.name LIKE ?)
             ORDER BY a.created_at DESC, a.name ASC'
        );
        $keyword = '%' . $search . '%';
        $query->execute([$keyword, $keyword, $keyword, $keyword]);
        return $query->fetchAll();
    }

    public function getAccountById($id)
    {
        $query = $this->db->prepare('SELECT * FROM accounts WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$id]);
        return $query->fetch();
    }

    public function findByEmail($email)
    {
        $query = $this->db->prepare('SELECT * FROM accounts WHERE email = ? AND deleted_at IS NULL');
        $query->execute([$email]);
        return $query->fetch();
    }

    public function emailExists($email, $exceptId = '')
    {
        $query = $this->db->prepare('SELECT COUNT(*) FROM accounts WHERE email = ? AND id <> ?');
        $query->execute([$email, $exceptId]);
        return $query->fetchColumn() > 0;
    }

    public function typeIsUsed($typeId, $exceptId = '')
    {
        $query = $this->db->prepare('SELECT COUNT(*) FROM accounts WHERE account_type_id = ? AND id <> ?');
        $query->execute([$typeId, $exceptId]);
        return $query->fetchColumn() > 0;
    }

    public function createAccount($data)
    {
        $query = $this->db->prepare(
            'INSERT INTO accounts (id, name, email, password, account_type_id, status, identification_number, identification_type, created_at, updated_at)
             VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())'
        );
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $query->execute([$data['name'], $data['email'], $password,
            $data['account_type_id'], $data['status'], $data['identification_number'], $data['identification_type']]);
    }

    public function updateAccount($id, $data)
    {
        $query = $this->db->prepare(
            'UPDATE accounts SET name = ?, email = ?, account_type_id = ?, status = ?, identification_number = ?, identification_type = ?, updated_at = NOW()
             WHERE id = ? AND deleted_at IS NULL'
        );
        $query->execute([$data['name'], $data['email'], $data['account_type_id'], $data['status'],
            $data['identification_number'], $data['identification_type'], $id]);

        if ($data['password'] !== '') {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $query = $this->db->prepare('UPDATE accounts SET password = ? WHERE id = ? AND deleted_at IS NULL');
            $query->execute([$password, $id]);
        }
    }

    public function deleteAccount($id)
    {
        $query = $this->db->prepare('UPDATE accounts SET deleted_at = NOW(), updated_at = NOW() WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$id]);
    }
}
