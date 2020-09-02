Created in 2018&2019

1. Zainstalować program XAMPP 7.3.1.
2. W folderze "xampp/sendmail" podmienić plik "sendmail.ini" oraz uzupełnić w nim wartości zmiennnych auth_username, auth_password i force_sender.
3. W folderze "xampp/php" podmienić plik "php.ini oraz uzupełnić wartość zmiennej sendmail_from.
4. Folder z pozostałymi plikami przenieść do folderu "xampp/htdocs".
5. W pliku rejestracja.php ustawić wartość zmiennych "sekret" oraz "data-sitekey".
5. Uruchomić "xampp/xampp-control.exe".
6. W panelu kontrolnym XAMPP uruchomić serwer Apache i MySQL
7. W przeglądarce uruchomić adres "localhost/phpmyadmin/".
8. Na górnym pasku menu w phpMyAdmin wybrać zakładkę "Bazy danych".
9. Utworzyć bazę danych o nazwie "quiz" z kodowaniem "utf8_polish_ci".
10. Z lewej strony z listy wybrać bazę "quiz".
11. W menu wybrać "import" i zaimportować plik "quiz.sql" z folderu "systemquizow" z płyty.
12. W przeglądarce uruchomić adres "localhost/QuizSystem".
