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

        if ((in_array($priority, ['low', 'normal', 'high'])) && ($name !== '')) {
            $stmt = $this->db->prepare('INSERT INTO tasks (name, priority, added_on) VALUES (?, ?, ?);');
            $stmt->execute([$name, $priority, (new DateTime())->format('Y-m-d H:i:s')]);
            $this->message(201, "Task added succesfully");
        } else {
            $this->message(422, 'Task could not been added, check your input values');
        }
    }


    /*
        public function create() {
            $priority = isset($_POST['priority']) ? trim($_POST['priority']) : '';
            $what = isset($_POST['what']) ? trim($_POST['what']) : '';

            $formErrors = [];

            if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {
                if (strLen($what) < 3) {
                    $formErrors[] = 'Taakbeschrijving moet minstens 3 karakters zijn';
                }
                if (!in_array($priority, ['low', 'normal', 'high'])) {
                    $formErrors[] = 'Incorrecte prioriteit opgegeven';
                }

                if (!$formErrors) {
                    $stmt = $this->db->prepare('INSERT INTO tasks (name, priority, added_on, user_id) VALUES (?, ?, ?, ?);');
                    $stmt->execute([$what, $priority, (new DateTime())->format('Y-m-d H:i:s'), $this->user['id']]);
                } else {
                    $_SESSION['flash'] = ['formErrors' => $formErrors, 'what' => $what, 'priority' => $priority];
                }
            }
            $mailer = new EmailService();
            $mailer->sendMailTask($this->user['email'], $this->user['username'], $what);
            header('location: /tasks');
            exit();
        }

        public function showEdit(string $id) {
            $formErrors = isset($_SESSION['flash']['formErrors']) ? $_SESSION['flash']['formErrors'] : [];
            $task = isset($_SESSION['flash']['task']) ? $_SESSION['flash']['task'] : null;
            unset($_SESSION['flash']);

            $taskRow = $this->db->fetchAssociative('SELECT * FROM tasks WHERE id = ? AND user_id = ?', [$id, $this->user['id']]);

            if ($taskRow === false) {
                header('Location: /tasks');
                exit();
            }

            if ($task === null) {
                $task = Task::fromArray($taskRow);
            }
            echo $this->twig->render('pages/task-edit.twig', ['task' => $task, 'formErrors' => $formErrors, 'authenticated' => true]);
        }

        public function edit() {
            $priority = isset($_POST['priority']) ? trim($_POST['priority']) : '';
            $what = isset($_POST['what']) ? trim($_POST['what']) : '';
            $id = isset($_POST['id']) ? trim($_POST['id']) : 0;

            if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'edit')) {
                if (strLen($what) < 3) {
                    $formErrors[] = 'Taakbeschrijving moet minstens 3 karakters zijn';
                }
                if (!in_array($priority, ['low', 'normal', 'high'])) {
                    $formErrors[] = 'Incorrecte prioriteit opgegeven';
                }
                if (!$formErrors) {
                    $stmt = $this->db->prepare('UPDATE tasks SET name = ?, priority = ? WHERE id = ?');
                    $stmt->execute([$what, $priority, $id]);
                    header('Location: /tasks');
                    exit();
                }
            }
            $_SESSION['flash'] = ['formErrors' => $formErrors, 'task' => new Task($id, $what, $priority, new DateTime())];
            header('Location: /tasks/' . $id . '/edit');
            exit();
        }

        public function showDelete(string $id) {
            $taskRow = $this->db->fetchAssociative('SELECT * FROM tasks WHERE id = ? AND user_id = ?', [$id, $this->user['id']]);

            if ($taskRow === false) {
                header('Location: /tasks');
                exit();
            }
            $task = Task::fromArray($taskRow);

            echo $this->twig->render('pages/task-delete.twig', ['task' => $task, 'authenticated' => true]);
        }

        public function delete(string $id) {
            $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = ?');
            $stmt->execute([$id]);
            header('Location: /tasks');
            exit();
        }*/
}