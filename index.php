<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/app.js"></script>
    <title></title>
</head>
<body>

    <form id="addbook">
        <label>Imię i nazwisko autora:</label>
        <input type="text" name="author" />

        <label>Tytuł książki:</label>
        <input type="text" name="name" />

        <label>Opis książki:</label>
        <textarea maxlength="250" name="book_desc" rows="5" style="width:50%"></textarea>

        <input id="createNewBook" type="submit" value="Dodaj książkę" />
    </form>

    <hr/>

    <h1>Książki</h1>
    <h3></h3>
    <table class="books_table">
        <tr>
            <th>Autor</th>
            <th>Tytuł</th>
            <th>Opis</th>
            <th></th>
            
        </tr>
    </table>

</body>
</html>
