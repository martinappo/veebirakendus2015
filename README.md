# veebirakendus2015
Veebirakenduste loomise aine raames valmiv projekt.

# Üles panemine

* Tõmba repositori alla
* Installi arvutisse composer, kui seda juba teinud pole (https://getcomposer.org/doc/00-intro.md)
* Käivita projekti kaustas käsurealt "composer update"
* Kui see tehtud, siis "php artisan serve"
* Kui http://localhost:8000 näed LARAVEL 5 teksti, siis on kõik õnnestunud

# Andmebaas ja keskkonna muutujad (environment variables)

Andmebaasiks on mysql. Laravel kasutab andmebaasi haldamiseks migrationeid (kaustas database/migrations). Põhimõtteliselt on see andmebaasi versioonihaldus. See tähendab, et andmebaasi struktuuri saab üles seada ühe käsuga: "php artisan migrate" .

*Kõigepealt tuleb teha andmebaas:*
* Käivita wamp (kui veel pole siis tõmba alla ja installi enne)
* Mine http://localhost/myphpadmin
* Logi sisse root kasutajaga, ilma paroolita
* Tee andmebaas: Databases -> Create database kasti kirjua leiatrenn -> create

*Nüüd tuleb laravelile öelda, et mis on sinu andmebaasi andmed*
* Leia üles .env.example fail projekti juurkaustast
* Tee sellest koopia nimega .env
* Kui sa tegid andmebaasi nimega leiatrenn, siis peaks kõik juba toimima. Kui mingi muu nimega, siis pane .env faili ka vastav nimi

*Uuendame andmebaasi:*
* käsureal 'php artisan migrate'

Edaspidi teeme andmebaasis muudatusi vaid migrate'i kasutades. Lisainfo: http://laravel.com/docs/5.0/migrations .



Minul "composer update" ajal tekkis selline probleem:
 http://artarmstrong.com/blog/2014/12/23/how-to-fix-composer-update-failure-due-to-github-authorization/
Leidsin vastavalt lehelt ka lahenduse.

# Kogemustest Linuxi all:

Üldiselt suuri probleeme ei tekkinud, kui vajalikud package'd lõpuks peale sain.

