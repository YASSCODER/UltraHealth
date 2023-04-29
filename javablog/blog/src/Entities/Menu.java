/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

/**
 *
 * @author Mega-PC
 */
public class Menu {
    private int id;
    private String titre;
    private String category;
    private int plats_id;

    public Menu(int id, String titre, String category, int plats_id) {
        this.id = id;
        this.titre = titre;
        this.category = category;
        this.plats_id = plats_id;
    }

    public Menu() {
       
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
    }

    public int getPlats_id() {
        return plats_id;
    }

    public void setPlats_id(int plats_id) {
        this.plats_id = plats_id;
    }

    @Override
    public String toString() {
        return "Menu{" + "id=" + id + ", titre=" + titre + ", category=" + category + ", plats_id=" + plats_id + '}';
    }
    
    
    
}
