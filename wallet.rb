class Portefeuille
    def initialize(solde_initial = 0)
      @solde = solde_initial
      @historique_transactions = []
    end
  
    def afficher_solde
      puts "Solde actuel: #{@solde} euros"
    end
  
    def deposer(montant)
      @solde += montant
      @historique_transactions << "Dépôt de #{montant} euros"
      puts "Dépôt de #{montant} euros effectué avec succès."
      afficher_solde
    end
  
    def retirer(montant)
      if montant <= @solde
        @solde -= montant
        @historique_transactions << "Retrait de #{montant} euros"
        puts "Retrait de #{montant} euros effectué avec succès."
        afficher_solde
      else
        puts "Solde insuffisant pour effectuer le retrait."
      end
    end
  
    def afficher_historique
      puts "Historique des transactions:"
      @historique_transactions.each do |transaction|
        puts transaction
      end
    end
  
    def effectuer_virement(destinataire, montant)
      if montant <= @solde
        @solde -= montant
        destinataire.deposer(montant)
        @historique_transactions << "Virement de #{montant} euros vers #{destinataire.class.name}"
        puts "Virement de #{montant} euros vers #{destinataire.class.name} effectué avec succès."
        afficher_solde
      else
        puts "Solde insuffisant pour effectuer le virement."
      end
    end
  end
  
  def executer_commandes
    portefeuille = Portefeuille.new
  
    loop do
      print "Entrez une commande (solde, depot, retrait, virement, historique, quitter): "
      commande = gets.chomp.downcase
  
      case commande
      when "solde"
        portefeuille.afficher_solde
      when "depot"
        print "Entrez le montant du dépôt : "
        montant_depot = gets.chomp.to_f
        portefeuille.deposer(montant_depot)
      when "retrait"
        print "Entrez le montant du retrait : "
        montant_retrait = gets.chomp.to_f
        portefeuille.retirer(montant_retrait)
      when "virement"
        destinataire = Portefeuille.new
        print "Entrez le montant du virement : "
        montant_virement = gets.chomp.to_f
        portefeuille.effectuer_virement(destinataire, montant_virement)
      when "historique"
        portefeuille.afficher_historique
      when "quitter"
        puts "Fermeture du programme."
        break
      else
        puts "Commande invalide. Veuillez réessayer."
      end
    end
  end
  
  executer_commandes
  
