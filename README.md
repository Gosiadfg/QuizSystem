1. Zainstalowa� program XAMPP 7.3.1.
2. W folderze "xampp/sendmail" podmieni� plik "sendmail.ini" oraz uzupe�ni� w nim warto�ci zmiennnych auth_username, auth_password i force_sender.
3. W folderze "xampp/php" podmieni� plik "php.ini oraz uzupe�ni� warto�� zmiennej sendmail_from.
4. Folder z pozosta�ymi plikami przenie�� do folderu "xampp/htdocs".
5. W pliku rejestracja.php ustawi� warto�� zmiennych "sekret" oraz "data-sitekey".
5. Uruchomi� "xampp/xampp-control.exe".
6. W panelu kontrolnym XAMPP uruchomi� serwer Apache i MySQL
7. W przegl�darce uruchomi� adres "localhost/phpmyadmin/".
8. Na g�rnym pasku menu w phpMyAdmin wybra� zak�adk� "Bazy danych".
9. Utworzy� baz� danych o nazwie "quiz" z kodowaniem "utf8_polish_ci".
10. Z lewej strony z listy wybra� baz� "quiz".
11. W menu wybra� "import" i zaimportowa� plik "quiz.sql" z folderu "systemquizow" z p�yty.
12. W przegl�darce uruchomi� adres "localhost/QuizSystem".