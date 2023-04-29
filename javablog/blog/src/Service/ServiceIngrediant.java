/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entities.Ingrediant;


import Services.IServiceIngrediant;
import Utiles.Maconnexion;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Date;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.ButtonType;
/**
 *
 * @author User
 */
public class ServiceIngrediant implements IServiceIngrediant {

    Connection cnx;

    public ServiceIngrediant() {
        cnx = Maconnexion.getInstance().getConnection();
    }

    @Override
    public void AjouterIngrediant(Ingrediant c) {
        try {
            Statement stm = cnx.createStatement();

            String query = "INSERT INTO ingrediant(titre,caloris,poids) VALUES ('" + c.getTitre() + "','" + c.getCaloris() + "','" + c.getPoids() + "')";
            Alert alert = new Alert(AlertType.CONFIRMATION);
            alert.setTitle("Confirmation d'ajout");
            alert.setHeaderText("Confirmation ");
            alert.setContentText("Etes vous sur de vouloir ajouter cet ingredient?");

            Optional<ButtonType> result = alert.showAndWait();
            if (result.get() == ButtonType.OK) {
                stm.executeUpdate(query);
                Alert alert2 = new Alert(AlertType.INFORMATION);
                alert2.setTitle("Ajout");
                alert2.setHeaderText("Ingredient ajoutée");
                alert2.setContentText("L'ingredient a été ajouter avec success!");
                alert2.showAndWait();
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public ObservableList<Ingrediant> AfficherIngrediant() {
        ObservableList<Ingrediant> ingredients = FXCollections.observableArrayList();
        try {
            Statement stm;

            stm = cnx.createStatement();

            String query = "SELECT * from `ingrediant`";
            ResultSet rst = stm.executeQuery(query);

            while (rst.next()) {
                Ingrediant c = new Ingrediant();
                c.setId(rst.getInt("id"));
                c.setTitre(rst.getString("titre"));
                c.setCaloris(rst.getInt("caloris"));
                c.setPoids(rst.getInt("poids"));
                ingredients.add(c);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return ingredients;
    }

    @Override
    public void supprimerIngrediant(int id) {
        try {
            Statement stm = cnx.createStatement();

            String query = " Delete FROM ingrediant where id='" + id + "'";
            Alert alert = new Alert(AlertType.CONFIRMATION);
            alert.setTitle("Confirmation Dialog");
            alert.setHeaderText("Confirmation ");
            alert.setContentText("Etes vous sur de vouloir supprimer cet ingredient?");

            Optional<ButtonType> result = alert.showAndWait();
            if (result.get() == ButtonType.OK) {
                stm.executeUpdate(query);
                Alert alert2 = new Alert(AlertType.INFORMATION);
                alert2.setTitle("Suppression");
                alert2.setHeaderText("Ingredient Supprimé");
                alert2.setContentText("L'ingredient a été supprimer avec success!");
                alert2.showAndWait();
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public void ModifierIngrediant(Ingrediant c) {
        try {


          Statement stm = cnx.createStatement();
          String query = "UPDATE ingrediant SET titre='" + c.getTitre() + "', caloris=" + c.getCaloris() + ", poids=" + c.getPoids() + " WHERE id=" + c.getId();
          stm.executeUpdate(query);
            Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Update");
            alert.setHeaderText("Ingredient Modifié");
            alert.setContentText("L'ingredient a été modifier avec success!");
            alert.showAndWait();

            
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
          
        }
    }
 
    
    // RECHERCHE SELON TITRE OU ID 29/04/2023 
    
    public ObservableList<Ingrediant> search(String input, String searchType) {
    ObservableList<Ingrediant> ingredients = FXCollections.observableArrayList();
    try {
        Statement stm;
        stm = cnx.createStatement();
        String query = "SELECT * from ingrediant where " + searchType + " like '%" + input + "%'";
        ResultSet rst = stm.executeQuery(query);
        Ingrediant form;
        while (rst.next()) {
            Ingrediant c = new Ingrediant();
            c.setId(rst.getInt("id"));
            c.setTitre(rst.getString("titre"));
            c.setCaloris(Integer.parseInt(rst.getString("caloris")));
            c.setPoids(Integer.parseInt(rst.getString("poids")));
            form = new Ingrediant(rst.getInt("id"), rst.getString("titre"), rst.getInt("caloris"), rst.getInt("poids"));
            ingredients.add(form);
        }

    } catch (SQLException ex) {
        Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
    }

    return ingredients;
}
    
    /*public ObservableList<Ingrediant> search(String input) {
        ObservableList<Ingrediant> ingredients = FXCollections.observableArrayList();
        try {
            Statement stm;
            stm = cnx.createStatement();
            String query = "SELECT * from ingrediant where titre like '%" + input + "%'";
            ResultSet rst = stm.executeQuery(query);
            Ingrediant form;
            while (rst.next()) {
                Ingrediant c = new Ingrediant();
                c.setId(rst.getInt("id"));
                c.setTitre(rst.getString("titre"));
                c.setCaloris(Integer.parseInt(rst.getString("caloris")));
                c.setPoids(Integer.parseInt(rst.getString("poids")));
                form = new Ingrediant(rst.getInt("id"), rst.getString("titre"), rst.getInt("caloris"), rst.getInt("poids"));
                ingredients.add(form);
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return ingredients;
    }*/

    public ObservableList<Ingrediant> triasc() {
        ObservableList<Ingrediant> ingredients = FXCollections.observableArrayList();
        try {
            Statement stm = cnx.createStatement();
            String query = "SELECT * from ingrediant ORDER by titre ASC";
            ResultSet rst = stm.executeQuery(query);
            Ingrediant form;
            while (rst.next()) {
                Ingrediant c = new Ingrediant();
                c.setId(rst.getInt("id"));
                c.setTitre(rst.getString("titre"));
                c.setCaloris(rst.getInt("caloris"));
                c.setPoids(rst.getInt("poids"));
                form = new Ingrediant(rst.getInt("id"), rst.getString("titre"), rst.getInt("caloris"), rst.getInt("poids"));
                ingredients.add(form);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return ingredients;
    }

    public ObservableList<Ingrediant> triadsc() {
        ObservableList<Ingrediant> ingredients = FXCollections.observableArrayList();
        try {
            Statement stm = cnx.createStatement();
            String query = "SELECT * from ingrediant ORDER by titre DESC";
            ResultSet rst = stm.executeQuery(query);
            Ingrediant form;
            while (rst.next()) {
               Ingrediant c = new Ingrediant();
                c.setId(rst.getInt("id"));
                c.setTitre(rst.getString("titre"));
                c.setCaloris(rst.getInt("caloris"));
                c.setPoids(rst.getInt("poids"));
                form = new Ingrediant(rst.getInt("id"), rst.getString("titre"), rst.getInt("caloris"), rst.getInt("poids"));
                ingredients.add(form);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return ingredients;
    }

}
