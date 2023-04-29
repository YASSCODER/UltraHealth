/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entities.Plat;
import Services.IServicePlat;
import Utiles.Maconnexion;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Optional;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.control.Alert;
import javafx.scene.control.ButtonType;

/**
 *
 * @author Mega-PC
 */
public class ServicePlat implements IServicePlat  {
    Connection cnx;

    public ServicePlat() {
        cnx = Maconnexion.getInstance().getConnection();
    }

    @Override
    public void AjouterPlat(Plat p) {
        try {
            Statement stm = cnx.createStatement();

            String query = "INSERT INTO plat(titre,caloris,ingrediants_id) VALUES ('" + p.getTitre() + "','" + p.getCaloris() + "','" + p.getIngrediants_id() + "')";
            Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
            alert.setTitle("Confirmation d'ajout");
            alert.setHeaderText("Confirmation ");
            alert.setContentText("Etes vous sur de vouloir ajouter ce plat?");

            Optional<ButtonType> result = alert.showAndWait();
            if (result.get() == ButtonType.OK) {
                stm.executeUpdate(query);
                Alert alert2 = new Alert(Alert.AlertType.INFORMATION);
                alert2.setTitle("Ajout");
                alert2.setHeaderText("Plat ajouté");
                alert2.setContentText("Le plat a été ajouter avec success!");
                alert2.showAndWait();
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public ObservableList<Plat> AfficherPlat() {
        ObservableList<Plat> plats = FXCollections.observableArrayList();
        try {
            Statement stm;

            stm = cnx.createStatement();

            String query = "SELECT * from `plat`";
            ResultSet rst = stm.executeQuery(query);

            while (rst.next()) {
                Plat p = new Plat();
                p.setId(rst.getInt("id"));
                p.setTitre(rst.getString("titre"));
                p.setCaloris(rst.getInt("caloris"));
                p.setIngrediants_id(rst.getInt("ingrediants_id"));
                plats.add(p);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return plats;
    }

    @Override
    public void supprimerPlat(int id) {
        try {
            Statement stm = cnx.createStatement();

            String query = " Delete FROM plat where id='" + id + "'";
            Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
            alert.setTitle("Confirmation Dialog");
            alert.setHeaderText("Confirmation ");
            alert.setContentText("Etes vous sur de vouloir supprimer ce plat?");

            Optional<ButtonType> result = alert.showAndWait();
            if (result.get() == ButtonType.OK) {
                stm.executeUpdate(query);
                Alert alert2 = new Alert(Alert.AlertType.INFORMATION);
                alert2.setTitle("Suppression");
                alert2.setHeaderText("Plat Supprimé");
                alert2.setContentText("Le plat a été supprimer avec success!");
                alert2.showAndWait();
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public void ModifierPlat(Plat p) {
        try {


          Statement stm = cnx.createStatement();
          String query = "UPDATE plat SET titre='" + p.getTitre() + "', caloris=" + p.getCaloris() + ", ingrediants_id=" + p.getIngrediants_id() + " WHERE id=" + p.getId();
          stm.executeUpdate(query);
            Alert alert = new Alert(Alert.AlertType.INFORMATION);
            alert.setTitle("Update");
            alert.setHeaderText("Plat Modifié");
            alert.setContentText("Le plat a été modifier avec success!");
            alert.showAndWait();

            
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
          
        }
    }

    public ObservableList<Plat> search(String input) {
        ObservableList<Plat> plats = FXCollections.observableArrayList();
        try {
            Statement stm;
            stm = cnx.createStatement();
            String query = "SELECT * from plat where titre like '%" + input + "%'";
            ResultSet rst = stm.executeQuery(query);
            Plat form;
            while (rst.next()) {
                Plat p = new Plat();
                p.setId(rst.getInt("id"));
                p.setTitre(rst.getString("titre"));
                p.setCaloris(Integer.parseInt(rst.getString("caloris")));
                p.setIngrediants_id(Integer.parseInt(rst.getString("ingrediants_id")));
                form = new Plat(rst.getInt("id"), rst.getString("titre"), rst.getInt("caloris"), rst.getInt("ingrediants_id"));
                plats.add(form);
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return plats;
    }

    public ObservableList<Plat> triasc() {
        ObservableList<Plat> plats = FXCollections.observableArrayList();
        try {
            Statement stm = cnx.createStatement();
            String query = "SELECT * from plat ORDER by titre ASC";
            ResultSet rst = stm.executeQuery(query);
            Plat form;
            while (rst.next()) {
                Plat p = new Plat();
                p.setId(rst.getInt("id"));
                p.setTitre(rst.getString("titre"));
                p.setCaloris(rst.getInt("caloris"));
                p.setIngrediants_id(rst.getInt("ingrediants_id"));
                form = new Plat(rst.getInt("id"), rst.getString("titre"), rst.getInt("caloris"), rst.getInt("ingrediants_id"));
                plats.add(form);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return plats;
    }

    public ObservableList<Plat> triadsc() {
        ObservableList<Plat> plats = FXCollections.observableArrayList();
        try {
            Statement stm = cnx.createStatement();
            String query = "SELECT * from plat ORDER by titre DESC";
            ResultSet rst = stm.executeQuery(query);
            Plat form;
            while (rst.next()) {
               Plat p = new Plat();
                p.setId(rst.getInt("id"));
                p.setTitre(rst.getString("titre"));
                p.setCaloris(rst.getInt("caloris"));
                p.setIngrediants_id(rst.getInt("ingrediants_id"));
                form = new Plat(rst.getInt("id"), rst.getString("titre"), rst.getInt("caloris"), rst.getInt("ingrediants_id"));
                plats.add(form);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return plats;
    }

    
}
