/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities;

/**
 *
 * @author Mega-PC
 */
public class Plat {
    private String Titre;
    private String Caloris,Poids;

   

    public Plat(String Titre, String Caloris, String Poids) {
        this.Titre = Titre;
        this.Caloris = Caloris;
        this.Poids = Poids;
    }

    public Plat() {
    }
     public String getTitre() {
        return Titre;
    }

    public void setTitre(String Titre) {
        this.Titre = Titre;
    }

    public String getCaloris() {
        return Caloris;
    }

    public void setCaloris(String Caloris) {
        this.Caloris = Caloris;
    }

    public String getPoids() {
        return Poids;
    }

    public void setPoids(String Poids) {
        this.Poids = Poids;
    }

    @Override
    public String toString() {
        return "Plat{" + "Titre=" + Titre + ", Caloris=" + Caloris + ", Poids=" + Poids + '}';
    }
    
}
