const readline = require('readline');

class Portefeuille {
    constructor(solde_initial = 0) {
        this.solde = solde_initial;
        this.historique_transactions = [];
    }

    afficherSolde() {
        console.log(`Solde actuel: ${this.solde} euros`);
    }

    deposer(montant) {
        this.solde += montant;
        this.historique_transactions.push(`Dépôt de ${montant} euros`);
        console.log(`Dépôt de ${montant} euros effectué avec succès.`);
        this.afficherSolde();
    }

    retirer(montant) {
        if (montant <= this.solde) {
            this.solde -= montant;
            this.historique_transactions.push(`Retrait de ${montant} euros`);
            console.log(`Retrait de ${montant} euros effectué avec succès.`);
            this.afficherSolde();
        } else {
            console.log("Solde insuffisant pour effectuer le retrait.");
        }
    }

    afficherHistorique() {
        console.log("Historique des transactions:");
        for (const transaction of this.historique_transactions) {
            console.log(transaction);
        }
    }

    effectuerVirement(destinataire, montant) {
        if (montant <= this.solde) {
            this.solde -= montant;
            destinataire.deposer(montant);
            this.historique_transactions.push(`Virement de ${montant} euros vers ${destinataire.constructor.name}`);
            console.log(`Virement de ${montant} euros vers ${destinataire.constructor.name} effectué avec succès.`);
            this.afficherSolde();
        } else {
            console.log("Solde insuffisant pour effectuer le virement.");
        }
    }
}

function executerCommandes() {
    const portefeuille = new Portefeuille();

    const rl = readline.createInterface({
        input: process.stdin,
        output: process.stdout
    });

    function questionUtilisateur(question) {
        return new Promise(resolve => rl.question(question, resolve));
    }

    async function gestionCommandes() {
        while (true) {
            const commande = (await questionUtilisateur("Entrez une commande (solde, depot, retrait, virement, historique, quitter): ")).toLowerCase();

            if (commande === "solde") {
                portefeuille.afficherSolde();
            } else if (commande === "depot") {
                const montantDepot = parseFloat(await questionUtilisateur("Entrez le montant du dépôt : "));
                portefeuille.deposer(montantDepot);
            } else if (commande === "retrait") {
                const montantRetrait = parseFloat(await questionUtilisateur("Entrez le montant du retrait : "));
                portefeuille.retirer(montantRetrait);
            } else if (commande === "virement") {
                const destinataire = new Portefeuille();
                const montantVirement = parseFloat(await questionUtilisateur("Entrez le montant du virement : "));
                portefeuille.effectuerVirement(destinataire, montantVirement);
            } else if (commande === "historique") {
                portefeuille.afficherHistorique();
            } else if (commande === "quitter") {
                console.log("Fermeture du programme.");
                rl.close();
                return;
            } else {
                console.log("Commande invalide. Veuillez réessayer.");
            }
        }
    }

    gestionCommandes().then(() => rl.close());
}

executerCommandes();
