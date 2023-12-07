<?php

class Portefeuille {
    private $solde;
    private $historiqueTransactions;

    public function __construct($soldeInitial = 0) {
        $this->solde = $soldeInitial;
        $this->historiqueTransactions = [];
    }

    public function afficherSolde() {
        echo "Solde actuel: {$this->solde} euros\n";
    }

    public function deposer($montant) {
        $this->solde += $montant;
        $this->historiqueTransactions[] = "Dépôt de {$montant} euros";
        echo "Dépôt de {$montant} euros effectué avec succès.\n";
        $this->afficherSolde();
    }

    public function retirer($montant) {
        if ($montant <= $this->solde) {
            $this->solde -= $montant;
            $this->historiqueTransactions[] = "Retrait de {$montant} euros";
            echo "Retrait de {$montant} euros effectué avec succès.\n";
            $this->afficherSolde();
        } else {
            echo "Solde insuffisant pour effectuer le retrait.\n";
        }
    }

    public function afficherHistorique() {
        echo "Historique des transactions:\n";
        foreach ($this->historiqueTransactions as $transaction) {
            echo $transaction . "\n";
        }
    }

    public function effectuerVirement($destinataire, $montant) {
        if ($montant <= $this->solde) {
            $this->solde -= $montant;
            $destinataire->deposer($montant);
            $this->historiqueTransactions[] = "Virement de {$montant} euros vers " . get_class($destinataire);
            echo "Virement de {$montant} euros vers " . get_class($destinataire) . " effectué avec succès.\n";
            $this->afficherSolde();
        } else {
            echo "Solde insuffisant pour effectuer le virement.\n";
        }
    }
}

// Fonction pour exécuter des commandes depuis la console
function executerCommandes() {
    $portefeuille = new Portefeuille();

    while (true) {
        $commande = readline("Entrez une commande (solde, depot, retrait, virement, historique, quitter): ");

        switch ($commande) {
            case "solde":
                $portefeuille->afficherSolde();
                break;
            case "depot":
                $montantDepot = (float)readline("Entrez le montant du dépôt : ");
                $portefeuille->deposer($montantDepot);
                break;
            case "retrait":
                $montantRetrait = (float)readline("Entrez le montant du retrait : ");
                $portefeuille->retirer($montantRetrait);
                break;
            case "virement":
                $destinataire = new Portefeuille();
                $montantVirement = (float)readline("Entrez le montant du virement : ");
                $portefeuille->effectuerVirement($destinataire, $montantVirement);
                break;
            case "historique":
                $portefeuille->afficherHistorique();
                break;
            case "quitter":
                echo "Fermeture du programme.\n";
                return;
            default:
                echo "Commande invalide. Veuillez réessayer.\n";
        }
    }
}

executerCommandes();

?>
