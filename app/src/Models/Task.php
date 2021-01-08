<?php

namespace Models;

use \DateTime;

class Task {

    private int $id;
    private string $name;
    private string $priority;
    private DateTime $addedOn;

    public function __construct(int $id, string $name, string $priority, DateTime $addedOn) {
        $this->id = $id;
        $this->name = $name;
        $this->priority = $priority;
        $this->addedOn = $addedOn;
    }


    public static function fromArray($taskArray) {
        return new Task($taskArray['id'], $taskArray['name'], $taskArray['priority'], new DateTime($taskArray['added_on']));
    }
    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPriority(): string {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority(string $priority): void {
        $this->priority = $priority;
    }

    /**
     * @return DateTime
     */
    public function getAddedOn(): DateTime {
        return $this->addedOn;
    }

    /**
     * @param DateTime $addedOn
     */
    public function setAddedOn(DateTime $addedOn): void {
        $this->addedOn = $addedOn;
    }

}