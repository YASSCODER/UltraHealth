/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;


import Entities.Ingrediant;
import java.sql.SQLException;
import javafx.collections.ObservableList;

/**
 *
 * @author User
 */
public interface IServiceIngrediant {
    public void AjouterIngrediant(Ingrediant c);
    public ObservableList<Ingrediant>AfficherIngrediant();
    public void supprimerIngrediant(int id);
    public void ModifierIngrediant(Ingrediant c);
}
