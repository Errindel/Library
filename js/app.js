$(document).ready(function () {
    var endpoint = window.location + 'api/books.php';
    
    function loadBooks() {
        $.get(endpoint, function (json) {
            var books = $.parseJSON(json); // pobieramy dane jako json i zwracamy jako js

            for (var i = 0; i < books.length; i++) {
                var book = $('<table class="addedBook"><tr data-book_id="' + books[i].id + '"><td>' + books[i].author + '</td><td class="book-name">'
                        + books[i].name + '</td><td>' + books[i].book_desc
                        + '</td><td class="delete">usuń</td></tr></table><div class="book-info" data-book_id="' + books[i].id + '"></div>');
                $('table.books_table').after(book);
            }
        });
    }

    loadBooks();

    //rozwijanie diva i wczytywanie do niego dodatkowych danych
    $(document).on('click', 'td.book-name', function () {
        var editForm = '<form id="editbook"><label>Imię i nazwisko autora:</label>\n\
        <input type="text" name="author"/><label>Tytuł książki:</label><input type="text" name="name" />\n\
        <label>Opis książki:</label><textarea maxlength="250" name="book_desc" rows="5" style="width:50%">'
        +'</textarea><input id="editBook" type="submit" value="Edytuj dane" /></form>';
        var bookDiv = $(this).closest("table").next();
        bookDiv.slideToggle();
        var bookId = $(this).parent().data("book_id");
        $.get(endpoint + '?id=' + bookId + '', function (json) {
            var book = $.parseJSON(json);
            bookDiv.html('Info: ' + book.name+'<br><br><b>Formularz edycji danych:</b>' + editForm);
        });
    });



    //dodawanie książki
    $(document).find('#createNewBook').click(function (e) {
        e.preventDefault();
        var nameValue = $(this).parent().find('input[name="name"]');
        var authorValue = $(this).parent().find('input[name="author"]');
        var descriptionValue = $(this).parent().find('textarea[name="book_desc"]');

        var data = {'author': authorValue.prop('value'),
            'name': nameValue.prop('value'),
            'book_desc': descriptionValue.prop('value')
        };
        $.ajax({
            type: 'POST',
            url: endpoint,
            data: data,
            dataType: 'json'
        })

                .done(function (message) {
                    $(document).find("h3").text(message.text);
                    $('table.addedBook').remove();
                    $('div.book-info').remove();
                    loadBooks();
                    nameValue.prop('value', '');
                    authorValue.prop('value', '');
                    descriptionValue.prop('value', '');
                });
    });

    //usuwnie książki
    $(document).on('click', 'td.delete', function () {
        var bookId = $(this).parent().data("book_id");
        var data = {'id': bookId};
        
        $.ajax({
            type: 'DELETE',
            url: endpoint,
            data: data,
            dataType: 'json'
        })
                .done(function (message) {
                    $('table.addedBook').remove();
                    $('div.book-info').remove();
                    $(document).find("h3").text(message.text);
                    loadBooks();
                });

    });

    //edycja danych
    $(document).on('click', '#editBook', function (e) {
        e.preventDefault();
        var bookId = $(this).closest("div").data("book_id");
        var nameValue = $(this).parent().find('input[name="name"]');
        var authorValue = $(this).parent().find('input[name="author"]');
        var descriptionValue = $(this).parent().find('textarea[name="book_desc"]');

        var data = {'author': authorValue.prop('value'),
            'name': nameValue.prop('value'),
            'book_desc': descriptionValue.prop('value'),
            'id': bookId
        };
        $.ajax({
            type: 'PUT',
            url: endpoint,
            data: data,
            dataType: 'json'
        })
                .done(function (message) {
                    $('table.addedBook').remove();
                    $('div.book-info').remove();
                    $(document).find("h3").text(message.text);
                    loadBooks();
                });
    });


});
