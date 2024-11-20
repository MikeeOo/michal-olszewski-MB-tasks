01. A.
    - Przyczyny:
      - Tabela nie istnieje w bazie danych z powodu błędnej nazwy/literówki lub niewłaściwych uprawnień.
    - Obsługa defektu:
      1. Sprawdzić czy tabela istnieje i czy nie występują jakieś literówki/niespójności.
      2. Sprawdzić czy użytkownik bazy danych posiada odpowiednie uprawnienia.
      3. Sprawdzić czy używany jest właściwy schemat bazy danych i czy wszystkie migracje zostały wykonane.
02. B. 
    - Przyczyna:
        - Próbujemy wypisać wniosek dla pracownika na konkretny dzień, ale pracownik nie był zatrudniony w tym dniu.
        - Obsługa defektu:
          - Jeżeli faktycznie pracownik nie był wtedy zatrudniony, to wszystko jest ok. Ewentualnie można zablokować możliwość wysłania formularza na frontendzie. Jeżeli zaś pracownik był zatrudniony, trzeba sprawdzić czy cały proces śledzenia okresu zatrudnienia jest poprawny.
03. C.
    - Przyczyna:
      - Wartość zawiera literę 'B', która nie jest dozwoloną składnią dla typu integer.
    - Obsługa defektu:
      - Trzeba dopasować i zwalidować typ danych, biorąc pod uwagę wymagania biznesowe.
04. D.
    - Przyczyna:
      - Problem z połączeniem lub eksportem danuych do Sage ERP FK
    - Obsługa defektu:
        - Trzeba przejrzeć logi aplikacji Sage ERP i przeanalizować szczegółowe komunikaty błędów w logach. Trzeba skontrolować format i kompletność wysyłanych danych.
05. E.
    - Przyczyna:
        - Jest to ogólny błąd z konsoli w Chrome. Wskazywać może na problemy z połączeniem sieciowym lub nieprawidłowy adres url.
    - Obsługa defektu:
        - Ze względu na dużą ilość potencjalnych powodów, ustalić z testerem, w jakiej sytuacji pojawił się ten błąd i wtedy przemyśleć plan działania.



    






