<?php

class Action
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getActions($search = '')
    {
        $query = $this->db->prepare('SELECT * FROM actions WHERE deleted_at IS NULL AND (name LIKE ? OR description LIKE ?) ORDER BY name ASC');
        $keyword = '%' . $search . '%';
        $query->execute([$keyword, $keyword]);
        return $query->fetchAll();
    }

    public function getActionById($id)
    {
        $query = $this->db->prepare('SELECT * FROM actions WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$id]);
        return $query->fetch();
    }

    public function createAction($data)
    {
        $query = $this->db->prepare('INSERT INTO actions (id, name, description, created_at, updated_at) VALUES (UUID(), ?, ?, NOW(), NOW())');
        $query->execute([$data['name'], $data['description']]);
    }

    public function updateAction($id, $data)
    {
        $query = $this->db->prepare('UPDATE actions SET name = ?, description = ?, updated_at = NOW() WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$data['name'], $data['description'], $id]);
    }

    public function deleteAction($id)
    {
        $query = $this->db->prepare('UPDATE actions SET deleted_at = NOW(), updated_at = NOW() WHERE id = ? AND deleted_at IS NULL');
        $query->execute([$id]);
    }
}
