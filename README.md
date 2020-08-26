1. Zainstalowaæ program XAMPP 7.3.1.
2. W folderze "xampp/sendmail" podmieniæ plik "sendmail.ini" oraz uzupe³niæ w nim wartoœci zmiennnych auth_username, auth_password i force_sender.
3. W folderze "xampp/php" podmieniæ plik "php.ini oraz uzupe³niæ wartoœæ zmiennej sendmail_from.
4. Folder z pozosta³ymi plikami przenieœæ do folderu "xampp/htdocs".
5. W pliku rejestracja.php ustawiæ wartoœæ zmiennych "sekret" oraz "data-sitekey".
5. Uruchomiæ "xampp/xampp-control.exe".
6. W panelu kontrolnym XAMPP uruchomiæ serwer Apache i MySQL
7. W przegl¹darce uruchomiæ adres "localhost/phpmyadmin/".
8. Na górnym pasku menu w phpMyAdmin wybraæ zak³adkê "Bazy danych".
9. Utworzyæ bazê danych o nazwie "quiz" z kodowaniem "utf8_polish_ci".
10. Z lewej strony z listy wybraæ bazê "quiz".
11. W menu wybraæ "import" i zaimportowaæ plik "quiz.sql" z folderu "systemquizow" z p³yty.
12. W przegl¹darce uruchomiæ adres "localhost/QuizSystem".