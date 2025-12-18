# TP2
## Infos Générales
Mail: mon mail
Sujet: [2A][PHP] TP2 - {nom et prénom}

## Objectifs du TP
Le but du TP est de découper au maximum ( de façon pertinente ) le code pour utiliser proprement require ou require_once.   

15pts
- Créer un composant visuel pour lister les tâches
- Ajouter ce tableau dans toutes les pages concernant les tâches
- Finir de découper les parties communes des views et des controllers

5 pts
- Créer une mini BDD en format fichier pour persister les tâches. UNE LIGNE PAR ÉLÉMENT.
- Prévoir un fichier commun avec des méthodes readData et writeData qui seront utilisées par le model Task pour lire et écrire les data. Chaque ligne du fichier représente une data sérialisée.
  Exemple appel de la méthode readData :
  $data = readData('tasks.txt'); // renvoie un tableau de lignes
  Exemple appel de la méthode writeData :
  writeData('tasks.txt', $data);