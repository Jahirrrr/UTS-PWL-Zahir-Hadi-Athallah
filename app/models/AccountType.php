<?php

class AccountType
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAccountType($search = '')
    {
        $query = $this->db->prepare('SELECT * FROM account_type WHERE deleted_at IS NULL AND (name LIKE ? OR description LIKE ?) ORDER BY name ASC');
        $keyword = '%' . $search . '%';
        $query->execute([$keyword, $keyword]);
        return $query->fetchAll();
    }

    public function getAccountTypeById($id)
    {
        $query = $this->db->prepare('SELECT * FROM account_type WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$id]);
        return $query->fetch();
    }

    public function getAvailableTypes($accountId = '')
    {
        $query = $this->db->prepare(
            'SELECT t.* FROM account_type t
             LEFT JOIN accounts a ON a.account_type_id = t.id
             WHERE t.deleted_at IS NULL AND (a.id IS NULL OR a.id = ?)
             ORDER BY t.name ASC'
        );
        $query->execute([$accountId]);
        return $query->fetchAll();
    }

    public function isUsed($id)
    {
        $query = $this->db->prepare('SELECT COUNT(*) FROM accounts WHERE account_type_id = ? AND deleted_at IS NULL');
        $query->execute([$id]);
        return $query->fetchColumn() > 0;
    }

    public function createAccountType($data)
    {
        $query = $this->db->prepare('INSERT INTO account_type (id, name, description, created_at, updated_at) VALUES (UUID(), ?, ?, NOW(), NOW())');
        $query->execute([$data['name'], $data['description']]);
    }

    public function updateAccountType($id, $data)
    {
        $query = $this->db->prepare('UPDATE account_type SET name = ?, description = ?, updated_at = NOW() WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$data['name'], $data['description'], $id]);
    }

    public function deleteAccountType($id)
    {
        $query = $this->db->prepare('UPDATE account_type SET deleted_at = NOW(), updated_at = NOW() WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$id]);
    }
}
