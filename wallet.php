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
        $this->historiqueTransactions[] = "Dépôt de $montant euros";
        echo "Dépôt de $montant euros effectué avec succès.\n";
        $this->afficherSolde();
    }

    public function retirer($montant) {
        if ($montant <= $this->solde) {
            $this->solde -= $montant;
            $this->historiqueTransactions[] = "Retrait de $montant euros";
            echo "Retrait de $montant euros effectué avec succès.\n";
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
            $this->historiqueTransactions[] = "Virement de $montant euros vers " . get_class($destinataire);
            echo "Virement de $montant euros vers " . get_class($destinataire) . " effectué avec succès.\n";
            $this->afficherSolde();
        } else {
            echo "Solde insuffisant pour effectuer le virement.\n";
        }
    }
}

function executerCommandes() {
    $soldeInitial = isset($_POST["soldeInitial"]) ? floatval($_POST["soldeInitial"]) : 0;
    $portefeuille = new Portefeuille($soldeInitial);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $commande = isset($_POST["commande"]) ? strtolower(trim($_POST["commande"])) : "";

        switch ($commande) {
            case "solde":
                $portefeuille->afficherSolde();
                break;
            case "depot":
                $montantDepot = isset($_POST["montantDepot"]) ? floatval($_POST["montantDepot"]) : 0;
                if ($montantDepot > 0) {
                    $portefeuille->deposer($montantDepot);
                } else {
                    echo "Veuillez entrer un montant de dépôt valide.\n";
                }
                break;
            case "retrait":
                $montantRetrait = isset($_POST["montantRetrait"]) ? floatval($_POST["montantRetrait"]) : 0;
                $portefeuille->retirer($montantRetrait);
                break;
            case "virement":
                $destinataire = new Portefeuille();
                $montantVirement = isset($_POST["montantVirement"]) ? floatval($_POST["montantVirement"]) : 0;
                $portefeuille->effectuerVirement($destinataire, $montantVirement);
                break;
            case "historique":
                $portefeuille->afficherHistorique();
                break;
            case "quitter":
                echo "Fermeture du programme.\n";
                exit;
            default:
                echo "Commande invalide. Veuillez réessayer.\n";
        }
    }
}
executerCommandes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portefeuille</title>
</head>
<body>
    <h1>Portefeuille</h1>
    <form method="post" action="">
        <label for="commande">Entrez une commande (solde, depot, retrait, virement, historique, quitter): </label>
        <input type="text" name="commande" id="commande">
        <br>

        <label for="soldeInitial">Solde initial :</label>
        <input type="text" name="soldeInitial" id="soldeInitial">
        <br>

        <label for="montantDepot">Montant du dépôt :</label>
        <input type="text" name="montantDepot" id="montantDepot">
        <br>

        <label for="montantRetrait">Montant du retrait :</label>
        <input type="text" name="montantRetrait" id="montantRetrait">
        <br>

        <label for="montantVirement">Montant du virement :</label>
        <input type="text" name="montantVirement" id="montantVirement">
        <br>

        <button type="submit">Soumettre</button>
    </form>
</body>
</html>