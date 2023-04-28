/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

import java.sql.Date;

/**
 *
 * @author Mega-PC
 */
public class Commentaire {
  private int id;
  private Date date_cm;
  private String texte; 

    public Commentaire() {
    }

    public Commentaire(int id, Date date_cm, String texte) {
        this.id = id;
        this.date_cm = date_cm;
        this.texte = texte;
    }

    public int getId() {
        return id;
    }

    public Date getDate_cm() {
        return date_cm;
    }

    public String getTexte() {
        return texte;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setDate_cm(Date date_cm) {
        this.date_cm = date_cm;
    }

    public void setTexte(String texte) {
        this.texte = texte;
    }
  
  
}
