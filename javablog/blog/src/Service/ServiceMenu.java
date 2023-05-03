/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entities.Menu;
import IService.IService;

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
public   class ServiceMenu extends BaseService  {
    Connection cnx;

    public ServiceMenu() {
        cnx = Maconnexion.getInstance().getConnection();
    }

    @Override
    public void AjouterMenu(Menu m) {
        try {
            Statement stm = cnx.createStatement();

            String query = "INSERT INTO menu(plats_id,titre,category) VALUES ('" + m.getPlats_id() + "','" + m.getTitre() + "','" + m.getCategory() + "')";
            Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
            alert.setTitle("Confirmation d'ajout");
            alert.setHeaderText("Confirmation ");
            alert.setContentText("Etes vous sur de vouloir ajouter ce menu?");

            Optional<ButtonType> result = alert.showAndWait();
            if (result.get() == ButtonType.OK) {
                stm.executeUpdate(query);
                Alert alert2 = new Alert(Alert.AlertType.INFORMATION);
                alert2.setTitle("Ajout");
                alert2.setHeaderText("Menu ajouté");
                alert2.setContentText("Le menu a été ajouter avec success!");
                alert2.showAndWait();
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public ObservableList<Menu> AfficherMenu() {
        ObservableList<Menu> menus = FXCollections.observableArrayList();
        try {
            Statement stm;

            stm = cnx.createStatement();

            String query = "SELECT * from `menu`";
            ResultSet rst = stm.executeQuery(query);

            while (rst.next()) {
                Menu m = new Menu();
                m.setId(rst.getInt("id"));
                m.setTitre(rst.getString("titre"));
                m.setCategory(rst.getString("category"));
                m.setPlats_id(rst.getInt("plats_id"));
                menus.add(m);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return menus;
    }

    @Override
    public void supprimerMenu(String titre) {
        try {
            Statement stm = cnx.createStatement();

            String query = " Delete FROM menu where titre='" + titre + "'";
            Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
            alert.setTitle("Confirmation Dialog");
            alert.setHeaderText("Confirmation ");
            alert.setContentText("Etes vous sur de vouloir supprimer ce menu?");

            Optional<ButtonType> result = alert.showAndWait();
            if (result.get() == ButtonType.OK) {
                stm.executeUpdate(query);
                Alert alert2 = new Alert(Alert.AlertType.INFORMATION);
                alert2.setTitle("Suppression");
                alert2.setHeaderText("Menu Supprimé");
                alert2.setContentText("Le menu a été supprimer avec success!");
                alert2.showAndWait();
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public void ModifierMenu(Menu m) {
        try {


          Statement stm = cnx.createStatement();
          
          String query = "UPDATE menu SET titre='" + m.getTitre() + "', category='" + m.getCategory() + "', plats_id=" + m.getPlats_id() + " WHERE id=" + m.getId();
          stm.executeUpdate(query);
            Alert alert = new Alert(Alert.AlertType.INFORMATION);
            alert.setTitle("Update");
            alert.setHeaderText("Menu Modifié");
            alert.setContentText("Le menu a été modifier avec success!");
            alert.showAndWait();

            
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
          
        }
    }

    public ObservableList<Menu> search(String input) {
        ObservableList<Menu> menus = FXCollections.observableArrayList();
        try {
            Statement stm;
            stm = cnx.createStatement();
             String query = "SELECT * FROM menu WHERE titre LIKE '%" + input + "%' OR category LIKE '%" + input + "%' OR plats_id LIKE '%" + input + "%'";
            ResultSet rst = stm.executeQuery(query);
            Menu form;
            while (rst.next()) {
                Menu m = new Menu();
                m.setId(rst.getInt("id"));
                m.setTitre(rst.getString("titre"));
                m.setCategory(rst.getString("category"));
                m.setPlats_id(Integer.parseInt(rst.getString("plats_id")));
                form = new Menu(rst.getInt("id"), rst.getString("titre"), rst.getString("category"), rst.getInt("plats_id"));
                menus.add(form);
            }

        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return menus;
    }

    public ObservableList<Menu> triasc() {
        ObservableList<Menu> menus = FXCollections.observableArrayList();
        try {
            Statement stm = cnx.createStatement();
            String query = "SELECT * from menu ORDER by titre ASC";
            ResultSet rst = stm.executeQuery(query);
            Menu form;
            while (rst.next()) {
                Menu m = new Menu();
                m.setId(rst.getInt("id"));
                m.setTitre(rst.getString("titre"));
                m.setCategory(rst.getString("category"));
                m.setPlats_id(rst.getInt("plats_id"));
                form = new Menu(rst.getInt("id"), rst.getString("titre"), rst.getString("category"), rst.getInt("plats_id"));
                menus.add(form);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return menus;
    }

    public ObservableList<Menu> triadsc() {
        ObservableList<Menu> menus = FXCollections.observableArrayList();
        try {
            Statement stm = cnx.createStatement();
            String query = "SELECT * from menu ORDER by titre DESC";
            ResultSet rst = stm.executeQuery(query);
            Menu form;
            while (rst.next()) {
               Menu m = new Menu();
                m.setId(rst.getInt("id"));
                m.setTitre(rst.getString("titre"));
                m.setCategory(rst.getString("caloris"));
                m.setPlats_id(rst.getInt("ingrediants_id"));
                form = new Menu(rst.getInt("id"), rst.getString("titre"), rst.getString("category"), rst.getInt("plats_id"));
                menus.add(form);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceIngrediant.class.getName()).log(Level.SEVERE, null, ex);
        }

        return menus;
    }
}
