class Portefeuille:
    def __init__(self, solde_initial=0):
        self.solde = solde_initial
        self.historique_transactions = []

    def afficher_solde(self):
        print(f"Solde actuel: {self.solde} euros")

    def deposer(self, montant):
        self.solde += montant
        self.historique_transactions.append(f"Dépôt de {montant} euros")
        print(f"Dépôt de {montant} euros effectué avec succès.")
        self.afficher_solde()

    def retirer(self, montant):
        if montant <= self.solde:
            self.solde -= montant
            self.historique_transactions.append(f"Retrait de {montant} euros")
            print(f"Retrait de {montant} euros effectué avec succès.")
            self.afficher_solde()
        else:
            print("Solde insuffisant pour effectuer le retrait.")

    def afficher_historique(self):
        print("Historique des transactions:")
        for transaction in self.historique_transactions:
            print(transaction)

    def effectuer_virement(self, destinataire, montant):
        if montant <= self.solde:
            self.solde -= montant
            destinataire.deposer(montant)
            self.historique_transactions.append(f"Virement de {montant} euros vers {type(destinataire).__name__}")
            print(f"Virement de {montant} euros vers {type(destinataire).__name__} effectué avec succès.")
            self.afficher_solde()
        else:
            print("Solde insuffisant pour effectuer le virement.")

# Fonction pour exécuter des commandes depuis la console
def executer_commandes():
    portefeuille = Portefeuille()

    while True:
        commande = input("Entrez une commande (solde, depot, retrait, virement, historique, quitter): ").lower()

        if commande == "solde":
            portefeuille.afficher_solde()
        elif commande == "depot":
            montant_depot = float(input("Entrez le montant du dépôt : "))
            portefeuille.deposer(montant_depot)
        elif commande == "retrait":
            montant_retrait = float(input("Entrez le montant du retrait : "))
            portefeuille.retirer(montant_retrait)
        elif commande == "virement":
            destinataire = Portefeuille()
            montant_virement = float(input("Entrez le montant du virement : "))
            portefeuille.effectuer_virement(destinataire, montant_virement)
        elif commande == "historique":
            portefeuille.afficher_historique()
        elif commande == "quitter":
            print("Fermeture du programme.")
            return
        else:
            print("Commande invalide. Veuillez réessayer.")

# Exécutez la fonction pour démarrer le programme interactif
executer_commandes()

