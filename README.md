# BLJ-Zeiterfassungssystem
## Aufgabenstellung
Im Basislehrjahr gibt es eine Zeiterfassungs-Gerät. Das Problem ist aber, dass die Zeiten erst Ende Monat oder mit einer Nachfrage beim Coach einsehen kann. Ich hatte die Idee eine Web-Applikation zu Programmieren in der die Stemplungen jederzeit angesehen werden können. Die Web-Applikation würde auch die Arbeit des Coaches erleichtert da er die Stemplungen nicht mehr in ein Excel-File exportieren muss. Die Stemplungen sollten dann samt den Überstunden auf der Webseite angezeigt werden. Dafür habe ich 12 Tage Zeit bekommen.

## Ergebnisse
Ich habe eine Consolen-Applikation programmiert. Sie kann die Daten von dem Zeiterfassungs-Gerät lesen und verarbeiten. Die Daten werden nachher von der Applikation in eine MySQL Datenbank abgespeichert. Die Daten werden dann am Schluss auf einer Webseite angezeigt. Aud der Webseite kann man sich auch einloggen.

## Lösungskonzept
Ich habe eine C# Consolen Applikation programmiert. Diese Applikation kann Daten vom Backup des Zeiterfassungs-Geräts abrufen und verarbeiten. Die Applikation rechnet die Überstunden aus, Markiert Tage wo eine Stemplung vergessen wurde als nicht Korrekter Tag. Nach dem die Daten verarbeitet wurden werden sie in einer MySQL Datenbank abgespeichert. Die Daten werden dann mit mit Hilfe einer php-Applikation auf der Webseite angezeigt.

## Diagram
## Aufgetretene Probleme
Ich konnte am Anfang nicht auf die Daten des Gerätes zugreifen. Mit Urs hilfe habe ich ein Weg herausgefunden wie ich Daten bekommen kann. Das Gerät macht regelmässig ein Backup. Dieses Backup wir in Form von einer Firebase Datenbank gemacht. Da ich auf diese Daten ohne Nutzername und Passwort zugreifen kann war dieses Problem gelöst. Ein anders Problem war, dass ich das Projekt unterschätz habe. Ich war schon nach den ersten Tagen hinter dem Zeitplan und ich konnte das Projekt nicht fertigstellen.

