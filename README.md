
Contao 3
============

not yet supported

Contao 2
============

Erstellen von Bildergalerie-Gruppen mit Listen-, Einzel- und Ansichtsmodulen

Das Galerie-Modul erlaubt es Ihnen, außerhalb eines Artikels Bildergalerien zu verwalten. Dieses Modul arbeitet ähnlich dem Galerie CE, aber es verwendet seine eigene Datenbank und Module, um eine Galerie-Liste, Ansichten und einzelne Galerien zu erstellen.

Lizenz:  LGPL
Copyright: 	© 2008-2012 Thyon Design
Autor: Thyon Design (thyon) http://www.thyon.com/
Deutsch übers.:	Pascal Wieland (P_J) http://www.pw-webcreations.de

### Einführung ###
Galerie-Sammlungen (oder Archive) können eingerichtet werden, um geschützte Gruppen zu erstellen, um mit Seiten verknüpft zu werden, mit Künstler-Mitgliedsgruppen-Beschränkung, Standard-Sortierung, RSS Feeds (ja, Galerien in Feeds), und natürlich durchsuchbar (wie News, Events, FAQ).

Galerie-Einträge wurden extrem verbessert und Sie können nun entweder individuelle Kunstwerk-oder Foto-Einträge innerhalb eines einzelnen Poster-Bildes handhaben oder Sie können eine Mehrfach-Bilder-Galerie hinzufügen. Dies erlaubt Ihnen, sowohl Einträge mit einzelnen Fotos zu katalogisieren als auch noch Foto-Galerien mit Events zu erstellen, das für die Darstellung ein nettes Poster-Bild verwendet (wenn Sie es bevorzugen, die Galerie in der Listenansicht zu verstecken).

Diese neue Version führt das Konzept der Kategorisierung von Kunstwerken/Fotos innerhalb von Galerien ein, d.h.

* Autor (BE Benutzer)
* Künstler (FE Mitglied)
* Status (Verfügbar, verkauft, reserviert)
* Größe des Kunstwerkes (A x B cm/mm/in/px)
* Medium (Öl, Acryl, Farbdruck etc.)
* Stoff (Canvas, Papier, Foto, Fabriano, etc.) 
* Ort
* Beschreibung
* Gestaltung 
* Veröffentlichte Merkmale Start/Stop

All diese Einträge oder alle zusätzlichen Kategorie-Einträge können jetzt von anderen Entwicklern erweitert und gefiltert werden (['eval']['feFilter'] = true).

### Galerie-List-Module ###

Sie können nun Galerie-Einträge auflisten wie News-Einträge (nun mit odd/even Klassen), pro Seite, gestaltet, mit Sortier-Einschränkungen. Dann können Sie optional auch die Bildgalerie rendern (was dann ihren Stil vom CE Galerie kopiert). Sie können desweiteren auch bestimmen, welche Meta-Felder angezeigt werden müssen (Menge, Kommentare, Autor, Stoff, Medium, etc.). 

#### Listen-Filterung ####

Das ist eine großartige neue Erweiterung, die Ihnen erlaubt, Checkboxen zu verwenden, um eine "Vorfilterung" auf jeden feFilter durchzuführen, d.h. Status=verfügbar, Medium=Öl, etc. Dann können Sie auch das Filter-Menü aktivieren, welches eine UL/LI Navigation erstellt, um Ihnen eine schnellere Filterung der gesamten Liste mit Kunstwerken/Fotos/Galerien mit ein paar Mausklicks erlaubt.

### Verknüpfte Module für Galerie-Listen-Seiten ### 

Dies arbeitet wie das Listen-Modul, aber erlaubt Ihnen, eine Seite mit einem einem Archiv zu verknüpfen, damit Sie nur ein Layout für viele Seiten benötigen. Das Modul schaut eigenständig nach, auf welcher Seite es verfügbar ist, sucht danach in den Galerie-Sammlungen und zeigt dann nur diese Sammlungen an. Sie können natürlich noch filtern anhand des Status, Medium, Stoff etc.

### Galerie-Ansichts-Modul ###

Dies konfiguriert ganz einfach die Anzeige der Detail-Seite, ähnlich des Listen-Moduls.

### Galerie-Single-Modul ###

Dies erlaubt Ihnen die Erstellung einer Liste mit einem Galerie-Eintrag. Dies allein ist ein bisschen sinnlos, wird aber jetzt ein Kraftpaket in Bezug auf die Erstellung einer Inserttag-Referenz.
[{]insert_gallery::ID:MID[}] 
wobei ID die Galerie-ID ist, und MID die Module-ID des Galerie-Single-Moduls. Grundsätzlich lädt es die Konfiguration des Galerie-Single-Moduls, dann bestimmt es seine Modul-ID anhand der ID, die Sie angegeben haben und rendert sie dann in die Inserttag-Ausgabe.

### Galerie-Kommentare ###

Während der Installation werden Ihre bestehenden Kommentare in das integrierte Contao Kommentar-System migriert.

### Zusammenfassung ###

Wir hoffen, dass Ihnen diese neue und erweiterte Version gefällt.


Freigabe-Notizen und Änderungs-Log für 0.8.2

* Korrektur eines kleinen Fehlers, der verhinderte, dass der Ort angezeigt wurde
* Neue KlassePaginationCustom erstellt, die mit eingelagerten Galerien und Kommentaren zurechtkommt
* Zusätzliche Meta Parameters hinzugefügt: Fotograf, Ort
* Änderungen an Templates, um die obigen Meta Parameter zu unterstützen
* Ein neues Galerie-Anzeige-Modul wurde hinzugefügt, das dfGallery unterstützt (Nur Unterstützung für einzelne Hauptordner, Unterordner eingeschlossen)
* Galerie-Kommentare hinzugefügt
