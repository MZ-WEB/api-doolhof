### Structure d'une requète ###

#On importe la librairie nécessaire
import requests;

#token secret, obtenu avec une requete préliminaire sur la page /login.php avec les identifiants du joueur
token = 'token-secret-9f91'
#Le header qui définit un "user-agent" specifique pour le client
headers = {'user-agent': 'doolhof-client/1.1', 'X-Auth-Token': token}
#La requète
r = requests.post("https://api.doolhof.mz-web.fr/action.php", headers=headers, data={'data1':'something', 'data2': 'somethingElse'})

#Le retour de la page peut être obtenu avec : 
#- r.text (le code la page)
#- r.status_code et r.reason (le "header" de la réponse de la page
