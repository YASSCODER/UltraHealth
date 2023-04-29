/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entities.Plat;
import javafx.collections.ObservableList;
import java.sql.SQLException;

/**
 *
 * @author Mega-PC
 */
public interface IServicePlat {
    public void AjouterPlat(Plat p);
    public ObservableList<Plat>AfficherPlat();
    public void supprimerPlat(int id);
    public void ModifierPlat(Plat p);
    
}

