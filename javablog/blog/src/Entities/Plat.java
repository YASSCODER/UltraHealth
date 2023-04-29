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
public class Plat {
    private int id;
    private String titre;
    private int caloris;
    private int ingrediants_id;

    public Plat(int id, String titre, int caloris, int ingrediants_id) {
        this.id = id;
        this.titre = titre;
        this.caloris = caloris;
        this.ingrediants_id = ingrediants_id;
    }

    public Plat() {
        
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

    public int getCaloris() {
        return caloris;
    }

    public void setCaloris(int caloris) {
        this.caloris = caloris;
    }

    public int getIngrediants_id() {
        return ingrediants_id;
    }

    public void setIngrediants_id(int ingrediants_id) {
        this.ingrediants_id = ingrediants_id;
    }

    @Override
    public String toString() {
        return "Plat{" + "id=" + id + ", titre=" + titre + ", caloris=" + caloris + ", ingrediants_id=" + ingrediants_id + '}';
    }
    
    
}
