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
public class Ingrediant {
    private int id;
    private String titre;
    private int caloris;
    private int poids;

    public Ingrediant(int id, String titre, int caloris, int poids) {
        this.id = id;
        this.titre = titre;
        this.caloris = caloris;
        this.poids = poids;
    }

    public Ingrediant() {
      
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

    public int getPoids() {
        return poids;
    }

    public void setPoids(int poids) {
        this.poids = poids;
    }

    @Override
    public String toString() {
        return "Ingrediant{" + "id=" + id + ", titre=" + titre + ", caloris=" + caloris + ", poids=" + poids + '}';
    }
    
    
}
