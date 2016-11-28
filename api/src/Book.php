<?php

/**
 *
 */
class Book implements JsonSerializable {

    private $id;
    private $name;
    private $author;
    private $book_desc;

    public function __construct($name = '', $author = '', $book_desc = '') {
        $this->id = -1;
        $this->name = $name;
        $this->author = $author;
        $this->book_desc = $book_desc;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAuthor($author) {
        $this->author = $author;
    }

    function setBook_desc($book_desc) {
        $this->book_desc = $book_desc;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getAuthor() {
        return $this->author;
    }

    function getBook_desc() {
        return $this->book_desc;
    }

    public function loadFromDB($mysqli, $id) {
        $safe_id = $mysqli->real_escape_string($id);
        $query = "SELECT name, author, book_desc FROM books WHERE id = $safe_id";
        if ($res = $mysqli->query($query)) {
            $row = $res->fetch_assoc();
            $this->name = $row['name'];
            $this->author = $row['author'];
            $this->book_desc = $row['book_desc'];
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    public function create($mysqli, $name, $author, $book_desc) {
        $safe_name = $mysqli->real_escape_string($name);
        $safe_author = $mysqli->real_escape_string($author);
        $safe_book_desc = $mysqli->real_escape_string($book_desc);

        $query = "INSERT INTO books (name, author, book_desc) VALUES ('$safe_name', '$safe_author', '$safe_book_desc')";
        if ($mysqli->query($query)) {
            $this->name = $name;
            $this->author = $author;
            $this->book_desc = $book_desc;
            $this->id = $mysqli->insert_id;
            return true;
        } else {
            return false;
        }
    }

    public function update($mysqli, $name, $author, $book_desc) {
        $safe_id = $mysqli->real_escape_string($this->id);
        $safe_name = $mysqli->real_escape_string($name);
        $safe_author = $mysqli->real_escape_string($author);
        $safe_book_desc = $mysqli->real_escape_string($book_desc);

        $query = "UPDATE books SET name ='$safe_name', author = '$safe_author', "
                . "book_desc = '$safe_book_desc' WHERE id = $safe_id";

        if ($mysqli->query($query)) {
            $this->name = $name;
            $this->author = $author;
            $this->book_desc = $book_desc;
            return true;
        } else {
            return false;
        }
    }

    public function deleteFromDB($mysqli) {
        $safe_id = $mysqli->real_escape_string($this->id);

        $query = "DELETE FROM books WHERE id = $safe_id";
        if ($res = $mysqli->query($query)) {
            $this->name = '';
            $this->author = '';
            $this->book_desc = '';
            $this->id = -1;
            return true;
        } else {
            return false;
        }
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'book_desc' => $this->book_desc
        ];
    }

}

?>
