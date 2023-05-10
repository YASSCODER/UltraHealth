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
public class Menu {
    private String Titre;
    private int  Caloris,Poids;

    public Menu() {
    }

    public Menu(String Titre, int Caloris, int Poids) {
        this.Titre = Titre;
        this.Caloris = Caloris;
        this.Poids = Poids;
    }

    public String getTitre() {
        return Titre;
    }

    public void setTitre(String Titre) {
        this.Titre = Titre;
    }

    public int getCaloris() {
        return Caloris;
    }

    public void setCaloris(int Caloris) {
        this.Caloris = Caloris;
    }

    public int getPoids() {
        return Poids;
    }

    public void setPoids(int Poids) {
        this.Poids = Poids;
    }

    @Override
    public String toString() {
        return "Menu{" + "Titre=" + Titre + ", Caloris=" + Caloris + ", Poids=" + Poids + '}';
    }
    
}
