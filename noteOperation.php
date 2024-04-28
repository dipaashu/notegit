<?php
include 'database.php';

class NoteOperations
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createNote($userId, $title, $content)
    {
        // $stmt = $this->conn->prepare("INSERT INTO notes (title, notes) VALUES (?, ?)");
        $stmt = $this->conn->prepare("INSERT INTO notes (userid, title, notes) VALUES (?, ?, ?)");
        // $stmt->bind_param("ss", $title, $content);
        $stmt->bind_param("sss", $userId, $title, $content);
        $stmt->execute();
        $stmt->close();
    }

    public function readNotes($userId)
    {
        $stmt = $this->conn->prepare("SELECT noteid, title, notes FROM notes WHERE userid = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $notes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notes;
    }

    public function updateNote($noteId, $userId, $title, $content)
    {
        $stmt = $this->conn->prepare("UPDATE notes SET title = ?, notes = ? WHERE noteid = ? AND userid = ?");
        $stmt->bind_param("ssii", $title, $content, $noteId, $userId);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteNote($noteId, $userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM notes WHERE noteid = ? AND userid = ?");
        $stmt->bind_param("ii", $noteId, $userId);
        $stmt->execute();
        $stmt->close();
    }
}
