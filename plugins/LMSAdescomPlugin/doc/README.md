LMSAdescomPlugin
================

Wymagania
---------

Obowiązkowo, aby uruchomić plugin:

 * LMS GIT od 2ff41783d62566e34ae8f5045d06df87e83fe8a4 (2015-02-11) do c5de997dab26624f27ae8b6df69ec5334a339211 (2015-06-03)
   * obsługiwany przez plugin w wersjach do 1.1.12
 * LMS GIT od e16dc46fddfd62fb613e851302d7533a3e0a7c1b (2015-08-13)
   * obsługiwany przez plugin w wersjach od 1.2.0

Opcjonalnie, do uruchomienia lms-payments:

 * SOAP/Lite.pm
 * Date/Simple.pm

Instalacja
----------

1. Rozpakować plugin do folderu lms/plugins.
2. Skopiować zawartość lms/plugins/LMSAdescomPlugin/doc/lms.ini do właściwego lms.ini.
3. W lms.ini w sekcji "adescom" podać właściwe URL do webserwisów oraz hasła.
4. Zalogować się do LMS i w "Konfiguracja" > "Interfejs użytkownika" w sekcji "phpui" dodać opcję "plugins" z zawartością "LMSAdescomPlugin:1" (jeśli opcja plugins istnieje i nie jest pusta to należy dodać zawartość oddzielając ją od poprzedniej znakiem ";").
5. Odświeżyć stronę LMS.
6. W razie potrzeby dostosować zmienne w sekcji "adescom" w "Konfiguracja" > "Interfejs użytkownika".
7. W razie problemów wyczyścić lms/templates_c oraz lms/cache (pozostawiając tylko pliki .htaccess).

Funkcjonalność pluginu
----------------------

1. Wyświetlanie listy kont VoIP istniejących na centrali i przypisanych do klienta z LMS, w tym prezentacja:
    * stanu urządzenia VoIP;
    * hasła urządzenia VoIP;
    * adresu IP urządzenia VoIP;
    * taryfy powiązanej z numerem VoIP;
    * stanu konta powiązanego z numerem VoIP;
    * listy usług włączonych dla numeru VoIP.

2. Dodawanie, edycja i usuwanie kont VoIP na centrali, w tym:
    * określanie globalnego miesięcznego limitu;
    * ustawianie podstawowych danych o koncie VoIP;
    * ustawianie taryf;
    * ustawianie poziomów blokowania;
    * edycja usług przypisanych do konta VoIP;
    * zarządzanie limitami przypisanymi do konta VoIP;
    * doładowywanie kont prepaid.

3. Pobieranie danych billingowych, w tym:
    * wyszukiwanie połączeń przychodzących i wychodzących;
    * wyszukiwanie po numerze źródłowym i docelowym;
    * wyszukiwanie w zadanym okresie;
    * prezentacja czasu połączeń, kierunków, naliczonej ceny oraz ceny za minutę;
    * prezentacja podsumowania dla zadanego zapytania.

4. Podstawowe zarządzanie zobowiązaniami po stronie centrali:
    * dodawanie nowego zobowiązania;
    * edycja istniejących zobowiązań;
    * wyświetlanie historii zmian zobowiązania.

5. Pobieranie danych billingowych do faktury tworzonej po stronie LMS:
    * dodawanie pozycji na fakturach tworzonych z interfejsu WWW LMS;
    * dodawanie pozycji na fakturach tworzonych poprzez lms-payments (tylko wersja perl).

6. Logowanie z panelu klienta LMS do panelu abonenta na centrali.

Synchronizacja centrali z LMS
-----------------------------

W przypadku występowania rozbieżności pomiedzy listą kont VoIP w LMS i na centrali Adescom należy dokonać synchronizacji.
Poniżej opisano kilka najczęstszych scenariuszy oraz krok po kroku procedurę synchroniacji.

1. Klient istnieje po stronie centrali i LMS (inne konta były już wcześniej łączone):
    1. Wyłączamy plugin w LMS (w konfiguracji interfejsu użytkownika usuwamy opcję plugins lub jeśli mamy tam wpisane więcej pluginów to usuwamy tylko informację o LMSAdescomPlugin).
    2. Dodajemy w LMS konta tak aby w polu login i numer znalazł się clid z centrali.
        Jeśli wiemy jaki był typ rejestracji to w polu "login" wpisujemy odpowiednią kombinację country_code + area_code + short_clid, jeśli nie wiemy to wpisujemy cały clid.
        W polu "hasło" wpisujemy hasło z centrali (jeśli hasło nie może zostać zapisane z powodu niedozwolonych znaków to wpisujemy cokolwiek).
    3. Włączamy plugin w LMS.
    4. Wchodzimy na kartę klienta, a następnie do edycji numeru i zapisujemy numer. 
        Pozwoli to na ewentualną poprawę hasła i loginu po stronie LMS, tak aby były one takie same jak na centrali (uwzględnienie typu rejestracji, niedozwolonych znaków w haśle).

2. Klient nie istnieje po stronie LMS, istnieje na centrali:
    1. Wyłączamy plugin w LMS (w konfiguracji interfejsu użytkownika usuwamy opcję plugins lub jeśli mamy tam wpisane więcej pluginów to usuwamy tylko informację o LMSAdescomPlugin).
    2. Dodajemy klienta w LMS.
    3. Na centrali odnajdujemy klienta i w polu "Dodatkowy ID 1" wpisujemy id z LMS.
    4. Dodajemy konta tak aby w polu login i numer znalazł się clid z centrali (jeśli wiemy jaki był typ rejestracji to w polu login wpisujemy odpowiednią kombinację country_code + area_code + short_clid, jeśli nie wiemy to wpisujemy cały clid), a w polu hasło hasło z centrali (jeśli hasło nie może zostać zapisane z powodu niedozwolonych znaków to wpisujemy cokolwiek).
    5. Włączamy plugin w LMS.
    6. Wchodzimy na kartę klienta a następnie do edycji numeru i zapisujemy numer. 
        Pozwoli to na ewentualną poprawę hasła i loginu po stronie LMS tak aby był taki sam jak na centrali (uwzględnienie typu rejestracji, niedozwolonych znaków w haśle).

3. Klient i konto istnieją po stronie LMS, nie istnieje konto na centrali:
    1. Odnajdujemy klienta, np. wyszukując po nazwisku.
    2. Dodajemy konto na centrali do klienta.
    3. Uzupełniamy "Identyfikator klienta 1" tak aby odpowiadał on ID klienta w LMS.

4. Klient i konto istnieją po stronie LMS, nie istnieje zarówno klient jak i konto na centrali
    1. Dodajemy klienta lub korzystamy ze szybkiego dodawania numerów.
    2. Dodajemy konto VoIP, tak jak opisano w punkcie 3.
