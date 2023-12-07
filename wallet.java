import java.util.ArrayList;
import java.util.Scanner;

class Portefeuille {
    private double solde;
    private ArrayList<String> historiqueTransactions;

    public Portefeuille(double soldeInitial) {
        this.solde = soldeInitial;
        this.historiqueTransactions = new ArrayList<>();
    }

    public void afficherSolde() {
        System.out.println("Solde actuel: " + solde + " euros");
    }

    public void deposer(double montant) {
        solde += montant;
        historiqueTransactions.add("Dépôt de " + montant + " euros");
        System.out.println("Dépôt de " + montant + " euros effectué avec succès.");
        afficherSolde();
    }

    public void retirer(double montant) {
        if (montant <= solde) {
            solde -= montant;
            historiqueTransactions.add("Retrait de " + montant + " euros");
            System.out.println("Retrait de " + montant + " euros effectué avec succès.");
            afficherSolde();
        } else {
            System.out.println("Solde insuffisant pour effectuer le retrait.");
        }
    }

    public void afficherHistorique() {
        System.out.println("Historique des transactions:");
        for (String transaction : historiqueTransactions) {
            System.out.println(transaction);
        }
    }

    public void effectuerVirement(Portefeuille destinataire, double montant) {
        if (montant <= solde) {
            solde -= montant;
            destinataire.deposer(montant);
            historiqueTransactions.add("Virement de " + montant + " euros vers " + destinataire.getClass().getSimpleName());
            System.out.println("Virement de " + montant + " euros vers " + destinataire.getClass().getSimpleName() + " effectué avec succès.");
            afficherSolde();
        } else {
            System.out.println("Solde insuffisant pour effectuer le virement.");
        }
    }
}

public class wallet {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        Portefeuille portefeuille = new Portefeuille(0);

        while (true) {
            System.out.print("Entrez une commande (solde, depot, retrait, virement, historique, quitter): ");
            String commande = scanner.nextLine().toLowerCase();

            switch (commande) {
                case "solde":
                    portefeuille.afficherSolde();
                    break;
                case "depot":
                    System.out.print("Entrez le montant du dépôt : ");
                    double montantDepot = scanner.nextDouble();
                    portefeuille.deposer(montantDepot);
                    break;
                case "retrait":
                    System.out.print("Entrez le montant du retrait : ");
                    double montantRetrait = scanner.nextDouble();
                    portefeuille.retirer(montantRetrait);
                    break;
                case "virement":
                    Portefeuille destinataire = new Portefeuille(0);
                    System.out.print("Entrez le montant du virement : ");
                    double montantVirement = scanner.nextDouble();
                    portefeuille.effectuerVirement(destinataire, montantVirement);
                    break;
                case "historique":
                    portefeuille.afficherHistorique();
                    break;
                case "quitter":
                    System.out.println("Fermeture du programme.");
                    scanner.close();
                    return;
                default:
                    System.out.println("Commande invalide. Veuillez réessayer.");
            }

            scanner.nextLine();
        }
    }
}
