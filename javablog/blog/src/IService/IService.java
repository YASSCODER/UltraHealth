    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */
    package IService;


    import Entities.Ingrediant;
    import Entities.Menu;
    import Entities.Plat;
    import java.sql.SQLException;
    import javafx.collections.ObservableList;

    /**
     *
     * @author User
     */
    public   interface IService {
        // methods for ingredients
        public void AjouterIngrediant(Ingrediant c);
        public ObservableList<Ingrediant> AfficherIngrediant();
        public void supprimerIngrediant(String titre);
        public void ModifierIngrediant(Ingrediant c);

        // methods for menus
        public void AjouterMenu(Menu m);
        public ObservableList<Menu> AfficherMenu();
        public void supprimerMenu(String titre);
        public void ModifierMenu(Menu m);

        // methods for plats
        public void AjouterPlat(Plat p);
        public ObservableList<Plat> AfficherPlat();
        public void supprimerPlat(String titre);
        public void ModifierPlat(Plat p);
    }