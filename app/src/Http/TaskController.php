<?php

namespace Http;

use DateTime;
use \Services\DatabaseConnector;

class TaskController extends ApiBaseController {

    protected \Doctrine\DBAL\Connection $db;

    public function __construct() {
        parent::__construct();
        $this->db = DatabaseConnector::getConnection();
    }

    public function overview() {
        $tasks = $this->db->fetchAllAssociative('SELECT * FROM tasks ORDER BY priority', []);
        echo json_encode(['tasks' => $tasks]);
    }

    public function getTask($id) {
        $task = $this->db->fetchAssociative('SELECT * FROM tasks WHERE id = ?', [$id]);
        if (!$task) {
            $this->message(404, 'Task not found');
        } else {
            echo json_encode(['task' => $task]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = ?');
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            $this->message(404, 'Task not found');
        } else {
            $this->message(204, 'Task has been deleted');
        }
    }

    public function addTask() {
        $bodyParams = $this->httpBody;
        $priority = $bodyParams['priority'] ?? '';
        $name = $bodyParams['name'] ?? '';

        if ((in_array($priority, ['low', 'normal', 'high'])) && (strLen($name) < 2)) {
            $stmt = $this->db->prepare('INSERT INTO tasks (name, priority, added_on) VALUES (?, ?, ?);');
            $stmt->execute([$name, $priority, (new DateTime())->format('Y-m-d H:i:s')]);
            $this->message(201, "Task added successfully");
        } else {
            $this->message(422, 'Task could not been added, check your input values');
        }
    }

    public function editTask($id) {
        $bodyParams = $this->httpBody;
        $priority = $bodyParams['priority'] ?? '';
        $name = $bodyParams['name'] ?? '';
        if ((in_array($priority, ['low', 'normal', 'high'])) && ($name !== '')) {
            $stmt = $this->db->prepare('UPDATE tasks SET name = ?, priority = ? WHERE id = ?');
            $stmt->execute([$name, $priority, $id]);
            $this->message(204, "Task updated successfully");
        } else {
            $this->message(404, 'Task could not been updated, check your input values');
        }
    }
}