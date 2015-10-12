# LMSAdescomPlugin
Wszelkie wymagające wzmianki zmiany w projekcie będą opisywane w tym pliku.
Projekt wspiera standardy [Semantic Versioning](http://semver.org/) i [Keep a CHANGELOG](http://keepachangelog.com/).

## [1.2.0] - 2015-08-14
### Dodano
- dodano CHANGELOG w języku polskim
- dodano w README informację o obsługiwanych wersjach LMS
- dodano w README informację o sekcji "adescom" w "Konfiguracja" > "Interfejs użytkownika"
- dodano informację o autorze pluginu
- dodano informację o nazwie pluginu

### Zmieniono
- dostosowano szablony do nowego silnika renderowania szablonów w pluginach
- dostosowano znaki końca linii
- porzucono wsparcie dla plików README w formatach HTML i PDF
- zmieniono format pliku CHANGELOG
- usunięto nieaktualne zrzuty ekranu prezentujące plugin
- usunięto z pliku README nieaktualne informacje o łańcuchach znaków z tłumaczeniami, łańcuchy znaków z tłumaczeniami są automatycznie obecnie dołączane w LMS
- usunięto z pliku README nieaktualne informacje o zmiennych "default_" z pliku lms.ini
- ulepszono sposób określania ścieżki do pluginu

### Naprawiono
- naprawiono ostrzeżenia wysyłane przez lms-payments w przypadku napotkania niezdefiniowanych frakcji

## [1.1.12] - 2015-07-30
### Naprawiono
- naprawiono edycję zobowiązań VoIP klientów

## [1.1.11] - 2015-07-21
### Naprawiono
- naprawiono pobieranie informacji o kontach VoIP klientów którzy nie są obecni na centrali VoIP Adescom

## [1.1.10] - 2015-07-13
### Naprawiono
- naprawiono usuwanie klientów którzy nie są obecni na centrali VoIP Adescom

## [1.1.9] - 2015-06-30
### Naprawiono
- naprawiono sprawdzanie wartości domyślnej dla usługi UF2M
- naprawiono problemy z kodowaniem znaków w lms-payments

## [1.1.8] - 2015-06-15
### Dodano
- dodano możliwość pobierania ustawień z uiconfig w lms-payments

### Naprawiono
- zmieniono operatory porównania z "eq" na "==" i z "neq" na "!=" w szablonach Smarty

## [1.1.7] - 2015-05-08
### Dodano
- przeniesiono niektóre ze zmiennych konfiguracyjnych z pliku lms.ini do bazy danych z zachowaniem wstecznej kompatybilności

## [1.1.6] - 2015-04-22
### Dodano
- dodano instrukcję nt. synchronizacji

### Naprawiono
- naprawiono procedurę dodawania kont prepaid dla starszych wersji PHP
- naprawiono ścieżkę do szablonu edycji faktur
- usunięto sprawdzanie uprawnienia do wyboru CTM

## [1.1.5] - 2015-04-10
### Naprawiono
- naprawiono dane zwracane przez handler lmsInit
- zmieniono nazwy niektórych klas w celu uniknięcia konfliktów

## [1.1.4] - 2015-04-02
### Naprawiono
- naprawiono błędy w parserze numerów pobieranych z puli pojawiające się w przypadku korzystania z web serwisów frontendowych

## [1.1.3] - 2015-03-25
### Zmieniono
- zaktualizowano pliki README

## [1.1.2] - 2015-03-19
### Dodano
- dodano plik README

## [1.1.1] - 2015-03-17
### Zmieniono
- usunięto zbędne handlery obsługujące dodawanie i edycję klientów

## [1.1.0] - 2015-03-03
### Zmieniono
- wprowadzono więcej OOP
- dodano więcej dokumentacji
- usunięto zbędny kod

## [1.0.13] - 2015-02-23
### Dodano
- dodano więcej dokumentacji

### Naprawiono
- naprawiono błędy wyświetlane na formatce edycji konta VoIP

## [1.0.12] - 2015-02-17 
### Naprawiono
- zoptymalizowano czas pobierania informacji o kontach VoIP na formatkach z listami kont VoIP
- naprawiono problem z zapisaniem domyślnego absolutnego limitu
- naprawiono problem ze sprawdzaniem czy klient już istnieje na centrali podczas dodawania nowego konta VoIP

## [1.0.11] - 2015-02-11
### Dodano
- dodano poziomy blokowanie na formatce dodawanie konta VoIP

### Naprawiono
- naprawiono problem z doładowaniem konta prepaid wartością w której część dziesiętna oddzielona jet znakiem ","
- naprawiono wyświetlanie informacji o koncie VoIP na formatce doładowania konta prepaid
- naprawiono wyświetlanie poziomów blokowania na formatce edycji konta VoIP

## [1.0.10] - 2015-02-10
### Naprawiono
- naprawiono wysyłanie żądań dodawania klientów
- naprawiono formatki dodawania i edycji zobowiązań kont VoIP

## [1.0.9] - 2015-02-02
### Naprawiono
- naprawiono wyświetlanie błędów na formatce dodawania klienta
- naprawiono filtrowanie billingu
- naprawiono formatki dodawania i edycji faktur

## [1.0.8] - 2015-02-01
### Naprawiono
- naprawiono problemy z wyświetlaniem formatek dodawania i edycji faktur

## [1.0.7] - 2015-01-22
### Naprawiono
- naprawiono wyświetlanie nazwy centrali na szablonie informacji o koncie VoIP

## [1.0.6] - 2015-01-13
### Dodano
- dodano ten changelog

### Naprawiono
- naprawiono zmienianie właścicieli konta VoIP

## [1.0.5] - 2015-01-11
### Naprawiono
- poprawiono wyświetlanie informacji o stanie konta VoIP na formatce informacji o koncie VoIP

## [1.0.4] - 2014-12-07
### Zmieniono
- zmieniono ścieżki do szablonów zgodnie ze zmianami w LMS

## [1.0.3] - 2014-11-14
### Naprawiono
- naprawiono problemy z edycją konta VoIP: ustawiono status na domyślnie włączone, dodano domyślny numer telefonu i login

## [1.0.2] - 2014-11-06
### Zmieniono
- usunięto próby łączenia się z centralą Adescom z modułów gdzie nie jest to wymagane

## [1.0.1] - 2014-11-05
### Naprawiono
- naprawiono zarządzanie zobowiązaniami VoIP
- naprawiono problem z profilami telefonów na formatce dodawania kont VoIP
- naprawiono problem z pulą numerów na formatce dodawania kont VoIP
- naprawiono problem z statusem konta VoIP na formatce informacji o koncie VoIP
- naprawiono blok z informacjami o kontach VoIP na formatce informacji o komputerach
- naprawiono problemy na formatce dodawania nowego klienta

## [1.0.0] - 2014-10-16
### Dodano
- pierwsza wersja pluginu
- dodano zarządzanie kontami VoIP i klientami
- dodano zarządzanie zobowiązaniami VoIP
- dodano pozycje VoIP na fakturach
- dodano raporty billingowe
