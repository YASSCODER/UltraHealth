/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entities.Ingrediant;

import Entities.Menu;
import Entities.Plat;
import IService.IService;
import javafx.collections.ObservableList;

/**
 *
 * @author Mega-PC
 */

public abstract class BaseService implements IService {

    // Default implementation for Ingrediant methods

@Override
    public void AjouterIngrediant(Ingrediant c) {
        
    }
    @Override
    public ObservableList<Ingrediant> AfficherIngrediant() {
        throw new UnsupportedOperationException("Not supported yet.");
    }
    
    @Override
    public void supprimerIngrediant(String titre) {
       
    }

    @Override
    public void ModifierIngrediant(Ingrediant c) {
        
    }

    // Default implementation for Menu methods
    @Override
    public void AjouterMenu(Menu m) {
        
    }

    @Override
    public ObservableList<Menu> AfficherMenu() {
        throw new UnsupportedOperationException("Not supported yet.");
    }

    @Override
    public void supprimerMenu(String titre) {
       
    }

    @Override
    public void ModifierMenu(Menu m) {
        
    }

    // Default implementation for Plat methods
    @Override
    public void AjouterPlat(Plat p) {
        
    }

    @Override
    public ObservableList<Plat> AfficherPlat() {
        throw new UnsupportedOperationException("Not supported yet.");
    }

    @Override
    public void supprimerPlat(String titre) {
        
    }

    @Override
    public void ModifierPlat(Plat p) {
        
    }
}

