/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entities.Menu;
import javafx.collections.ObservableList;

/**
 *
 * @author Mega-PC
 */
public interface IServiceMenu {
    public void AjouterMenu(Menu m);
    public ObservableList<Menu>AfficherMenu();
    public void supprimerMenu(int id);
    public void ModifierMenu(Menu m);
    
}
